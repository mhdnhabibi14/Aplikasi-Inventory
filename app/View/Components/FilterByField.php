<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FilterByField extends Component
{
    /**
     * Create a new component instance.
     */
    public string $term;
    public string $placeholder;

    public function __construct(string $term = 'Cari data...', string $placeholder = 'Cari data...')
    {
        $this->term = $term;
        $this->placeholder = $placeholder;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.filter-by-field');
    }
}
