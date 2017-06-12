<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ArticleRequest;

class ArticleController extends Controller
{
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
        dd($request->all());
    }
}
