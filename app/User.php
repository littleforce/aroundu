<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function articles()
    {
        return $this->hasMany('App\Article');
    }

    public function badges()
    {
        return $this->belongsToMany('App\Badge');
    }

    /**
     * Get all of the user's score.
     */
    public function scores()
    {
        return $this->morphMany('App\Score', 'scorable');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    //用户关注
    public function following()
    {
        return $this->belongsToMany(self::class,'follows','follower_id','followed_id')->withTimestamps();
    }

    //用户的粉丝
    public function followers()
    {
        return $this->belongsToMany(self::class,'follows','followed_id','follower_id')->withTimestamps();
    }

    //关注用户
    public function followThisUser($user)
    {
        return $this->following()->attach($user);
    }

    //取消关注用户
    public function unfollowThisUser($user)
    {
        return $this->following()->detach($user);
    }

    //是否关注了这个用户
    public function hasFollowed($user)
    {
     //dd($this->following()->where('followed_id', $user)->get());
        if ($this->following()->where('followed_id', $user)->count() > 0) {
            return true;
        } else {
            return false;
        }
    }
}
