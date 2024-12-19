<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\StaffProvince;
use Illuminate\Support\Facades\Hash;
class AkunSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $provinces = [
            'ACEH',
            'SUMATERA UTARA',
            'SUMATERA BARAT',
            'RIAU',
            'JAMBI',
            'SUMATERA SELATAN',
            'BENGKULU',
            'LAMPUNG',
            'KEPULAUAN BANGKA BELITUNG',
            'KEPULAUAN RIAU',
            'DKI JAKARTA',
            'JAWA BARAT',
            'JAWA TENGAH',
            'DI YOGYAKARTA',
            'JAWA TIMUR',
            'BANTEN',
            'BALI',
            'NUSA TENGGARA BARAT',
            'NUSA TENGGARA TIMUR',
            'KALIMANTAN BARAT',
            'KALIMANTAN TENGAH',
            'KALIMANTAN SELATAN',
            'KALIMANTAN TIMUR',
            'KALIMANTAN UTARA',
            'SULAWESI UTARA',
            'SULAWESI TENGAH',
            'SULAWESI SELATAN',
            'SULAWESI TENGGARA',
            'GORONTALO',
            'SULAWESI BARAT',
            'MALUKU',
            'MALUKU UTARA',
            'PAPUA',
            'PAPUA BARAT',
            'PAPUA TENGAH',
            'PAPUA PEGUNUNGAN',
            'PAPUA SELATAN',
        ];

        foreach ($provinces as $province) {
            $password = strtolower(str_replace(' ', '', $province)) . '127';

            $email = 'staff_' . strtolower(str_replace(' ', '_', $province)) . '@gmail.com';

            $user = User::create([
                'email' => $email,
                'password' => Hash::make($password),
                'role' => 'STAFF',
            ]);
            StaffProvince::create([
                'user_id' => $user->id,
                'province' => strtolower($province),
            ]);
        }
    }
}
