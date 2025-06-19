<?php

namespace App\Listeners;

use App\Models\Account;
use Illuminate\Auth\Events\Registered;

class CreateDefaultAccount
{
    /**
     * Handle the event.
     */
    public function handle(Registered $event): void
    {
        $user = $event->user;

        // Buat akun default kalau belum punya
        if (!$user->account) {
            Account::create([
                'user_id' => $user->id,
                'nama_akun' => $user->name, 
                'saldo' => 0,
            ]);
        }
    }
}
