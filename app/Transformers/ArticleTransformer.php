<?php
namespace App\Transformers;

use App\Article;
use League\Fractal;
use League\Fractal\TransformerAbstract;

class ArticleTransformer extends TransformerAbstract
{
    public function transform(Article $article)
    {
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
                'link' => ['uri' => '/user/'.$article->user->id],
            ],
            'votes_count' => $article->votes->count(),
            'comments_count' => $article->comments->count(),
        ];
    }
}