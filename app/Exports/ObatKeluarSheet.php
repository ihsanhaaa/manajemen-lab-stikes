<?php

namespace App\Exports;

use App\Models\StokKeluar;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Events\AfterSheet;

class ObatKeluarSheet implements FromCollection, WithHeadings, WithEvents, WithCustomStartCell
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
        // Ambil data obat keluar dan kelompokkan berdasarkan tanggal dan nama obat
        $data = StokKeluar::with('obat')
            ->whereMonth('tanggal_keluar', $this->bulan)
            ->whereYear('tanggal_keluar', $this->tahun)
            ->get()
            ->groupBy(function ($item) {
                // Kelompokkan berdasarkan tanggal_keluar dan nama_obat
                return $item->tanggal_keluar . '-' . ($item->obat->nama_obat ?? '-');
            })
            ->map(function ($group) {
                // Jumlahkan jumlah_pemakaian untuk setiap grup
                return [
                    'tanggal_keluar' => Carbon::parse($group->first()->tanggal_keluar)->translatedFormat('d F Y'),
                    'nama_obat' => $group->first()->obat->nama_obat ?? '-',
                    'kode_obat' => $group->first()->obat->kode_obat ?? '-',
                    'jumlah_pemakaian' => $group->sum('jumlah_pemakaian'),
                ];
            })
            ->values(); // Reset indeks koleksi

        return $data;
    }

    public function headings(): array
    {
        return [
            'Tanggal Keluar',
            'Nama Obat',
            'Kode Obat',
            'Jumlah Pemakaian',
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
                $judul = "Laporan Obat Keluar {$namaBulan} {$this->tahun}";
                $event->sheet->setCellValue('A1', $judul);

                // Merge dan format judul
                $event->sheet->getDelegate()->mergeCells('A1:D1');
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
