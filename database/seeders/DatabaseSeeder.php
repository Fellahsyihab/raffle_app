<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Prize;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Membuat Akun Admin
        User::create([
            'name' => 'Admin JCH',
            'email' => 'admin@jch.com',
            'password' => Hash::make('password123'), // Ganti sesuai keinginanmu
        ]);

        // 2. Membuat Data Hadiah Awal (Opsional, biar nggak kosong)
        Prize::create(['name' => 'Stiker JCH', 'stock' => 100]);
        Prize::create(['name' => 'Tumbler Creative', 'stock' => 10]);
        Prize::create(['name' => 'Zonk', 'stock' => 999]);
    }
}