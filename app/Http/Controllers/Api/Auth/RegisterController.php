<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function registration (Request $request) {

        if (User::where('email', '=', $request->get('email'))->first() === null) {
            $user = User::create([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'password' => Hash::make($request->get('password')),
            ]);
            if ($user->save()) {
                return response(['message' => 'Пользователь успешно создан'], 201);
            }
            return response(['error' => true, 'message' => 'Не удалось зарегистрировать пользователя'], 400);
        }

        return response(['error' => true, 'message' => 'Пользователь с данным email уже существует'], 400);
    }
}
