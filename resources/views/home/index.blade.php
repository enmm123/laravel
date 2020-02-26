@extends('layouts.home')
@section('title','菠萝笔记')
@section('main')
    {{--<style>--}}
        {{--*{padding: 0;margin: 0;}  /* 先重置一下html，消除HTML标签默认的内外边距 */--}}
        {{--.wrap{width: 800px;margin: 0 auto;height: 150px;}    /* 对导航的内容设置一个主体为800px的宽并使其居中 */--}}
        {{--.clear{clear: both;}  /* 清除浮动 */--}}
        {{--a{text-decoration-line: none;}   /* 去掉默认a标签的下划线 */--}}
        {{--ul,li{list-style: none;}--}}
        {{--nav .level>li{float: left;width: 16.66%;text-align: center;background: white;padding: 10px 0;font-size: 16px;transition: .4s;border: 1px solid #ff7f21;margin-top: 50px;border-radius: 20px;margin-right: 20px}--}}
        {{--nav .level>li a{color: black;}--}}
        {{--/*nav .level>li:hover{background: red;}   !* 设置鼠标滑过后的样式 *!*/--}}

        {{--nav .two{display: none;margin-top: 10px;z-index: 999;}  /* 先使二级菜单的内容隐藏 */--}}
        {{--nav .level>li:hover .two{display: block;position: absolute;text-align: center}   /* 鼠标滑过一级菜单后的显示二级菜单 */--}}
        {{--nav .two li{padding: 5px 0;transition: .4s;cursor: pointer;}--}}
        {{--nav .two li:hover{color: #ff7f21}--}}
        {{--.collect-no{cursor:pointer;}--}}
        {{--.collect-yes i{color:#ff9933;}--}}
    {{--</style>--}}

    <div class="banner">
        <div class="cont w1000">
            <div class="title">
                <h3>MY<br />BLOG</h3>
                <h4>well-balanced heart</h4>
            </div>
            <div class="amount">
                {{--<p><span class="text">访问量</span><span class="access">1000</span></p>--}}
                {{--<p><span class="text">日志</span><span class="daily-record">1000</span></p>--}}
            </div>
        </div>
    </div>

    {{--<div class="layui-carousel" id="test1" lay-filter="test1">--}}
        {{--<div carousel-item="">--}}
            {{--<div>条目1</div>--}}
            {{--<div>条目2</div>--}}
            {{--<div>条目3</div>--}}
            {{--<div>条目4</div>--}}
            {{--<div>条目5</div>--}}
        {{--</div>--}}
    {{--</div>--}}


    {{--<nav>--}}
        {{--<div class="wrap">--}}
            {{--<ul class="level">--}}
                {{--@foreach($cateone as $k=>$v)--}}
                {{--<li>--}}
                    {{--<a href="{{url('/lists/'.$v->id)}}">{{$v->name}}</a>--}}
                    {{--@if(!empty($catetwo[$k]))--}}
                    {{--<ul class="two">--}}
                        {{--@foreach($catetwo[$k] as $m=>$n)--}}
                            {{--<li><a href="{{url('/lists/'.$n->id)}}">{{$n->name}}</a></li>--}}
                        {{--@endforeach--}}
                    {{--</ul>--}}
                    {{--@endif--}}
                {{--</li>--}}
                {{--@endforeach--}}
            {{--</ul>--}}
        {{--</div>--}}
    {{--</nav>--}}


    <div class="content">
            <div class="cont w1000">
                <div class="title">
                    {{--<span class="layui-breadcrumb" lay-separator="|">--}}
                      {{--<a href="javascript:;" class="active">设计文章</a>--}}
                      {{--<a href="javascript:;">前端文章</a>--}}
                      {{--<a href="javascript:;">旅游杂记</a>--}}
                    {{--</span>--}}
                    <ul style="background-color: #F1F1F1;" class="layui-nav" >
                        @foreach($cateone as $k=>$v)
                        <li class="layui-nav-item layui-this">
                            <a href="{{url('/lists/'.$v->id)}}" style="color: black;">{{$v->name}}</a>
                            @if(!empty($catetwo[$k]))
                            <dl class="layui-nav-child">
                            @foreach($catetwo[$k] as $m=>$n)
                                <dd><a href="{{url('/lists/'.$n->id)}}">{{$n->name}}</a></dd>
                            @endforeach
                            </dl>
                            @endif
                        </li>
                        @endforeach
                    </ul>
                </div>

                <div class="list-item">
                    @foreach($cate_arts as $k=>$v)
                    <div class="item">
                        <div class="layui-fluid">
                            <div class="layui-row" style="background-color: white;padding: 10px;">
                                {{--@if(!empty($v->article))--}}
                                {{--@foreach($v->article as $m=>$n)--}}
                                <div class="layui-col-xs12 layui-col-sm4 layui-col-md5">
                                    <div class="img"><img src="{{$v->art_thumb}}" height="280px"></div>
                                </div>
                                <div class="layui-col-xs12 layui-col-sm8 layui-col-md7">
                                    <div class="item-cont" style="height: 270px">
                                        <h3><a href="{{url('/detail/'.$v->id)}}">{{$v->art_title}}</a></h3>
                                        <h5>{{$v->name}}</h5>
                                        <p style="height: 100px;">{!!$v->art_description!!}</p>
                                        @if(empty(session()->get('user')))
                                        <div class="postlist-meta-collect collect collect-no" style="float:right;cursor: default;color: #8796A3;margin-top: 40px;" title="必须登录才能收藏" artid="{{$v->id}}">
                                            <i class="fa fa-star"></i>&nbsp;
                                            <span>{{$v->art_collect}}</span>&nbsp;
                                        </div>
                                        @else
                                            @if($v->collect)
                                            <div class="postlist-meta-collect collect collect-yes" style="float:right;color: #8796A3;cursor: pointer;margin-top: 40px;" title="已收藏，点击取消收藏" uid="{{session()->get('user')->id}}" artid="{{$v->id}}">
                                                <i class="fa fa-star"></i>&nbsp;
                                                <span>{{$v->art_collect}}</span>&nbsp;
                                            </div>
                                            @else
                                            <div class="postlist-meta-collect collect collect-no" style="float:right;color: #8796A3;cursor: pointer;margin-top: 40px;" title="点击收藏" uid="{{session()->get('user')->id}}" artid="{{$v->id}}">
                                                <i class="fa fa-star"></i>&nbsp;
                                                <span>{{$v->art_collect}}</span>&nbsp;
                                            </div>
                                            @endif
                                        @endif
                                        <div style="float:right;color: #8796A3;margin-top: 40px;">
                                            <i class="fa fa-eye"></i>&nbsp;
                                            <span>{{$v->art_view}}</span>&nbsp;&nbsp;
                                        </div>
                                        {{--<a href="details.html" class="go-icon"></a>--}}
                                    </div>
                                </div>
                                {{--@endforeach--}}
                                {{--@endif--}}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="page">
                    {{$cate_arts->render()}}
                </div>
            </div>
        </div>
    <script>
        //点击收藏或取消收藏
        $('.collect').click(function(){
            var _this = $(this);
            // 文章id
            var artid = Number(_this.attr('artid'));
            var collectnum = _this.children("span").text();
            if(_this.attr('uid')&&_this.hasClass('collect-no')){
                var uid = Number(_this.attr('uid'));
                collectnum = Number(collectnum) + 1;
                $.ajax({
                    type: 'POST',
                    dataType: 'html',
                    url: 'collect',
                    data: 'action=collect&uid=' + uid + '&artid=' + artid + '&act=add',
                    cache: false,
                    success: function(){_this.children("span").text(collectnum);
                        _this.addClass("collect-animate").attr("title","已收藏，点击取消收藏");
                        setTimeout(function(){_this.removeClass('collect-animate').removeClass('collect-no').addClass('collect-yes');},500);}});
                return false;
            }else if(_this.attr('uid')&&_this.hasClass('collect-yes')){
                var uid = Number(_this.attr('uid'));
                if(collectnum > 0){
                    collectnum = Number(collectnum) - 1;
                }
                $.ajax({
                    type: 'POST',
                    dataType: 'html',
                    url: 'collect',
                    data: 'action=collect&uid=' + uid + '&artid=' + artid + '&act=remove',
                    cache: false,
                    success: function(){
                        _this.children("span").text(collectnum);
                        _this.addClass("collect-animate").attr("title","点击收藏");
                        setTimeout(function(){_this.removeClass('collect-animate').removeClass('remove-collect').removeClass('collect-yes').addClass('collect-no');},500);}});
                return false;
            }else{
                return true;
            }
        })
    </script>
    {{--获取访客ip及地址--}}
    <script src="http://pv.sohu.com/cityjson?ie=utf-8"></script>
    <script>
        $.get('userip',{userip:returnCitySN["cip"],usercity:returnCitySN["cname"]});
    </script>
@endsection

