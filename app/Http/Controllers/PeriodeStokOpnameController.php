<?php

namespace App\Http\Controllers;

use App\Models\PeriodeStokOpname;
use Illuminate\Http\Request;

class PeriodeStokOpnameController extends Controller
{
    public $pageTitle = "Periode Stok Opname";

    public function index()
    {
        $pageTitle = $this->pageTitle;
        $dataPeriode = PeriodeStokOpname::all();
        return view('stok-opname.periode.index', compact('pageTitle', 'dataPeriode'));
    }
}
