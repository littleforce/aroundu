<?php
namespace App\Transformers;

use App\Comment;
use League\Fractal;
use League\Fractal\TransformerAbstract;

class CommentTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'user',
        'upperuser',
        'commentable',
    ];

    public function transform(Comment $comment)
    {
        if ($comment->upper_id == null) {
            $upper_user = 0;
        } else {
            $upper_user = [
                'id' => $comment->upper_id,
                'name' => $comment->upperUser->name,
                'link' => ['uri' => '/user/'.$comment->upper_id],
            ];
        }
        return [
            'id' => $comment->id,
            'content' => $comment->content,
            'votes_count' => $comment->votes->count(),
            'upper_user' => $upper_user,
        ];
    }

    public function includeUser(Comment $comment)
    {
        $user = $comment->user;
        return $this->item($user, new UserSimpleTransformer);
    }

    public function includeCommentable(Comment $comment)
    {
        //$comment = Comment::find(1);
        $commentable = $comment->commentable;
        return $this->item($commentable, new ArticleSimpleTransformer);
    }
}