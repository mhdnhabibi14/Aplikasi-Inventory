<?php

namespace App\View\Components\kategoriProduk;

use App\Models\KategoriProduk;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FormKategoriProduk extends Component
{
    /**
     * Create a new component instance.
     */
    public ?int $id = null;
    public ?string $nama_kategori = null;
    public ?string $action = null;

    public function __construct(?int $id = null)
    {
        if ($id) {
            $kategori = KategoriProduk::findOrFail($id);
            $this->id = $kategori->id;
            $this->nama_kategori = $kategori->nama_kategori;
            $this->action = route('master-data.kategori-produk.update', $kategori->id);
        } else {
            $this->action = route('master-data.kategori-produk.store');
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.kategori-produk.form-kategori-produk');
    }
}
