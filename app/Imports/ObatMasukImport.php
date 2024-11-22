<?php

namespace App\Imports;

use App\Models\Obat;
use App\Models\Kemasan;
use App\Models\BentukSediaan;
use App\Models\Foto;
use App\Models\Satuan;
use App\Models\StokMasuk;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ObatMasukImport implements ToModel, WithStartRow
{
    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {
        // dd( $row[7]);
        // Ambil nilai dari session
        $jumlahMasuk = session('jumlah_masuk');
        $tanggalMasuk = session('tanggal_masuk');

        // Cari atau buat kemasan, satuan, dan bentuk sediaan berdasarkan nama
        $kemasan = Kemasan::firstOrCreate(['nama_kemasan' => $row[3]]);
        $satuan = Satuan::firstOrCreate(['nama_satuan' => $row[6]]);
        $bentuk_sediaan = BentukSediaan::firstOrCreate(['nama_bentuk_sediaan' => $row[4]]);

        // Cari obat berdasarkan kode_obat
        $obat = Obat::where('kode_obat', $row[0])->first();

        if ($obat) {
            // Update data obat jika sudah ada
            $obat->update([
                'nama_obat' => $row[1] ?? null,
                'kekuatan_obat' => $row[2] ?? null,
                'kemasan_id' => $kemasan->id ?? null,
                'bentuk_sediaan_id' => $bentuk_sediaan->id ?? null,
                'exp_obat' => $row[5] ?? null,
                'satuan_id' => $satuan->id ?? null,
            ]);

            // Perbarui stok obat dan hitung sisa obat
            $obat->update([
                'sisa_obat' => $obat->stok_obat + ($row[7] ?? 0),
            ]);
        } else {
            // Jika belum ada, buat data obat baru
            $obat = Obat::create([
                'kode_obat' => $row[0] ?? null,
                'nama_obat' => $row[1] ?? null,
                'kekuatan_obat' => $row[2] ?? null,
                'kemasan_id' => $kemasan->id ?? null,
                'bentuk_sediaan_id' => $bentuk_sediaan->id ?? null,
                'exp_obat' => $row[5] ?? null,
                'satuan_id' => $satuan->id ?? null,
                'stok_obat' => $row[7] ?? 0,
                'sisa_obat' => $row[7] ?? 0,
            ]);
        }

        

        // Buat entri StokMasuk
        $stokMasuk = StokMasuk::create([
            'obat_id' => $obat->id,
            'jumlah_masuk' => $row[7] ?? 0,
            'tanggal_masuk' => $tanggalMasuk,
        ]);

        // Jika ada foto, simpan foto-foto
        if (isset($row['foto_path']) && is_array($row['foto_path'])) {
            foreach ($row['foto_path'] as $foto) {
                // Pastikan foto disimpan di folder 'fotos' dalam storage publik
                $path = $foto->store('fotos', 'public');

                // Simpan foto ke tabel foto
                Foto::create([
                    'stok_masuk_id' => $stokMasuk->id,
                    'foto_path' => $path,
                ]);
            }
        }

        // Kembalikan objek StokMasuk yang telah dibuat
        return $stokMasuk;
    }
}

