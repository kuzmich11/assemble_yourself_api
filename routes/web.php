<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Admin\IndexController as AdminController;
use App\Http\Controllers\Api\Admin\UsersController as AdminUsersController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'is_admin'], static function() {
//    Route::get('/', AdminController::class)->name('index');
//});

Route::group(['prefix' => 'admin', 'as' => 'admin.'], static function() {
    Route::get('/', AdminController::class)->name('index');
    Route::resource('/users', AdminUsersController::class);
});


