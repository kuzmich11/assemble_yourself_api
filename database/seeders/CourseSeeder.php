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
    public function run()
    {
        \DB::table('courses')->insert($this->getData());
    }

    private function getData(): array
    {
        $data = [];
        for ($i = 0; $i < 10; $i++) {
            $data[] = [
                'course_name' => fake()->jobTitle(),
                'author' => fake()->name(),
                'price' => rand(100, 1000),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        return $data;
    }
}
