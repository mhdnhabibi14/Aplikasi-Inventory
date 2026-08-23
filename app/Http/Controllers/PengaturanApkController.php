<?php

namespace App\Http\Controllers;

use App\Http\Requests\PengaturanApkRequest;
use App\Models\PengaturanApk;
use Illuminate\Http\Request;

class PengaturanApkController extends Controller
{
    public function index()
    {
        $pageTitle = 'Pengaturan Aplikasi';

        $pengaturan = PengaturanApk::firstOrCreate(
            ['id' => 1],
            [
                'nama_aplikasi' => 'Aplikasi Inventory',
                'tanggal_analisa_awal' => now()->startOfYear()->format('Y-m-d'),
                'tanggal_analisa_akhir' => now()->endOfYear()->format('Y-m-d'),
                'minimal_stok' => 10,
            ]
        );

        return view('pengaturan-apk.index', compact(
            'pageTitle',
            'pengaturan'
        ));
    }

    public function update(
        PengaturanApkRequest $request,
        PengaturanApk $pengaturan
    ) {
        $pengaturan->update([
            'nama_aplikasi' => $request->nama_aplikasi,
            'tanggal_analisa_awal' => $request->tanggal_analisa_awal,
            'tanggal_analisa_akhir' => $request->tanggal_analisa_akhir,
            'minimal_stok' => $request->minimal_stok,
        ]);

        toast()->success('Pengaturan Aplikasi berhasil diupdate');
        return redirect()->route('pengaturan-apk.index');
    }
}
