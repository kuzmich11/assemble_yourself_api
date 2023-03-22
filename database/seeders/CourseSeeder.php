<?php

declare(strict_types=1);

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
        \DB::table('courses')->insert($this->getData(10));
    }

    private function getData($quantity): array
    {
        $data = [];
        for ($i = 0; $i < $quantity; $i++) {
            $data[] = [
//                'section_id' => mt_rand(1,10),
                'author_id' => mt_rand(1,10),
                'title' => \fake()->jobTitle(),
                'description' => \fake()->text(),
                'price' => round(mt_rand(100000, 100000000) / 100, 2),
                'start_date' => \now(),
                'end_date' => \now(),
            ];
        }
        return $data;
    }
}
