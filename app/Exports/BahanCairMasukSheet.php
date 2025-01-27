<?php

namespace App\Exports;

use App\Models\BahanMasuk;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Events\AfterSheet;

class BahanCairMasukSheet implements FromCollection, WithHeadings, WithEvents, WithCustomStartCell
{
    protected $bulan;
    protected $tahun;

    public function __construct($bulan, $tahun)
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    public function collection()
    {
        // Ambil data bahan masuk dengan filter bahan yang jenis_bahan != 'Padat'
        $data = BahanMasuk::with('bahan')
            ->whereMonth('tanggal_masuk', $this->bulan)
            ->whereYear('tanggal_masuk', $this->tahun)
            ->whereHas('bahan', function ($query) {
                $query->where('jenis_bahan', '!=', 'Padat');  // Filter bahan yang jenis_bahan tidak 'Padat'
            })
            ->get()
            ->map(function ($item) {
                return [
                    'tanggal_masuk' => Carbon::parse($item->tanggal_masuk)->translatedFormat('d F Y'),
                    'nama_bahan' => $item->bahan->nama_bahan ?? '-',
                    'kode_bahan' => $item->bahan->kode_bahan ?? '-',
                    'jenis_bahan' => $item->bahan->jenis_bahan ?? '-',
                    'jumlah_masuk' => $item->jumlah_masuk,
                    'harga_satuan' => $item->harga_satuan,
                    'total_harga' => $item->total_harga,
                ];
            });

        return $data;
    }

    public function headings(): array
    {
        return [
            'Tanggal Masuk',
            'Nama Bahan',
            'Kode Bahan',
            'Jenis Bahan',
            'Jumlah Masuk',
            'Harga Satuan',
            'Total Harga',
        ];
    }

    public function startCell(): string
    {
        // Data tabel dimulai dari A4
        return 'A3';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Format nama bulan dan tahun
                $namaBulan = Carbon::create()
                    ->month($this->bulan)
                    ->locale('id')
                    ->translatedFormat('F');

                // Tambahkan judul di A1
                $judul = "Laporan Bahan Masuk {$namaBulan} {$this->tahun}";
                $event->sheet->setCellValue('A1', $judul);

                // Merge dan format judul
                $event->sheet->getDelegate()->mergeCells('A1:G1');
                $event->sheet->getDelegate()->getStyle('A1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 14,
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                ]);

                // Tambahkan baris kosong di A2 untuk spasi
                $event->sheet->setCellValue('A2', '');
            },
        ];
    }
}
