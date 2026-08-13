<?php

namespace App\Http\Controllers;

use App\Exports\ExportBasicLaporanTransaksi;
use App\Http\Requests\ExportLaporanTransaksiRequest;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportLaporanTransaksiController extends Controller
{
    public function exportLaporanTransaksi(ExportLaporanTransaksiRequest $request)
    {
        $jenisTransaksi     = $request->jenis_transaksi;
        $pengirim           = $request->pengirim;
        $penerima           = $request->penerima;
        $tanggalAwal        = $request->tanggal_awal;
        $tanggalAkhir       = $request->tanggal_akhir;
        $isCompleted        = $request->is_completed;

        if ($isCompleted) {
            return $this->downloadFullReport($jenisTransaksi, $pengirim, $penerima, $tanggalAwal, $tanggalAkhir);
        } else {
            return $this->downloadBasicReport($jenisTransaksi, $pengirim, $penerima, $tanggalAwal, $tanggalAkhir);
        }
    }

    public function downloadBasicReport(string $jenisTransaksi, ?string $pengirim, ?string $penerima, ?string $tanggalAwal, ?string $tanggalAkhir)
    {
        $query = Transaksi::query();
        $query->where('jenis_transaksi', $jenisTransaksi);

        if ($jenisTransaksi == 'pemasukan' && $pengirim) {
            $query->where('pengirim', 'like', '%' . $pengirim . '%');
        }

        if ($jenisTransaksi == 'pengeluaran' && $penerima) {
            $query->where('penerima', 'like', '%' . $penerima . '%');
        }

        if ($tanggalAwal && $tanggalAkhir) {
            $tanggalAwal = Carbon::parse($tanggalAwal)->startOfDay();
            $tanggalAkhir = Carbon::parse($tanggalAkhir)->endOfDay();
            $query->whereBetween('created_at', [$tanggalAwal, $tanggalAkhir]);
        }

        $transaksi = $query->get();
        return Excel::download(
            new ExportBasicLaporanTransaksi($transaksi, $jenisTransaksi, $tanggalAwal, $tanggalAkhir),
            'LAPORAN TRANSAKSI ' . strtoupper($jenisTransaksi) . '.xlsx'
        );
    }

    public function downloadFullReport($jenisTransaksi, $pengirim, $penerima, $tanggalAwal, $tanggalAkhir) {}
}
