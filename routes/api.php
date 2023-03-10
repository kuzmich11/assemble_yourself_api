<?php


use App\Http\Controllers\AuthController;
use App\Http\Controllers\Courses\CourseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/



Route::group(['middleware' => 'api'], function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);

    Route::post('courses', [CourseController::class, 'createCourse']);

    Route::group(['middleware' => 'auth:api'], function () {

    });
});

Route::get('courses', [CourseController::class, 'getCourses']);
Route::get('courses/{id}', [CourseController::class, 'getCourseById']);
