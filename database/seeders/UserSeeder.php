<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Nusaroma Coffee',
            'email' => 'admin@nusaromacoffee.com',
            'password' => Hash::make('admin12345'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Budi',
            'email' => 'budi@nusaromacoffee.com',
            'password' => Hash::make('password123'),
            'role' => 'pegawai',
        ]);
    }
}