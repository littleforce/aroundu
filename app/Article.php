<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
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

    public function topics()
    {
        return $this->belongsToMany('App\Topic');
    }
//属于某个用户的文章
    public function scopeAuthorBy(Builder $query, $user_id)
    {
        return $query->where('user_id', $user_id);
    }
//不属于某个专题的文章
    public function scopeTopicNotBy(Builder $query, $topic_id)
    {
        return $query->doesntHave('topics', 'and', function ($q) use($topic_id) {
            $q->where('topic_id', $topic_id);
        });
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
        return $articles;
    }

    public static function getArticlesByComments()
    {
        $articles = Article::all();
        $sorted = $articles->sortByDesc(function ($articles) {
            return $articles->comments->count();
        });
        //dd($sorted);
        return $sorted;
    }

    public static function getArticlesByVotes()
    {
        $articles = Article::all();
        $sorted = $articles->sortByDesc(function ($articles) {
            return $articles->votes->count();
        })->take(5);
        //dd($sorted);
        return $sorted;
    }
}
