<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class PostPhoto extends Model {
    protected $hidden = ["post_id", "filename"];
    protected $appends = ["full_image_path"];

    protected function fullImagePath(): Attribute {
        return new Attribute(get: fn() => asset("/storage/post/$this->filename"));
    }
}
