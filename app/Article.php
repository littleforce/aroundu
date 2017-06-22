<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    /**
     * Get all of the article's comments.
     */
    public function comments()
    {
        return $this->morphMany('App\Comment', 'commentable');
    }

    /**
     * Get all of the articel's votes.
     */
    public function votes()
    {
        return $this->morphMany('App\Vote', 'votable');
    }

    public function vote($user_id)
    {
        return $this->morphOne('App\Vote', 'votable')->where('user_id', $user_id);
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
