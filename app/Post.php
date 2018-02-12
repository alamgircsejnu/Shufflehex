<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title', 'link', 'featured_image', 'category', 'description', 'user_id', 'tags',
    ];
    protected $dates=['deleted_at'];

    public function votes()
    {
        return $this->hasMany('App\Vote');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    public function users()
    {
        return $this->belongsTo('App\User');
    }

    public function saved_stories()
    {
        return $this->hasMany('App\savedStories');
    }
}
