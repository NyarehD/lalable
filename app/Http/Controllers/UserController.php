<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Inertia\Inertia;

class UserController extends Controller
{
    public function profile(User $user)
    {
        return Inertia::render("Profile", [
            "user" => $user->load("posts")
        ]);
    }
}