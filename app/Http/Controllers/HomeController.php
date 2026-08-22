<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\TransaksiItems;
use App\Models\VarianProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $pageTitle = "Dashboard Analitik";

        $tanggalMulai = $request->tanggal_mulai ?? now()->startOfMonth()->format('Y-m-d');
        $tanggalSelesai = $request->tanggal_selesai ?? now()->endOfMonth()->format('Y-m-d');

        $barangMasuk = Transaksi::where('jenis_transaksi', 'pemasukan')
            ->whereBetween('created_at', [$tanggalMulai . ' 00:00:00', $tanggalSelesai . ' 23:59:59'])
            ->sum('jumlah_barang');
        $barangKeluar = Transaksi::where('jenis_transaksi', 'pengeluaran')
            ->whereBetween('created_at', [$tanggalMulai . ' 00:00:00', $tanggalSelesai . ' 23:59:59'])
            ->sum('jumlah_barang');

        $totalTransaksi = Transaksi::whereBetween('created_at', [$tanggalMulai . ' 00:00:00', $tanggalSelesai . ' 23:59:59'])->count();

        $biayaKeluar = Transaksi::where('jenis_transaksi', 'pemasukan')
            ->whereBetween('created_at', [$tanggalMulai . ' 00:00:00', $tanggalSelesai . ' 23:59:59'])
            ->sum('total_harga');
        $biayaDiterima = Transaksi::where('jenis_transaksi', 'pengeluaran')
            ->whereBetween('created_at', [$tanggalMulai . ' 00:00:00', $tanggalSelesai . ' 23:59:59'])
            ->sum('total_harga');

        $margin = $biayaDiterima - $biayaKeluar;

        // Data grafik pendapatan dan pengeluaran per bulan
        $grafikPendapatan = Transaksi::select(DB::raw('MONTH(created_at) as bulan'), DB::raw('SUM(total_harga) as total'))
            ->where('jenis_transaksi', 'pengeluaran')
            ->whereYear('created_at', now()->year)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->pluck('total', 'bulan');

        $grafikPengeluaran = Transaksi::select(DB::raw('MONTH(created_at) as bulan'), DB::raw('SUM(total_harga) as total'))
            ->where('jenis_transaksi', 'pemasukan')
            ->whereYear('created_at', now()->year)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->pluck('total', 'bulan');

        // Membuat data 12 bulan
        $pendapatanPerBulan = [];
        $pengeluaranPerBulan = [];
        $marginPerBulan = [];

        for ($bulan = 1; $bulan <= 12; $bulan++) {
            $pendapatan = $grafikPendapatan[$bulan] ?? 0;
            $pengeluaran = $grafikPengeluaran[$bulan] ?? 0;

            $pendapatanPerBulan[] = $pendapatan;
            $pengeluaranPerBulan[] = $pengeluaran;
            $marginPerBulan[] = $pendapatan - $pengeluaran;
        }

        // Produk dengan stok minimal
        $produkStokMinimal = \App\Models\Produk::with('varian')
            ->whereHas('varian', function ($query) {
                $query->where('stok_varian', '<', 10);
            })->limit(10)->get();

        // Produk terlaris
        $produkTerlaris = DB::table('transaksi_items')
            ->join('varian_produks', 'transaksi_items.nomor_sku', '=', 'varian_produks.nomor_sku')
            ->join('produks', 'varian_produks.produk_id', '=', 'produks.id')
            ->join('transaksis', 'transaksi_items.transaksi_id', '=', 'transaksis.id')
            ->where('transaksis.jenis_transaksi', 'pengeluaran')
            ->whereBetween('transaksis.created_at', [$tanggalMulai . ' 00:00:00', $tanggalSelesai . ' 23:59:59'])
            ->select('produks.nama_produk', DB::raw('SUM(transaksi_items.qty) as total_terjual'))
            ->groupBy('produks.id', 'produks.nama_produk')
            ->orderByDesc('total_terjual')
            ->limit(10)
            ->get();

        //Kenaikan Harga Produk
        $produkPerbandinganHarga = TransaksiItems::query()
            ->select(
                'transaksi_items.nomor_sku',
                DB::raw('MIN(transaksi_items.harga) as harga_awal'),
                DB::raw('MAX(transaksi_items.harga) as harga_sekarang')
            )
            ->join('transaksis', 'transaksi_items.transaksi_id', '=', 'transaksis.id')
            ->where('transaksis.jenis_transaksi', 'pemasukan')
            ->whereNotNull('transaksi_items.harga')
            ->groupBy('transaksi_items.nomor_sku')
            ->get()
            ->map(function ($item) {
                $hargaAwal = (float) $item->harga_awal;
                $hargaSekarang = (float) $item->harga_sekarang;
                $kenaikan = $hargaSekarang - $hargaAwal;
                $persentase = $hargaAwal > 0
                    ? ($kenaikan / $hargaAwal) * 100
                    : 0;

                // Ambil data varian dan produk
                $varian = VarianProduk::with('produk')
                    ->where('nomor_sku', $item->nomor_sku)
                    ->first();

                return [
                    'nomor_sku' => $item->nomor_sku,
                    'nama_produk' => $varian?->produk?->nama_produk ?? 'Produk',
                    'nama_varian' => $varian?->nama_varian ?? '',
                    'harga_awal' => $hargaAwal,
                    'harga_sekarang' => $hargaSekarang,
                    'kenaikan' => $kenaikan,
                    'persentase' => round($persentase, 2),
                ];
            })

            // Hanya produk yang mengalami kenaikan harga
            ->filter(function ($produk) {
                return $produk['kenaikan'] > 0;
            })
            // Urutkan berdasarkan nominal kenaikan terbesar
            ->sortByDesc('kenaikan')
            // Ambil 5 produk
            ->take(5)->values();

        $labelPerbandinganHarga = $produkPerbandinganHarga
            ->map(function ($produk) {
                return $produk['nama_produk']
                    . ($produk['nama_varian'] ? ' - ' . $produk['nama_varian'] : '');
            })
            ->toArray();

        $hargaAwalChart = $produkPerbandinganHarga
            ->map(function ($produk) {
                return $produk['harga_awal'];
            })
            ->toArray();

        $hargaSekarangChart = $produkPerbandinganHarga
            ->map(function ($produk) {
                return $produk['harga_sekarang'];
            })
            ->toArray();

        $kenaikanHargaChart = $produkPerbandinganHarga
            ->map(function ($produk) {
                return $produk['kenaikan'];
            })
            ->toArray();

        $persentaseKenaikanChart = $produkPerbandinganHarga
            ->map(function ($produk) {
                return $produk['persentase'];
            })
            ->toArray();

        return view('home', compact(
            'totalTransaksi',
            'barangMasuk',
            'barangKeluar',
            'biayaKeluar',
            'biayaDiterima',
            'margin',
            'tanggalMulai',
            'tanggalSelesai',
            'pageTitle',
            'pendapatanPerBulan',
            'pengeluaranPerBulan',
            'marginPerBulan',
            'produkStokMinimal',
            'produkTerlaris',
            'produkPerbandinganHarga',
            'labelPerbandinganHarga',
            'hargaAwalChart',
            'hargaSekarangChart',
            'kenaikanHargaChart',
            'persentaseKenaikanChart'
        ));
    }
}
