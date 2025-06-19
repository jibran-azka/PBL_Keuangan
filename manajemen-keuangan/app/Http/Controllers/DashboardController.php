<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Total saldo semua akun user
        $totalSaldo = Account::where('user_id', $user->id)->sum('saldo');

        // Pemasukan dan pengeluaran bulan ini
        $pemasukan = Transaction::where('user_id', $user->id)
            ->where('jenis', 'pemasukan')
            ->whereMonth('created_at', now()->month)
            ->sum('jumlah');

        $pengeluaran = Transaction::where('user_id', $user->id)
            ->where('jenis', 'pengeluaran')
            ->whereMonth('created_at', now()->month)
            ->sum('jumlah');

        // Riwayat 5 transaksi terakhir
        $riwayat = Transaction::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        // Grafik - 6 bulan terakhir
        $bulan = [];
        $dataPemasukan = [];
        $dataPengeluaran = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $bulan[] = $month->format('M Y');

            $pemasukanBulanan = Transaction::where('user_id', $user->id)
                ->where('jenis', 'pemasukan')
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->sum('jumlah');

            $pengeluaranBulanan = Transaction::where('user_id', $user->id)
                ->where('jenis', 'pengeluaran')
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->sum('jumlah');

            $dataPemasukan[] = $pemasukanBulanan;
            $dataPengeluaran[] = $pengeluaranBulanan;
        }

        return view('dashboard', compact(
            'totalSaldo',
            'pemasukan',
            'pengeluaran',
            'riwayat',
            'bulan',
            'dataPemasukan',
            'dataPengeluaran',

        ));
    }
}
