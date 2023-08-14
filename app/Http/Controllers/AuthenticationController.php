<?php

namespace App\Http\Controllers;


use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;


class AuthenticationController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Email atau password salah'],
            ]);

        }

        $token = $user->createToken('Mongkek mokicrot');

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
