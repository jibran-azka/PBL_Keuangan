<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    protected $fillable = [
        'user_id', 'account_id', 'nama', 'nominal', 'tanggal_jatuh_tempo', 'status',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
