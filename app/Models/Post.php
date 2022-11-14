<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model {
    use HasFactory;

    protected $with = ["post_photos", "owner","total_likes","original_post.post_photos"];

    protected $appends = ["for_humans"];

    public function post_photos() {
        return $this->hasMany(PostPhoto::class);
    }

    public function owner() {
        return $this->belongsTo(User::class, "user_id")->select("name", "id", "profile_picture");
    }

    public function total_likes() {
        return $this->hasMany(Like::class, "post_id");
    }

    public function original_post() {
        return $this->belongsTo(Post::class, "original_post_id");
    }

    protected function forHumans(): Attribute {
        return new Attribute(get: fn() => $this->created_at->diffForHumans());
    }
}
