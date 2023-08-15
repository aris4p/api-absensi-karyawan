<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class KaryawanResource extends JsonResource
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
            'nama_karyawan' => $this->nama_karyawan,
            'tgl_lahir' => $tgl_lahir,
            'jenis_kelamin' => $this->jenis_kelamin,
            'alamat' => $this->alamat,
            'no_tlp' => $this->no_tlp,
            'image' => $this->image,
            'jabatan_id' => $this->jabatan_id,
            'status' => $this->status,

        ];
    }
}
