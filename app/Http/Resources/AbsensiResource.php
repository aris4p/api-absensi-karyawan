<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AbsensiResource extends JsonResource
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
            'absen_id' => $this->absen_id,
            'karyawan_data' => $this->whenLoaded('karyawan', function () {
                return $this->karyawan->only(['id_pegawai', 'nama_karyawan', 'tgl_lahir', 'jenis_kelamin', 'alamat', 'no_tlp']);
             }),
            'jam_masuk' => $this->jam_masuk,
            'jam_keluar' => $this->jam_keluar,
            'keterangan' => $this->keterangan,
        ];
    }
}
