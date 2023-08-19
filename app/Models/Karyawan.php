<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;

class Karyawan extends Model
{
    use HasApiTokens,HasFactory,SoftDeletes;



    protected $fillable = [
        'id_pegawai',
        'password',
        'nama_karyawan',
        'tgl_lahir',
        'jenis_kelamin',
        'alamat',
        'no_tlp',
        'image',
        'jabatan_id',
        'status',
    ];

    /**
     * Get the user that owns the Karyawan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function jabatan(): BelongsTo
    {
        return $this->belongsTo(Jabatan::class, 'jabatan_id', 'id');
    }
}
