<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KonfirmasiPembayaran extends Model
{
    use HasFactory;

    protected $table = 'konfirmasi_pembayarans';
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    public function fotoBuktiBayars()
    {
        return $this->hasMany(FotoBuktiBayar::class, 'konfirmasi_pembayaran_id');
    }
}
