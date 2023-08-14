<?php

use App\Http\Controllers\AuthenticationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KaryawanController;

//login
Route::post('login', [AuthenticationController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {

    //user
    Route::get('/user', [AuthenticationController::class, 'user']);

    Route::get('/karyawan', [KaryawanController::class, 'index']);
    Route::get('/karyawan/{id}', [KaryawanController::class, 'show']);
    Route::post('/karyawan', [KaryawanController::class, 'store']);
    Route::patch('/karyawan/{id}', [KaryawanController::class, 'update']);
    Route::delete('/karyawan/{id}', [KaryawanController::class, 'destroy']);



    Route::get('logout', [AuthenticationController::class, 'logout']);


});
