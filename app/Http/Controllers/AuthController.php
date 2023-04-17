<?php

namespace App\Http\Controllers;

use App\Http\Requests\Users\CreateRequest;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;

/**
 * @OA\Tag(
 *     name="auth",
 *     description="Контроллер обеспечивает авторизацию и аутентификацию пользователя"
 * )
 */
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
    /**
     * @OA\Post(
     * path="/api/register",
     * summary="Регистрация",
     * description="Регистрация пользователя по email и паролю",
     * operationId="register",
     * tags={"auth"},
     * @OA\RequestBody(
     * required=true,
     * description="Pass user credentials",
     * @OA\JsonContent(
     * required={"name", "email", "password"},
     * @OA\Property(property="name", type="string", example="name"),
     * @OA\Property(property="email", type="string", format="email", example="user1@mail.com"),
     * @OA\Property(property="password", type="string", format="password", minLength=8, example="PassWord12345"),
     * @OA\Property(property="about", type="string", example="Обо мне"),
     * ),
     * ),
     * @OA\Response(
     * response=422,
     * description="Wrong credentials response",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Sorry, wrong email address or password. Please try again")
     * )
     * ),
     * * @OA\Response(
     * response=200,
     * description="Success",
     * @OA\JsonContent(
     * @OA\Property(property="user", type="object", ref="#/components/schemas/User"),
     * )
     * ),
     * )
     */
    public function register(CreateRequest $request)
    {
        if ($valid = $request->validated()) {
            $user = User::create([
                ...$valid,
                'password' => Hash::make($request['password']),
            ]);
            return response($user, 200);
//            if ($user->save()) {
//                return $this->login();
//            }
        }
        return response(['error' => true, 'message' => 'Не удалось зарегистрировать пользователя'], 400);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return Application|\Illuminate\Foundation\Application|Response|ResponseFactory|JsonResponse
     */
    /**
     * @OA\Post(
     * path="/api/login",
     * summary="Авторизация",
     * description="Авторизация пользователя по email и паролю",
     * operationId="login",
     * tags={"auth"},
     * @OA\RequestBody(
     * required=true,
     * description="Pass user credentials",
     * @OA\JsonContent(
     * required={"email", "password"},
     * @OA\Property(property="email", type="string", format="email", example="user1@mail.com"),
     * @OA\Property(property="password", type="string", format="password", minLength=8, example="PassWord12345"),
     * ),
     * ),
     * @OA\Response(
     * response=422,
     * description="Wrong credentials response",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Sorry, wrong email address or password. Please try again")
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="Success",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Success"),
     * ),
     *     @OA\Parameter(
     *         name="apiKey",
     *         in="cookie",
     *         description="access token",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     * @OA\Header(
     * header="Set-Cookie",
     *     @OA\Schema(type="access_token, refresh_token")
     * ),
     * ),
     * )
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->respondWithToken($token);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return JsonResponse
     */
    /**
     * @OA\Post(
     *  path="/api/logout",
     *  summary="Выход из системы",
     *  description="Выход из системы",
     *  operationId="logout",
     *  tags={"auth"},
     *  security={ {"bearer_token": {} }},
     *  @OA\Response(
     *      response=200,
     *      description="Success",
     *      @OA\JsonContent(
     *          @OA\Property(property="message", type="string", example="Successfully logged out"),
     *      ),
     *  ),
     *  @OA\Response(
     *     response=401,
     *     description="Пользователь не авторизован",
     *     @OA\JsonContent(
     *          @OA\Property(property="message", type="string", example="Unauthenticated."),
     *      ),
     *  ),
     * )
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
    /**
     * @OA\Post(
     *  path="/api/refresh",
     *  summary="Обновление токена",
     *  description="Обновление токена при истечении access_token",
     *  operationId="refresh",
     *  tags={"auth"},
     *  security={ {"bearer_token": {} }},
     *  @OA\Response(
     *      response=200,
     *      description="Success",
     *      @OA\JsonContent(
     *          @OA\Property(property="message", type="string", example="Success"),
     *      ),
     *     @OA\Parameter(
     *         name="apiKey",
     *         in="cookie",
     *         description="access token",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *      ),
     *      @OA\Header(
     *          header="Set-Cookie",
     *          @OA\Schema(type="access_token, refresh_token")
     *      ),
     *  ),
     *  @OA\Response(
     *     response=500,
     *     description="Токен в стоп-листе или неверный формат токена или токен отсутствует",
     *     @OA\JsonContent(
     *          @OA\Property(property="message", type="string", example="The token has been blacklisted"),
     *      ),
     *  ),
     * )
     */
    public function refresh()
    {
        try {
            return $this->respondWithToken(auth()->refresh());
        } catch (TokenBlacklistedException|JWTException $e) {
            return response(['message' => $e->getMessage()],500);
        }
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
        return response(['message' => 'Success', 'access_token' => $token, 'refresh_token' => $token])->withCookie($access_token)->withCookie($refresh_token);
    }
}
