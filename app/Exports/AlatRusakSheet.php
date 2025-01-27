<?php

namespace App\Exports;

use App\Models\AlatRusak;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Events\AfterSheet;

class AlatRusakSheet implements FromCollection, WithHeadings, WithEvents, WithCustomStartCell
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
        // Ambil data alat rusak
        $data = AlatRusak::with('alat')
            ->whereMonth('tanggal_rusak', $this->bulan)
            ->whereYear('tanggal_rusak', $this->tahun)
            ->get()
            ->map(function ($item) {
                return [
                    'tanggal_rusak' => Carbon::parse($item->tanggal_rusak)->translatedFormat('d F Y'),
                    'nama_barang' => $item->alat->nama_barang ?? '-',
                    'jumlah_rusak' => $item->jumlah_rusak,
                    'keterangan' => $item->nama_perusak,
                    'status' => $item->status == 1 ? 'Sudah diganti' : 'Belum diganti',
                ];
            });

        return $data;
    }

    public function headings(): array
    {
        return [
            'Tanggal Rusak',
            'Nama Alat',
            'Jumlah Rusak',
            'Keterangan',
            'Status',
        ];
    }

    public function startCell(): string
    {
        // Data tabel dimulai dari A3
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
                $judul = "Laporan Alat Rusak {$namaBulan} {$this->tahun}";
                $event->sheet->setCellValue('A1', $judul);

                // Merge dan format judul
                $event->sheet->getDelegate()->mergeCells('A1:F1');
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
