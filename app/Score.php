<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    /**
     * Get all of the owning scorable models.
     */
    public function scorable()
    {
        return $this->morphTo();
    }
}
