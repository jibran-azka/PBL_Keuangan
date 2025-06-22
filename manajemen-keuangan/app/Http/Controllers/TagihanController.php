<?php

namespace App\Http\Controllers;

use App\Models\Tagihan;
use App\Models\Account;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Xendit\Xendit;



class TagihanController extends Controller
{
    public function index()
    {
        $tagihans = Tagihan::where('user_id', auth()->id())->get();
        return view('tagihan.index', compact('tagihans'));
    }

    public function create()
    {
        return view('tagihan.metode');
    }

    public function formTagihan(Request $request)
    {
        $metode = $request->query('metode');
        $tujuan = $request->query('tujuan');
        $accounts = Account::where('user_id', auth()->id())->get();

        return view('tagihan.form', compact('metode', 'tujuan', 'accounts'));
    }

    public function simpan(Request $request)
    {
        $request->validate([
            'nama_tagihan' => 'required|string',
            'no_tujuan' => 'required',
            'nominal' => 'required|numeric|min:1000',
            'akun_id' => 'required|exists:accounts,id',
            'tanggal_transfer' => 'required|date',
            'metode' => 'required',
            'tujuan' => 'required',
        ]);

        
        $akun = Account::find($request->akun_id);

        if ($akun->saldo < $request->nominal) {
            return back()->with('error', 'Saldo tidak mencukupi.');
        }

        Tagihan::create([
            'user_id' => auth()->id(),
            'nama' => $request->nama_tagihan,
            'no_tujuan' => $request->no_tujuan,
            'nominal' => $request->nominal,
            'account_id' => $akun->id,
            'tanggal_transfer' => $request->tanggal_transfer,
            'metode' => $request->metode, // ✅ tambahkan ini
            'tujuan' => $request->tujuan,
            'status' => 'terjadwal',
        ]);
        
        return redirect()->route('tagihan.index')->with('success', 'Tagihan berhasil dijadwalkan.');
    }

    public function prosesTagihanHarian()
    {
        Xendit::setApiKey(config('xendit.secret_key'));

        $tagihans = Tagihan::whereDate('tanggal_transfer', Carbon::today())
            ->where('status', 'terjadwal')
            ->get();

        foreach ($tagihans as $tagihan) {
            $akun = $tagihan->akun;

            if ($akun->saldo >= $tagihan->nominal) {
                $akun->saldo -= $tagihan->nominal;
                $akun->save();

                // Buat invoice Xendit
                $invoice = \Xendit\Invoice::create([
                    'external_id' => 'TAGIHAN-' . $tagihan->id . '-' . time(),
                    'payer_email' => $tagihan->user->email,
                    'description' => $tagihan->nama,
                    'amount' => $tagihan->nominal,
                    'success_redirect_url' => route('tagihan.index'),
                    'failure_redirect_url' => route('tagihan.index'),
                    'payment_methods' => $tagihan->metode == 'bank' 
                        ? ['BCA', 'BNI', 'BRI']
                        : ['DANA', 'OVO', 'LINKAJA']
                ]);

                $tagihan->status = 'menunggu bayar';
                $tagihan->xendit_invoice_url = $invoice['invoice_url'];
                $tagihan->save();
            } else {
                $tagihan->status = 'gagal - saldo tidak cukup';
                $tagihan->save();
            }
        }
    }
}
