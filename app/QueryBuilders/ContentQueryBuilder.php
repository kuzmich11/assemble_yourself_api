<?php

namespace App\QueryBuilders;

use App\Models\ContentModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ContentQueryBuilder extends QueryBuilder
{

    public Builder $model;

    public function __construct()
    {
        $this->model = ContentModel::query();
    }


    public function getAll(): Collection
    {
        return $this->model->get();
    }

    public function getContentByCourseID (int $courseId): Collection
    {
        return $this->model->where('course_id', '=', $courseId)->get();
    }

    public function getPageWithContentByCourseId (int $courseId, int $page): MOdel|null
    {
        return $this->model->where([['course_id', '=', $courseId], ['page', '=', $page]])->first();
    }
}
