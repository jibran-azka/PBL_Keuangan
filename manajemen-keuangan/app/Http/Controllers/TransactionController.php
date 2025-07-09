<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Account;

class TransactionController extends Controller
{
    public function create()
    {
        $accounts = Account::where('user_id', auth()->id())->get();
        return view('transaksi.create', compact('accounts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis' => 'required|in:pemasukan,pengeluaran',
            'jumlah' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
            'tanggal' => 'nullable|date',
        ]);

        // Ambil akun pertama user
        $account = Account::where('user_id', auth()->id())->first();

        if (!$account) {
            return redirect()->back()->with('error', 'Akun belum tersedia. Buat akun terlebih dahulu.');
        }

        // Update saldo dulu
        if ($request->jenis === 'pemasukan') {
            $account->saldo += $request->jumlah;
        } else {
            $account->saldo -= $request->jumlah;
        }
        $account->save();

        // Simpan transaksi
        Transaction::create([
            'user_id'    => auth()->id(),
            'account_id' => $account->id,
            'jenis'      => $request->jenis,
            'jumlah'     => $request->jumlah,
            'keterangan' => $request->keterangan,
            'tanggal'    => $request->tanggal ?? now(),
        ]);

        return redirect()->route('dashboard')->with('success', 'Transaksi berhasil ditambahkan!');
    }


    public function edit(Transaction $transaksi)
    {
        if ($transaksi->user_id !== auth()->id()) {
            abort(403);
        }

        return view('transaksi.edit', compact('transaksi'));
    }


    public function update(Request $request, Transaction $transaksi)
    {
        if ($transaksi->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'jenis' => 'required|in:pemasukan,pengeluaran',
            'jumlah' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
            'tanggal' => 'nullable|date',
        ]);

        // Ambil akun terkait transaksi
        $account = Account::findOrFail($transaksi->account_id);

        // 1. Batalkan efek saldo lama
        if ($transaksi->jenis === 'pemasukan') {
            $account->saldo -= $transaksi->jumlah;
        } else {
            $account->saldo += $transaksi->jumlah;
        }

        // 2. Terapkan efek saldo baru
        if ($request->jenis === 'pemasukan') {
            $account->saldo += $request->jumlah;
        } else {
            $account->saldo -= $request->jumlah;
        }

        $account->save();

        // Update transaksi
        $transaksi->update([
            'jenis'       => $request->jenis,
            'jumlah'      => $request->jumlah,
            'keterangan'  => $request->keterangan,
            'tanggal'     => $request->tanggal ?? now(),
        ]);

        return redirect()->route('dashboard')->with('success', 'Transaksi berhasil diperbarui.');
    }


    public function destroy(Transaction $transaksi)
    {
        
        $transaksi->delete();

        return redirect()->route('dashboard')->with('success', 'Transaksi berhasil dihapus.');
    }
}
