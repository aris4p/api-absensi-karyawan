<?php

namespace App\Http\Controllers;

use App\Http\Resources\JabatanResource;
use App\Models\Jabatan;
use Illuminate\Http\Request;

class JabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jabatan = Jabatan::query()->get();

        return response()->json([
            "status" => true,
            "message" => "data berhasil didapatkan",
            "data" => JabatanResource::collection($jabatan)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'jabatan' => 'required'
        ],[
            'jabatan.required' => "Nama jabatan Wajib Diisi"
        ]);

        $data = [
            'jabatan' => $request->jabatan
        ];

        $jabatan = Jabatan::create($data);

        return response()->json([
            "status" => true,
            "message" => "data berhasil didapatkan",
            "data" => new JabatanResource($jabatan)
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Jabatan  $jabatan
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $jabatan = Jabatan::find($id);

        return response()->json([
            "status" => true,
            "message" => "data berhasil didapatkan",
            "data" => new JabatanResource($jabatan)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Jabatan  $jabatan
     * @return \Illuminate\Http\Response
     */
    public function edit(Jabatan $jabatan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Jabatan  $jabatan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {


        $request->validate([
            'jabatan' => 'required'
        ],[
            'jabatan.required' => "Nama jabatan Wajib Diisi"
        ]);

        $data = [
            'jabatan' => $request->jabatan
        ];

        $jabatan = Jabatan::find($id);
        $jabatan->update($data);

        return response()->json([
            "status" => true,
            "message" => "data berhasil didapatkan",
            "data" => new JabatanResource($jabatan)
        ]);



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Jabatan  $jabatan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
            $jabatan = Jabatan::findOrFail($id);
            $jabatan->delete();

            return response()->json([
                'status' => true,
                'message' => 'Data Berhasil Dihapus',
                'data' =>  new JabatanResource($jabatan)

            ]);
    }
}
