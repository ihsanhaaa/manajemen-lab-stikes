<?php

namespace App\Exports;

use App\Models\BahanKeluar;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class BahanKeluarSheet implements FromCollection
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

        // Ambil data bahan keluar dan kelompokkan berdasarkan tanggal dan nama bahan
        $data = BahanKeluar::with('bahan')
            ->whereMonth('tanggal_keluar', $this->bulan)
            ->whereYear('tanggal_keluar', $this->tahun)
            ->get()
            ->groupBy(function ($item) {
                // Kelompokkan berdasarkan tanggal_keluar dan nama_bahan
                return $item->tanggal_keluar . '-' . ($item->bahan->nama_bahan ?? '-');
            })
            ->map(function ($group) {
                // Jumlahkan jumlah_pemakaian untuk setiap grup
                return [
                    'tanggal_keluar' => Carbon::parse($group->first()->tanggal_keluar)->translatedFormat('d F Y'),
                    'nama_bahan' => $group->first()->bahan->nama_bahan ?? '-',
                    'kode_bahan' => $group->first()->bahan->kode_bahan ?? '-',
                    'jenis_bahan' => $group->first()->bahan->jenis_bahan ?? '-',
                    'jumlah_pemakaian' => $group->sum('jumlah_pemakaian'),
                ];
            })
            ->values(); // Reset indeks koleksi

        // Sisipkan judul, baris kosong, dan header
        $judul = [
            ["Laporan Bahan Keluar Bulan {$namaBulan} Tahun {$this->tahun}"],
            ["", "", "", "", ""],
            ['Tanggal Keluar', 'Nama Bahan', 'Kode Bahan', 'Jenis Bahan', 'Jumlah Pemakaian'],
        ];

        return collect(array_merge($judul, $data->toArray()));
    }
}
