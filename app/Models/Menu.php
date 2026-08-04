<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menu';
    protected $fillable = ['kategori_menu_id', 'nama', 'deskripsi', 'harga', 'gambar', 'status'];

    public function kategoriMenu()
    {
        return $this->belongsTo(KategoriMenu::class);
    }

    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class);
    }

    public function aiRekomendasi()
    {
        return $this->hasMany(AiRekomendasi::class);
    }

    public function bahanUsage()
    {
        return $this->hasMany(MenuBahan::class);
    }
}