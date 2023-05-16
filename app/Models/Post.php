<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable= ['title', 'content','user_id','file'];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id','id');
    }
    public function comments() {
        return $this->hasMany(Comment::class, 'post_id', 'id');
    }
}
