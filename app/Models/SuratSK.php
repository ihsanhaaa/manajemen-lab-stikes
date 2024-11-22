<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratSK extends Model
{
    use HasFactory;

    protected $table = 'surat_s_k_s';

    protected $guarded = ['id'];
}
