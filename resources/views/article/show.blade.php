@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-2"></div>
            <div class="col-lg-8">
                <h1 class="text-center">{{ $article->title }}</h1>
                <h5>{{ $article->created_at }} by {{ $article->user->name }}</h5>
                <hr>
                {!! $article->content !!}
            </div>
            <div class="col-lg-2"></div>
        </div>
        <hr>
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{--<div class="row">--}}
                        <p>Comments</p>
                    {{--</div>--}}
                </div>
                <div class="panel-body">
                    @if($article->comments->count()>0)
                        @foreach($article->comments as $comment)
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <a href="{{ url('/user', ['id' => $comment->user->id]) }}">{{ $comment->user->name }}</a> at {{ $comment->created_at->toDateTimeString() }}
                                        </div>
                                        <div class="col-md-1">
                                            <a href="#comment-content" name="{{ $comment->user->name }}" id="{{ $comment->user->id }}" onclick="clickReply(this)"><i class="fa fa-mail-reply"></i></a>
                                        </div>
                                        <div class="col-md-1">
                                            @if(!$comment->vote(\Auth::id())->exists())
                                                <a href="{{ url('/comment/'.$comment->id.'/vote') }}"><i class="fa fa-thumbs-o-up"></i></a>
                                            @else
                                                <a href="{{ url('/comment/'.$comment->id.'/unvote') }}"><i class="fa fa-thumbs-up"></i></a>
                                            @endif
                                            {{ $comment->votes->count() }}
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    @if($comment->upper_id != null)
                                        <a href="{{ url('/user', ['id' => $comment->upperUser->id]) }}">@ {{ $comment->upperUser->name }}</a>
                                    @endif
                                    {!! $comment->content !!}
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center" style="height: 50px">
                            <h4>暂时没有评论哦~</h4>
                        </div>
                    @endif
                    <hr>
                    @if(Auth::guest())
                        <div class="col-sm-offset-5">
                            <a class="btn btn-primary" href="{{ url('login') }}">login</a> 登陆发表评论哦～
                        </div>
                    @else
                        回复：<span id="upper_name"></span>
                        <form role="form" method="post" action="{{ url('/comment/store') }}">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <textarea id="comment-content" class="form-control" rows="5" name="content"></textarea>
                                <input class="hidden" value="{{ Auth::user()->id }}" name="user_id">
                                <input class="hidden" value="{{ $article->id }}" name="article_id">
                                <input class="hidden" id="upper_id" name="upper_id">
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-5">
                                    <button class="btn btn-primary" type="button" onclick="form.submit();">submit</button>
                                </div>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
            </div>
            {{--评论区结束--}}
        </div>
    </div>
@endsection

@section('js')
    <script>
        function clickReply(obj) {
            window.location.hash = "#comment-content";
            //document.getElementById('comment-content').value = "@"+obj.name+' ';
            document.getElementById('upper_name').innerText = obj.name;
            document.getElementById('upper_id').value = obj.id;
        }
    </script>
@endsection