<?php

namespace App\View\Components\Produk;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FormProduk extends Component
{
    /**
     * Create a new component instance.
     */
    public ?int $id;
    public ?string $nama_produk;
    public ?string $deskripsi_produk;
    public ?string $kategori;
    public ?string $action;

    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.produk.form-produk');
    }
}
