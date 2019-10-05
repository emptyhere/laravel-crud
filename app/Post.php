<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title', 'description', 'category', 'image',
    ];

    public function users() {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function show_users()
    {
    return $this->belongsToMany('App\User', 'show_post_user')->withTimestamps();
    }
}
