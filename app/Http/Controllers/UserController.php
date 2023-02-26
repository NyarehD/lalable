<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;

class UserController extends Controller {
    public function show(User $user) {
        return Inertia::render("User/UserView", [
            "user" => $user,
            "posts" => $user->posts()->latest()->with("original_post")->withCount("allComments", "total_likes", "user_liked")->get()
        ]);
    }
    public function edit(User $user) {
        if ($user->id === auth()->id()) {
            return Inertia::render("User/UserEdit", [
                "user" => $user
            ]);
        }
    }
}