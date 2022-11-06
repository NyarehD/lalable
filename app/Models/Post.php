<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model {
    use HasFactory;

    protected $with = ["post_photos"];
    public function post_photos() {
        return $this->hasMany(PostPhoto::class);
    }
}
