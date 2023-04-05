<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseModelFactory extends Factory
{
    public function definition(): array
    {
        return [
            'course_name' => fake()->jobTitle(),
            'description' => fake()->text(250),
            'tag' => fake()->text(15),
            'cover_url' => 'https://images.unsplash.com/photo-1553877522-43269d4ea984?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=2070&q=80',
            'author' => User::factory(),
            'start_date' => fake()->date(),
            'end_date' => fake()->date(),
            'course_program' => [
                ['heading' => fake()->jobTitle(), 'description' => fake()->text()],
                ['heading' => fake()->jobTitle(), 'description' => fake()->text()],
            ],
        ];
    }
}
