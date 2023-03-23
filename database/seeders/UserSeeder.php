<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        \DB::table('users')->insert($this->getData(5));
    }

    public function getData($quantity): array
    {
        $data = [];
        for ($i = 0; $i < $quantity; $i++) {
            $data[] = [
                'username' => \fake()->userName(),
                'first_name' => \fake()->firstName(),
                'last_name' => \fake()->lastName(),
                'email' => \fake()->email(),
                'password' => str_repeat((string)$i, 5),
                'created_at' => \now(),
                'updated_at' => \now(),
            ];
        }
        return $data;
    }

}
