<?php

namespace App\Http\Resources;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;

class KaryawanDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $tgl = $this->tgl_lahir;
        $tgl_lahir = date('d F Y', strtotime($tgl));


        return [
            'id' => $this->id,
            'id_pegawai' => $this->id_pegawai,
            'nama_karyawan' => $this->nama_karyawan,
            'tgl_lahir' => $tgl_lahir,
            'jenis_kelamin' => $this->jenis_kelamin,
            'alamat' => $this->alamat,
            'no_tlp' => $this->no_tlp,
            'image' => asset('storage/photo_karyawan/'.$this->image),
            'status' => $this->status,
            'jabatan_id' => $this->jabatan_id,
            'jabatan' => $this->whenLoaded('jabatan'),

        ];
    }
}
