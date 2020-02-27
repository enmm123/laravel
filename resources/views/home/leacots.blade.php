@extends('layouts.home')
@section('title','菠萝笔记')
@section('main')
    <div class="content whisper-content leacots-content">
        <div class="cont w1000">
            <div class="whisper-list">
                <div class="item-box">
                    <div class="review-version">
                        <div class="form-box">
                            <img class="banner-img" src="{{asset('/home/img/liuyan.jpg')}}">
                            <div class="form">
                                <form class="layui-form">
                                    <div class="layui-form-item layui-form-text">
                                        <div class="layui-input-block">
                                            <textarea id="content" placeholder="既然来了，就说几句" class="layui-textarea"></textarea>
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        @if(empty(session()->get('user')))
                                            <div class="layui-input-block" style="text-align: right;">
                                                <button class="layui-btn definite"><a href="{{url('log')}}">请先登录</a></button>
                                            </div>
                                        @else
                                            <div class="layui-input-block" style="text-align: right;">
                                                <button class="layui-btn definite" id="btn" name="{{session()->get('user')->id}}">发表</button>
                                                <input type="hidden" value="{{session()->get('user')->username}}">
                                            </div>
                                        @endif
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="volume">
                            全部留言
                        </div>
                        <div class="list-cont">
                            @foreach($comment as $v)
                                <div class="cont">
                                    <div class="text">
                                        <p class="tit"><span class="name">{{$v->username}}</span></p>
                                        <p class="ct">{{$v->comment}}</p>
                                    </div>
                                    <p style="float: right;color: #666;font-size: 12px">{{$v->time}}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="page">
                {{$comment->render()}}
            </div>
        </div>
    </div>
    <script>
        $('#btn').click(function () {
            var content = $('#content').val();
            var url = "/leacot";
            var uid = this.name;
            if(content==''){
                alert("评论为空！无法提交！");
                return false;
            }
            $.get(url,{'art_id':0,'comment':content,'uid':uid},function (data) {
                if(data.status==0){
                    alert(data.msg)
                }else{
                    alert(data.msg)
                }
                $('#content').val('');
            })
        })
    </script>
@endsection