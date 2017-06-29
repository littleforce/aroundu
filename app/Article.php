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




    public function apiArticleList($offset = 0, $number = 10)
    {
        if (is_null($offset)) {
            $offset = 0;
        }
        if (is_null($number)) {
            $number = 10;
        }
        $articles = Article::orderBy('created_at', 'desc')->offset($offset)->limit($number)->get();
        foreach ($articles as $article) {
            $array[$article->id]['title'] =$article->title ;
            $array[$article->id]['created_at'] =$article->created_at->diffForHumans() ;
            $array[$article->id]['content'] = str_limit(preg_replace("/<[^>]+>/", '', $article->content), 150, '...');
            $array[$article->id]['user_name'] = $article->user->name;
            $array[$article->id]['user_id'] = $article->user->id;
            $array[$article->id]['votes_count'] = $article->votes->count();
            $array[$article->id]['comments_count'] = $article->comments->count();
        }
        return $array;
    }
}
