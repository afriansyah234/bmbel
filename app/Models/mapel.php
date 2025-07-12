<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mapel extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_mapel'
    ];

    public function jadwal()
    {
        return $this->hasMany(jadwal_bimbel::class);
    }
}
