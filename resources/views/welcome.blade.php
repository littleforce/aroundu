@extends('layouts.app')

@section('content')
    <div class="app-content">
        <el-row>
            <el-col :span="16" :offset="4">
                <el-row>
                    <carousel id="carousel"></carousel>
                </el-row>
                <el-row :gutter='10'>
                    <el-col :sm="16">
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
@endsection