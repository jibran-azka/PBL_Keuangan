<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama',                 // Nama tagihan
        'nominal',              // Jumlah tagihan
        'tanggal_transfer',     // Tanggal jatuh tempo
        'status',               // menunggu bayar / lunas / lainnya
        'sudah_dikirim',        // boolean: apakah sudah dikirim pengingat
        'tanggal_dikirim',      // waktu terakhir reminder dikirim
        'pengingat_terakhir',   // H atau H-1
    ];

    protected $casts = [
        'tanggal_transfer'     => 'date',
        'tanggal_dikirim'      => 'datetime',
        'sudah_dikirim'        => 'boolean',
    ];

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope: filter tagihan yang perlu diingatkan
     * H-1 = besok
     * H   = hari ini
     */
    public function scopePerluDiingatkan($query)
    {
        return $query->where('status', 'menunggu bayar')
            ->where(function ($query) {
                $query->where(function ($q) {
                    $q->whereDate('tanggal_transfer', now()->addDay())
                      ->where(function ($s) {
                          $s->whereNull('pengingat_terakhir')
                            ->orWhere('pengingat_terakhir', '!=', 'H-1');
                      });
                })->orWhere(function ($q) {
                    $q->whereDate('tanggal_transfer', now())
                      ->where(function ($s) {
                          $s->whereNull('pengingat_terakhir')
                            ->orWhere('pengingat_terakhir', '!=', 'H');
                      });
                });
            });
    }
}
