<?php

namespace App\Http\Controllers\Api;

use App\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    protected $article;

    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    public function index()
    {
        $array = $this->article->apiArticleList(request('offset'), request('number'));
        return $array;
    }

    public function show($id)
    {
        $article = Article::find($id);
        if (is_null($article)) {
            return [
                'error' => 1,
                'msg' => '找不到文章',
            ];
        } else {
            $array = $article->getAttributes();
            $array['location'] = json_decode($array['location']);
            return $array;
        }
    }


}
