<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostPhoto;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class PostController extends Controller {
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
        return Inertia::render("Post/PostCreate");
    }

    public function store(Request $request) {
        // Validating the uploaded images
        if ($request->hasFile("photos.*")) {
            // For saving names of saved images
            $fileNameArr = [];
            // Saving images in storage
            foreach ($request->file("photos.*") as $file) {
                $newName = uniqid() . "_photos." . $file->getClientOriginalExtension();
                array_push($fileNameArr, $newName);
                $file->storeAs('public/post', $newName);
            }
        }

        $request->validate([
            "description" => "nullable|string",
            "photos.*" => "mimetypes:image/jpeg,image/png"
        ]);
        $post = new Post();
        $post->description = $request['description'];
        $post->user_id = Auth::id();
        $post->save();
        // Saving the saved photo in database records
        if (isset($fileNameArr)) {
            foreach ($fileNameArr as $fileName) {
                $postPhoto = new PostPhoto();
                $postPhoto->post_id = $post->id;
                $postPhoto->filename = $fileName;
                $postPhoto->save();
            }
        }
        return redirect()->route("newsfeed")->with("message", "Post Created");
    }

    public function show(Post $post) {
        $post = $post->post_photos;
        return Inertia::render("Post/PostShow", ["post" => $post]);
    }

    public function edit(Post $post) {
        if (Gate::allows("post_owner", $post)) {
            return Inertia::render("Post/PostEdit", ["post" => [$post, $post->post_photos()]]);
        }
        return abort(403);
    }

    public function update(Request $request, Post $post) {
    }

    public function destroy(Post $post) {
    }
}
