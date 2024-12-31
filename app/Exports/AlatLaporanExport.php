<?php

namespace App\Exports;

use App\Models\AlatMasuk;
use App\Models\AlatRusak;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class AlatLaporanExport implements WithMultipleSheets
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
            new AlatMasukSheet($this->bulan, $this->tahun),
            new AlatRusakSheet($this->bulan, $this->tahun),
        ];
    }
}
