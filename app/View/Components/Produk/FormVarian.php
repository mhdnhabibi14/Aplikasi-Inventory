<?php

namespace App\View\Components\produk;

use App\Models\VarianProduk;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FormVarian extends Component
{
    /**
     * Create a new component instance.
     */
    public ?int $id = null;
    public int $produk_id;
    public ?string $nama_varian = null;
    public ?int $harga_varian = null;
    public ?int $stok_varian = null;
    public string $action;

    public function __construct($id = null)
    {
        $this->produk_id = request()->route('produk')->id;
        if ($id) {
            $varian = VarianProduk::findOrFail($id);
            $this->id = $varian->id;
            $this->nama_varian = $varian->nama_varian;
            $this->harga_varian = $varian->harga_varian;
            $this->stok_varian = $varian->stok_varian;
            $this->action = route('master-data.varian-produk.update', $varian->id);
        } else {
            $this->action = route('master-data.varian-produk.store');
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.produk.form-varian');
    }
}
