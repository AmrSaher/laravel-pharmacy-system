<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => '123456'
        ])->assignRole('admin');

        User::create([
            'name' => 'pharmacy',
            'email' => 'pharmacy@pharmacy.com',
            'password' => '123456'
        ])->assignRole('pharmacy');
    }
}
