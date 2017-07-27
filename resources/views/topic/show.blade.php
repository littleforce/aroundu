@extends('layouts.app')

@section('css')
    <style>

        .follow span {
            margin-left: 2px;
            display: inline;
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
                <el-row>
                    <el-col :span="16">
                        <div class="row">
                            <blockquote>
                                <p>
                                    <img src="{{ $topic->image }}" alt="" class="img-rounded" style="border-radius:1000px; height: 60px; width: 60px"> {{ $topic->name }}
                                    @if(\Auth::check())
                                        <button class="btn btn-success" style="border-radius: 50px;float: right;"  data-toggle="modal" data-target="#topic_submit_modal">投稿</button>
                                <div class="modal fade" id="topic_submit_modal" tabindex="-1" role="dialog" >
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="myModalLabel">我的文章</h4>
                                            </div>
                                            <div class="modal-body">
                                                <form action="/topic/{{$topic->id}}/submit">
                                                    @foreach($myarticles as $article)
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" name="article_ids[]" value="{{$article->id}}">
                                                                {{$article->title}}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                    <button type="submit" class="btn btn-default">投稿</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    @endif
                                </p>
                                <footer>已收录{{ $topic->articles->count() }}篇文章</footer>
                            </blockquote>
                        </div>
                        <div class="row">
                            <el-tabs active-name="first">
                                <el-tab-pane name="first">
                                    <span slot="label"><i class="el-icon-document"></i> 最新收录文章</span>
                                    @foreach($topic->articles as $article)
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
                                    <span slot="label"><i class="el-icon-fire"></i> 最热文章</span>
                                    @foreach($articlesbyvote as $article)
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
{{--                                    {{ $articlebyvote->links }}--}}
                                </el-tab-pane>
                            </el-tabs>
                        </div><!-- /.blog-main -->
                    </el-col>
                    <el-col :span="8">
                        <div style="margin-left: 50px;">
                            <p>描述</p>
                            <p>{{ $topic->description }}</p>
                            <hr>
                            <p>创建者</p>
                            <a href="{{ url('/user/'.$topic->founder->id) }}">
                                <img src="{{ $topic->founder->avatar }}" alt="" class="img-rounded" style="border-radius:1000px; height: 30px; width: 30px"> {{ $topic->founder->name }}
                            </a>
                        </div>
                    </el-col>
                </el-row>
            </el-col>
        </el-row>
    </div><!-- /.container -->
@endsection