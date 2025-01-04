<?php

namespace App\Exports;

use App\Models\StokMasuk;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;

class ObatMasukSheet implements FromCollection
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

        $data = StokMasuk::with('obat')
            ->whereMonth('tanggal_masuk', $this->bulan)
            ->whereYear('tanggal_masuk', $this->tahun)
            ->get()
            ->map(function ($item) {
                return [
                    'tanggal_masuk' => Carbon::parse($item->tanggal_masuk)->translatedFormat('d F Y'),
                    'nama_obat' => $item->obat->nama_obat ?? '-',
                    'kode_obat' => $item->obat->kode_obat ?? '-',
                    'jumlah_masuk' => $item->jumlah_masuk,
                    'harga_satuan' => $item->harga_satuan,
                    'total_harga' => $item->total_harga,
                ];
            });

        // Sisipkan judul dan baris kosong
        $judul = [
            ["Laporan Obat Masuk Bulan {$namaBulan} Tahun {$this->tahun}"],
            ["", "", "", "", "", ""],
            ['Tanggal Masuk' ,'Nama Obat', 'Kode Obat', 'Jumlah Masuk', 'Harga Satuan', 'Total Harga'],
        ];

        return collect(array_merge($judul, $data->toArray()));
    }
}
