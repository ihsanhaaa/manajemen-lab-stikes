<?php

namespace App\Exports;

use App\Models\Obat;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Events\AfterSheet;

class ObatSummarySheet implements FromCollection, WithHeadings, WithEvents, WithCustomStartCell
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
        return Obat::with(['stokMasuks', 'stokKeluars'])
            ->get()
            ->map(function ($obat) {
                // Menjumlahkan semua stok masuk dan stok keluar tanpa filter bulan/tahun
                $stokMasuk = $obat->stokMasuks->sum('jumlah_masuk'); // Menjumlahkan seluruh stok masuk
                $stokKeluar = $obat->stokKeluars->sum('jumlah_pemakaian'); // Menjumlahkan seluruh stok keluar

                return [
                    'kode_obat' => $obat->kode_obat,
                    'nama_obat' => $obat->nama_obat,
                    'kekuatan_obat' => $obat->kekuatan_obat,
                    'kemasan' => $obat->kemasan_id ? $obat->kemasan->nama_kemasan : '-',
                    'bentuk_sediaan' => $obat->bentuk_sediaan_id ? $obat->bentukSediaan->nama_bentuk_sediaan : '-',
                    'exp_obat' => $obat->exp_obat,
                    'satuan' => $obat->satuan_id ? $obat->satuan->nama_satuan : '-',
                    'jumlah_masuk' => $stokMasuk > 0 ? $stokMasuk : 0, // Menampilkan jumlah stok masuk
                    'jumlah_keluar' => $stokKeluar > 0 ? $stokKeluar : 0, // Menampilkan jumlah stok keluar
                    'stok_obat' => number_format($obat->stok_obat + $stokMasuk - $stokKeluar, 0), // Menghitung stok obat yang terhitung
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
                $judul = "Laporan Stok Obat {$namaBulan} {$this->tahun}";
                $event->sheet->setCellValue('A1', $judul);

                // Merge dan format judul
                $event->sheet->getDelegate()->mergeCells('A1:J1'); // Menambahkan 1 kolom lebih untuk mencocokkan jumlah kolom
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
