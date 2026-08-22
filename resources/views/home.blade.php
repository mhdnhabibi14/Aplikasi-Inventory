@extends('layouts.kai')
@section('page_title', $pageTitle)
@section('breadcrumb')
    <i class="fas fa-chevron-right breadcrumb-arrow"></i>
    <span class="breadcrumb-current">
        Dashboard Analitik
    </span>
@endsection
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
                        <div id="grafikPendapatanPengeluaran"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            {{-- Produk dengan stok minimal --}}
            <div class="col-md-5">
                <div class="card card-round h-100">
                    <div class="card-header" style="background: #fff4e5;">
                        <div class="card-title">
                            <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                            Produk dengan Stok Minimal
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Produk</th>
                                        <th>Varian</th>
                                        <th>Stok</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @forelse ($produkStokMinimal as $produk)
                                        @foreach ($produk->varian as $varian)
                                            @if ($varian->stok_varian < 10)
                                                <tr>
                                                    <td>{{ $no++ }}</td>
                                                    <td>{{ $produk->nama_produk }}</td>
                                                    <td>{{ $varian->nama_varian }}</td>
                                                    <td>
                                                        <span class="badge bg-warning text-dark">
                                                            {{ $varian->stok_varian }} pcs
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">
                                                Tidak ada produk dengan stok minimal
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Produk Terlaris --}}
            <div class="col-md-7">
                <div class="card card-round h-100">
                    <div class="card-header" style="background: #eef7ff;">
                        <div class="card-title">
                            <i class="fas fa-chart-bar text-primary me-2"></i>
                            Produk Terlaris
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="chart-produk-terlaris"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card card-round">
                    <div class="card-header"
                        style="background: linear-gradient(135deg, #6366f1, #818cf8); color: white; border-radius: 10px 10px 0 0;">
                        <div class="card-head-row">
                            <div class="card-title text-white">
                                <i class="fas fa-tags me-2"></i>
                                Perbandingan Harga Awal vs Harga Sekarang
                            </div>
                            <div class="card-tools">
                                <span class="text-white">
                                    5 Produk
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if (count($hargaAwalChart) > 0)
                            <div style="height: 400px;">
                                <div id="chartPerbandinganHarga" style="height: 100%;">
                                </div>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-tags fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">
                                    Belum ada data perubahan harga
                                </h5>
                                <p class="text-muted mb-0">
                                    Data akan muncul setelah terdapat transaksi
                                    pemasukan dengan harga yang berbeda.
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endsection
    @push('script')
        <script>
            const options = {
                series: [{
                        name: 'Pendapatan',
                        data: @json($pendapatanPerBulan)
                    },
                    {
                        name: 'Pengeluaran',
                        data: @json($pengeluaranPerBulan)
                    },
                    {
                        name: 'Margin',
                        data: @json($marginPerBulan)
                    }
                ],
                chart: {
                    type: 'bar',
                    height: 350,
                    toolbar: {
                        show: false
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '45%',
                        borderRadius: 6,
                        borderRadiusApplication: 'end'
                    }
                },
                dataLabels: {
                    enabled: false
                },
                xaxis: {
                    categories: [
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
                    ]
                },
                yaxis: {
                    beginAtZero: true,
                    labels: {
                        formatter: function(value) {
                            return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                        }
                    }
                },
                tooltip: {
                    y: {
                        formatter: function(value) {
                            return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                        }
                    }
                },
                legend: {
                    position: 'top'
                }
            };
            const chart = new ApexCharts(
                document.querySelector("#grafikPendapatanPengeluaran"),
                options
            );
            chart.render();

            //Produk Terlaris
            $(document).ready(function() {
                const produk = @json($produkTerlaris);
                const namaProduk = produk.map(function(item) {
                    return item.nama_produk;
                });

                const totalTerjual = produk.map(function(item) {
                    return Number(item.total_terjual);
                });

                const options = {
                    series: [{
                        name: 'Terjual',
                        data: totalTerjual
                    }],
                    chart: {
                        type: 'bar',
                        height: 350,
                        toolbar: {
                            show: false
                        }
                    },
                    plotOptions: {
                        bar: {
                            horizontal: true,
                            borderRadius: 6,
                            barHeight: '55%'
                        }
                    },
                    dataLabels: {
                        enabled: true,
                        formatter: function(value) {
                            return value + ' pcs';
                        }
                    },
                    xaxis: {
                        categories: namaProduk,
                        title: {
                            text: 'Jumlah Terjual'
                        }
                    },
                    tooltip: {
                        y: {
                            formatter: function(value) {
                                return value + ' pcs';
                            }
                        }
                    }
                };
                const chart = new ApexCharts(
                    document.querySelector("#chart-produk-terlaris"),
                    options
                );
                chart.render();

            });

            // Perbandingan Harga awal dan sekarang
            document.addEventListener("DOMContentLoaded", function() {
                const labels = @json($labelPerbandinganHarga);
                const hargaAwal = @json($hargaAwalChart);
                const hargaSekarang = @json($hargaSekarangChart);
                const kenaikan = @json($kenaikanHargaChart);
                const persentase = @json($persentaseKenaikanChart);
                if (hargaAwal.length === 0) {
                    return;
                }

                const formatter = new Intl.NumberFormat('id-ID');
                const options = {
                    series: [{
                            name: 'Harga Awal',
                            data: hargaAwal
                        },
                        {
                            name: 'Harga Sekarang',
                            data: hargaSekarang
                        }
                    ],
                    chart: {
                        type: 'bar',
                        height: 400,
                        toolbar: {
                            show: false
                        }
                    },
                    plotOptions: {
                        bar: {
                            horizontal: true,
                            borderRadius: 5,
                            barHeight: '65%'
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    xaxis: {
                        categories: labels,
                        title: {
                            text: 'Harga Produk'
                        },
                        labels: {
                            formatter: function(value) {
                                return 'Rp ' +
                                    formatter.format(value);
                            }
                        }
                    },
                    yaxis: {
                        labels: {
                            style: {
                                fontSize: '13px',
                                fontWeight: 500
                            }
                        }
                    },
                    tooltip: {
                        shared: true,
                        intersect: false,
                        custom: function({
                            series,
                            dataPointIndex,
                            w
                        }) {
                            const namaProduk = labels[dataPointIndex];
                            const awal = hargaAwal[dataPointIndex];
                            const sekarang = hargaSekarang[dataPointIndex];
                            const naik = kenaikan[dataPointIndex];
                            const persen = persentase[dataPointIndex];
                            return `
                                    <div style="padding: 12px 15px; min-width: 220px;">
                                        <strong>
                                            ${namaProduk}
                                        </strong>
                                            <hr style="margin: 8px 0;">
                                        <div>
                                            Harga Awal:
                                            <strong>
                                                Rp ${formatter.format(awal)}
                                            </strong>
                                        </div>
                                        <div>
                                            Harga Sekarang:
                                            <strong>
                                                Rp ${formatter.format(sekarang)}
                                            </strong>
                                        </div>

                                        <div style="margin-top: 5px;">
                                            Kenaikan:
                                                <strong>
                                                    +Rp ${formatter.format(naik)}
                                                </strong>
                                                <span>
                                                    (+${persen}%)
                                                </span>
                                        </div>
                                    </div>
                                    `;
                        }
                    },
                    legend: {
                        position: 'bottom',
                        horizontalAlign: 'center'
                    },
                    grid: {
                        borderColor: '#e5e7eb',
                        strokeDashArray: 4
                    }
                };

                const chart = new ApexCharts(
                    document.querySelector(
                        "#chartPerbandinganHarga"
                    ),
                    options
                );
                chart.render();
            });
        </script>
    @endpush
