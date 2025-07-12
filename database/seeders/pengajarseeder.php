<?php

namespace Database\Seeders;

use App\Models\pengajar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class pengajarseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \Faker\Factory::create('id_ID');
        for ($i = 1; $i <= 10; $i++) {
            pengajar::create([
                'nama' => 'Pengajar ' . $i,
                'email' => 'pengajar' . $i . '@example.com',
                'no_telp' => '08' . rand(1000000000, 9999999999),
            ]);
        }
    }
}
