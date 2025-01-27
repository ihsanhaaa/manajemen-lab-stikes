<?php

namespace App\Exports;

use App\Models\Bahan;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Events\AfterSheet;

class BahanSummarySheet implements FromCollection, WithHeadings, WithEvents, WithCustomStartCell
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
        // Ambil data bahan dengan jenis_bahan 'Padat'
        return Bahan::where('jenis_bahan', 'Padat')
            ->with(['bahanMasuks', 'bahanKeluars']) // Relasi untuk transaksi masuk dan keluar
            ->get()
            ->map(function ($item) {
                return [
                    $item->kode_bahan,
                    $item->nama_bahan,
                    $item->formula,
                    $item->exp_bahan,
                    $item->jenis_bahan,
                    $item->bahanMasuks->sum('jumlah_masuk'), // Total barang masuk
                    $item->bahanKeluars->sum('jumlah_pemakaian'), // Total barang keluar
                    $item->stok_bahan,
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
            'Stok Bahan',
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
                $judul = "Laporan Stok Bahan Padat {$namaBulan} {$this->tahun}";
                $event->sheet->setCellValue('A1', $judul);

                // Merge dan format judul
                $event->sheet->getDelegate()->mergeCells('A1:H1');
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
