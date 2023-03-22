<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
//            $table->foreignId('course_programs_id')->constrained()->cascadeOnDelete();
//            $table->foreignId('section_id')->constrained()->cascadeOnDelete();
//            $table->foreignId('image_id')->constrained()->cascadeOnDelete();
            $table->foreignId('author_id')->references('id')->on('users')->cascadeOnDelete();
            $table->string('title');
            $table->text('description');
            $table->timestamps('start_date');
            $table->timestamps('end_date');
            $table->float('price');
            $table->json('metadata')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
