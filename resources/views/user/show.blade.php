@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="blog-header">
        </div>

        <div class="row">

            <div class="col-sm-7">
                <div class="row">
                    <blockquote>
                        <p><img src="{{ $user->avatar }}" alt="" class="img-rounded" style="border-radius:500px; height: 40px"> {{ $user->name }}
                            @if($user->id != \Auth::id())
                                @if(\Auth::user()->hasFollowed($user->id))
                                    <a class="btn btn-primary" href="{{ url('user/'.$user->id.'/unfollow') }}"><i class="fa fa-plus"></i> 取消关注</a>
                                @else
                                    <a class="btn btn-primary" href="{{ url('user/'.$user->id.'/follow') }}"><i class="fa fa-plus"></i> 关注</a>
                                @endif
                            @endif
                        </p>
                        <footer>关注：{{ $user->following->count() }}｜粉丝：{{ $user->followers->count() }}｜文章：{{ $user->articles->count() }}</footer>
                    </blockquote>
                </div>
                <div class="row">
                    <div class="blog-main">
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">文章</a></li>
                                <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">关注</a></li>
                                <li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="false">粉丝</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab_1">
                                    @foreach($user->articles as $article)
                                        <div class="blog-post" style="margin-top: 30px">
                                            <p class=""><a href="{{ url('/user/'.$user->id) }}">{{ $user->name }}</a> at {{ $article->created_at->diffForHumans() }}</p>
                                            <p class=""><a href="{{ url('/article/'.$article->id) }}" >{{ $article->title }}</a></p>
                                            {{--<p>{!! $article->content !!} </p>--}}
                                            <p>{{ str_limit($article->content, 150, '...') }}</p>
                                        </div>
                                        <p class=""><i class="fa fa-comments"></i> {{ $article->comments->count() }} | <i class="fa fa-heart"></i> {{ $article->votes->count() }}
                                            @if($user->id == \Auth::id())
                                            <span class=""><a><i class="fa fa-edit"></i> edit</a> | <a><i class="fa fa-trash"></i> delete</a></span>
                                            @endif
                                        </p>
                                        <hr>
                                    @endforeach
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="tab_2">
                                    @foreach($user->following as $following)
                                        <div class="blog-post" style="margin-top: 30px">
                                            <p class=""><a href="{{ url('user/'.$following->id) }}">{{ $following->name }}</a></p>
                                            <p class="">关注：{{ $following->following->count() }} | 粉丝：{{ $following->followers->count() }}｜ 文章：{{ $following->articles->count() }}</p>
                                            @if($user->id == \Auth::id())
                                            <a class="btn btn-primary" href="{{ url('user/'.$following->id.'/unfollow') }}"><i class="fa fa-plus"></i> 取消关注</a>
                                            @endif
                                        </div>
                                        <hr>
                                    @endforeach
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="tab_3">
                                    @foreach($user->followers as $follower)
                                        <div class="blog-post" style="margin-top: 30px">
                                            <p class=""><a href="{{ url('user/'.$follower->id) }}">{{ $follower->name }}</a></p>
                                            <p class="">关注：{{ $follower->following->count() }} | 粉丝：{{ $follower->followers->count() }}｜ 文章：{{ $follower->articles->count() }}</p>
                                            @if($user->id == \Auth::id())
                                                @if(\Auth::user()->hasFollowed($follower->id))
                                                    <a class="btn btn-primary" href="{{ url('user/'.$follower->id.'/unfollow') }}"><i class="fa fa-plus"></i> 互相关注</a>
                                                @else
                                                    <a class="btn btn-primary" href="{{ url('user/'.$follower->id.'/follow') }}"><i class="fa fa-plus"></i> 关注</a>
                                                @endif
                                            @endif
                                        </div>
                                        <hr>
                                    @endforeach
                                </div>
                                <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div>
                    </div>
                </div><!-- /.blog-main -->
            </div>

            <div id="sidebar" class="col-sm-4 col-sm-offset-1">
                <aside id="widget-welcome" class="widget panel panel-default">
                    <div class="panel-heading">
                        welcome!
                    </div>
                    <div class="panel-body">
                        <p>
                            welcome to aroundu!
                        </p>
                        <p>
                            <strong><a href="/">aroundu</a></strong> 基于 Laravel5.4 构建
                        </p>
                        <div class="bdsharebuttonbox bdshare-button-style0-24" data-bd-bind="1494580268777"><a href="#" class="bds_more" data-cmd="more"></a><a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a><a href="#" class="bds_renren" data-cmd="renren" title="分享到人人网"></a><a href="#" class="bds_douban" data-cmd="douban" title="分享到豆瓣网"></a><a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a><a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a><a href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博"></a><a href="#" class="bds_bdhome" data-cmd="bdhome" title="分享到百度新首页"></a></div>
                        <script>window._bd_share_config={"common":{"bdSnsKey":{"tsina":"120473611"},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"24"},"share":{},"image":{"viewList":["tsina","renren","douban","weixin","qzone","tqq","bdhome"],"viewText":"分享到：","viewSize":"16"},"selectShare":{"bdContainerClass":null,"bdSelectMiniList":["tsina","renren","douban","weixin","qzone","tqq","bdhome"]}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>
                    </div>
                </aside>
                <aside id="widget-categories" class="widget panel panel-default">
                    <div class="panel-heading">
                        专题
                    </div>

                    <ul class="category-root list-group">
                        <li class="list-group-item">
                            <a href="/topic/1">旅游
                            </a>
                        </li>
                        <li class="list-group-item">
                            <a href="/topic/2">轻松
                            </a>
                        </li>
                        <li class="list-group-item">
                            <a href="/topic/5">测试专题
                            </a>
                        </li>
                    </ul>

                </aside>
            </div>
        </div>    </div><!-- /.row -->
    </div><!-- /.container -->
@endsection