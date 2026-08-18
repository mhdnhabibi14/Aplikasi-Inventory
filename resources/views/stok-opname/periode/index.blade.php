@extends('layouts.kai')
@section('page_title', $pageTitle)
@section('content')
    <div class="card py-5">
        <div class="d-flex justify-content-end">
            <x-stok-opname.form-periode-stok-opname />
        </div>
        <table class="table mt-5">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Periode</th>
                    <th>Jumlah Barang</th>
                    <th>Jumlah Barang Sesuai</th>
                    <th>Jumlah Barang Selisih</th>
                    <th>Status Kerja</th>
                    <th>Pelaporan Stok Opname</th>
                    <th>Opsi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($dataPeriode as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->periode }}</td>
                        <td>{{ $item->jumlah_barang }}</td>
                        <td>{{ $item->jumlah_barang_sesuai }}</td>
                        <td>{{ $item->jumlah_barang_selisih }}</td>
                        <td>{{ $item->is_active }}</td>
                        <td>{{ $item->is_completed }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">Belum ada data periode stok opname</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
