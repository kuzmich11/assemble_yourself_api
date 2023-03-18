<?php

namespace App\QueryBuilders;

use App\Models\CourseModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class CoursesQueryBuilder extends QueryBuilder
{

    public Builder $model;
    public function __construct()
    {
        $this->model = CourseModel::query();
    }

    function getAll(): Collection
    {
        return $this->model->get();
    }
}
