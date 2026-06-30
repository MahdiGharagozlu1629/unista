<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\IndexController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Client\UserController as ClientUserController;
use App\Http\Controllers\Client\PostController as ClientPostController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(['middleware' => ['web' , 'auth:client']], function () {

    Route::get('/', [HomeController::class, 'index'])->name('index');
    Route::get('profile' , [ClientUserController::class , 'profile'])->name('profile');

    Route::get('post/create' , [ClientPostController::class , 'create'])->name('post.create');
    Route::post('post/store' , [ClientPostController::class , 'store'])->name('post.store');

    Route::get('users/{id}' , [ClientUserController::class , 'show'])->name('users.show');

    Route::post('media/create' , [MediaController::class , 'create'])->name('media.create');
});

Route::prefix('admin')->middleware(['web' , 'auth:web'])->group(function () {

    Route::get('/panel' , [IndexController::class, 'index'])->name('admin.index');


    Route::resource('users' , UserController::class)->names('user');
});

Route::get('login' , [LoginController::class, 'index'])->name('login');
Route::get('clientLogin' , [LoginController::class, 'clientLogin'])->name('login');
Route::post('loginToClient' , [LoginController::class, 'loginToClient'])->name('loginToClient');
Route::post('loginToPanel' , [LoginController::class, 'login'])->name('loginToPanel');
