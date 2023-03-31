<?php

namespace App\Http\Controllers;

use App\Http\Requests\Users\CreateRequest;
use App\Models\User;

use App\QueryBuilders\CoursesQueryBuilder;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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

    public function register (CreateRequest $request)
    {

//        $name = $request->get('name');
//        $email = $request->get('email');
//        $password =  $request->get('password');
//
//        if (!isset($name) or !isset($email) or !isset($password)) {
//            return response(['error' => true, 'message' => 'Не удалось зарегистрировать пользователя'], 400);
//        }
//        if (User::where('email', '=', $email)->first() === null) {
        if ($valid = $request->validated()) {
            $user = User::create([
//                'name' => $name,
//                'email' => $email,
                ...$valid,
                'password' => Hash::make($request['password']),

            ]);
            if ($user->save()) {
                return $this->login();
            }
        }

            return response(['error' => true, 'message' => 'Не удалось зарегистрировать пользователя'], 400);
//        }

//        return response(['error' => true, 'message' => 'Пользователь с данным email уже существует'], 400);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return Application|\Illuminate\Foundation\Application|Response|ResponseFactory|JsonResponse
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
//    public function me(CoursesQueryBuilder $coursesQueryBuilder)
//    {
//        $user = auth()->user();
//        $courses = $coursesQueryBuilder->getCoursesByAuthor($user->getKey());
//        return response()->json([$user, $courses]);
//    }

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
     * @return Application|\Illuminate\Foundation\Application|Response|ResponseFactory
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
     * @return Application|ResponseFactory|\Illuminate\Foundation\Application|Response
     */
    protected function respondWithToken(string $token)
    {
        $access_token = cookie('access_token', $token, auth()->factory()->getTTL() * 5, secure: true, httpOnly: false); //связанная настройка с config/jwt.php
        $refresh_token = cookie('refresh_token', $token, secure: true, httpOnly: false);
//            json([
//            'access_token' => $token,
//            'token_type' => 'bearer',
//            'expires_in' => auth()->factory()->getTTL() * 60
//        ]));
        return response(['message' => 'Success'])->withCookie($access_token)->withCookie($refresh_token);
    }
}
