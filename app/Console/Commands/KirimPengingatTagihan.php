<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tagihan;
use App\Notifications\TagihanReminderNotification;
use Carbon\Carbon;

class KirimPengingatTagihan extends Command
{
    /**
     * Signature command
     */
    protected $signature = 'app:kirim-pengingat-tagihan';

    /**
     * Deskripsi command
     */
    protected $description = 'Mengirim email pengingat otomatis untuk tagihan yang jatuh tempo H-1 dan H';

    /**
     * Logic utama
     */
    public function handle()
    {
        $today = now()->toDateString();
        $besok = now()->addDay()->toDateString();

        $tagihans = Tagihan::where('status', 'belum dibayar')
            ->where(function ($query) use ($today, $besok) {
                // H-1 (besok)
                $query->orWhere(function ($q) use ($besok) {
                    $q->whereDate('tanggal_transfer', $besok)
                      ->where(function ($sub) {
                          $sub->whereNull('pengingat_terakhir')
                              ->orWhere('pengingat_terakhir', '!=', 'H-1');
                      });
                });
                // H (hari ini)
                $query->orWhere(function ($q) use ($today) {
                    $q->whereDate('tanggal_transfer', $today)
                      ->where(function ($sub) use ($today) {
                          $sub->whereNull('tanggal_dikirim')
                              ->orWhereDate('tanggal_dikirim', '!=', $today);
                      });
                });
            })
            ->with('user')
            ->get();

        if ($tagihans->isEmpty()) {
            $this->info("Tidak ada tagihan yang perlu diingatkan hari ini.");
            return;
        }

        foreach ($tagihans as $tagihan) {
            $kapan = null;

            if ($tagihan->tanggal_transfer->isToday()) {
                $kapan = 'H';
            } elseif ($tagihan->tanggal_transfer->isTomorrow()) {
                $kapan = 'H-1';
            }

            if ($kapan) {
                $tagihan->user->notify(new TagihanReminderNotification($tagihan, $kapan));

                $tagihan->update([
                    'pengingat_terakhir' => $kapan,
                    'tanggal_dikirim' => now(),
                    'sudah_dikirim' => true,
                ]);

                $this->info("[$kapan] Pengingat dikirim ke {$tagihan->user->email} - {$tagihan->nama}");
            }
        }
    }
}
