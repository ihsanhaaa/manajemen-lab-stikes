<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class BahanLaporanExport implements WithMultipleSheets
{
    protected $bulan;
    protected $tahun;

    public function __construct($bulan, $tahun)
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    public function sheets(): array
    {
        return [
            new BahanMasukSheet($this->bulan, $this->tahun),
            new BahanKeluarSheet($this->bulan, $this->tahun),
        ];
    }
}
