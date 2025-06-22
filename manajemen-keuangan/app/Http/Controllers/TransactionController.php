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
            'account_id' => 'required|exists:accounts,id',
            'tanggal' => 'nullable|date',
        ]);

        Transaction::create([
            'user_id'     => auth()->id(),
            'account_id'  => $request->account_id,
            'jenis'       => $request->jenis,
            'jumlah'      => $request->jumlah,
            'keterangan'  => $request->keterangan,
            'tanggal'     => $request->tanggal ?? now(),
        ]);

        return redirect()->route('dashboard')->with('success', 'Transaksi berhasil ditambahkan!');
    }

    public function edit(Transaction $transaksi)
    {
         // kalau pakai policy
        $accounts = Account::where('user_id', auth()->id())->get();
        return view('transaksi.edit', compact('transaksi', 'accounts'));
    }

    public function update(Request $request, Transaction $transaksi)
    {
        

        $request->validate([
            'jenis' => 'required|in:pemasukan,pengeluaran',
            'jumlah' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
            'account_id' => 'required|exists:accounts,id',
            'tanggal' => 'nullable|date',
        ]);

        $transaksi->update([
            'account_id' => $request->account_id,
            'jenis' => $request->jenis,
            'jumlah' => $request->jumlah,
            'keterangan' => $request->keterangan,
            'tanggal' => $request->tanggal ?? now(),
        ]);

        return redirect()->route('dashboard')->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function destroy(Transaction $transaksi)
    {
        
        $transaksi->delete();

        return redirect()->route('dashboard')->with('success', 'Transaksi berhasil dihapus.');
    }
}
