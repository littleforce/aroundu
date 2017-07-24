@extends('layouts.app')

@section('content')
    <div class="container app-content">
    	@foreach($articles as $article)
            <p><a href="{{ url('/article', ['id' => $article->id]) }}">{{ $article->title }}</a></p>
            <p>{{ $article->user->name }}</p>
            <p>{{ $article->user->followers->count() }}</p>
            <p>{{ $article->comments->count() }}</p>
            @can('update', $article)
                <p>有更新权限</p>
            @endcan
            @can('delete', $article)
                <p>有删除权限</p>
            @endcan
    @endforeach
    </div>
@endsection