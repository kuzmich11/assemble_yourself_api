<?php


use App\Http\Controllers\AuthController;
use App\Http\Controllers\Courses\ContentController;
use App\Http\Controllers\Courses\CourseController;
use App\Http\Controllers\Users\UsersController;
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
    Route::get('profile', [UsersController::class, 'getProfileByToken']);
    Route::put('profile', [UsersController::class, 'updateProfile']);

    Route::post('courses', [CourseController::class, 'createCourse']);

    Route::patch('courses/{id}', [CourseController::class, 'updateCourse']);

    Route::delete('courses/{id}', [CourseController::class, 'deleteCourse']);

    Route::patch('courses/{id}/content/{page}', [ContentController::class, 'createContent']);

    Route::group(['middleware' => 'auth:api'], function () {

    });
});

Route::get('courses', [CourseController::class, 'getCoursesWithPaginate']);
Route::get('courses/{id}', [CourseController::class, 'getCourseById']);

Route::get('courses/{id}/content/{page}', [ContentController::class, 'getContentByCourseId']);
