<?php

namespace Database\Factories;

use App\Models\CourseModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContentModelFactory extends Factory
{
    public function definition(): array
    {
        return [
            'course_id' => CourseModel::factory(),
            'page' => fake()->unique()->randomNumber(2),
            'page_title' => fake()->jobTitle(),
            'content' => fake()->text(500),
        ];
    }
}
