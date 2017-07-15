<?php

namespace App\Http\Controllers\Api\V1;

use App\Article;
use App\Comment;
use App\Vote;
use App\Transformers\ArticleSimpleTransformer;
use App\Transformers\ArticleTransformer;
use App\Transformers\CommentTransformer;
use Illuminate\Http\Request;

class ArticleController extends ApiController
{
    protected $article;
    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    public function show($id)
    {
        $article = Article::findOrFail($id);
        return $this->response->item($article, new ArticleTransformer);
    }

    public function index()
    {
        $array = $this->article->apiArticleList(request('offset'), request('number'));
        return $this->response->collection($array, new ArticleSimpleTransformer);
    }

    public function comments($id)
    {
        $article = Article::findOrFail($id);
        $comments = $article->comments;
        return $this->response->collection($comments, new CommentTransformer);
    }

    public function comment(Request $request, $id)
    {
        $newComment = [
            'content' => $request->get('content'),
        ];
        $rules = [
            'content' => 'required|min:3|max:255',
        ];
        $validator = \Validator::make($newComment, $rules);
        if ($validator->fails()) {
            throw new \Dingo\Api\Exception\StoreResourceFailedException('Could not create new comment.', $validator->errors());
        }
        $article = Article::find($id);
        $comment = new Comment();
        $comment->user_id = $this->auth->user()->id;
        $comment->upper_id = is_null($request->get('upper_id')) ? null : $request->get('upper_id');
        $comment->content = $request->get('content');
        $article->comments()->save($comment);
        return $this->response->noContent();
    }

    public function vote($id)
    {
        $article = Article::find($id);
        $vote = new Vote();
        $user = $this->auth->user();
        $vote->user_id = $user->id;
        //dd($comment->vote(\Auth::id())->exists());
        if ($article->vote($user->id)->exists()){
            $param = [
                'error' => 1,
                'message' => 'already voted!',
            ];
        } else {
            $article->votes()->save($vote);
            $param = [
                'error' => 0,
                'message' => 'vote success!',
                'count' => $article->votes->count(),
            ];
        }
        return $param;
    }

    public function unvote($id)
    {
        $article = Article::find($id);
        $user = $this->auth->user();
        if (!$article->vote($user->id)->exists()){
            $param = [
                'error' => 1,
                'message' => 'unvote failure!',
            ];
            return $param;
        }
        $article->vote($user->id)->delete();
        $param = [
            'error' => 0,
            'message' => 'unvote success!',
            'count' => $article->votes->count(),
        ];
        return $param;
    }

    public function store(Request $request)
    {
        $newArticle = [
            'title' => $request->get('title'),
            'content' => $request->get('content'),
            'location' => $request->get('location'),
            'type' => $request->get('type'),
        ];
        $rules = [
            'title' => 'required',
            'content' => 'required',
            'location' => 'required',
            'type' => 'required'
        ];
        $validator = \Validator::make($newArticle, $rules);
        if ($validator->fails()) {
            throw new \Dingo\Api\Exception\StoreResourceFailedException('Could not create new article.', $validator->errors());
        }
        $user = $this->auth->user();
        $article = new Article();
        $article->title = $request->get('title');
        $article->content = $request->get('content');
        $article->location = $request->get('location');
        $article->type = $request->get('type');
        $article->user_id = $user->id;
        $article->save();
        return $this->response->noContent();
    }

    public function destroy($id)
    {
        $article = Article::find($id);
        $user = $this->auth->user();
        if ($user->can('delete', $article)) {
            $article->delete();
            return $this->response->noContent();
        } else {
            return [
                'error' => 1,
                'message' => '没有删除文章权限！',
            ];
        }
    }
}
