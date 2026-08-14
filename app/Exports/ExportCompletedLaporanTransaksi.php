<?php

namespace App\Exports;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use Override;

class ExportCompletedLaporanTransaksi implements FromCollection, WithHeadings, WithCustomStartCell, WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public mixed $transaksi;
    public mixed $tanggalAwal;
    public mixed $tanggalAkhir;
    public mixed $jenisTransaksi;

    public function __construct(mixed $transaksi, mixed $jenisTransaksi, mixed $tanggalAwal, mixed $tanggalAkhir)
    {
        $this->transaksi        = $transaksi;
        $this->jenisTransaksi   = $jenisTransaksi;
        $this->tanggalAwal      = $tanggalAwal;
        $this->tanggalAkhir     = $tanggalAkhir;
    }

    public function collection()
    {
        $result = collect();
        $data = $this->transaksi;

        foreach ($data as $index => $item) {
            $result[] = [
                'No'                => $index + 1,
                'Tanggal Transaksi' => Carbon::parse($item->created_at)->locale('id')->translatedFormat('l, d F Y'),
                'Nomor Transaksi'   => $item->transaksi->nomor_transaksi,
                'Pengirim'          => $item->transaksi->pengirim,
                'Kontak'            => $item->transaksi->kontak,
                'Produk'            => $item->produk,
                'Varian'            => $item->varian,
                'Qty'               => $item->qty,
                'Harga'             => number_format($item->harga),
                'Sub Total'       => number_format($item->sub_total),
            ];
        }

        return $result;
    }

    #[Override]
    public function headings(): array
    {
        return [
            'No',
            'Tanggal Transaksi',
            'Nomor Transaksi',
            'Pengirim',
            'Kontak',
            'Produk',
            'Varian',
            'Qty',
            'Harga',
            'Sub Total'
        ];
    }

    #[Override]
    public function startCell(): string
    {
        return 'A4';
    }

    #[Override]
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // judul dibaris 1, di merge dari A sampai J
                $event->sheet->mergeCells('A1:J1');
                $event->sheet->setCellValue('A1', 'LAPORAN TRANSAKSI ' . strtoupper($this->jenisTransaksi));
                $event->sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
                $event->sheet->getStyle('A1')->getAlignment()->setHorizontal('center');

                $periode = '-';
                if ($this->tanggalAwal && $this->tanggalAkhir) {
                    $periode = date('d M Y', strtotime($this->tanggalAwal)) . ' s/d ' . date('d M Y', strtotime($this->tanggalAkhir));
                }

                $event->sheet->mergeCells('A2:J2');
                $event->sheet->setCellValue('A2', 'Periode ' . $periode);
                $event->sheet->getStyle('A2')->getFont()->setSize(12);
                $event->sheet->getStyle('A2')->getAlignment()->setHorizontal('center');

                $lastRow = $event->sheet->getDelegate()->getHighestRow();
                $event->sheet->getStyle('A4:J' . $lastRow)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                // font size untuk setiap data yang di looping
                $event->sheet->getStyle('A4:J' . $lastRow)->getFont()->setSize(12);
                $event->sheet->getStyle('A5:J' . $lastRow)->getAlignment()->setHorizontal('center');

                // font heading
                $event->sheet->getStyle('A4:J4')->getFont()->setBold(true);
                $event->sheet->getStyle('A4:J4')->getAlignment()->setHorizontal('center');
            }
        ];
    }
}
