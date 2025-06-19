<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tagihan;
use App\Models\Account;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;


class CekDanPotongTagihan extends Command
{
    protected $signature = 'tagihan:proses';
    protected $description = 'Cek dan potong tagihan otomatis berdasarkan tanggal jatuh tempo';

    public function handle()
    {
        $today = now()->toDateString();

        $tagihans = Tagihan::whereDate('tanggal_jatuh_tempo', '<=', Carbon::today())
            ->where('status', 'aktif')
            ->with('account')
            ->get();

        foreach ($tagihans as $tagihan) {
            $akun = $tagihan->account;

            // pastikan saldo cukup
            if ($akun->saldo >= $tagihan->nominal) {
                $akun->saldo -= $tagihan->nominal;
                $akun->save();

                $tagihan->status = 'sudah dipotong';
                $tagihan->save();

                Log::info("Tagihan {$tagihan->nama_akun} berhasil dipotong dari akun {$akun->nama_akun}.");
            } else {
                Log::warning("Saldo tidak cukup untuk tagihan {$tagihan->nama_akun}.");
            }
        }

        $this->info('Proses tagihan selesai.');
    }
}
