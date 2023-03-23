<?php

namespace App\QueryBuilders;

use App\Models\CourseModel;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class CoursesQueryBuilder extends QueryBuilder
{

    public Builder $model;

    public function __construct()
    {
        $this->model = CourseModel::query();
    }

    function getAll(): Collection
    {
        $courses = $this->model->get();
        foreach ($courses as $course) {
            $author = User::where('id', '=', $course['author'])->get()->first();
            $course['author'] = $author['name'];
        }
        return $courses;
    }

    public function getCoursesWithPagination(int $quantity = 10): LengthAwarePaginator
    {
        $courses = $this->model->paginate($quantity);
        foreach ($courses as $course) {
            $author = User::where('id', '=', $course['author'])->get()->first();
            $course['author'] = $author['name'];
        }
        return $courses;
    }

    public function getCourseById($id): Model
    {
        $course = $this->model->where('id', '=', $id)->sole();
        $author = User::where('id', '=',  $course['author'])->get()->first();
        $course['author'] = $author['name'];

        return $course;
    }

}
