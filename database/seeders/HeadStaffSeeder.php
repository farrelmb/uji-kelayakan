<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class HeadStaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'email' => 'headstaff@gmail.com', // Ganti dengan email yang diinginkan
            'password' => Hash::make('password123'), // Ganti dengan password yang diinginkan
            'role' => 'HEAD_STAFF', // Role pengguna
        ]);
    }
}
