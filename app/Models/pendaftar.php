<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class pendaftar extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_pendaftar',
        'jadwal_bimbel_id',
        'tanggal_daftar',
        'status_pendaftaran'
    ];

    public function jadwal()
    {
        return $this->belongsTo(jadwal_bimbel::class, 'jadwal_bimbel_id');
    }

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'pendaftar_id');
    }
}
