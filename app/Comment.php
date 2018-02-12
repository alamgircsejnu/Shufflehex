<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'comment', 'user_id', 'post_id', 'category', 'description', 'user_id',
    ];
    protected $dates=['deleted_at'];

    public function posts()
    {
        return $this->belongsTo('App\Post');
    }
}
