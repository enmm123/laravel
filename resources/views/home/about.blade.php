@extends('layouts.home')
@section('title','菠萝笔记')
@section('main')
    <div class="about-content">
        <div class="w1000">
            <div class="item info">
                <div class="title">
                    <h3>我收藏的文章</h3>
                </div>
                <div class="cont">
                    @if(empty(session()->get('user')))
                        <div class="layui-input-block" style="text-align: center;">
                            您还未登录，请<a href="{{url('log')}}" style="color: orange">登录</a>后查看
                        </div>
                    @else
                        <table class="layui-table" lay-even="" lay-skin="nob">
                            <tr>
                                <td>文章标题</td>
                                <td>文章作者</td>
                            </tr>
                            @foreach($collect_arts as $v)
                            <tr>
                                <td><a href="{{url('/detail/'.$v->id)}}">{{$v->art_title}}</a></td>
                                <td>{{$v->art_editor}}</td>
                            </tr>
                            @endforeach
                        </table>
                    @endif
                </div>
            </div>
            {{--<div class="item tool">--}}
                {{--<div class="title">--}}
                    {{--<h3>我的技能</h3>--}}
                {{--</div>--}}
                {{--<div class="layui-fluid">--}}
                    {{--<div class="layui-row">--}}
                        {{--<div class="layui-col-xs6 layui-col-sm3 layui-col-md3">--}}
                            {{--<div class="cont-box">--}}
                                {{--<img src="{{asset('/home/img/gr_img2.jpg')}}">--}}
                                {{--<p>80%</p>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="layui-col-xs6 layui-col-sm3 layui-col-md3">--}}
                            {{--<div class="cont-box">--}}
                                {{--<img src="{{asset('/home/img/gr_img3.jpg')}}">--}}
                                {{--<p>80%</p>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="layui-col-xs6 layui-col-sm3 layui-col-md3">--}}
                            {{--<div class="cont-box">--}}
                                {{--<img src="{{asset('/home/img/gr_img4.jpg')}}">--}}
                                {{--<p>80%</p>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="layui-col-xs6 layui-col-sm3 layui-col-md3">--}}
                            {{--<div class="cont-box">--}}
                                {{--<img src="{{asset('/home/img/gr_img5.jpg')}}">--}}
                                {{--<p>80%</p>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<div class="item contact">--}}
                {{--<div class="title">--}}
                    {{--<h3>联系方式</h3>--}}
                {{--</div>--}}
                {{--<div class="cont">--}}
                    {{--<img src="{{asset('/home/img/erweima.jpg')}}">--}}
                    {{--<div class="text">--}}
                        {{--<p class="WeChat">微信：<span>1234567890</span></p>--}}
                        {{--<p class="qq">qq：<span>123456789</span></p>--}}
                        {{--<p class="iphone">电话：<span>123456789</span></p>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        </div>
    </div>
@endsection