<?php

namespace App\Http\Controllers\Courses;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function getCourses()
    {
        $courses = Course::get();
        foreach ($courses as $course) {
            $author = User::where('id', '=',  $course['author'])->get()->first();
            $course['author'] = $author['name'];
        }

        return response()->json($courses, 200);
    }

    public function getCourseById(int $id)
    {
        $course = Course::where('id', '=', $id)->first();
        $author = User::where('id', '=',  $course['author'])->get()->first();
        $course['author'] = $author['name'];

        if (!isset($course)) {
            return response(['message' => 'Такого курса не существует'], 404);
        }
        return response()->json($course, 200);
    }

    public function createCourse(Request $request)
    {
        $user = auth()->user();

        if (isset($user)) {
            $course_name = $request->get('course_name');
            $description = $request->get('description');
            $tag = $request->get('tag');
            $cover_url = $request->get('cover_url');
            $author = $user->getKey('id');
            $start_date = $request->get('start_date');
            $end_date = $request->get('end_date');
            $course_program = json_encode($request->get('course_program'));

            if (!isset($course_name) or !isset($description) or !isset($cover_url) or !isset($author) or !isset($course_program)) {
                return response(['message' => 'Заполнены не все обязательные поля'], 400);
            }
            $course = Course::create([
                'course_name' => $course_name,
                'description' => $description,
                'tag' => $tag,
                'cover_url' => $cover_url,
                'author' => $author,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'course_program' => $course_program,
            ]);
            if ($course) {
                return response(['message' => 'Success'], 200);
            }
            return response(['message' => 'Error'], 400);
        }
        return response(['message' => 'Курс может составлять только авторизованный пользователь'], 401);
    }
}
