<?php

namespace App\Http\Controllers\Courses;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function getCourses ()
    {
        return response()->json(Course::get(), 200);
    }

    public function getCourseById (int $id)
    {
        $course = Course::where('id', '=', $id)->first();
        if (!isset($course)) {
            return response(['message' => 'Такого курса не существует'], 404);
        }
        return response()->json(Course::find($id), 200);
    }
}
