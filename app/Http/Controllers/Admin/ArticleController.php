<?php

namespace App\Http\Controllers\Admin;

use App\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::withoutGlobalScope('available')->where('status', 0)->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.article.index', compact('articles'));
    }

    public function status(Article $article)
    {
        $this->validate(request(), [
            'status' => 'required|in:-1,1',
        ]);

        $article->status = request('status');
        $article->save();

        return [
            'error' => 0,
            'msg' => '',
        ];
    }
}
