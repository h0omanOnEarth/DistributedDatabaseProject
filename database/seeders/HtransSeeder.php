<?php

namespace Database\Seeders;

use App\Models\Htrans;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HtransSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ongoing, delivery, done
        $htrans = [
            [
                "kode" => "ABC123",
                "subtotal" => 100000,
                "status" => "belum bayar",
                "pengirimans_id" => 1,
                "users_id" => 4,
                "ctr_estimasi" => 2,
            ],
            [
                "kode" => "ABC124",
                "subtotal" => 75000,
                "status" => "delivery",
                "pengirimans_id" => 2,
                "users_id" => 4,
                "ctr_estimasi" => 2,
            ],
            [
                "kode" => "ABC125",
                "subtotal" => 50000,
                "status" => "done",
                "pengirimans_id" => 3,
                "users_id" => 4,
                "ctr_estimasi" => 0,
            ],
        ];

        Htrans::insert($htrans);
    }
}
