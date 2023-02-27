<?php

namespace App\Http\Controllers;

use App\Http\Middleware\UserSameAsAuth;
use App\Models\User;
use Inertia\Inertia;

class UserController extends Controller {
    public function __construct() {
        $this->middleware(UserSameAsAuth::class)->only("edit");
    }
    public function show(User $user) {
        return Inertia::render("User/UserView", [
            "user" => $user,
            "posts" => $user->posts()->latest()->with("original_post")->withCount("allComments", "total_likes", "user_liked")->get()
        ]);
    }
    public function edit(User $user) {
        return Inertia::render("User/UserEdit", [
            "user" => $user
        ]);
    }
}