<?php

namespace App\Exports;

use App\Models\Alat;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class RekapAlatExport implements FromCollection, WithHeadings, WithCustomStartCell, WithEvents
{
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
        return 'A4'; // Data tabel akan dimulai dari sel A4
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Menambahkan judul "Rekap Asset Lab" pada sel A1
                $event->sheet->setCellValue('A1', 'Rekap Asset Lab');

                // Memformat judul agar rata tengah dan tebal
                $event->sheet->getDelegate()->mergeCells('A1:G1'); // Menggabungkan sel A1 sampai G1
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
            },
        ];
    }
}
