<?php

namespace App\Exports;

use App\Models\BahanMasuk;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;

class BahanCairMasukSheet implements FromCollection
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

        // Ambil data bahan masuk dengan relasi bahan, filter bahan yang jenis_bahan != 'Padat'
        $data = BahanMasuk::with('bahan')
            ->whereMonth('tanggal_masuk', $this->bulan)
            ->whereYear('tanggal_masuk', $this->tahun)
            ->whereHas('bahan', function($query) {
                $query->where('jenis_bahan', '!=', 'Padat');  // Filter bahan dengan jenis_bahan yang tidak sama dengan 'Padat'
            })
            ->get()
            ->map(function ($item) {
                return [
                    'tanggal_masuk' => Carbon::parse($item->tanggal_masuk)->translatedFormat('d F Y'),
                    'nama_bahan' => $item->bahan->nama_bahan ?? '-',
                    'kode_bahan' => $item->bahan->kode_bahan ?? '-',
                    'jenis_bahan' => $item->bahan->jenis_bahan ?? '-',
                    'jumlah_masuk' => $item->jumlah_masuk,
                    'harga_satuan' => $item->harga_satuan,
                    'total_harga' => $item->total_harga,
                ];
            });

        // Sisipkan judul dan baris kosong
        $judul = [
            ["Laporan Bahan Masuk Bulan {$namaBulan} Tahun {$this->tahun}"],
            ["", "", "", "", "", "", ""],
            ['Tanggal Masuk', 'Nama Bahan', 'Kode Bahan', 'Jenis Bahan', 'Jumlah Masuk', 'Harga Satuan', 'Total Harga'],
        ];

        return collect(array_merge($judul, $data->toArray()));
    }
}
