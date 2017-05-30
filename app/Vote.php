<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    /**
     * Get all of the owning votable models.
     */
    public function votable()
    {
        return $this->morphTo();
    }
}
