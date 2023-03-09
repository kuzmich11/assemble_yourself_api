<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'refresh', 'register']]);
    }

    public function register (Request $request) {

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
//                return response(['message' => 'Пользователь успешно зарегистрирован'], 201);
                return $this->login();
            }
            return response(['error' => true, 'message' => 'Не удалось зарегистрировать пользователя'], 400);
        }

        return response(['error' => true, 'message' => 'Пользователь с данным email уже существует'], 400);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return JsonResponse
     */
    public function refresh()
    {

        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return JsonResponse
     */
    protected function respondWithToken(string $token)
    {
        $cookie = cookie('token', $token);
//            json([
//            'access_token' => $token,
//            'token_type' => 'bearer',
//            'expires_in' => auth()->factory()->getTTL() * 60
//        ]));
        return response(['message' => 'Success'])->withCookie($cookie);
    }
}