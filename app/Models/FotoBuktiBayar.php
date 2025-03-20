<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FotoBuktiBayar extends Model
{
    use HasFactory;

    protected $table = 'foto_bukti_bayars';
    protected $guarded = ['id'];

    public function konfirmasiPembayaran()
    {
        return $this->belongsTo(KonfirmasiPembayaran::class, 'konfirmasi_pembayaran_id');
    }
}
