<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pembayaran extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'pendaftar_id',
        'tanggal_pembayaran',
        'jumlah_bayar',
        'keterangan',
        'status_pembayaran'
    ];

    protected $dates = ['deleted_at'];

    public function pendaftar()
    {
        return $this->belongsTo(pendaftar::class);
    }
}
