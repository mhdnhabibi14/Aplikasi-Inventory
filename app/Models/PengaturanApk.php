<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengaturanApk extends Model
{
    protected $table = 'pengaturan_apks';

    protected $fillable = ['nama_aplikasi', 'tanggal_analisa_awal', 'tanggal_analisa_akhir', 'minimal_stok'];

    protected $casts = [
        'tanggal_analisa_awal' => 'date',
        'tanggal_analisa_akhir' => 'date',
        'minimal_stok' => 'integer',
    ];
}
