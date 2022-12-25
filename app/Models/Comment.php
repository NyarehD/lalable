<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model {
    public function comment_owner(){
        return $this->belongsTo(User::class,"user_id");
    }
}
