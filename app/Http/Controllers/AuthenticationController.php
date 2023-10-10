<?php

namespace App\Http\Controllers;

use App\Repositories\Auth\AuthRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Http\Request;



class AuthenticationController extends Controller
{


    private $authRepository;
    public function __construct(AuthRepository $authRepository) {
        $this->authRepository = $authRepository;
    }


    public function login(Request $request)
    {

        $token  = $this->authRepository->login($request);

        return response()->json([
            'status' => true,
            'code' => 200,
            'token' => $token->plainTextToken
        ]);


    }
    public function user()
    {
        $user = $this->authRepository->user();
        return $user;
    }

    public function logout(Request $request)
    {
        $logout =  $this->authRepository->logout($request);
        return $logout;
    }
}
