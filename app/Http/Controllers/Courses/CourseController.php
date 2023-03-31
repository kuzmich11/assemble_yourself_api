<?php

namespace App\Http\Controllers\Courses;

use App\Http\Controllers\Controller;
use App\Http\Requests\Courses\CreateRequest;
use App\Models\ContentModel;
use App\Models\CourseModel;
use App\QueryBuilders\CoursesQueryBuilder;

class CourseController extends Controller
{
    public function getCourses(CoursesQueryBuilder $coursesQueryBuilder)
    {

        $courses = $coursesQueryBuilder->getAll();

        return response()->json($courses);
    }

    public function getCourseById(CoursesQueryBuilder $coursesQueryBuilder, int $id)
    {

        $course = $coursesQueryBuilder->getCourseById($id);

        if (!isset($course)) {
            return response(['message' => 'Такого курса не существует'], 404);
        }
        return response()->json($course);
    }

    public function createCourse(CreateRequest $request)
    {
        $user = auth()->user();

        if (isset($user)) {

            $valid = $request->validated();
            $course = CourseModel::create([
                ...$valid,
                'author' => $user->getKey(),
            ]);

            if (isset($course)) {
                ContentModel::create([
                    'course_id' => $course['id'],
                    'content' => "---
                    Hello world!!!

                    [![](https://avatars.githubusercontent.com/u/1680273?s=80&v=4)]
                    (https://avatars.githubusercontent.com/u/1680273?v=4)",
                ]);
                return response(['id' => $course['id'], 'message' => 'Success'], 200);
            }
            return response(['message' => 'Заполнены не все обязательные поля'], 400);
        }
        return response(['message' => 'Курс может составлять только авторизованный пользователь'], 401);
    }

    public function updateCourse(CreateRequest $request, CoursesQueryBuilder $coursesQueryBuilder, int $id)
    {
        $user = auth()->user();

        if (isset($user)) {
            $course = $coursesQueryBuilder->getCourseByIdWithAuthorId($id);
            if ($course) {

                if ($course['author'] === $user->getKey()) {
                    $valid = $request->validated();

                    if ($course->update([
                        ...$valid,
                        'author' => $user->getKey(),
                    ])) {
                        return response(['id' => $course['id'], 'message' => 'Success'], 200);
                    }
                    return response(['message' => 'Заполнены не все обязательные поля'], 400);
                }
                return response(['message' => 'Описание курса может менять только автор курса'], 403);
            }

            return response(['message' => 'Такого курса не существует'], 404);
        }
        return response(['message' => 'Курс может менять только авторизованный пользователь'], 401);
    }

    public function deleteCourse(CoursesQueryBuilder $coursesQueryBuilder, int $id)
    {
        $user = auth()->user();

        if (isset($user)) {
            $course = $coursesQueryBuilder->getCourseByIdWithAuthorId($id);

            if (isset($course)) {

                if ($course['author'] === $user->getKey()) {
                    $course->delete();
                    return response(['message' => 'Success'], 200);
                }
                return response(['message' => 'Курс может удалить только его создатель'], 403);
            }
            return response(['message' => 'Такого курса не существует'], 404);
        }
        return response(['message' => 'Курс может удалить только авторизованный пользователь'], 401);
    }
}
