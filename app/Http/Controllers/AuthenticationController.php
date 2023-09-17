<?php

namespace App\Http\Controllers;


use Exception;
use App\Models\User;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;


class AuthenticationController extends Controller
{
    public function login(Request $request)
    {

        $request->validate([
            'email' => 'required', // Menggunakan field 'email' untuk menerima username atau email
            'password' => 'required'
        ]);

        $type = filter_var($request->email, FILTER_VALIDATE_EMAIL) ? 'email' : 'id_pegawai';

        switch ($type) {
            case 'email':
                $user = User::where('email', $request->email)->first();
                if ($user && Hash::check($request->password, $user->password)) {
                    $model = $user;
                } else {
                    throw ValidationException::withMessages([
                        'email' => ['Email atau password salah'],
                    ]);
                }
                break;

                case 'id_pegawai':
                    $karyawan = Karyawan::where('id_pegawai', $request->email)->first();
                    if ($karyawan && Hash::check($request->password, $karyawan->password)) {
                        $model = $karyawan;
                    } else {
                        throw ValidationException::withMessages([
                            'email' => ['ID Pegawai atau password salah'],
                        ]);
                    }
                    break;

                    default:
                    throw ValidationException::withMessages([
                        'email' => ['Format input tidak valid'],
                    ]);
                    break;
                }


                // Generate token using Sanctum
                $token = $model->createToken('API Token');

                return response()->json([
                    'status' => true,
                    'token' => $token->plainTextToken
                ]);


            }

            public function user()
            {
                try {
                    $user = Auth::user();

                    if ($user) {
                        return response()->json([
                            'status' => true,
                            'data' => $user,
                        ]);
                    } else {
                        return response()->json([
                            'status' => false,
                            'message' => 'User not authenticated.',
                        ], 401); // Unauthorized
                    }
                } catch (\Exception $e) {
                    return response()->json([
                        'status' => false,
                        'message' => 'An error occurred.',
                        'error' => $e->getMessage(),
                    ], 500); // Internal Server Error
                }
            }

            public function logout(Request $request)
            {
                try {
                    $request->user()->currentAccessToken()->delete();
                    return ['message' => "Berhasil Logout"];
                } catch (Exception $e) {
                    return ['message' => "Gagal Logout: " . $e->getMessage()];
                }

            }
        }
