<?php

namespace App\Http\Controllers\Courses;

use App\Http\Controllers\Controller;
use App\Http\Requests\Courses\CreateRequest;
use App\Models\CourseModel;
use App\Models\User;
use App\QueryBuilders\CoursesQueryBuilder;
use Illuminate\Http\Request;
use OpenApi\Annotations\OpenApi as OA;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      x={
 *          "logo": {
 *              "url": "https://via.placeholder.com/190x90.png?text=L5-Swagger"
 *          }
 *      },
 *      title="L5 OpenApi",
 *      description="L5 Swagger OpenApi description",
 *      @OA\Contact(
 *          email="darius@matulionis.lt"
 *      ),
 *     @OA\License(
 *         name="Apache 2.0",
 *         url="https://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * )
 */

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

    /**
     * @OA\Post(
     *     path="/api/courses",
     *     tags={"courses"},
     *     summary="Create course",
     *     description="This can only be done by the logged in course.",
     *     operationId="createCourse",
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     ),
     *     @OA\RequestBody(
     *         description="Create course object",
     *         required=true,
     *         @OA\JsonContent(ref="#/Models/CourseModel")
     *     )
     * )
     */
    public function createCourse(CreateRequest $request)
    {
        $user = auth()->user();

        if (isset($user)) {

            $valid = $request->validated();
            $course = CourseModel::create([
                ...$valid,
                'author' => $user->getKey(),
            ]);

            if ($course) {
                return response(['message' => 'Success'], 200);
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
                        return response(['message' => 'Success'], 200);
                    }
                    return response(['message' => 'Заполнены не все обязательные поля'], 400);
                }
                return response(['message' => 'Описание курса может менять только автор курса'], 401);
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
                return response(['message' => 'Курс может удалить только его создатель'], 401);
            }
            return response(['message' => 'Такого курса не существует'], 404);
        }
        return response(['message' => 'Курс может удалить только авторизованный пользователь'], 401);
    }
}
