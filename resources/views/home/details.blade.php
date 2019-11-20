@extends('layouts.home')
@section('title','博客系统')
@section('main')
  <div class="content whisper-content leacots-content details-content">
    <div class="cont w1000">
      <div class="whisper-list">
        <div class="item-box">
          <div class="review-version">
              <div class="form-box">
                <div class="article-cont">
                  <div class="title">
                    <h3>{{$article->art_title}}</h3>
                    <p class="cont-info"><span class="types">{{$article->name}}</span></p>
                  </div>
                  <p>{{$article->art_content}}</p>
                  <img src="{{$article->art_thumb}}">
                  <div class="btn-box">
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
                        <button class="layui-btn definite" style="cursor: default">请先登录</button>
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
                </div>
                @endforeach
              </div>
          </div>
        </div>
      </div>
      <div id="demo" style="text-align: center;"></div>
    </div>
  </div>
  <script>
    $('#btn').click(function () {
        var content = $('#content').val();
        var url = "/comment";
        var art_id = '{{$article->id}}';
        var uid = this.name;
        var username = $('input').attr('value');
        if(content==''){
            alert("评论为空！无法提交！");
            return false;
        }
        $.get(url,{'art_id':art_id,'comment':content,'uid':uid},function (data) {
            $('#content').val('');
            location.reload();
        })
    })
  </script>
@endsection