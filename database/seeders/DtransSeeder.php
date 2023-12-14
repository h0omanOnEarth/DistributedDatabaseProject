<?php

namespace Database\Seeders;

use App\Models\Dtrans;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DtransSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dtrans = [
            [
                "htrans_kode" => "ABC123",
                "products_id" => 1,
                "qty" => 2,
            ],
            [
                "htrans_kode" => "ABC123",
                "products_id" => 2,
                "qty" => 2,
            ],
            [
                "htrans_kode" => "ABC123",
                "products_id" => 3,
                "qty" => 2,
            ],
        ];

        Dtrans::insert($dtrans);
    }
}
