<?php

namespace App\Repositories\Auth;

use Illuminate\Http\Request;

interface AuthRepository
{

    public function login(Request $request);
    public function user();
    public function logout(Request $request);
}
