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

    public function getCoursesWithPagination(array $tags = null, int $quantity = 10, int $page = 1): LengthAwarePaginator
    {
        if (isset($tags)) {
            $courses = $this->model->whereIn('tag', array_map('strtolower', $tags))->paginate($quantity, page: $page);
        } else {
            $courses = $this->model->paginate($quantity, page: $page);
        }
        foreach ($courses as $course) {
            $author = User::where('id', '=', $course['author'])->get()->first();
            $course['author'] = $author['name'];
        }

        return $courses;
    }

    public function getCourseById($id): Model|null
    {
        $course = $this->model->where('id', '=', $id)->first();
        if (isset($course)) {
            $author = User::where('id', '=',  $course['author'])->get()->first();
            $course['author'] = $author['name'];
        }

        return $course;
    }

    public function getCourseByIdWithAuthorId($id): Model|null
    {

        return $this->model->where('id', '=', $id)->first();

    }

    public function getCoursesByAuthor($author_id)
    {
        $courses = $this->model->where('author', '=', $author_id)->get();
        if (isset($courses)) {
            foreach ($courses as $course) {
                $author = User::where('id', '=', $author_id)->get()->first();
                $course['author'] = $author['name'];
            }
        }
        return $courses;
    }

    public function getTags ()
    {

        return $this->model->select('tag')->distinct()->limit(10);
    }

}
