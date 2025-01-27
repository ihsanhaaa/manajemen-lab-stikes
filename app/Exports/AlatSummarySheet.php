<?php

namespace App\Exports;

use App\Models\Alat;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Events\AfterSheet;

class AlatSummarySheet implements FromCollection, WithHeadings, WithEvents, WithCustomStartCell
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
        return Alat::with('alatMasuks') // Mengambil data relasi alatMasuks
            ->get()
            ->map(function ($alat) {
                // Mengambil data pertama dari relasi alatMasuks
                $alatMasuk = $alat->alatMasuks->first();

                return [
                    'nama_barang' => $alat->nama_barang,
                    'stok' => $alat->stok,
                    'ukuran' => $alat->ukuran,
                    'jumlah_masuk' => $alatMasuk ? $alatMasuk->jumlah_masuk : 0,
                    'tanggal_masuk' => $alatMasuk
                        ? Carbon::parse($alatMasuk->tanggal_masuk)->format('d-m-Y')
                        : '-', // Format: tanggal-bulan-tahun
                    'penyimpanan' => $alat->penyimpanan,
                    'letak_aset' => $alat->letak_aset,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Nama Barang',
            'Stok',
            'Ukuran',
            'Jumlah Masuk',
            'Tanggal Masuk',
            'Penyimpanan',
            'Letak Aset',
        ];
    }

    public function startCell(): string
    {
        // Data dimulai dari A3
        return 'A3';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Format nama bulan
                $namaBulan = Carbon::create()
                    ->month($this->bulan)
                    ->locale('id')
                    ->translatedFormat('F');
                
                // Tambahkan judul di A1
                $judul = "Laporan Stok Alat {$namaBulan} {$this->tahun}";
                $event->sheet->setCellValue('A1', $judul);

                // Merge dan format judul
                $event->sheet->getDelegate()->mergeCells('A1:G1'); // Sesuaikan jumlah kolom header
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
