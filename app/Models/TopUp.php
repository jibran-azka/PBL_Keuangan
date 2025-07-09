<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopUp extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'account_id',
        'amount',
        'status',
        'snap_token'
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Account
    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
