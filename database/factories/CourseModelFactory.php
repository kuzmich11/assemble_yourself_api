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
            'cover_url' => fake()->url(),
            'author' => User::factory(),
            'start_date' => fake()->date(),
            'end_date' => fake()->date(),
            'course_program' => json_encode([
                'heading' => fake()->jobTitle(),
                'description' => fake()->text(),
            ]),
        ];
    }
}
