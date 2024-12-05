<?php

namespace App\Imports;

use App\Models\Alat;
use App\Models\AlatMasuk;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class AlatMasukImport implements ToModel, WithStartRow
{
    public function startRow(): int
    {
        return 6;
    }

    public function model(array $row)
    {
        // dd( $row);

        $namaBarang = strtolower(preg_replace('/\s+/', '', $row[0]));

        // Cek apakah alat sudah ada di database berdasarkan nama yang telah dibersihkan
        $alat = Alat::whereRaw("REPLACE(LOWER(nama_barang), ' ', '') = ?", [$namaBarang])->first();

        dd($alat);
        
        if ($alat) {
            $alat->update([
                'stok' => $alat->stok + ($row[5] ?? 0),
            ]);
        } else {
            $alat = Alat::create([
                'nama_barang' => $row[0] ?? null,
                'ukuran' => $row[2] ?? null,
                'jumlah' => $row[5] ?? null,
                'penyimpanan' => $row[6] ?? null,
                'letak_aset' => $row[7] ?? null,
            ]);
        }

        // Buat entri StokMasuk
        $alatMasuk = AlatMasuk::create([
            'alat_id' => $alat->id,
            'jumlah_masuk' => $row[5] ?? 0,
        ]);

        // Kembalikan objek StokMasuk yang telah dibuat
        return $alatMasuk;
    }
}
