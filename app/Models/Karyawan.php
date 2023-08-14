<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Karyawan extends Model
{
    use HasFactory,SoftDeletes;



    protected $fillable = [
        'nama_karyawan',
        'tgl_lahir',
        'jenis_kelamin',
        'alamat',
        'no_tlp',
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
