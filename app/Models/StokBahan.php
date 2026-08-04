<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StokBahan extends Model
{
    protected $table = 'stok_bahan';
    protected $fillable = ['nama', 'jumlah', 'satuan'];
}