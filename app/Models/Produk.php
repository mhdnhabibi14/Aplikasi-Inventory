<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    public function kategori()
    {
        return $this->belongsTo(KategoriProduk::class);
    }
}
