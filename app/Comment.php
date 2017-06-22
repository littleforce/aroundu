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

    public function vote($user_id)
    {
        return $this->morphOne('App\Vote', 'votable')->where('user_id', $user_id);
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function upperUser()
    {
        return $this->belongsTo('App\User', 'upper_id', 'id');
    }
}
