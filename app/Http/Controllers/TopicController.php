<?php

namespace App\Http\Controllers;

use App\Article;
use App\Topic;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TopicController extends Controller
{
    public function show(Topic $topic)
    {
        $articles = $topic->articles;
        $articlesbyvote = $topic->getTopicArticlesByVote($topic->id,2);
        $myarticles = Article::authorBy(\Auth::id())->topicNotBy($topic->id)->get();
        return view('topic.show', compact('topic', 'articles', 'articlesbyvote', 'myarticles'));
    }

    public function submit(Topic $topic)
    {
        $this->validate(request(),[
            'article_ids' => 'required|array',
        ]);
        $article_ids = request('article_ids');
        $topic_id = $topic->id;
        foreach ($article_ids as $article_id) {
            Article::find($article_id)->topics()->attach($topic_id, ['created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
//            Article::find($article_id)->topics()->save(Topic::find($topic_id));
        }
        return back();
    }

    public function store(Request $request)
    {
        $topic = new Topic();
        $topic->name = $request->get('name');
        $topic->image = $request->get('topicimage');
        $topic->description = $request->get('description');
        $topic->founder_id = \Auth::id();
        $topic->save();
        return back();
    }
}
