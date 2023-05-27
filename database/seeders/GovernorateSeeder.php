<?php

namespace Database\Seeders;

use App\Models\Governorate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GovernorateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $governorates = [
            'Alexandria',
            'Aswan',
            'Asyut',
            'Beheira',
            'Beni Suef',
            'Cairo',
            'Dakahlia',
            'Damietta',
            'Faiyum',
            'Gharbia',
            'Giza',
            'Ismailia',
            'Kafr El Sheikh',
            'Luxor',
            'Matruh',
            'Minya',
            'Monufia',
            'New Valley',
            'North Sinai',
            'Port Said',
            'Qalyubia',
            'Qena',
            'Red Sea',
            'Sharqia',
            'Sohag',
            'South Sinai',
            'Suez'
        ];

        foreach ($governorates as $governorate) {
            Governorate::create([
                'name' => $governorate
            ]);
        }
    }
}
