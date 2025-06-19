<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AccountController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $accounts = Account::where('user_id', auth()->id())
            ->with('topUps')
            ->get()
            ->map(function ($account) {
                $account->saldo = $account->topUps
                    ->where('status', 'success')
                    ->sum('amount');
                return $account;
            });

        return view('account.index', compact('accounts'));
    }


    public function create()
    {
        // Cek apakah user sudah punya akun
        $existing = Account::where('user_id', auth()->id())->first();

        if ($existing) {
            return redirect()->route('akun.index')->with('info', 'Kamu sudah punya akun.');
        }

        return view('account.create');
    }

    public function store(Request $request)
    {
        // Cegah user punya lebih dari satu akun
        $existing = Account::where('user_id', auth()->id())->first();

        if ($existing) {
            return redirect()->route('akun.index')->with('error', 'Kamu tidak bisa menambah akun lagi.');
        }

        $request->validate([
            'nama_akun' => 'required|string|max:255',
        ]);

        Account::create([
            'user_id' => auth()->id(),
            'nama_akun' => $request->nama_akun,
        ]);

        return redirect()->route('akun.index')->with('success', 'Akun berhasil ditambahkan.');
    }

    public function edit(Account $account)
    {
        $this->authorize('update', $account);
        return view('account.edit', compact('account'));
    }

    public function update(Request $request, Account $account)
    {
        $this->authorize('update', $account);

        $request->validate([
            'nama_akun' => 'required|string|max:255',
        ]);

        $account->update([
            'nama_akun' => $request->nama_akun,
        ]);

        return redirect()->route('akun.index')->with('success', 'Akun berhasil diperbarui.');
    }

    public function destroy(Account $account)
    {
        $this->authorize('delete', $account);

        $account->delete();

        return redirect()->route('akun.index')->with('success', 'Akun berhasil dihapus.');
    }
}
