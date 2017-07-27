@extends('layouts.app')

@section('css')
    <style>
        .follow {
            border-color: #42c02e;
            padding: 0 7px 0 5px;
            font-size: 12px;
        }
        .follow span {
            margin-left: 2px;
            display: inline;
        }
        .btn-success {
            border-radius: 40px;
        }
        .following {
            padding: 0 7px 0 5px;
            font-size: 12px;
            font-weight: 400;
            line-height: normal;
        }
        .btn-default {
            border-radius: 40px;
            color: #8c8c8c;
            background-color: #f0f0f0;
            border-color: #f0f0f0;
        }
        .btn-default:hover {
            background-color: #e6e6e6;
            border-color: #e6e6e6;
        }
        .btn-default:hover {
            color: #8c8c8c;
            background-color: #d7d7d7;
            border-color: #d1d1d1;
        }
        .btn:hover {
            color: #8c8c8c;
            text-decoration: none;
        }
    </style>
@endsection

@section('content')
    <div class="container app-content">
        <el-row>
            <el-col :span="18" :offset="3">
                <el-row :gutter="20">
                    <el-col :span="16" >
                        <div class="row">
                            <blockquote>
                                <p><img src="{{ $user->avatar }}" alt="" class="img-rounded" style="border-radius:1000px; height: 60px; width: 60px"> {{ $user->name }}
                                    @if(\Auth::check() && $user->id != \Auth::id())
                                        @if(\Auth::user()->hasFollowed($user->id))
                                            <a class="btn btn-default following" href="{{ url('user/'.$user->id.'/unfollow') }}">
                                                <i class="fa fa-check"></i> <span class="followed-span">已关注</span>
                                            </a>
                                        @else
                                            <a class="btn btn-success follow" href="{{ url('user/'.$user->id.'/follow') }}">
                                                <i class="fa fa-plus"></i>
                                                <span>关注</span>
                                            </a>
                                        @endif
                                    @endif
                                </p>
                                <footer>关注：{{ $user->following->count() }}｜粉丝：{{ $user->followers->count() }}｜文章：{{ $user->articles->count() }}</footer>
                            </blockquote>
                        </div>
                        <div class="row">
                            <el-tabs active-name="first">
                            <el-tab-pane name="first">
                                <span slot="label"><i class="el-icon-document"></i> 文章</span>
                                @foreach($user->articles as $article)
                                    <articleitem
                                            user_id="{{ $article->user->id }}"
                                            user_name="{{ $article->user->name }}"
                                            user_avatar="{{ $article->user->avatar }}"
                                            article_id="{{ $article->id }}"
                                            article_title="{{ $article->title }}"
                                            article_content="<?php
                                            $contentes = preg_replace("/<[^>]+>/", '', $article->content);
                                            echo str_limit($contentes, 150, '...');
                                            ?>"
                                            article_created_at="{{ $article->created_at }}"
                                            article_image= "{{ is_null($article->image) ? 'isok' : $article->image }}"
                                            article_votes_count="{{ $article->votes->count() }}"
                                            article_comments_count="{{ $article->comments->count() }}"
                                    ></articleitem>
                                @endforeach
                            </el-tab-pane>
                            <el-tab-pane name="second">
                                <span slot="label"><i class="el-icon-date"></i> 关注 {{ $user->following->count() }}</span>
                                @foreach($user->following as $following)
                                    <div class="author">
                                        <div class="name">
                                            <img class="avatar" src="{{ $following->avatar }}" style="border-radius:1000px; height: 48px; width: 48px;">
                                            <div class="info">
                                                <a href="{{ url('/user/'.$following->id) }}">{{ $following->name }} </a>
                                                <span>关注：{{ $following->following->count() }} | 粉丝：{{ $following->followers->count() }}｜ 文章：{{ $following->articles->count() }}</span>
                                            </div>
                                            @if($user->id == \Auth::id())
                                                <a style="float: right; vertical-align: middle;" class="btn btn-primary" href="{{ url('user/'.$following->id.'/unfollow') }}"><i class="fa fa-plus"></i> 取消关注</a>
                                            @endif
                                        </div>
                                    </div>
                                    <hr>
                                @endforeach
                            </el-tab-pane>
                            <el-tab-pane name="third">
                                <span slot="label"><i class="el-icon-date"></i> 粉丝 {{ $user->followers->count() }}</span>
                                @foreach($user->followers as $follower)
                                    <div class="author">
                                        <div class="name">
                                            <img class="avatar" src="{{ $follower->avatar }}" style="border-radius:1000px; height: 48px; width: 48px;">
                                            <div class="info">
                                                <a href="{{ url('/user/'.$follower->id) }}">{{ $follower->name }} </a>
                                                <span>关注：{{ $follower->following->count() }} | 粉丝：{{ $follower->followers->count() }}｜ 文章：{{ $follower->articles->count() }}</span>
                                            </div>
                                            @if($user->id == \Auth::id())
                                                @if(\Auth::user()->hasFollowed($follower->id))
                                                    <a style="float: right; vertical-align: middle;" class="btn btn-primary" href="{{ url('user/'.$follower->id.'/unfollow') }}"><i class="fa fa-plus"></i> 互相关注</a>
                                                @else
                                                    <a style="float: right; vertical-align: middle;" class="btn btn-primary" href="{{ url('user/'.$follower->id.'/follow') }}"><i class="fa fa-plus"></i> 关注</a>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                    <hr>
                                @endforeach
                            </el-tab-pane>
                            </el-tabs>
                        </div><!-- /.blog-main -->
                    </el-col>
                    <el-col :span="8">
                        <div style="margin-left: 20px">
                            @if(\Auth::check() && $user->id == \Auth::id())
                                <span>My Topics</span>
                                <button class="btn btn-success" data-toggle="modal" data-target="#myModal" style="float: right;"><i class="fa fa-plus"></i> 创建新主题</button>
                                <!-- 模态框（Modal） -->
                                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                                    &times;
                                                </button>
                                                <h4 class="modal-title" id="myModalLabel">
                                                    创建新主题
                                                </h4>
                                            </div>
                                            <div class="modal-body">
                                                <form role="form" method="post" action="{{ url('topic/') }}">
                                                    {{ csrf_field() }}
                                                    <div class="form-group">
                                                        <label for="name">名称</label>
                                                        <input type="text" class="form-control" id="name" name="name" placeholder="请输入名称">
                                                        <label for="description">描述</label>
                                                        <textarea id="description" name="description" class="form-control" rows="3"></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="image">图片</label>
                                                        <input type="file" id="image" name="file" onchange="uploadImage()">
                                                        <input type="hidden" name="topicimage" id="topicimage">
                                                    </div>
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                                    <button type="submit" class="btn btn-success">提交</button>
                                                </form>
                                            </div>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal -->
                                </div>
                            @else
                                <span>Topics</span>
                            @endif
                            {{ $user->topics->count() }}
                            @foreach($user->topics as $topic)
                                <div style="height: 30px; margin-top: 10px; margin-bottom: 10px">
                                    <a href="{{ url('/topic/'.$topic->id) }}">
                                        <img src="{{ $topic->image }}" style="height: 30px; width: 30px">
                                        <span>{{ $topic->name }}</span>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </el-col>
                </el-row>
            </el-col>
        </el-row>
    </div><!-- /.container -->
@endsection

@section('js')
    <script>
        function uploadImage() {
            data = new FormData();
            data.append("file", $('#image')[0].files[0]);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: data,
                type: "POST",
                url: "/uploadImage",
                cache: false,
                contentType: false,
                processData: false,
                success: function(url) {
                    $('#topicimage').attr('value', url);
                }
            });
        }
    </script>
@endsection