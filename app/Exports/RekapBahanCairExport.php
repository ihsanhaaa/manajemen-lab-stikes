<?php

namespace App\Exports;

use App\Models\Bahan;
use App\Models\BahanMasuk;
use App\Models\BahanKeluar;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class RekapBahanCairExport implements FromCollection, WithHeadings, WithCustomStartCell, WithEvents
{
    public function collection()
    {
        return Bahan::where('jenis_bahan', '!=', 'Padat')
            ->get()
            ->map(function ($bahan) {
                // Mengambil total barang masuk dan keluar
                $barangMasuk = BahanMasuk::where('bahan_id', $bahan->id)->sum('jumlah_masuk');
                $barangKeluar = BahanKeluar::where('bahan_id', $bahan->id)->sum('jumlah_pemakaian');

                return [
                    'kode_bahan' => $bahan->kode_bahan,
                    'nama_bahan' => $bahan->nama_bahan,
                    'formula' => $bahan->formula,
                    'exp_bahan' => $bahan->exp_bahan,
                    'jenis_bahan' => $bahan->jenis_bahan,
                    'barang_masuk' => $barangMasuk,
                    'barang_keluar' => $barangKeluar,
                    'stok_bahan' => $bahan->stok_bahan,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Kode Bahan',
            'Nama Bahan',
            'Formula',
            'Exp Bahan',
            'Jenis Bahan',
            'Barang Masuk',
            'Barang Keluar',
            'Stok Bahan'
        ];
    }

    public function startCell(): string
    {
        return 'A3';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Mendapatkan bulan dan tahun saat ini
                $bulanTahun = Carbon::now()->locale('id')->isoFormat('MMMM YYYY'); // Format: Januari 2025

                // Menambahkan judul "Rekap Bahan Padat Januari 2025" pada sel A1
                $event->sheet->setCellValue('A1', 'Laporan Stok Bahan Cair ' . $bulanTahun);

                // Memformat judul agar rata tengah dan tebal
                $event->sheet->getDelegate()->mergeCells('A1:H1'); // Menggabungkan sel A1 sampai H1
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
