<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;
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
        $karyawan = Karyawan::query()->get();
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
            'nama_karyawan' => 'required|max:50',
            'tgl_lahir' => 'required|date',
            'jenis_kelamin' => 'required|max:10',
            'alamat' => 'required|max:100',
            'no_tlp' => 'required|numeric',
            'jabatan_id' => 'required|numeric',
            'status' => 'required',
        ]);

        $karyawan = Karyawan::create([
            'nama_karyawan' => $request->nama_karyawan,
            'tgl_lahir' => $request->tgl_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'no_tlp' => $request->no_tlp,
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
        $karyawan = Karyawan::with('jabatan:id,jabatan')->findOrFail($id);

        return response()->json([
            'status' => true,
            'message' => 'Data Ditemukan',
            'data' =>  new KaryawanDetailResource($karyawan),
        ]);


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
        try {

            $validate =  $request->validate([
                'nama_karyawan' => 'required|max:50',
                'tgl_lahir' => 'required|date',
                'jenis_kelamin' => 'required|max:10',
                'alamat' => 'required|max:100',
                'no_tlp' => 'required|numeric',
                'jabatan_id' => 'required|numeric',
                'status' => 'required',
            ]);

            $karyawan = Karyawan::findOrFail($id);

            $karyawan->update([
                'nama' => $request->nama_karyawan,
                'tgl_lahir' => $request->tgl_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'alamat' => $request->alamat,
                'no_tlp' => $request->no_tlp,
                'jabatan_id' => $request->jabatan_id,
                'status' => $request->status,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Data Berhasil Diupdate',
                'data' =>  new KaryawanDetailResource($karyawan),
            ]);

        } catch (\Exception $e) {
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
