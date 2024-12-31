<?php

namespace App\Exports;

use App\Models\AlatRusak;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;

class AlatRusakSheet implements FromCollection
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
        // Format nama bulan
        $namaBulan = Carbon::create()->month($this->bulan)->translatedFormat('F');

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

        // Sisipkan judul, baris kosong, dan header
        $judul = [
            ["Laporan Alat Rusak Bulan {$namaBulan} Tahun {$this->tahun}"],
            ["", "", "", "", ""], // Baris kosong dengan jumlah kolom sesuai header
            ['Tanggal Rusak', 'Nama Alat', 'Jumlah Rusak', 'Keterangan', 'Status'],
        ];

        return collect(array_merge($judul, $data->toArray()));
    }
}
