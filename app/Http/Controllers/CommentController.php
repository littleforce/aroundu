<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Http\Requests\CommentRequest;
use App\Vote;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(CommentRequest $request)
    {
//        dd(request()->all());
//  "_token" => "DIYsvgzgLAZGFLCHXR0GsXqGO2S9roayjfAQQPAa"
//  "content" => "xixi"
//  "user_id" => "1"
//  "article_id" => "2"
//  "upper_id" => "1"
    }

    public function vote($id)
    {
        $comment = Comment::find($id);
        $vote = new Vote();
        $vote->user_id = \Auth::id();
        //dd($comment->vote(\Auth::id())->exists());
        if ($comment->vote(\Auth::id())->exists()){
            return back()->withError('already voted!');
        }
        $comment->votes()->save($vote);
        return back();
    }

    public function unvote($id)
    {
        $comment = Comment::find($id);
        if (!$comment->vote(\Auth::id())->exists()){
            return back()->withError('already unvoted!');
        }
        $comment->vote(\Auth::id())->delete();
        return back();
    }
}
