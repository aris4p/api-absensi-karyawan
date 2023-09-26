<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\JabatanController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KaryawanController;


    //login
Route::post('login', [AuthenticationController::class, 'login']);



Route::middleware(['auth:sanctum'])->group(function () {

    //user
    Route::get('/user', [AuthenticationController::class, 'user']);
    // karyawawan
    Route::get('/karyawan', [KaryawanController::class, 'index']);
    Route::get('/karyawan/{id}', [KaryawanController::class, 'show']);
    Route::post('/karyawan', [KaryawanController::class, 'store']);
    Route::patch('/karyawan/{id}', [KaryawanController::class, 'update']);
    Route::delete('/karyawan/{id}', [KaryawanController::class, 'destroy']);
    //jabatan
    Route::get('/jabatan', [JabatanController::class, 'index']);
    Route::get('/jabatan/{id}', [JabatanController::class, 'show']);
    Route::post('/jabatan', [JabatanController::class, 'store']);
    Route::patch('/jabatan/{id}', [JabatanController::class, 'update']);
    Route::delete('/jabatan/{id}', [JabatanController::class, 'destroy']);

    //absensi
    Route::get('/absensi', [AbsensiController::class, 'index']);
    Route::get('/absensi/{id}', [AbsensiController::class, 'show']);
    Route::post('/absensi', [AbsensiController::class, 'store']);
    Route::patch('/absensi', [AbsensiController::class, 'update']);

    Route::get('logout', [AuthenticationController::class, 'logout']);


});

