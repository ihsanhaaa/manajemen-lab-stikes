<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanBahan extends Model
{
    use HasFactory;

    protected $table = 'pengajuan_bahans';
    protected $guarded = ['id'];

    public function obatPengajuanBahans()
    {
        return $this->hasMany(ObatPengajuanBahan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
