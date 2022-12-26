<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', [PostController::class, "index"])->name("newsfeed");
Route::middleware("auth")->group(function () {
    Route::resource("/post", PostController::class)->except("index");
    Route::prefix("/post")->group(function () {
        Route::controller(PostController::class)->group(function () {
            Route::post("/like", "like")->name("post.like");
            Route::post("/unlike", "unlike")->name("post.unlike");
            Route::post("/share", "share")->name("post.share");
            Route::controller(CommentController::class)->prefix("comment")->group(function () {
                Route::post("/store", "store")->name("comment.store");
            });
        });
    });

});
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get("/test", function () {
    return Inertia::render("Test");
});

require __DIR__ . '/auth.php';
