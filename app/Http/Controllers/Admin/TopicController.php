<?php

namespace App\Http\Controllers\Admin;

use App\Topic;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    public function index()
    {
        $topics = Topic::paginate(10);
        return view('admin.topic.index', compact('topics'));
    }

    public function destroy(Topic $topic)
    {
        $topic->articles()->detach();
        $topic->delete();
        return [
            'error' => 0,
            'msg' => '',
        ];
    }
}
