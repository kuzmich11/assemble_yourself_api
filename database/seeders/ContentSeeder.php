<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('contents')->insert($this->getData());
    }

    private function getData(): array
    {
        $data = [];
        for ($i = 1; $i<=10; $i++) {
            $data[] = [
                'course_id' => $i,
                'content' => fake()->text(500),
            ];
        }

        return $data;
    }
}
