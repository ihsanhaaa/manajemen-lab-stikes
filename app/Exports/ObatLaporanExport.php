<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ObatLaporanExport implements WithMultipleSheets
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
            new ObatSummarySheet($this->bulan, $this->tahun),
            new ObatMasukSheet($this->bulan, $this->tahun),
            new ObatKeluarSheet($this->bulan, $this->tahun),
        ];
    }
}
