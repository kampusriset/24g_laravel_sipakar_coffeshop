<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';
    protected $fillable = ['transaksi_id', 'metode', 'status', 'total_bayar'];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }
}