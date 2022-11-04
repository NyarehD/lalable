<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class PostsController extends Controller {
    public function index() {
        return Inertia::render("NewsFeed", [
            'posts' => Post::latest()->get(),
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ]);
    }

    public function create() {
    }

    public function store(Request $request) {
    }

    public function show(Post $post) {
    }

    public function edit(Post $post) {
    }

    public function update(Request $request, Post $post) {
    }

    public function destroy(Post $post) {
    }
}
