<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\KaryawanResource;
use App\Http\Resources\KaryawanDetailResource;

class KaryawanController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $karyawan = Karyawan::orderBy('id_pegawai', 'asc')->get();
        return response()->json([
            'status' => true,
            'message' => 'Data Ditemukan',
            'data' => KaryawanResource::collection($karyawan),
        ]);

        // return KaryawanResource::collection($karyawan);
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        //
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {


        $validate =  $request->validate([
            'id_pegawai' => 'required|max:30',
            'password' => 'required|max:255',
            'nama_karyawan' => 'required|max:50',
            'tgl_lahir' => 'required|date',
            'jenis_kelamin' => 'required|max:10',
            'alamat' => 'required|max:100',
            'no_tlp' => 'required|numeric',
            'gambar' => 'required|image|mimes:png,jpeg,gif|max:2048',
            'jabatan_id' => 'required|numeric',
            'status' => 'required',
        ]);
        $extension = null;
        if ($request->gambar){
            $extension = time().'.'.$request->gambar->getClientOriginalExtension();

            Storage::putFileAs('photo_karyawan', $request->gambar, $extension);
        }



        $karyawan = Karyawan::create([
            'id_pegawai' => $request->id_pegawai,
            'password' => Hash::make($request->password),
            'nama_karyawan' => $request->nama_karyawan,
            'tgl_lahir' => $request->tgl_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'no_tlp' => $request->no_tlp,
            'image' => $extension,
            'jabatan_id' => $request->jabatan_id,
            'status' => $request->status,
        ]);



        return response()->json([
            'status' => true,
            'message' => 'Data Berhasil Di Simpan',
            'data' =>  new KaryawanDetailResource($karyawan),
        ]);


    }

    /**
    * Display the specified resource.
    *
    * @param  \App\Models\Karyawan  $karyawan
    * @return \Illuminate\Http\Response
    */
    public function show($id)
    {
        $karyawan = Karyawan::with('jabatan:id,jabatan')->find($id);

        try {

            if (!$karyawan) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data Tidak Ditemukan'
                ], 404); // Menggunakan kode status 404 untuk menandakan Not Found
            }

            return response()->json([
                'status' => true,
                'message' => 'Data Ditemukan',
                'data' =>  new KaryawanDetailResource($karyawan),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => "Gagal Melihat detail karyawan: " . $e->getMessage()
            ]);
        }


        // return new KaryawanDetailResource($karyawan);
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\Models\Karyawan  $karyawan
    * @return \Illuminate\Http\Response
    */
    public function edit(Karyawan $karyawan)
    {
        //
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Models\Karyawan  $karyawan
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, $id)
    {

        $karyawan = Karyawan::find($id);

        if (!$karyawan) {
            return response()->json([
                'status' => false,
                'message' => 'Data Tidak Ditemukan'
            ], 404);
        }

        try {
            $validate = $request->validate([
                'nama_karyawan' => 'required|max:50',
                'tgl_lahir' => 'required|date',
                'jenis_kelamin' => 'required|in:laki-laki,perempuan',
                'alamat' => 'required|max:100',
                'no_tlp' => 'required|numeric',
                'jabatan_id' => 'required|numeric',
                'status' => 'required|in:aktif,tidak aktif',
                'gambar' => 'nullable|mimes:png,jpg,gif,svg|max:2048',
            ], [
                'gambar.mimes' => 'Gambar hanya diperbolehkan berkestensi png, jpg, gif, svg'
            ]);

            $data = [

                'nama_karyawan' => $request->nama_karyawan,
                'tgl_lahir' => $request->tgl_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'alamat' => $request->alamat,
                'no_tlp' => $request->no_tlp,
                'jabatan_id' => $request->jabatan_id,
                'status' => $request->status,
            ];

            if ($request->hasFile('gambar')) {
                // Delete old image if exists
                if ($karyawan->image) {
                    $storage =  Storage::delete('photo_karyawan/' . $karyawan->image);

                }

                $extension = time() . '.' . $request->gambar->getClientOriginalExtension();
                Storage::putFileAs('photo_karyawan', $request->file('gambar'), $extension);

                $data = [
                    'image' => $extension
                ];

            }

            $karyawan->update($data);

            return response()->json([
                'status' => true,
                'message' => 'Data Berhasil Diupdate',
                'data' => new KaryawanDetailResource($karyawan),
            ]);
        } catch (\Exception $e) {
            // Log the exception for debugging
            Log::error("Error updating data karyawan: " . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => "Gagal mengupdate data karyawan: " . $e->getMessage()
            ]);
        }
    }


    /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Models\Karyawan  $karyawan
    * @return \Illuminate\Http\Response
    */
    public function destroy($id)
    {
        try {

            $karyawan = Karyawan::findOrFail($id);
            $karyawan->delete();

            return response()->json([
                'status' => true,
                'message' => 'Data Berhasil Dihapus',
                'data' =>  new KaryawanDetailResource($karyawan->loadMissing('jabatan:id,jabatan')),

            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => "Gagal menghapus karyawan: " . $e->getMessage()
            ]);
        }
    }
}
