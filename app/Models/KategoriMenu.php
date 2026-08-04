<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriMenu extends Model
{
    protected $table = 'kategori_menu';
    protected $fillable = ['nama', 'deskripsi', 'status'];

    public function menu()
    {
        return $this->hasMany(Menu::class);
    }
}