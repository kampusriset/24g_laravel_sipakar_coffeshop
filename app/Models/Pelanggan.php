<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $table = 'pelanggan';
    protected $fillable = ['nama'];

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class);
    }

    public function aiJawaban()
    {
        return $this->hasMany(AiJawaban::class);
    }

    public function aiRekomendasi()
    {
        return $this->hasMany(AiRekomendasi::class);
    }
}