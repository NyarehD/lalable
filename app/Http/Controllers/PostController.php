<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use App\Models\PostPhoto;
use App\Rules\PostExistsRule;
use App\Rules\UserHasLikedRule;
use App\Rules\UserHasNotLikedRule;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Storage;

class PostController extends Controller {
    public function index() {
        // This is for paginating of posts
        // $posts = Post::latest()->with("original_post")->withCount("allComments", "total_likes", "user_liked")->simplePaginate(12)->withPath(url("/api/post"));
        $posts = Cache::remember("all_posts", 60 * 60, function () {
            return Post::latest()->with("original_post")->withCount("allComments", "total_likes", "user_liked")->get();
        });

        return Inertia::render("NewsFeed", [
            'posts' => $posts,
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
            "description" => "nullable|string|required_without:photos",
            "photos" => "required_without:description",
            "photos.*" => "mimetypes:image/jpeg,image/png"
        ], [
                "description.required_without" => "Please either provide description or upload photos",
                "photos.required_without" => "Please either provide description or upload photos",
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

        // Removes all posts cache so that the newly added will be included
        Cache::forget("all_posts");

        return redirect()->route("newsfeed")->with(["message" => "Post Created Successfully"]);
    }

    public function show($id) {
        $post = Cache::remember("post_$id" . "_show", 60 * 60, function () use ($id) {
            return Post::findOrFail($id)->load([
                "comments" => [
                    "user:id,name,profile_picture",
                    // Replies are just comments
                    "replies",
                    // So calling replies.user is the same as calling comments.user
                    "replies.user"
                ]
            ]);
        });
        return Inertia::render("Post/PostShow", ["post" => $post]);
    }

    public function edit($id) {
        $post = Cache::remember("post_$id" . "_edit", 60 * 60, function () use ($id) {
            return Post::findOrFail($id);
        });
        if (Gate::allows("post_owner", $post)) {
            return Inertia::render("Post/PostEdit", ["post" => $post]);
        }
        return abort(403);
    }

    public function update(Request $request, Post $post) {
        if (Gate::allows("post_owner", $post)) {
            if ($request->hasFile("photos.*")) {
                $fileNameArr = [];
                foreach ($request->file("photos.*") as $file) {
                    $newName = uniqid() . "_photos." . $file->getClientOriginalExtension();
                    array_push($fileNameArr, $newName);
                    $file->storeAs('public/post', $newName);
                }
            }

            $request->validate([
                "description" => "nullable|string",
                "photos.*" => "mimetypes:image/jpeg,image/png",
            ]);

            $post->description = $request['description'];
            $post->update();

            if (isset($fileNameArr)) {
                foreach ($fileNameArr as $fileName) {
                    $postPhoto = new PostPhoto();
                    $postPhoto->post_id = $post->id;
                    $postPhoto->filename = $fileName;
                    $postPhoto->save();
                }
            }

            Cache::forget("all_posts");

            return redirect()->route("newsfeed");
        }
        return abort(403);
    }

    public function destroy(Post $post) {
        if (Gate::allows('post_owner', $post)) {
            if (isset($post->post_photos)) {
                foreach ($post->post_photos as $photo) {
                    Storage::delete('/public/post/' . $photo->filename);
                }
                $toDelete = $post->post_photos->pluck("id");
                PostPhoto::destroy($toDelete);
            }
            $post->delete();

            Cache::forget("all_posts");

            return response('', 200);
        } else {
            return abort(404);
        }
    }

    public function like(Request $request) {
        $request->validate([
            "post_id" => [new UserHasNotLikedRule(), new PostExistsRule()]
        ]);
        $like = new Like();
        $like->post_id = $request->post_id;
        $like->user_id = Auth::id();
        $like->save();

        Cache::flush();

        return response('', 200);
    }

    public function unlike(Request $request) {
        $request->validate([
            "post_id" => [new PostExistsRule(), new UserHasLikedRule()],
        ]);
        Like::where("user_id", Auth::id())->where("post_id", $request['post_id'])->delete();

        // Clear all cache for all posts
        Cache::flush();

        return response('', 200);
    }

    public function share(Request $request) {
        $request->validate([
            "post_id" => [new PostExistsRule()],
            'description' => "nullable|string"
        ]);
        $post = Post::findOrFail($request->post_id);
        if (Gate::allows("is_original_post", $post)) {
            $newPost = new Post();
            $newPost->user_id = Auth::id();
            $newPost->original_post_id = $post->id;
            $newPost->description = $request['description'];
            $newPost->save();
            return response('', 200);
        }

        Cache::flush();

        return response("You cannot share a shared post", 403);
    }

    public function search(Request $request) {
        $posts = Cache::remember("post_search_$request->keyword", 60 * 60, function () use ($request) {
            return Post::latest()->where("description", "like", "%" . $request->keyword . "%")->with("original_post")->withCount("allComments", "total_likes", "user_liked")->get();
        });

        return Inertia::render("Post/PostSearchResults", [
            'posts' => $posts,
            'keyword' => $request->keyword,
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ]);
    }
}