@extends('layouts.home')
@section('title','菠萝笔记')
@section('main')
  <div class="content whisper-content leacots-content details-content">
    <div class="cont w1000">
      <div class="whisper-list">
        <div class="item-box">
          <div class="review-version">
              <div class="form-box">
                <div class="article-cont" style="background-color: white;padding-left: 20px;padding-right: 20px;">
                  <div class="title" style="margin-top: 10px;">
                    <h3 style="padding-top: 30px;">{{$article->art_title}}</h3>
                      <p class="cont-info" style="color: #777;"><span style="margin-right: 30px">作者：{{$article->art_editor}}</span><span style="margin-right: 30px">{{$article->name}}</span><span style="margin-right: 30px">时间：{{$article->time}}</span>浏览量：{{$article->art_view}}</p>
                  </div>
                  <p>{!! $article->art_content !!}</p>
                  <div class="btn-box" style="padding-bottom: 30px;">
                    <button class="layui-btn layui-btn-primary">上一篇</button>
                    <button class="layui-btn layui-btn-primary">下一篇</button>
                  </div>
                </div>
                <div class="form">
                  <form class="layui-form" action="">
                    <div class="layui-form-item layui-form-text">
                      <div class="layui-input-block">
                        <textarea id="content" placeholder="既然来了，就说几句" class="layui-textarea"></textarea>
                      </div>
                    </div>
                    <div class="layui-form-item">
                      {{--<div class="layui-input-block" style="text-align: right;">--}}
                        {{--<button class="layui-btn definite" id="btn">发表</button>--}}
                      {{--</div>--}}
                    </div>
                  </form>
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
        var url = "/comment";
        var art_id = '{{$article->id}}';
        var uid = this.name;
        if(content==''){
            alert("评论为空！无法提交！");
            return false;
        }
        $.get(url,{'art_id':art_id,'comment':content,'uid':uid},function (data) {
            if(data.status==0){
                alert(data.msg)
            }else{
                alert(data.msg)
            }
            $('#content').val('');
            location.reload();
        })
    })
  </script>
@endsection