@extends('layouts.home')
@section('title','菠萝笔记')
@section('main')

    <div class="content" style="background-color: #FAF8FB;">
        <div class="cont w1000">
            <div class="title">
                <ul style="background-color: #FAF8FB;" class="layui-nav" >
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
                            <div class="layui-row">
                                {{--@if(!empty($v->article))--}}
                                {{--@foreach($v->article as $m=>$n)--}}
                                <div class="layui-col-xs12 layui-col-sm4 layui-col-md5">
                                    <div class="img"><img src="{{$v->art_thumb}}" height="280px"></div>
                                </div>
                                <div class="layui-col-xs12 layui-col-sm8 layui-col-md7">
                                    <div class="item-cont" style="height: 270px">
                                        <h3><a href="{{url('/detail/'.$v->id)}}">{{$v->art_title}}</a></h3>
                                        <h5>{{$v->name}}</h5>
                                        <p>{!!$v->art_description!!}</p>
                                        @if(empty(session()->get('user')))
                                            <div class="postlist-meta-collect collect collect-no" style="float:right;cursor: default;color: #8796A3;" title="必须登录才能收藏" artid="{{$v->id}}">
                                                <i class="fa fa-star"></i>&nbsp;
                                                <span>{{$v->art_collect}}</span>&nbsp;
                                            </div>
                                        @else
                                            @if($v->collect)
                                                <div class="postlist-meta-collect collect collect-yes" style="float:right;color: #8796A3;cursor: pointer;" title="已收藏，点击取消收藏" uid="{{session()->get('user')->id}}" artid="{{$v->id}}">
                                                    <i class="fa fa-star"></i>&nbsp;
                                                    <span>{{$v->art_collect}}</span>&nbsp;
                                                </div>
                                            @else
                                                <div class="postlist-meta-collect collect collect-no" style="float:right;color: #8796A3;cursor: pointer;" title="点击收藏" uid="{{session()->get('user')->id}}" artid="{{$v->id}}">
                                                    <i class="fa fa-star"></i>&nbsp;
                                                    <span>{{$v->art_collect}}</span>&nbsp;
                                                </div>
                                            @endif
                                        @endif
                                        <div style="float:right;color: #8796A3;">
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
@endsection

