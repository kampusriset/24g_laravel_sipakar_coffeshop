<?php

namespace Database\Seeders;

use App\Models\KategoriMenu;
use Illuminate\Database\Seeder;

class KategoriMenuSeeder extends Seeder
{
    public function run(): void
    {
        KategoriMenu::create(['nama' => 'Coffee', 'deskripsi' => 'Minuman berbasis kopi', 'status' => true]);
        KategoriMenu::create(['nama' => 'Non Coffee', 'deskripsi' => 'Minuman tanpa kopi', 'status' => true]);
    }
}