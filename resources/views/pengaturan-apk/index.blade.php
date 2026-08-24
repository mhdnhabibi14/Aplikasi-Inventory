@extends('layouts.kai')
@section('page_title', $pageTitle)
@section('breadcrumb')
    <i class="fas fa-chevron-right breadcrumb-arrow"></i>
    <span class="breadcrumb-current">
        Pengaturan Aplikasi
    </span>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-round">
                <form action="{{ route('pengaturan-apk.update', $pengaturanApk->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group mb-4">
                            <label for="nama_aplikasi" class="form-label">Nama Aplikasi</label>
                            <input type="text" name="nama_aplikasi" id="nama_aplikasi"
                                class="form-control @error('nama_aplikasi') is-invalid @enderror"
                                value="{{ old('nama_aplikasi', $pengaturanApk->nama_aplikasi ?? '') }}"
                                placeholder="Contoh: Aplikasi Inventory">
                            @error('nama_aplikasi')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group mb-4">
                            <label for="tanggal_analisa_awal" class="form-label">Tanggal Analisa Awal</label>
                            <input type="date" name="tanggal_analisa_awal" id="tanggal_analisa_awal"
                                class="form-control @error('tanggal_analisa_awal') is-invalid @enderror"
                                value="{{ old(
                                    'tanggal_analisa_awal',
                                    isset($pengaturanApk->tanggal_analisa_awal) ? $pengaturanApk->tanggal_analisa_awal->format('Y-m-d') : '',
                                ) }}">
                            @error('tanggal_analisa_awal')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group mb-4">
                            <label for="tanggal_analisa_akhir" class="form-label">Tanggal Analisa Akhir</label>
                            <input type="date" name="tanggal_analisa_akhir" id="tanggal_analisa_akhir"
                                class="form-control @error('tanggal_analisa_akhir') is-invalid @enderror"
                                value="{{ old(
                                    'tanggal_analisa_akhir',
                                    isset($pengaturanApk->tanggal_analisa_akhir) ? $pengaturanApk->tanggal_analisa_akhir->format('Y-m-d') : '',
                                ) }}">
                            @error('tanggal_analisa_akhir')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group mb-4">
                            <label for="minimal_stok" class="form-label">Minimal Stok</label>
                            <div class="input-group">
                                <input type="number" name="minimal_stok" id="minimal_stok" min="0"
                                    class="form-control @error('minimal_stok') is-invalid @enderror"
                                    value="{{ old('minimal_stok', $pengaturanApk->minimal_stok) }}"
                                    placeholder="Angka Minimal Stok">
                                <span class="input-group-text">
                                    pcs
                                </span>
                            </div>
                            @error('minimal_stok')
                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>
                            @enderror
                            <small class="text-muted">
                                Produk dengan stok sama atau di bawah jumlah ini akan dianggap sebagai stok minimal.
                            </small>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>
                            Simpan Pengaturan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
