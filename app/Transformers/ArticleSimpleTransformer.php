<?php
namespace App\Transformers;

use App\Article;
use League\Fractal;
use League\Fractal\TransformerAbstract;

class ArticleSimpleTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'user',
        'comments'
    ];

    public function transform(Article $article)
    {
        return [
            'id' => $article->id,
            'image' => $article->image,
            'title' => $article->title,
            'content' => str_limit(preg_replace("/<[^>]+>/", '', $article->content), 150, '...'),
            'created_at' => $article->created_at->diffForHumans(),
            'link' => ['uri' => '/article/'.$article->id],
            'votes_count' => $article->votes->count(),
            'comments_count' => $article->comments->count(),
        ];
    }

    public function includeUser(Article $article)
    {
        $user = $article->user;
        return $this->item($user, new UserSimpleTransformer);
    }

    public function includeComments(Article $article)
    {
        $comments = $article->comments;
        return $this->collection($comments, new CommentTransformer);
    }
}