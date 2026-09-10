<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\IndexController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Client\UserController as ClientUserController;
use App\Http\Controllers\Client\PostController as ClientPostController;
use App\Http\Controllers\Client\StoryController as ClientStoryController;
use App\Http\Controllers\Client\CommentController as ClientCommentController;
use App\Http\Controllers\Client\PostActionController as ClientPostActionController;
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

    Route::post('follow' , [ClientUserController::class , 'follow'])->name('follow');
    Route::post('unfollow' , [ClientUserController::class , 'unfollow'])->name('unfollow');
    Route::get('follow-requests' , [ClientUserController::class , 'followRequests'])->name('follow.requests');
    Route::post('accept-follow' , [ClientUserController::class , 'acceptFollow'])->name('accept.follow');
    Route::get('search' , [HomeController::class , 'search'])->name('search');

    /* Story */
    Route::get('add-story' , [ClientStoryController::class , 'create'])->name('add.story');
    Route::post('store-story' , [ClientStoryController::class , 'store'])->name('store.story');
    Route::get('stories/{userId?}', [ClientStoryController::class, 'show'])->name('story.show');
    Route::delete('story/{id}', [ClientStoryController::class, 'destroy'])->name('story.destroy');

    /* Comment */
    Route::get('comments/{postId}' , [ClientCommentController::class , 'postComments'])->name('post.comments');
    Route::post('comments/{postId}' , [ClientCommentController::class , 'store'])->name('comment.store');
    Route::delete('comments/{id}' , [ClientCommentController::class , 'destroy'])->name('comment.destroy');

    /* Post Actions */
    Route::post('like' , [ClientPostActionController::class , 'like'])->name('like.post');
    Route::post('save' , [ClientPostActionController::class , 'save'])->name('save.post');
    Route::delete('dislike' , [ClientPostActionController::class , 'dislike'])->name('dislike.post');
    Route::delete('removeSave' , [ClientPostActionController::class , 'removeSave'])->name('remove.save');

    /* Profile */
    Route::get('saved-posts' , [ClientUserController::class , 'savedPosts'])->name('saved.posts');

    /* Media */
    Route::post('media/create' , [MediaController::class , 'create'])->name('media.create');
    Route::post('media/story' , [MediaController::class , 'story'])->name('media.story');
});

Route::prefix('admin')->middleware(['web' , 'auth:web'])->group(function () {

    Route::get('/panel' , [IndexController::class, 'index'])->name('admin.index');


    Route::resource('users' , UserController::class)->names('user');
});

Route::get('login' , [LoginController::class, 'index'])->name('login');
Route::get('clientLogin' , [LoginController::class, 'clientLogin'])->name('login');
Route::post('loginToClient' , [LoginController::class, 'loginToClient'])->name('loginToClient');
Route::post('loginToPanel' , [LoginController::class, 'login'])->name('loginToPanel');
