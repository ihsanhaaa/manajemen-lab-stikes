<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObatPengajuanBahan extends Model
{
    use HasFactory;

    protected $table = 'obat_pengajuan_bahans';
    protected $guarded = ['id'];

    public function obat()
    {
        return $this->belongsTo(Obat::class);
    }

    public function bahan()
    {
        return $this->belongsTo(Bahan::class);
    }

    public function pengajuanBahan()
    {
        return $this->belongsTo(PengajuanBahan::class);
    }
}
