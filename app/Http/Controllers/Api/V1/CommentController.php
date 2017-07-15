<?php

namespace App\Http\Controllers\Api\V1;

use App\Comment;
use App\Vote;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentController extends ApiController
{
    public function vote($id)
    {
        $comment = Comment::find($id);
        $vote = new Vote();
        $user = $this->auth->user();
        $vote->user_id = $user->id;
        if ($comment->vote($user->id)->exists()){
            $param = [
                'error' => 1,
                'msg' => 'already voted!',
            ];
            return $param;
        } else {
            $comment->votes()->save($vote);
            $param = [
                'error' => 0,
                'msg' => 'vote success!',
                'count' => $comment->votes->count(),
            ];
            return $param;
        }
    }

    public function unvote($id)
    {
        $comment = Comment::find($id);
        $user = $this->auth->user();
        if (!$comment->vote($user->id)->exists()){
            $param = [
                'error' => 1,
                'msg' => 'already unvoted!',
            ];
            return $param;
        } else {
            $comment->vote($user->id)->delete();
            $param = [
                'error' => 0,
                'msg' => 'unvote success!',
                'count' => $comment->votes->count(),
            ];
            return $param;
        }
    }

    public function destroy($id)
    {
        $comment = Comment::find($id);
        $user = $this->auth->user();
        if ($user->can('delete', $comment)) {
            $comment->delete();
            return $this->response->noContent();
        } else {
            return [
                'error' => 1,
                'message' => '没有删除评论权限！',
            ];
        }
    }
}
