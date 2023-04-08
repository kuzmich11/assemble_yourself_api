<?php

namespace App\Http\Controllers\Courses;

use App\Http\Controllers\Controller;
use App\Models\ContentModel;
use App\Models\CourseModel;
use App\QueryBuilders\ContentQueryBuilder;
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
     *      path="/api/courses/{id}/content/{page}",
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
     *              type="integer",
     *              example="1",
     *          ),
     *      ),
     *      @OA\Parameter (
     *          name="page",
     *          in="path",
     *          description="Номер страницы курса",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              example="1",
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent (
     *              type="object",
     *              @OA\Property (
     *                  property="total_page_in_course",
     *                  type="integer",
     *                  description="Количество страниц контента курса",
     *                  example="1",
     *              ),
     *              @OA\Property (property="page", ref="#/components/schemas/ContentModel")
     *          ),
     *     ),
     *      @OA\Response(
     *          response=404,
     *          description="Отсутсвует содержимое курса",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Отсутсвует содержимое курса"),
     *         ),
     *      ),
     * )
     */
    public function getContentByCourseId(ContentQueryBuilder $contentQueryBuilder, int $id, int $page)
    {
        $content = $contentQueryBuilder->getPageWithContentByCourseId($id, $page);

        if (!isset($content)) {
            return response(['message' => 'Отсутсвует содержимое курса'], 404);
        }

        $response['total_page_in_course'] = ContentModel::where('course_id', $id)->count();
        $response['page'] = $content;

        return response()->json($response);
    }

    /**
     * @OA\Patch(
     *      path="/api/courses/{id}/content/{page}",
     *      summary="Изменение содержания курса",
     *      description="Изменяет или создает контент курса с заданными параметрами",
     *      operationId="createContent",
     *      tags={"content"},
     *      security={ {"bearer_token": {} }},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="ID по которому выберается курс",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              example="1",
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="page",
     *          in="path",
     *          description="Номер страницы контента курса",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              example="1",
     *          )
     *      ),
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
     *              @OA\Property(property="page_title", type="string", description="Заголовок страницы курса"),
     *              @OA\Property(property="content", type="string", description="Содержание страницы курса"),
     *          )
     *       )
     *   )
     */
    public function createContent(Request $request, int $id, int $page)
    {
        $user = auth()->user();

        if (isset($user)) {
            if ($course = CourseModel::where('id', '=', $id)->first()) {

                $author = $course['author'];

                if ($author === $user->getKey()) {
                    ContentModel::updateOrCreate(
                        ['course_id' => $course['id'], 'page' => $page],
                        ['page_title'=> $request->get('page_title'),'content' => $request->get('content')]
                    );
                    $content = ContentModel::where([['course_id', '=', $id], ['page', '=', $page]])->first();
                    return response()->json($content);
                }
                return response(['message' => 'Содержание курса может создавать только автор курса'], 403);
            }
            return response(['message' => 'Такого курса не существует'], 404);

        }
        return response(['message' => 'Содержание курса может создавать только авторизованый пользователь'], 401);
    }
}
