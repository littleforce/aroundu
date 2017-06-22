@extends('layouts.app')

@section('content')
        <div id="myCarousel" class="carousel slide">
        <!-- 轮播（Carousel）指标 -->
        <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
            <li data-target="#myCarousel" data-slide-to="2"></li>
        </ol>   
        <!-- 轮播（Carousel）项目 -->
        <div class="carousel-inner">
            <div class="item active">
                <img style="background-color: red; height: 500px; width: auto; " alt="First slide">
            </div>
            <div class="item">
                <img style="background-color: black; height: 500px; width: auto; " alt="Second slide">
            </div>
            <div class="item">
                <img style="background-color: blue; height: 500px; width: auto; " alt="Third slide">
            </div>
        </div>
        <!-- 轮播（Carousel）导航 -->
        <a class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a>
        <a class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a>
        </div>
@endsection

@section('js')
<script type="text/javascript">
    $('#myCarousel').carousel('cycle');
    $('#myCarousel').carousel({
        interval: 200
    });
</script>
@endsection