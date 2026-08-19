<?php

namespace App\View\Components\stokOpname;

use App\Models\PeriodeStokOpname;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FormPeriodeStokOpname extends Component
{
    /**
     * Create a new component instance.
     */
    public ?string $tanggal_mulai = null;
    public ?string $tanggal_selesai = null;
    public ?int $id = null;
    public ?string $action = null;
    public ?bool $is_active = null;

    public function __construct($id = null)
    {
        if ($id) {
            $periode = PeriodeStokOpname::findOrFail($id);
            $this->id = $periode->id;
            $this->tanggal_mulai = $periode->tanggal_mulai;
            $this->tanggal_selesai = $periode->tanggal_selesai;
            $this->is_active = $periode->is_active;
            $this->action = route('stok-opname.periode.update', $periode->id);
        } else {
            $this->action = route('stok-opname.periode.store');
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.stok-opname.form-periode-stok-opname');
    }
}
