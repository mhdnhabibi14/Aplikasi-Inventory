@extends('layouts.kai')
@section('page_title', $pageTitle)
@section('content')
    <div class="container-fluid">
        <div class="text-center mb-4">
            <h5>
                Dashboard Analitik Periode
                {{ \Carbon\Carbon::parse($tanggalMulai)->translatedFormat('d M Y') }}
                s/d
                {{ \Carbon\Carbon::parse($tanggalSelesai)->translatedFormat('d M Y') }}
            </h5>

        </div>
        <div class="row">
            <div class="col-sm-6 col-md-3 d-flex">
                <div class="card card-stats card-round h-80 w-100"
                    style="background: linear-gradient(135deg,#3B82F6,#60A5FA); color: white;">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <div class="numbers">
                                    <p class="card-category text-white">Total Transaksi</p>
                                    <h4 class="card-title text-white">
                                        {{ number_format($totalTransaksi, 0, ',', '.') }}
                                    </h4>
                                    <p class="mb-0">
                                        {{ number_format($barangMasuk, 0, ',', '.') }}
                                        Barang Masuk
                                    </p>
                                    <p class="mb-0">
                                        {{ number_format($barangKeluar, 0, ',', '.') }}
                                        Barang Keluar
                                    </p>
                                </div>
                            </div>
                            <div class="col-auto d-flex align-items-center justify-content-center">
                                <div class="icon-big text-center">
                                    <i class="fas fa-shopping-bag" style=" font-size: 50px; opacity: .35;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-3 d-flex">
                <div class="card card-stats card-round h-80 w-100"
                    style="background: linear-gradient(135deg,#F97316,#FB923C); color: white;">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <div class="numbers">
                                    <p class="card-category text-white">
                                        Biaya Keluar
                                    </p>
                                    <h4 class="card-title text-white">
                                        Rp.
                                        {{ number_format($biayaKeluar, 0, ',', '.') }}
                                    </h4>
                                </div>
                            </div>
                            <div class="col-auto d-flex align-items-center justify-content-center">
                                <div class="icon-big text-center">
                                    <i class="fas fa-money-bill-wave" style="font-size: 50px; opacity: .35;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-3 d-flex">
                <div class="card card-stats card-round h-80 w-100"
                    style="background: linear-gradient(135deg,#6366F1,#818CF8); color: white;">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <div class="numbers">
                                    <p class="card-category text-white">
                                        Biaya Diterima
                                    </p>
                                    <h4 class="card-title text-white">
                                        Rp.
                                        {{ number_format($biayaDiterima, 0, ',', '.') }}
                                    </h4>
                                </div>
                            </div>
                            <div class="col-auto d-flex align-items-center justify-content-center">
                                <div class="icon-big text-center">
                                    <i class="fas fa-hand-holding-usd" style=" font-size: 50px; opacity: .35;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-3 d-flex">
                <div class="card card-stats card-round h-80 w-100"
                    style="background: linear-gradient(135deg,#22C55E,#4ADE80); color: white;">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <div class="numbers">
                                    <p class="card-category text-white">
                                        Margin
                                    </p>
                                    <h4 class="card-title text-white">
                                        Rp.
                                        {{ number_format($margin, 0, ',', '.') }}
                                    </h4>
                                </div>
                            </div>
                            <div class="col-auto d-flex align-items-center justify-content-center">
                                <div class="icon-big text-center">
                                    <i class="fas fa-chart-line" style="font-size: 50px; opacity: .35;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card card-round">
                    <div class="card-header"
                        style="background: linear-gradient(135deg, #3B82F6,#60A5FA); color: #1e3a8a; border-radius: 10px 10px 0 0;">
                        <div class="card-head-row">
                            <div class="card-title">
                                Perbandingan Pendapatan dan Pengeluaran
                            </div>

                            <div class="card-tools">
                                <span class="text-muted">
                                    Tahun {{ date('Y') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div style="height: 350px;">
                            <canvas id="grafikPendapatanPengeluaran"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        const ctx = document
            .getElementById('grafikPendapatanPengeluaran')
            .getContext('2d');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [
                    'Jan',
                    'Feb',
                    'Mar',
                    'Apr',
                    'Mei',
                    'Jun',
                    'Jul',
                    'Agu',
                    'Sep',
                    'Okt',
                    'Nov',
                    'Des'
                ],
                datasets: [{
                        label: 'Pendapatan',
                        data: @json($pendapatanPerBulan),
                        backgroundColor: 'rgba(13, 110, 253, 0.75)',
                        borderColor: 'rgba(13, 110, 253, 1)',
                        borderWidth: 1,
                        borderRadius: 6,
                        borderSkipped: false
                    },
                    {
                        label: 'Pengeluaran',
                        data: @json($pengeluaranPerBulan),
                        backgroundColor: 'rgba(255, 159, 67, 0.75)',
                        borderColor: 'rgba(255, 159, 67, 1)',
                        borderWidth: 1,
                        borderRadius: 6,
                        borderSkipped: false
                    },
                    {
                        label: 'Margin',
                        data: @json($marginPerBulan),
                        backgroundColor: 'rgba(40, 199, 111, 0.75)',
                        borderColor: 'rgba(40, 199, 111, 1)',
                        borderWidth: 1,
                        borderRadius: 6,
                        borderSkipped: false
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                            }
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label +
                                    ': Rp ' +
                                    new Intl.NumberFormat('id-ID')
                                    .format(context.raw);
                            }
                        }
                    }
                }
            }
        });
    </script>
@endpush
