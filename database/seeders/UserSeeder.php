<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                "name" => "admin",
                "username" => "admin",
                "email" => "admin@example.com",
                "password" => Hash::make("admin"),
                "role" => "admin",
                "status" => 1,
            ],
            [
                "name" => "clarissa",
                "username" => "clar",
                "email" => "clarissa@gmail.com",
                "password" => Hash::make("clarissa"),
                "role" => "seller",
                "status" => 1,
            ],
            [
                "name" => "tuanmarkeu",
                "username" => "tuanmarkeu",
                "email" => "tuanmarkeu@gmail.com",
                "password" => Hash::make("tuanmarkeu"),
                "role" => "seller",
                "status" => 1,
            ],
            [
                "name" => "angelita",
                "username" => "angel",
                "email" => "angel@gmail.com",
                "password" => Hash::make("angelita"),
                "role" => "customer",
                "status" => 1,
            ],
        ];

        foreach ($users as $userData) {
            User::create($userData);
        }
    }
}
