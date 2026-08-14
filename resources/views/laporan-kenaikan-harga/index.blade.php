@extends('layouts.kai')
@section('page_title', $pageTitle)
@section('content')
    <div class="card py-5">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nomor Transaksi</th>
                        <th>Produk</th>
                        <th>Nomor Batch</th>
                        <th>Harga Lama</th>
                        <th>Harga Beli</th>
                        <th>Kenaikan Harga</th>
                        <th>Jumlah Barang</th>
                        <th>Konfirmasi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection
