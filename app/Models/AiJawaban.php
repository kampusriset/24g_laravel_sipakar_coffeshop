<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AiJawaban extends Model
{
    protected $table = 'ai_jawaban';
    protected $fillable = ['pelanggan_id', 'mood', 'cuaca', 'waktu', 'jenis_minuman', 'suka_susu', 'suka_kopi', 'suka_manis'];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }
}