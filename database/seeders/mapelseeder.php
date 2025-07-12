<?php

namespace Database\Seeders;

use App\Models\mapel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class mapelseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            mapel::create([
                'nama_mapel' => 'Mata Pelajaran ' . $i,
            ]);
        }
    }
}
