<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class jadwal_bimbel extends Model
{
    use HasFactory;

    protected $fillable = [
        'mapel_id',
        'pengajar_id',
        'kelas_id',
        'hari',
        'biaya',
        'jam_mulai',
        'jam_selesai'
    ];

    public function mapel()
    {
        return $this->belongsTo(mapel::class);
    }

    public function pengajar()
    {
        return $this->belongsTo(pengajar::class);
    }

    public function kelas()
    {
        return $this->belongsTo(kelas::class);
    }

    public function pendaftar()
    {
        return $this->hasMany(pendaftar::class);
    }
}
