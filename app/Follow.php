<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
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
    	return $this->following()->toggle($user);
	}
}
