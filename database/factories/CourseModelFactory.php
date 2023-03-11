<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CourseModelFactory extends Factory
{
    public function definition(): array
    {
        return [
            'course_name' => fake()->jobTitle(),
            'description' => fake()->text(250),
            'tag' => fake()->text(15),
            'cover_url' => fake()->url(),
            'author' => 1,
            'start_date' => fake()->date('d-m-Y'),
            'end_date' => fake()->date('d-m-Y'),
            'course_program' => [
                'heading' => fake()->jobTitle(),
                'description' => fake()->text(),
            ],
        ];
    }
}
