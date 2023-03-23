<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CoursesTest extends TestCase
{



    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {

        $response = $this->getJson('/api/courses');

        $response->assertStatus(200);
    }
}
