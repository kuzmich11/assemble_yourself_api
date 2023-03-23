<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\ContentModel;
use App\Models\CourseModel;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

//        $this->call([
//            CourseSeeder::class,
//            ContentSeeder::class,
//        ]);

        User::factory()
            ->count(3)
            ->has(
                CourseModel::factory()
                    ->count(3)
                    ->state(function (array $attributes, User $user) {
                        return ['author' => $user->id];
                    })
                    ->has(
                        ContentModel::factory()
                            ->count(1)
                            ->state(function (array $attributes, CourseModel $course) {
                                return ['course_id' => $course->id];
                            })
                    )
            )
            ->create();
    }
}
