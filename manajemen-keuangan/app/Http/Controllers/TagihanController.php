<?php

namespace App\Http\Controllers;

use App\Models\Tagihan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TagihanController extends Controller
{
    public function index()
    {
        $tagihans = Tagihan::where('user_id', auth()->id())->get();
        return view('tagihan.index', compact('tagihans'));
    }

    public function create()
    {
        return view('tagihan.create'); // Tidak perlu kirim akun lagi
    }
    public function destroy($id)
    {
        $tagihan = Tagihan::findOrFail($id);
        $tagihan->delete();

        return redirect()->route('tagihan.index')->with('success', 'Tagihan berhasil dihapus.');
    }


    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'nominal' => 'required|numeric|min:1000',
            'tanggal_jatuh_tempo' => 'required|date|after_or_equal:today',
        ]);

        Tagihan::create([
            'user_id' => auth()->id(),
            'nama' => $request->nama,
            'nominal' => $request->nominal,
            'account_id' => null, // karena di form gak dipilih
            'tanggal_transfer' => $request->tanggal_jatuh_tempo,
            'status' => 'belum dibayar',
            'metode' => null,
            'tujuan' => null,
            'no_tujuan' => null,
            'sudah_dikirim' => false,
        ]);

        return redirect()->route('tagihan.index')->with('success', 'Pengingat tagihan berhasil dibuat.');
    }

    public function cekTagihanHariIni()
    {
        $hariIni = Carbon::today();

        $tagihans = Tagihan::whereDate('tanggal_transfer', $hariIni)
            ->where('status', 'belum dibayar')
            ->where('sudah_dikirim', false)
            ->get();

        foreach ($tagihans as $tagihan) {
            \Log::info("Reminder: Tagihan '{$tagihan->nama}' jatuh tempo hari ini. Nominal: Rp{$tagihan->nominal}");

            $tagihan->sudah_dikirim = true;
            $tagihan->save();
        }
    }
}
