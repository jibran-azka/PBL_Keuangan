<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\KirimPengingatTagihan;

class Kernel extends ConsoleKernel
{
    /**
     * Register artisan commands (custom).
     *
     * Ini tempat daftar command agar dikenali Laravel.
     */
    protected $commands = [
        KirimPengingatTagihan::class,
    ];

    /**
     * Jadwal eksekusi otomatis via scheduler.
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('app:kirim-pengingat-tagihan')->everyMinute();
    }

    /**
     * Load semua perintah tambahan dari folder Commands & routes/console.php
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}
