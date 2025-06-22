<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    // app/Models/Tagihan.php

    protected $fillable = [
        'user_id',
        'account_id',
        'nama',
        'no_tujuan', // <== HARUS ADA INI
        'nominal',
        'tanggal_transfer',
        'metode',
        'tujuan',
        'status',
    ];


    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
