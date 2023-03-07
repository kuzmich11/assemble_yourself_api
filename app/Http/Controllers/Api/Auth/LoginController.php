<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login (Request $request) {
        $creds = $request->only('email', 'password');
        if (!$token = auth()->attempt($creds)) {
            return response()->json(['error' => true, 'message' => 'Не верный email или password'], 401);
        }
        setcookie('token', $token, time()+60);
        return response()->json(['token' => $token], 200);
    }
}
