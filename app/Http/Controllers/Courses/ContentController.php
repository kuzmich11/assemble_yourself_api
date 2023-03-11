<?php

namespace App\Http\Controllers\Courses;

use App\Http\Controllers\Controller;
use App\Models\ContentModel;
use App\Models\CourseModel;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    public function getContentByCourseId(int $id)
    {
        $content = ContentModel::where('course_id', '=', $id)->first();

        if (!isset($content)) {
            return response(['message' => 'Отсутсвует содержимое курса'], 404);
        }
        return response()->json($content->only('content'));
    }

    public function createContent(Request $request, int $id)
    {
        $user = auth()->user();

        if (isset($user)) {
            $course = CourseModel::where('id', '=', $id)->first();
            $author = $course['author'];

            if ($author === $user->getKey()) {
                $content = ContentModel::updateOrInsert(
                    ['course_id' => $course['id']],
                    ['content' => $request->get('content')]
                );
                if ($content) {
                    return response(['message' => 'Success'], 200);
                }
                return response(['message' => 'error'], 400);
            }
            return response(['message' => 'Содержание курса может создавать только автор курса'], 401);
        }
        return response(['message' => 'Содержание курса может создавать только авторизованый пользователь'], 401);
    }
}
