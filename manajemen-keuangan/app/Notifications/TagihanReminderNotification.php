<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Tagihan;

class TagihanReminderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $tagihan;

    /**
     * Create a new notification instance.
     */
    public function __construct(Tagihan $tagihan)
    {
        $this->tagihan = $tagihan;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $tanggal = \Carbon\Carbon::parse($this->tagihan->tanggal_transfer)->format('d M Y');

        $mail = (new MailMessage)
            ->subject('🔔 Pengingat Tagihan: ' . $this->tagihan->nama)
            ->greeting('Halo, ' . $notifiable->name)
            ->line('Ini adalah pengingat bahwa kamu memiliki tagihan yang akan jatuh tempo.')
            ->line('📌 Nama Tagihan: ' . $this->tagihan->nama)
            ->line('💰 Nominal: Rp ' . number_format($this->tagihan->nominal, 0, ',', '.'))
            ->line('🗓️ Tanggal Jatuh Tempo: ' . $tanggal);

        if ($this->tagihan->xendit_invoice_url) {
            $mail->action('💳 Bayar Sekarang', $this->tagihan->xendit_invoice_url);
        }

        $mail->line('Silakan segera lakukan pembayaran agar tidak terlambat. Terima kasih 🙏');

        return $mail;
    }

    /**
     * Optional: For database notifications if needed later.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'tagihan_id' => $this->tagihan->id,
            'nama' => $this->tagihan->nama,
            'nominal' => $this->tagihan->nominal,
            'tanggal_transfer' => $this->tagihan->tanggal_transfer,
        ];
    }
}
