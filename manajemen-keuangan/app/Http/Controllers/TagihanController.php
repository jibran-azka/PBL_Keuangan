<?php

namespace App\Http\Controllers;

use App\Models\Tagihan;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class TagihanController extends Controller
{
    public function index()
    {
        $tagihans = Tagihan::with('account')->where('user_id', auth()->id())->get();
        return view('tagihan.index', compact('tagihans'));
    }

    public function create()
    {
        $accounts = Account::where('user_id', auth()->id())->get();
        return view('tagihan.create', compact('accounts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'nominal' => 'required|numeric',
            'account_id' => 'required|exists:accounts,id',
            'tanggal_jatuh_tempo' => 'required|date',
        ]);

        Tagihan::create([
            'user_id' => auth()->id(), // <--- INI WAJIB!
            'nama' => $request->nama,
            'nominal' => $request->nominal,
            'account_id' => $request->account_id,
            'tanggal_jatuh_tempo' => $request->tanggal_jatuh_tempo,
            'status' => 'aktif',
        ]);
        Artisan::call('tagihan:proses');

        return redirect()->route('tagihan.index')->with('success', 'Tagihan berhasil ditambahkan.');
    }
}
