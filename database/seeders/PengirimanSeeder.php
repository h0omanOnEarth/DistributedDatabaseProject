<?php

namespace Database\Seeders;

use App\Models\Pengirimans;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PengirimanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pengirimans = [
            [
                "lokasi" => "surabaya",
                "estimasi" => 1,
            ],
            [
                "lokasi" => "semarang",
                "estimasi" => 2,
            ],
            [
                "lokasi" => "jogja",
                "estimasi" => 3,
            ],
            [
                "lokasi" => "solo",
                "estimasi" => 4,
            ],
            [
                "lokasi" => "banjarmasin",
                "estimasi" => 5,
            ],
            [
                "lokasi" => "balikpapan",
                "estimasi" => 6,
            ],
        ];

        foreach ($pengirimans as $pengiriman) {
            Pengirimans::create($pengiriman);
        }
    }
}
