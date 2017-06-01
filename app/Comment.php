<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
     * Get all of the owning commentable models.
     */
    public function commentable()
    {
        return $this->morphTo();
    }

    /**
     * Get all of the comment's votes.
     */
    public function votes()
    {
        return $this->morphMany('App\Vote', 'votable');
    }
}
