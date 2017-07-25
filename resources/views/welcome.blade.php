@extends('layouts.app')

@section('content')
    <div class="app-content">
        <el-row>
            <el-col :span="16" :offset="4">
                <el-row>
                    <div id="carousel">
                        <el-carousel :interval="3000" type="card" height="300px">
                            @foreach($article_links as $link)
                                <el-carousel-item key="{{ $link }}">
                                    <img src='{{ $link }}' style="height: inherit;">
                                </el-carousel-item>
                            @endforeach
                        </el-carousel>
                    </div>
                </el-row>
                <el-row :gutter='10'>
                    <el-col :sm="16">
                        <el-row>
                            <div class="recommend-collection">
                                {{--@foreach($collections as $collection)--}}
                                    {{--<a href="{{ url('/collection/'.$collection->id) }}" class="collection">--}}
                                        {{--<img src="//upload.jianshu.io/collections/images/277031/645317897236768460.png?imageMogr2/auto-orient/strip|imageView2/1/w/195/h/195" alt="195">--}}
                                        {{--<div class="name">{{ $collection->name }}</div>--}}
                                    {{--</a>--}}
                                {{--@endforeach--}}
                                <a href="/" class="collection">
                                    <img style="height: 32px; width: 32px;" src="//upload.jianshu.io/collections/images/277031/645317897236768460.png?imageMogr2/auto-orient/strip|imageView2/1/w/195/h/195" alt="195">
                                    <div class="collection-name">娱乐.......八卦</div>
                                </a>
                            </div>
                        </el-row>
                        @foreach($articles as $article)
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
                        {{ $articles->links() }}
                    </el-col>
                    <el-col :sm="8">
                        <div class="grid-content bg-purple-light"></div>
                    </el-col>
                </el-row>
            </el-col>
        </el-row>
    </div>
@endsection

@section('js')

@endsection

@section('css')
    <style>
        .el-col {
            border-radius: 4px;
        }
        .bg-purple-dark {
            background: #99a9bf;
        }
        .bg-purple {
            background: #d3dce6;
        }
        .bg-purple-light {
            background: #e5e9f2;
        }
        .grid-content {
            border-radius: 4px;
            min-height: 36px;
        }
    </style>
    <style>
        .recommend-collection .collection {
            display: inline-block;
            margin: 0 18px 18px 0;
            min-height: 32px;
            background-color: #f7f7f7;
            border: 1px solid #dcdcdc;
            border-radius: 4px;
            vertical-align: top;
            overflow: hidden;
        }
        .recommend-collection .collection .collection-name {
            display: inline-block;
            padding: 0 11px 0 6px;
            font-size: 14px;
        }
    </style>
@endsection