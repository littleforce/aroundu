<?php
namespace App\Transformers;

use App\Article;
use League\Fractal;
use League\Fractal\TransformerAbstract;

class ArticleTransformer extends TransformerAbstract
{
    public function transform(Article $article)
    {
        $user_id = app('Dingo\Api\Auth\Auth')->user() ? app('Dingo\Api\Auth\Auth')->user()->id : 0;
        return [
            'id' => $article->id,
            'type' => $article->type,
            'key' => $article->key,
            'image' => $article->image,
            'title' => $article->title,
            'content' => $article->content,
            'location' => json_decode($article->location),
            'created_at' => (string)$article->created_at,
            'updated_at' => (string)$article->updated_at,
            'user' => [
                'id' => $article->user->id,
                'name' => $article->user->name,
                'avatar' => $article->user->avatar,
                'link' => ['uri' => '/user/'.$article->user->id],
            ],
            'is_voted' => $article->vote($user_id)->exists() ? 1 : 0,
//            'is_voted' => $user_id,
            'votes_count' => $article->votes->count(),
            'comments_count' => $article->comments->count(),
        ];
    }
}