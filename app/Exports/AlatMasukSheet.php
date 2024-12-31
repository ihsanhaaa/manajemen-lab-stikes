<?php

namespace App\Exports;

use App\Models\AlatMasuk;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;

class AlatMasukSheet implements FromCollection
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

        $data = AlatMasuk::with('alat')
            ->whereMonth('tanggal_masuk', $this->bulan)
            ->whereYear('tanggal_masuk', $this->tahun)
            ->get()
            ->map(function ($item) {
                return [
                    'tanggal_masuk' => Carbon::parse($item->tanggal_masuk)->translatedFormat('d F Y'),
                    'nama_barang' => $item->alat->nama_barang ?? '-',
                    'jumlah_masuk' => $item->jumlah_masuk,
                    'harga_satuan' => $item->harga_satuan,
                    'total_harga' => $item->total_harga,
                ];
            });

        // Sisipkan judul dan baris kosong
        $judul = [
            ["Laporan Alat Masuk Bulan {$namaBulan} Tahun {$this->tahun}"],
            ["", "", "", "", ""], // Baris kosong
            ['Tanggal Masuk', 'Nama Alat', 'Jumlah Masuk', 'Harga Satuan', 'Total Harga'],
        ];

        return collect(array_merge($judul, $data->toArray()));
    }
}
