<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable=['absen_id','karyawan_id','jam_masuk','jam_keluar','keterangan'];
}
