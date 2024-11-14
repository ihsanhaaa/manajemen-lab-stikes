<?php

namespace App\Imports;

use App\Models\Obat;
use App\Models\Kemasan;
use App\Models\BentukSediaan;
use App\Models\Satuan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ObatImport implements ToModel, WithStartRow
{
    /**
     * Mulai dari baris ke-2 untuk mengabaikan header.
     */
    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {
        // dd(isset($row[4]));
        $kemasan = Kemasan::where('nama_kemasan', $row[3])->first();
        $satuan = Satuan::where('nama_satuan', $row[3])->first();
        $bentuk_sediaan = BentukSediaan::where('nama_bentuk_sediaan', $row[4])->first();
        // dd($kemasan);

        return new Obat([
            'kode_obat' => $row[0] ?? null,
            'nama_obat' => $row[1] ?? null,
            'kekuatan_obat' => $row[2] ?? null,
            'kemasan_id' => $kemasan->id ?? null,
            'bentuk_sediaan_id' => $bentuk_sediaan->id ?? null,
            'exp_obat' => $row[5] ?? null,
            'satuan_id' => $satuan->id ?? null,
            'stok_obat' => $row[7] ?? 0,
        ]);
    }
}
