<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class BahanCairLaporanExport implements WithMultipleSheets
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
            new BahanCairSummarySheet($this->bulan, $this->tahun),
            new BahanCairMasukSheet($this->bulan, $this->tahun),
            new BahanCairKeluarSheet($this->bulan, $this->tahun),
        ];
    }
}
