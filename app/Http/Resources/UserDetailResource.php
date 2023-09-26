<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id_karyawan' => $this->id_pegawai,
            'nama_karyawan' => $this->nama_karyawan,
            'tgl_lahir' => $this->tgl_lahir,
            'jenis_kelamin' => $this->jenis_kelamin,
            'alamat' => $this->alamat,
            'no_tlp' => $this->no_tlp,
            'gambar' => $this->image,
            'no_tlp' => $this->no_tlp,
            'jabatan_id'=> $this->jabatan_id,
            'status' =>$this->status
        ];
    }
}
