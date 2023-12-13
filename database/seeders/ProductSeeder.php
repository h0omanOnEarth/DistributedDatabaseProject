<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                "nama" => "bolpen",
                "harga" => "5000",
                "stok" => "100",
            ],
            [
                "nama" => "pensil",
                "harga" => "1000",
                "stok" => "200",
            ],
            [
                "nama" => "kaos",
                "harga" => "50000",
                "stok" => "50",
            ],
            [
                "nama" => "celana",
                "harga" => "50000",
                "stok" => "50",
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
