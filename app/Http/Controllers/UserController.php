<?php

namespace App\Http\Controllers;

use App\Http\Middleware\UserSameAsAuth;
use App\Models\User;
use Illuminate\Http\Request;
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
    public function update(Request $request, User $user) {
        $hasEmailChanged = $request->email !== $user->email ? "|unique:users" : "";
        $request->validate([
            "name" => "required|string|max:255",
            "email" => "email|required|string|max:255$hasEmailChanged",
            "bio" => "string|nullable"
        ]);
        if ($user->id === auth()->id()) {
            $user->updateOrFail([
                "name" => $request->name,
                "email" => $request->email,
                "bio" => $request->bio
            ]);
            return redirect()->back();
        }
        return abort(403);
    }
}