<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function registration (Request $request) {

        $name = $request->get('name');
        $email = $request->get('email');
        $password =  $request->get('password');

        if (!isset($name) or !isset($email) or !isset($password)) {
            return response(['error' => true, 'message' => 'Не удалось зарегистрировать пользователя'], 400);
        }
        if (User::where('email', '=', $email)->first() === null) {
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
            ]);
            if ($user->save()) {
                return response(['message' => 'Пользователь успешно зарегистрирован'], 201);
            }
            return response(['error' => true, 'message' => 'Не удалось зарегистрировать пользователя'], 400);
        }

        return response(['error' => true, 'message' => 'Пользователь с данным email уже существует'], 400);
    }
}
