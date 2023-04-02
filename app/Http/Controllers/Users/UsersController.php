<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\EditRequest;
use App\Models\User;
use App\QueryBuilders\CoursesQueryBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * @OA\Tag(
 *     name="profile",
 *     description="Контроллер обеспечивает получение информации о пользователе и изменение профиля пользователя"
 * )
 */
class UsersController extends Controller
{
    /**
     * @OA\Get(
     *  path="/api/profile",
     *  summary="Информация о пользователе",
     *  description="Получение информации о пользователе по токену",
     *  operationId="getProfileByToken",
     *  tags={"profile"},
     *  security={ {"bearer_token": {} }},
     *  @OA\Response(
     *      response=200,
     *      description="Success",
     *      @OA\JsonContent(
     *          @OA\Property (
     *              property="User",
     *              type="object",
     *              ref="#/components/schemas/User",
     *          ),
     *          @OA\Property (
     *              property="Courses",
     *              type="object",
     *              ref="#/components/schemas/CourseModel",
     *          ),
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
    public function getProfileByToken (CoursesQueryBuilder $coursesQueryBuilder)
    {
        if ($user = auth()->user()) {
            $courses = $coursesQueryBuilder->getCoursesByAuthor($user->getKey());
            return response()->json([$user, $courses]);
        }
        return response(['message'=>'Вы не авторизованы'], 401);
    }

    /**
    * @OA\Put(
    *   path="/api/profile",
    *   summary="Изменение профиля пользователя",
    *   description="Изменение профиля пользователя. Пользователь должен быть авторизован",
    *   operationId="updateProfile",
    *   tags={"profile"},
    *   security={ {"bearer_token": {} }},
    *   @OA\Response(
    *      response=200,
    *      description="Success",
    *      @OA\JsonContent(ref="#/components/schemas/User"),
    *   ),
    *   @OA\Response(
    *     response=401,
    *     description="Пользователь не авторизован",
    *     @OA\JsonContent(
    *          @OA\Property(property="message", type="string", example="Авторизуйтесь для изменения профиля"),
    *     ),
    *   ),
    *   @OA\Response(
    *      response=422,
    *      description="Переданы не все обязательные поля пользователь с таким email уже существует",
    *      @OA\JsonContent(
    *          @OA\Property(property="message", type="string", example="Поле id обязательно для заполнения")
    *      )
    *   ),
    *   @OA\RequestBody (ref="#/components/requestBodies/UserArray"),
    * )
    */
    public function updateProfile (EditRequest $request)
    {
        $user = auth()->user();
//        dd($request);
        if (isset($user)) {
//            $request->validated();
//            $profile = User::where('id', '=', $user->getKey());

            if ($user->update([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
                'about' => $request['about'],
            ])) {
                return response($user, 200);
            }
//            return response(['message' => 'Вы пытаетесь поменять не свой профиль'], 403);
        }
        return response(['message' => 'Авторизуйтесь для изменения профиля'], 401);
    }

}
