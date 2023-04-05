<?php

namespace App\Http\Controllers\Courses;

use App\Http\Controllers\Controller;
use App\Models\ContentModel;
use App\Models\CourseModel;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="content",
 *     description="Контроллер обеспечивает все операции с курсами"
 * )
 */
class ContentController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/courses/{id}/content",
     *      summary="Получение контента курса",
     *      description="Получает курсы по ID курса",
     *      operationId="getContentByCourseId",
     *      tags={"content"},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="ID курса по которому выберается контент",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/ContentModel")
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Отсутсвует содержимое курса",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Отсутсвует содержимое курса"),
     *         ),
     *      ),
     * )
     */
    public function getContentByCourseId(int $id)
    {
        $content = ContentModel::where('course_id', '=', $id)->first();

        if (!isset($content)) {
            return response(['message' => 'Отсутсвует содержимое курса'], 404);
        }
        return response()->json($content);
    }

    /**
     * @OA\Patch(
     *       path="/api/courses/{id}/content",
     *       summary="Изменение содержания курса",
     *       description="Изменяет или создает контент курса с заданными параметрами",
     *       operationId="createContent",
     *       tags={"content"},
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
     *           @OA\JsonContent(ref="#/components/schemas/ContentModel")
     *       ),
     *       @OA\Response(
     *           response=422,
     *           description="Переданы не все обязательные поля",
     *           @OA\JsonContent(
     *               @OA\Property(property="message", type="string", example="Поле cousre_id обязательно для заполнения")
     *           ),
     *       ),
     *       @OA\Response(
     *           response=401,
     *           description="Пользователь не авторизован",
     *           @OA\JsonContent(
     *               @OA\Property(property="message", type="string", example="Содержание курса может создавать только авторизованый пользователь"),
     *           ),
     *       ),
     *       @OA\Response(
     *           response=403,
     *           description="Пользователь не автор курса",
     *           @OA\JsonContent(
     *               @OA\Property(property="message", type="string", example="Содержание курса может создавать только автор курса"),
     *           ),
     *       ),
     *       @OA\Response(
     *           response=404,
     *           description="Курса не существует",
     *           @OA\JsonContent(
     *               @OA\Property(property="message", type="string", example="Такого курса не существует"),
     *           ),
     *       ),
     *       @OA\RequestBody(
     *          request="ContentArray",
     *          description="Перечень свойств контента",
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="content", type="string", description="Содержание курса"),
     *          )
     *       )
     *   )
     */
    public function createContent(Request $request, int $id)
    {
        $user = auth()->user();

        if (isset($user)) {
            if ($course = CourseModel::where('id', '=', $id)->first()) {

                $author = $course['author'];

                if ($author === $user->getKey()) {
                    ContentModel::updateOrInsert(
                        ['course_id' => $course['id']],
                        ['content' => $request->get('content')]
                    );
                    $content = ContentModel::where('id', '=', $id)->first();
                    return response()->json($content);
                }
                return response(['message' => 'Содержание курса может создавать только автор курса'], 403);
            }
            return response(['message' => 'Такого курса не существует'], 404);

        }
        return response(['message' => 'Содержание курса может создавать только авторизованый пользователь'], 401);
    }
}
