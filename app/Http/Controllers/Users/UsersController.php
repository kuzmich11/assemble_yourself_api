<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\EditRequest;
use App\Models\User;
use App\QueryBuilders\CoursesQueryBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function getProfileByToken (CoursesQueryBuilder $coursesQueryBuilder)
    {
        $user = auth()->user();
        $courses = $coursesQueryBuilder->getCoursesByAuthor($user->getKey());
        return response()->json([$user, $courses]);
    }


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
                return response(['id' => $user['id'], 'message' => 'Success'], 200);
            }
//            return response(['message' => 'Вы пытаетесь поменять не свой профиль'], 403);
        }
        return response(['message' => 'Авторизуйтесь для изменения профиля'], 401);
    }

}
