<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'findel007@gmail.com'],
            [
                'first_name' => 'Findel',
                'last_name' => 'Fofana',
                'phone' => '0747290470',
                'role' => 'admin',
                'password' => Hash::make('gfi-co@2025'),
            ]
        );
    }
}
