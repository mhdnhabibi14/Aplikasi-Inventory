@extends('layouts.kai')
@section('page_title', $pageTitle)
@section('content')
    <div class="card py-5">
        <div class="card-body">
            {{-- form --}}
            <form class="row col-12 justify-content-between" id="form-add-produk">
                <div class="alert alert-danger" id="alert-danger"></div>
                <div class="row">
                    <div class="form-group w-25">
                        <label for="pengirim" class="form-label">Pengirim</label>
                        <input type="text" name="pengirim" id="pengirim" class="form-control">
                    </div>
                    <div class="form-group w-25">
                        <label for="kontak" class="form-label">Kontak</label>
                        <input type="text" name="kontak" id="kontak" class="form-control">
                    </div>
                    <div class="form-group mt-1">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea name="keterangan" id="keterangan" cols="30" rows="2" class="form-control"></textarea>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-4">
                        <select id="select-produk" class="form-control border py-3"></select>
                    </div>
                    <div class="col-2">
                        <input type="text" name="nomor_batch" id="nomor_batch" class="form-control"
                            placeholder="Nomor Batch">
                    </div>
                    <div class="col-2">
                        <input type="number" name="qty" id="qty" class="form-control" placeholder="Qty">
                    </div>
                    <div class="col-2">
                        <input type="number" name="harga" id="harga" class="form-control" placeholder="Harga">
                    </div>
                    <div class="col-2">
                        <button type="submit" class="btn btn-dark btn-round w-100" id="btn-add">Tambahkan</button>
                    </div>
                </div>
            </form>
            {{-- end form --}}
            {{-- table --}}
            <table class="table mt-5" id="table-produk"></table>
            {{-- end table --}}
        </div>
    </div>
@endsection
@push('script')
    <script>
        $(document).ready(function() {
            $("#alert-danger").hide();
            const numberFormat = new Intl.NumberFormat('id-ID')
            let selectedOption = {};
            let selectedProduk = [];

            $('#select-produk').select2({
                placeholder: 'Pilih Produk',
                delay: 250,
                allowClear: true,
                theme: 'bootstrap-5',
                ajax: {
                    url: "{{ route('get-data.varian-produk') }}",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        let query = {
                            search: params.term
                        }
                        return query;
                    },
                    processResults: function(data) {
                        return {
                            results: data.map((item) => {
                                return {
                                    id: item.id,
                                    text: item.text,
                                    nomor_sku: item.nomor_sku
                                }
                            })
                        }
                    }
                }
            })
        });
    </script>
@endpush
