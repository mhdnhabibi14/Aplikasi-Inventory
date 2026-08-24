@extends('layouts.kai')
@section('page_title', $pageTitle)
@section('breadcrumb')
    <i class="fas fa-chevron-right breadcrumb-arrow"></i>
    <span class="breadcrumb-item-custom">
        Master Data
    </span>
    <i class="fas fa-chevron-right breadcrumb-arrow"></i>
    <span class="breadcrumb-current">
        Stok Barang
    </span>
@endsection

@section('content')
    <div class="card">
        <div class="card-body py-5">
            <div class="row align-items-center">
                {{-- Filter --}}
                <div class="row col-9 justify-content-between">
                    <div class="col-1">
                        <x-per-page-option />
                    </div>
                    <div class="col-8">
                        <x-filter-by-field term="search" placeholder="Cari Produk..." />
                    </div>
                    <div class="col-2">
                        <x-filter-by-options term="kategori" :options="$kategori" field="nama_kategori"
                            defaultValue="Pilih Kategori" />
                    </div>
                </div>
                {{-- end Filter --}}
                {{-- Stok Minim --}}
                <div class="col-2">
                    <a href="{{ route('master-data.stok-barang.index', ['stok_minimal' => $minimalStok]) }}"
                        class="btn {{ request('stok_minimal') == $minimalStok ? 'btn-danger' : 'btn-warning' }} btn-round w-100">
                        <i class="fas fa-exclamation-triangle me-1"></i>
                        Stok Minimal
                    </a>
                </div>
                {{-- end Stok Minim --}}
                {{-- Reset Filter --}}
                <div class="col-1">
                    <x-button-reset-filter route="master-data.stok-barang.index" />
                </div>
                {{-- end Reset Filter --}}
            </div>
            <table class="table mt-5">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 15px">No</th>
                        <th>SKU</th>
                        <th>Produk</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th>Harga</th>
                        <th>Kartu Stok</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($produk as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item['nomor_sku'] }}</td>
                            <td>{{ $item['produk'] }}</td>
                            <td>{{ $item['kategori'] }}</td>
                            <td>{{ number_format($item['stok']) }} pcs</td>
                            <td>Rp. {{ number_format($item['harga']) }}</td>
                            <td>
                                <x-kartu-stok nomor_sku="{{ $item['nomor_sku'] }}" />
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">
                                Data Produk Kosong
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
