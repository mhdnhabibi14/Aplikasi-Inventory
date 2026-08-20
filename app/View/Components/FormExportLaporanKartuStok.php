<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FormExportLaporanKartuStok extends Component
{
    /**
     * Create a new component instance.
     */
    public string $nomorSku;
    public array $jenisTransaksi;

    public function __construct(string $nomorSku)
    {
        $this->nomorSku = $nomorSku;
        $this->jenisTransaksi = ['in', 'out', 'adjustment', 'retur'];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form-export-laporan-kartu-stok');
    }
}
