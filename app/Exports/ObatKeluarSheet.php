<?php

namespace App\Exports;

use App\Models\StokKeluar;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;

class ObatKeluarSheet implements FromCollection
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

        // Sisipkan judul, baris kosong, dan header
        $judul = [
            ["Laporan Obat Keluar Bulan {$namaBulan} Tahun {$this->tahun}"],
            ["", "", "", ""],
            ['Tanggal Keluar', 'Nama Obat',  'Kode Obat', 'Jumlah Pemakaian'],
        ];

        return collect(array_merge($judul, $data->toArray()));
    }
}
