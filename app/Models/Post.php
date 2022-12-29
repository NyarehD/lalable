<?php

namespace App\Models;

use Carbon\CarbonInterface;
use Gate;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model {
    use HasFactory;

    protected $with = ["post_photos", "owner", "total_likes"];

    protected $appends = ["for_humans", "can", "user_liked", "total_likes_count"];

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

    public function comments() {
        return $this->hasMany(Comment::class, "post_id")->latest();
    }

    protected function forHumans(): Attribute {
        return new Attribute(get: fn() => $this->created_at->diffForHumans(["syntax" => CarbonInterface::DIFF_ABSOLUTE]));
    }

    protected function can(): Attribute {
        return new Attribute(get: fn() => ['is_post_owner' => Gate::allows("post_owner", $this)]);
    }

    protected function userLiked(): Attribute {
        return new Attribute(get: fn() => $this->total_likes->where("user_id", auth()->id())->count() > 0);
    }

    protected function totalLikesCount(): Attribute {
        return new Attribute(get: fn() => $this->total_likes->count());
    }
}
