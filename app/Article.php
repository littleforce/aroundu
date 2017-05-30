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
}
