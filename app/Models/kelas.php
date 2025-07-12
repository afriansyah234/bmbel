<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kelas extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_kelas',
        'kapasitas'
    ];

    public function jadwal()
    {
        return $this->hasMany(jadwal_bimbel::class);
    }

}
