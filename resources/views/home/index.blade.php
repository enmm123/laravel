@extends('layouts.home')
@section('title','博客系统')
@section('main')
    <style>
        *{padding: 0;margin: 0;}  /* 先重置一下html，消除HTML标签默认的内外边距 */
        .wrap{width: 800px;margin: 0 auto;height: 150px;}    /* 对导航的内容设置一个主体为800px的宽并使其居中 */
        .clear{clear: both;}  /* 清除浮动 */
        a{text-decoration-line: none;}   /* 去掉默认a标签的下划线 */
        ul,li{list-style: none;}
        nav .level>li{float: left;width: 16.66%;text-align: center;background: white;padding: 10px 0;font-size: 16px;transition: .4s;border: 1px solid #ff7f21;margin-top: 50px;border-radius: 20px;margin-right: 20px}
        nav .level>li a{color: black;}
        /*nav .level>li:hover{background: red;}   !* 设置鼠标滑过后的样式 *!*/

        nav .two{display: none;margin-top: 10px;}  /* 先使二级菜单的内容隐藏 */
        nav .level>li:hover .two{display: block;}   /* 鼠标滑过一级菜单后的显示二级菜单 */
        nav .two li{padding: 5px 0;transition: .4s;cursor: pointer;}
        nav .two li:hover{color: #ff7f21}
        .collect-no{cursor:pointer;}
        .collect-yes i{color:#ff9933;}
    </style>

    <div class="banner">
            <div class="cont w1000">
                <div class="title">
                    <h3>MY<br />BLOG</h3>
                    <h4>well-balanced heart</h4>
                </div>
                {{--<div class="amount">--}}
                    {{--<p><span class="text">访问量</span><span class="access">1000</span></p>--}}
                    {{--<p><span class="text">日志</span><span class="daily-record">1000</span></p>--}}
                {{--</div>--}}
            </div>
        </div>


    <nav>
        <div class="wrap">
            <ul class="level">
                @foreach($cateone as $k=>$v)
                <li>
                    <a href="{{url('/lists/'.$v->id)}}">{{$v->name}}</a>
                    @if(!empty($catetwo[$k]))
                    <ul class="two">
                        @foreach($catetwo[$k] as $m=>$n)
                            <li><a href="{{url('/lists/'.$n->id)}}">{{$n->name}}</a></li>
                        @endforeach
                    </ul>
                    @endif
                </li>
                @endforeach
            </ul>
        </div>
    </nav>


    <div class="content">
            <div class="cont w1000">
                {{--<div class="title">--}}
                    {{--<span class="layui-breadcrumb" lay-separator="|">--}}
                      {{--<a href="javascript:;" class="active">设计文章</a>--}}
                      {{--<a href="javascript:;">前端文章</a>--}}
                      {{--<a href="javascript:;">旅游杂记</a>--}}
                    {{--</span>--}}
                {{--</div>--}}
                <div class="list-item">
                    @foreach($cate_arts as $k=>$v)
                    <div class="item">
                        <div class="layui-fluid">
                            <div class="layui-row">
                                @if(!empty($v->article))
                                @foreach($v->article as $m=>$n)
                                <div class="layui-col-xs12 layui-col-sm4 layui-col-md5">
                                    <div class="img"><img src="{{$n->art_thumb}}" alt=""></div>
                                </div>
                                <div class="layui-col-xs12 layui-col-sm8 layui-col-md7">
                                    <div class="item-cont">
                                        <h3><a href="{{url('/detail/'.$n->id)}}">{{$n->art_title}}</a></h3>
                                        <h5>{{$v->name}}</h5>
                                        <p><a href="{{url('/detail/'.$n->id)}}">{!!$n->art_content!!}</a></p>
                                        @if(empty(session()->get('user')))
                                        <div class="postlist-meta-collect collect collect-no" style="float:right;cursor: default" title="必须登录才能收藏" artid="{{$n->id}}">
                                            <i class="fa fa-star"></i>&nbsp;
                                            <span>{{$n->art_collect}}</span>&nbsp;
                                        </div>
                                        @else
                                        <div class="postlist-meta-collect collect collect-no" style="float:right;" title="点击收藏" uid="{{session()->get('user')->id}}" artid="{{$n->id}}">
                                            <i class="fa fa-star"></i>&nbsp;
                                            <span>{{$n->art_collect}}</span>&nbsp;
                                        </div>
                                        @endif
                                        {{--<a href="details.html" class="go-icon"></a>--}}
                                    </div>
                                </div>
                                @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div id="demo" style="text-align: center;"></div>
            </div>
        </div>
    <script>
        //点击收藏或取消收藏
        $('.collect').click(function(){
            var _this = $(this);
            // 文章id
            var artid = Number(_this.attr('artid'));
            if(_this.attr('uid')&&_this.hasClass('collect-no')){
                var uid = Number(_this.attr('uid'));
                $.ajax({
                    type: 'POST',
                    dataType: 'html',
                    url: 'collect',
                    data: 'action=collect&uid=' + uid + '&artid=' + artid + '&act=add',
                    cache: false,
                    success: function(){_this.children("span").text("已收藏");
                        _this.addClass("collect-animate").attr("title","已收藏");
                        setTimeout(function(){_this.removeClass('collect-animate').removeClass('collect-no').addClass('collect-yes');},500);}});
                return false;
            }else if(_this.attr('uid')&&_this.hasClass('collect-yes')){
                var uid = Number(_this.attr('uid'));
                $.ajax({
                    type: 'POST',
                    dataType: 'html',
                    url: 'collect',
                    data: 'action=collect&uid=' + uid + '&artid=' + artid + '&act=remove',
                    cache: false,
                    success: function(){
                        _this.children("span").text("点击收藏");
                        _this.addClass("collect-animate").attr("title","点击收藏");
                        setTimeout(function(){_this.removeClass('collect-animate').removeClass('remove-collect').removeClass('collect-yes').addClass('collect-no');},500);}});
                return false;
            }else{
                return;
            }
        })
    </script>
@endsection

