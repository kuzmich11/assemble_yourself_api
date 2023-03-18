<?php

namespace App\Http\Controllers\Courses;

use App\Http\Controllers\Controller;
use App\Models\CourseModel;
use App\Models\User;
use App\QueryBuilders\CoursesQueryBuilder;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function getCourses(CoursesQueryBuilder $coursesQueryBuilder)
    {
//        $courses = CourseModel::get();
//        foreach ($courses as $course) {
//            $author = User::where('id', '=',  $course['author'])->get()->first();
//            $course['author'] = $author['name'];
//            $course['course_program'] = json_decode($course['course_program']);
//        }
        $courses = $coursesQueryBuilder->getAll();

        return response()->json($courses);
    }

    public function getCourseById(CoursesQueryBuilder $coursesQueryBuilder, int $id)
    {
//        $course = CourseModel::where('id', '=', $id)->first();
//        $author = User::where('id', '=',  $course['author'])->get()->first();
//        $course['author'] = $author['name'];
//        $course['course_program'] = json_decode($course['course_program']);
        $course = $coursesQueryBuilder->getCourseById($id);

        if (!isset($course)) {
            return response(['message' => 'Такого курса не существует'], 404);
        }
        return response()->json($course);
    }

    public function createCourse(Request $request)
    {
        $user = auth()->user();

        if (isset($user)) {
            $course_name = $request->get('course_name');
            $description = $request->get('description');
            $tag = $request->get('tag');
            $cover_url = $request->get('cover_url');
            $author = $user->getKey();
            $start_date = $request->get('start_date');
            $end_date = $request->get('end_date');
//            dd($request->get('course_program'));
            $course_program = $request->get('course_program');

            if (!isset($course_name) or !isset($description) or !isset($cover_url) or !isset($author) or !isset($course_program)) {
                return response(['message' => 'Заполнены не все обязательные поля'], 400);
            }
            $course = CourseModel::create([
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
