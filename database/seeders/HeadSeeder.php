<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class HeadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create user with HEAD_STAFF role
        User::create([
            'email' => 'headstaff@example.com', // Ganti dengan email yang diinginkan
            'password' => Hash::make('password123'), // Ganti dengan password yang diinginkan
            'role' => 'HEAD_STAFF', // Role pengguna
        ]);
    }
}
