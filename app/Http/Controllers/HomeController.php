<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
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

        $biayaKeluar = Transaksi::where('jenis_transaksi', 'pengeluaran')
            ->whereBetween('created_at', [$tanggalMulai . ' 00:00:00', $tanggalSelesai . ' 23:59:59'])
            ->sum('total_harga');
        $biayaDiterima = Transaksi::where('jenis_transaksi', 'pemasukan')
            ->whereBetween('created_at', [$tanggalMulai . ' 00:00:00', $tanggalSelesai . ' 23:59:59'])
            ->sum('total_harga');

        $margin = $biayaDiterima - $biayaKeluar;

        // Data grafik pendapatan dan pengeluaran per bulan
        $grafikPendapatan = Transaksi::select(DB::raw('MONTH(created_at) as bulan'), DB::raw('SUM(total_harga) as total'))
            ->where('jenis_transaksi', 'pemasukan')
            ->whereYear('created_at', now()->year)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->pluck('total', 'bulan');

        $grafikPengeluaran = Transaksi::select(DB::raw('MONTH(created_at) as bulan'), DB::raw('SUM(total_harga) as total'))
            ->where('jenis_transaksi', 'pengeluaran')
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

        return view('home', compact('totalTransaksi', 'barangMasuk', 'barangKeluar', 'biayaKeluar', 'biayaDiterima', 'margin', 'tanggalMulai', 'tanggalSelesai', 'pageTitle', 'pendapatanPerBulan', 'pengeluaranPerBulan', 'marginPerBulan'));
    }
}
