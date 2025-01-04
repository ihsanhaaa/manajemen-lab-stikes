<?php

namespace App\Exports;

use App\Models\Obat;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;


class RekapObatExport implements FromCollection, WithHeadings, WithCustomStartCell, WithEvents
{
    public function collection()
    {
        // Ambil data obat dengan relasi stok_masuks dan stok_keluars
        return Obat::with(['stokMasuks', 'stokKeluars'])
            ->get()
            ->map(function ($obat) {
                // Mengambil data pertama untuk stok_masuk dan stok_keluar
                $stokMasuk = $obat->stokMasuks->first();
                $stokKeluar = $obat->stokKeluars->first();

                // dd($obat->stok_obat);

                return [
                    'kode_obat' => $obat->kode_obat,
                    'nama_obat' => $obat->nama_obat,
                    'kekuatan_obat' => $obat->kekuatan_obat,
                    'kemasan' => $obat->kemasan_id ? $obat->kemasan->nama_kemasan : '-',
                    'bentuk_sediaan' => $obat->bentuk_sediaan_id ? $obat->bentukSediaan->nama_bentuk_sediaan : '-',
                    'exp_obat' => $obat->exp_obat,
                    'satuan' => $obat->satuan_id ? $obat->satuan->nama_satuan : '-',
                    'jumlah_masuk' => $stokMasuk ? $stokMasuk->jumlah_masuk : '0',
                    'jumlah_keluar' => $stokKeluar ? $stokKeluar->jumlah_pemakaian : '0',
                    'stok_obat' => number_format($obat->stok_obat == 0.0 ? 0 : $obat->stok_obat, 0),
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Kode Obat',
            'Nama Obat',
            'Kekuatan Obat',
            'Kemasan',
            'Bentuk Sediaan',
            'Exp Obat',
            'Satuan',
            'Barang Masuk',
            'Barang Keluar',
            'Stok Obat',
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
                // Menambahkan judul "Rekap Obat" pada sel A1
                $bulanTahun = Carbon::now()->locale('id')->isoFormat('MMMM YYYY'); // Format: Januari 2025
                $event->sheet->setCellValue('A1', 'Laporan Stok Obat ' . $bulanTahun);

                // Memformat judul agar rata tengah dan tebal
                $event->sheet->getDelegate()->mergeCells('A1:J1'); // Menggabungkan sel A1 sampai J1
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
