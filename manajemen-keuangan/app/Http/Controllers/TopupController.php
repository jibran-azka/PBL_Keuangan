<?php

namespace App\Http\Controllers;

use App\Models\TopUp;
use Illuminate\Http\Request;
use App\Models\Account;
use Midtrans\Snap;
use Midtrans\Config;
use Illuminate\Support\Facades\Log;

class TopupController extends Controller
{
    public function index()
    {
        $topUps = TopUp::all(); // Mengambil semua data top-up
        return view('topup.index', compact('topUps'));
    }

    public function create()
    {
        $accounts = Account::all(); // Tampilkan semua akun supaya user bisa pilih
        return view('topup.create', compact('accounts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'amount' => 'required|numeric|min:1000',
        ]);

        $topup = TopUp::create([
            'user_id' => auth()->id(),
            'account_id' => $request->account_id,
            'amount' => $request->amount,
            'status' => 'pending',
        ]);

        // Setup Midtrans configuration
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = true;  // Ganti ke true jika menggunakan production
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // Setup request params
        $params = [
            'transaction_details' => [
                'order_id' => 'TOPUP-' . $topup->id . '-' . time(),
                'gross_amount' => $topup->amount,
            ],
            'customer_details' => [
                'first_name' => auth()->user()->name,
                'email' => auth()->user()->email,
            ],
            'enabled_payments' => ['gopay', 'qris', 'shopeepay', 'bank_transfer'], // Tambahkan ini
        ];
        

        // Request Snap token from Midtrans
        try {
            $snapToken = Snap::getSnapToken($params);
            return view('topup.pay', compact('snapToken'));
        } catch (\Exception $e) {
            // Log the error if Snap API fails
            Log::error('Midtrans Snap Error: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memproses pembayaran.');
        }

        // Store transaction ID
        $topup->transaction_id = $params['transaction_details']['order_id'];
        $topup->save();

        return view('topup.pay', compact('snapToken'));
    }

    public function show($id)
    {
        $topUp = TopUp::findOrFail($id);
        return view('topup.show', compact('topUp'));
    }

    public function edit($id)
    {
        $topUp = TopUp::findOrFail($id);
        return view('topup.edit', compact('topUp'));
    }

    public function update(Request $request, $id)
    {
        $topUp = TopUp::findOrFail($id);
        $topUp->update($request->all());
        return redirect()->route('topup.index');
    }

    public function destroy($id)
    {
        $topUp = TopUp::findOrFail($id);
        $topUp->delete();
        return redirect()->route('topup.index');
    }

    public function midtransCallback(Request $request)
    {
        $notif = new \Midtrans\Notification();

        // Log the notification data for debugging
        Log::debug('Midtrans Callback Received: ' . json_encode($notif));

        $topup = TopUp::where('transaction_id', $notif->order_id)->first();

        if (!$topup) {
            Log::warning('TopUp not found for transaction_id: ' . $notif->order_id);
            return response()->json(['message' => 'TopUp not found'], 404);
        }

        if ($notif->transaction_status == 'settlement') {
            $topup->status = 'success';
            $topup->save();

            // Tambahkan saldo ke akun
            $topup->account->transactions()->create([
                'jenis' => 'pemasukan',
                'jumlah' => $topup->amount,
                'keterangan' => 'Top-Up via Midtrans',
            ]);
        } elseif ($notif->transaction_status == 'cancel') {
            $topup->status = 'failed';
            $topup->save();
        } elseif ($notif->transaction_status == 'pending') {
            $topup->status = 'pending';
            $topup->save();
        }

        return response()->json(['message' => 'Callback processed']);
    }

    public function history()
    {
        $topups = TopUp::with('account')->latest()->get(); // ambil semua riwayat top-up dengan relasi ke akun

        return view('Topup.index', compact('topups'));
    }
}
