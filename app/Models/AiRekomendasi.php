<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AiRekomendasi extends Model
{
    protected $table = 'ai_rekomendasi';
    protected $fillable = ['pelanggan_id', 'menu_id', 'nilai_cf', 'ranking'];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}