<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuBahan extends Model
{
    protected $table = 'menu_bahan';

    protected $fillable = ['menu_id', 'stok_bahan_id', 'jumlah_pakai'];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function stokBahan()
    {
        return $this->belongsTo(StokBahan::class);
    }
}