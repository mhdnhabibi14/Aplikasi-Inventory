<?php

namespace App\Http\Controllers;

use App\Http\Requests\storeTransaksiMasukRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransaksiMasukController extends Controller
{
    public $pageTitle = 'Transaksi Masuk';

    public function create()
    {
        $pageTitle = $this->pageTitle;
        return view('transaksi-masuk.create', compact('pageTitle'));
    }

    public function store(storeTransaksiMasukRequest $request)
    {
        $validator = Validator::make($request->all(), $request->rules(), $request->messages());
        if ($validator->fails()) {
            return response()->json([
                'success'       => false,
                'errors'        => $validator->errors()
            ], 422);
        }
    }
}
