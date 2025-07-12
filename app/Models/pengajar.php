<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pengajar extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'email',
        'no_telp'
    ];

    public function jadwal()
    {
        return $this->hasMany(jadwal_bimbel::class);
    }

    public function mapel()
    {
        return $this->hasManyThrough(
            Mapel::class,
            jadwal_bimbel::class,
            'pengajar_id',
            'id',
            'id',
            'mapel_id'
        );
    }
}
