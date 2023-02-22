<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;

class UserController extends Controller {
    public function profile(User $user) {
        return Inertia::render("Profile", [
            "user" => $user,
            "posts" => $user->posts()->with("original_post")->withCount("allComments", "total_likes", "user_liked")->get()
        ]);
    }
}