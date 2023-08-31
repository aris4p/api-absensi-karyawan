<?php

namespace App\Http\Controllers;

use App\Http\Resources\AbsensiResource;
use Carbon\Carbon;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index(Request $request)
    {

        $fromDate = $request->fromDate;
        // dd($request->fromDate);
        $toDate = $request->toDate;
        // Melakukan query menggunakan Eloquent
        $absensi = Absensi::with('karyawan')->whereDate('jam_masuk', '>=', $fromDate)
        ->whereDate('jam_masuk', '<=', $toDate)
        ->get();
        // $absensi = Absensi::get();

        return response()->json([
            'status' => true,
            'message' => "Data Berhasil Didapatkan",
            'data' => AbsensiResource::collection($absensi),
        ]);
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
        $validation = $request->validate([
            'absensi_id' => 'required',
            'karyawan_id' => 'required',

        ]);

        // dd($request->all());
        $jam_masuk = Carbon::now()->format('Y-m-d H:i:s');
        $absensi = Absensi::where('karyawan_id', $request->karyawan_id)
        ->whereDate('jam_masuk', now())
        ->first();
        if($absensi){
            return response()->json([
                'Anda sudah absen masuk'
            ]);
        }

        // $data = [
            //     'absen_id' => $request->absensi_id,
            //     'karyawan_id' => $request->karyawan_id,
            //     'jam_masuk' => $jam_masuk
            // ];
            // $absensi = Absensi::create($data);

            $absensi_id = $request->input('absensi_id');
            $karyawan_id = $request->input('karyawan_id');
            $keterangan = $request->input('keterangan');

            // Buat instance model Absensi
            $absensi = new Absensi();
            $absensi->absen_id = $absensi_id;
            $absensi->karyawan_id = $karyawan_id;
            $absensi->jam_masuk = $jam_masuk;
            $absensi->keterangan = $keterangan;

            // Simpan data ke dalam database
            $absensi->save();

            return response()->json([
                'status' => true,
                'message' => "Data Berhasil Didapatkan",
                'data' => $absensi
            ]);

        }

        /**
        * Display the specified resource.
        *
        * @param  \App\Models\Absensi  $absensi
        * @return \Illuminate\Http\Response
        */
        public function show(Absensi $absensi)
        {
            //
        }

        /**
        * Show the form for editing the specified resource.
        *
        * @param  \App\Models\Absensi  $absensi
        * @return \Illuminate\Http\Response
        */
        public function edit(Absensi $absensi)
        {
            //
        }

        /**
        * Update the specified resource in storage.
        *
        * @param  \Illuminate\Http\Request  $request
        * @param  \App\Models\Absensi  $absensi
        * @return \Illuminate\Http\Response
        */
        public function update(Request $request)
        {
            $validation = $request->validate([
                'karyawan_id' => 'required',
            ]);
            $jam_keluar = Carbon::now()->format('Y-m-d H:i:s');
            $absensi = Absensi::where('karyawan_id', $request->karyawan_id)
            ->whereDate('jam_masuk', now())
            ->first();
            if(!$absensi){
                return response()->json([
                    'Anda belum absen masuk, silahkan absen masuk terlebih dahulu'
                ]);

            }

            if(!$absensi->jam_keluar){
                $absensi->jam_keluar = $jam_keluar;
                $absensi->keterangan = "Hadir";
                $absensi->save();

                return response()->json([
                    "Absen keluar berhasil pada jam $jam_keluar"
                ]);
            }else{
                return response()->json([
                    "Anda Sudah Absen Keluar pada jam $absensi->jam_keluar"
                ]);
            }



        }

        /**
        * Remove the specified resource from storage.
        *
        * @param  \App\Models\Absensi  $absensi
        * @return \Illuminate\Http\Response
        */
        public function destroy(Absensi $absensi)
        {
            //
        }
    }
