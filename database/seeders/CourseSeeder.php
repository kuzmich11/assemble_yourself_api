<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        \DB::table('courses')->insert($this->getData());
    }

    private function getData(): array
    {
        $data = [];
        for ($i = 0; $i < 10; $i++) {
            $data[] = [
                'course_name' => fake()->jobTitle(),
                'description' => fake()->text(250),
                'tag' => fake()->text(15),
                'cover_url' => fake()->url(),
                'author' => 1,
                'start_date' => fake()->date(),
                'end_date' => fake()->date(),
                'course_program' => json_encode([
                    'heading' => fake()->jobTitle(),
                    'description' => fake()->text(250),
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        return $data;
    }
}
