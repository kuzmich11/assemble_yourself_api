<?php

namespace App\Http\Controllers\Courses;

use App\Http\Controllers\Controller;
use App\Http\Requests\Courses\CreateRequest;
use App\Models\ContentModel;
use App\Models\CourseModel;
use App\QueryBuilders\CoursesQueryBuilder;
use Illuminate\Http\Request;
use OpenApi\Annotations\OpenApi as OA;

 /**
 * @OA\Tag(
 *     name="courses",
 *     description="Контроллер обеспечивает все операции с курсами"
 * )
 */
class CourseController extends Controller
{
//    /**
//     * @OA\Get(
//     * path="/api/courses",
//     * summary="Получение курсов",
//     * description="Получает все курсы содержащиеся в базе",
//     * operationId="getCourses",
//     * tags={"courses"},
//     * @OA\Response(
//     *    response=200,
//     *    description="Success",
//     *    @OA\JsonContent(ref="#/components/schemas/CourseModel"),
//     *  )
//     * )
//     * )
//     */
    public function getCourses(CoursesQueryBuilder $coursesQueryBuilder)
    {

        $courses = $coursesQueryBuilder->getAll();

        return response()->json($courses);
    }

    /**
     * @OA\Get (
     *  path="/api/courses",
     *  summary="Получение курсов",
     *  description="Получает курсы c заданной фильтрацией по тэгам и заданной пагинацией",
     *  operationId="getCoursesWithPaginate",
     *  tags={"courses"},
     *  @OA\Response(
     *      response=200,
     *      description="Success",
     *      @OA\JsonContent(
     *          @OA\Property(
     *              property="tags",
     *              type="array",
     *              description="10 уникальных тэгов",
     *              @OA\Items (
     *                  type="string",
     *                  example="php",
     *              ),
     *          ),
     *          @OA\Property(
     *              property="num_page_paginate",
     *              type="integer",
     *              description="Количество страниц пагинации",
     *              example="1",
     *          ),
     *          @OA\Property (
     *              property="courses",
     *              type="array",
     *              description="Курсы с заданными параметрами",
     *              @OA\Items(
     *                  type="object",
     *                  ref="#/components/schemas/CourseModel",
     *              ),
     *          ),
     *      ),
     *  ),
     *  @OA\RequestBody (
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property (property="limit", type="integer", description="Количество выводимых на странице курсов", example="10"),
     *          @OA\Property (property="page", type="integer", description="Номер выводимой страницы пагинации", example="1"),
     *          @OA\Property (
     *              property="tags",
     *              type="array",
     *              description="Количество выводимых на странице курсов",
     *              @OA\Items (
     *                  type="string",
     *                  example="php",
     *              ),
     *          ),
     *      ),
     *  ),
     * )
     */
    public function getCoursesWithPaginate(CoursesQueryBuilder $coursesQueryBuilder, Request $request)
    {
        $limit = isset($request->limit) ? $request->limit : 10;
        $page = isset($request->page) ? $request->page : 1;
        $tags = isset($request->tags) ? $request->tags : null;

        $courses = $coursesQueryBuilder->getCoursesWithPagination($tags, $limit, $page);
        $allTags = CourseModel::pluck('tag')->take(10);
        $response['tags'] = $allTags;
        $response['num_page_paginate'] = $courses->lastPage();
        $response['courses'] = $courses->items();

        return response()->json($response);
    }

    /**
     * @OA\Get(
     * path="/api/courses/{id}",
     * summary="Получение курса",
     * description="Получает курсы по ID курса",
     * operationId="getCourseById",
     * tags={"courses"},
     * @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID по которому выберается курс",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(ref="#/components/schemas/CourseModel")
     *  ),
     * @OA\Response(
     *         response=404,
     *         description="Такого курса не существует",
     *         @OA\JsonContent(
     *          @OA\Property(property="message", type="string", example="Course not found"),
     *
     *         )
     *  ),
     * )
     */
    public function getCourseById(CoursesQueryBuilder $coursesQueryBuilder, int $id)
    {

        $course = $coursesQueryBuilder->getCourseById($id);

        if (!isset($course)) {
            return response(['message' => 'Такого курса не существует'], 404);
        }
        return response()->json($course);
    }

   /**
    *   @OA\Post(
    *       path="/api/courses",
    *       summary="Создание курса",
    *       description="Создает курс с заданными параметрами",
    *       operationId="createCourse",
    *       tags={"courses"},
    *       security={ {"bearer_token": {} }},
    *       @OA\Response(
    *           response=200,
    *           description="Success",
    *           @OA\JsonContent(ref="#/components/schemas/CourseModel")
    *       ),
    *       @OA\Response(
    *           response=422,
    *           description="Переданы не все обязательные поля",
    *           @OA\JsonContent(
    *               @OA\Property(property="message", type="string", example="Поле id обязательно для заполнения")
    *           ),
    *       ),
    *       @OA\Response(
    *           response=401,
    *           description="Пользователь не авторизован",
    *           @OA\JsonContent(
    *               @OA\Property(property="message", type="string", example="Курс может составлять только авторизованный пользователь"),
    *           ),
    *       ),
    *       @OA\RequestBody(ref="#/components/requestBodies/CourseArray")
    *   )
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

            if (isset($course)) {
                ContentModel::create([
                    'course_id' => $course['id'],
                    'page' => 1,
                    'page_title' => 'Hello world!!!',
                    'content' => "---
                    [![](https://avatars.githubusercontent.com/u/1680273?s=80&v=4)]
                    (https://avatars.githubusercontent.com/u/1680273?v=4)",
                ]);
                return response([$course], 200);
            }
            return response(['message' => 'Заполнены не все обязательные поля'], 422);
        }
        return response(['message' => 'Курс может составлять только авторизованный пользователь'], 401);
    }

    /**
     *   @OA\Patch(
     *       path="/api/courses/{id}",
     *       summary="Изменение курса",
     *       description="Изменяет курс с заданными параметрами",
     *       operationId="updateCourse",
     *       tags={"courses"},
     *       security={ {"bearer_token": {} }},
     *       @OA\Parameter(
     *           name="id",
     *           in="path",
     *           description="ID по которому выберается курс",
     *           required=true,
     *           @OA\Schema(
     *               type="integer"
     *           )
     *       ),
     *       @OA\Response(
     *           response=200,
     *           description="Success",
     *           @OA\JsonContent(ref="#/components/schemas/CourseModel")
     *       ),
     *       @OA\Response(
     *           response=422,
     *           description="Переданы не все обязательные поля",
     *           @OA\JsonContent(
     *               @OA\Property(property="message", type="string", example="Поле id обязательно для заполнения")
     *           ),
     *       ),
     *       @OA\Response(
     *           response=401,
     *           description="Пользователь не авторизован",
     *           @OA\JsonContent(
     *               @OA\Property(property="message", type="string", example="Курс может менять только авторизованный пользователь"),
     *           ),
     *       ),
     *       @OA\Response(
     *           response=404,
     *           description="Курса не существует",
     *           @OA\JsonContent(
     *               @OA\Property(property="message", type="string", example="Такого курса не существует"),
     *           ),
     *       ),
     *       @OA\Response(
     *           response=403,
     *           description="Пользователь не автор курса",
     *           @OA\JsonContent(
     *               @OA\Property(property="message", type="string", example="Описание курса может менять только автор курса"),
     *           ),
     *       ),
     *       @OA\RequestBody(ref="#/components/requestBodies/CourseArray")
     *   )
     */
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
                        return response([$course], 200);
                    }
                    return response(['message' => 'Заполнены не все обязательные поля'], 422);
                }
                return response(['message' => 'Описание курса может менять только автор курса'], 403);
            }

            return response(['message' => 'Такого курса не существует'], 404);
        }
        return response(['message' => 'Курс может менять только авторизованный пользователь'], 401);
    }

    /**
     *   @OA\Delete(
     *       path="/api/courses/{id}",
     *       summary="Изменение курса",
     *       description="Изменяет курс с заданными параметрами",
     *       operationId="deleteCourse",
     *       tags={"courses"},
     *       security={ {"bearer_token": {} }},
     *       @OA\Parameter(
     *           name="id",
     *           in="path",
     *           description="ID по которому удаляется курс",
     *           required=true,
     *           @OA\Schema(
     *               type="integer"
     *           )
     *       ),
     *       @OA\Response(
     *           response=200,
     *           description="Success",
     *           @OA\JsonContent(
     *               @OA\Property(property="message", type="string", example="Success"),
     *           ),
     *       ),
     *       @OA\Response(
     *           response=401,
     *           description="Пользователь не авторизован",
     *           @OA\JsonContent(
     *               @OA\Property(property="message", type="string", example="Курс может удалить только авторизованный пользователь"),
     *           ),
     *       ),
     *       @OA\Response(
     *           response=404,
     *           description="Курса не существует",
     *           @OA\JsonContent(
     *               @OA\Property(property="message", type="string", example="Такого курса не существует"),
     *           ),
     *       ),
     *       @OA\Response(
     *           response=403,
     *           description="Пользователь не автор курса",
     *           @OA\JsonContent(
     *               @OA\Property(property="message", type="string", example="Курс может удалить только его создатель"),
     *           ),
     *       ),
     *   )
     */
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
