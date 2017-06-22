<?php

namespace App\Http\Controllers;

use App\Article;
use App\Comment;
use App\Http\Requests\CommentRequest;
use Illuminate\Http\Request;
use App\Http\Requests\ArticleRequest;

class ArticleController extends Controller
{
    /**
     * show all articles
     */
    public function index()
    {
        $articles = Article::all();
        return view('article.articles')->withArticles($articles);
    }

    /**
     * show article
     */
    public function show($id)
    {
        $article = Article::find($id);
        //dd(Comment::find(1));
        return view('article.show')->withArticle($article);
    }

    /**
     * create article.
     */
    public function create()
    {
        return view('article.create');
    }
    /**
     * store article.
     */
    public function store(ArticleRequest $request)
    {
        $article = new Article();
        $article->title = $request->get('title');
        $article->content = $request->get('content');
        $article->location = $request->get('location');
        $article->type = $request->get('type');
        $article->user_id = $request->get('user_id');
        $article->save();
        return redirect('article/create')->withErrors('success!');
    }

    public function comment(CommentRequest $request)
    {
        $article = Article::find($request['article_id']);
        $comment = new Comment();
        $comment->user_id = $request['user_id'];
        $comment->upper_id = $request['upper_id'];
        $comment->content = $request['content'];
        $article->comments()->save($comment);
        return back();
    }

    public function vote()
    {

    }

    public function unvote()
    {

    }

    public function summerImageUpload(Request $request)
    {
        $path = $request->file('file')->storePublicly(md5(time()));
        return asset('storage/'.$path);
    }

    public function articleImageUpload()
    {
        dd(request()->all());
    }
}
