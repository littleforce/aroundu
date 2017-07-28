<?php

namespace App\Http\Controllers\Admin;

use App\Notice;
use Illuminate\Http\Request;

class NoticeController extends Controller
{
    public function index()
    {
        $notices = Notice::paginate(10);
        return view('admin.notice.index', compact('notices'));
    }

    public function create()
    {
        return view('admin.notice.add');
    }

    public function store()
    {
        $this->validate(request(), [
            'title' => 'required|max:50|string',
            'content' => 'required|string',
        ]);
        Notice::create(request(['title', 'content']));
        return redirect('/admin/notices');
    }
}
