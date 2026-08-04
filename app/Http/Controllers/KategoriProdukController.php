<?php

namespace App\Http\Controllers;

use App\Http\Requests\storeKategoriProdukRequest;
use App\Http\Requests\updateKategoriProdukRequest;
use App\Models\KategoriProduk;
use Illuminate\Http\Request;

use function Laravel\Prompts\confirm;

class KategoriProdukController extends Controller
{
    public $pageTitle = 'Kategori Produk';
    public function index()
    {
        $pageTitle = $this->pageTitle;
        $perPage = request()->query('perPage') ?? 10;
        $search = request()->query('search');
        $query = KategoriProduk::query();

        if ($search) {
            $query->where('nama_kategori', 'like', '%' . $search . '%');
        }

        $kategori = $query->paginate($perPage)->appends(request()->query());
        confirmDelete('Hapus data Kategori Produk tidak dapat dibatalkan, Lanjutkan ?');
        return view('kategori-produk.index', compact('pageTitle', 'kategori'));
    }

    public function store(storeKategoriProdukRequest $request)
    {
        KategoriProduk::create([
            'nama_kategori' => $request->nama_kategori
        ]);
        toast()->success('Kategori Produk berhasil ditambahkan');
        return redirect()->route('master-data.kategori-produk.index');
    }

    public function update(updateKategoriProdukRequest $request, KategoriProduk $kategoriProduk)
    {
        $kategoriProduk->nama_kategori = $request->nama_kategori;
        $kategoriProduk->save();
        toast()->success('Kategori Produk berhasil diupdate');
        return redirect()->route('master-data.kategori-produk.index');
    }

    public function destroy(KategoriProduk $kategoriProduk)
    {
        $kategoriProduk->delete();
        toast()->success('Kategori Produk berhasil dihapus');
        return redirect()->route('master-data.kategori-produk.index');
    }
}
