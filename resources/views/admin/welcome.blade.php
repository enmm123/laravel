<!DOCTYPE html>
<html class="x-admin-sm">
    <head>
        <meta charset="UTF-8">
        <title>欢迎页面-X-admin2.2</title>
        <meta name="renderer" content="webkit">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
        <link rel="stylesheet" href="./css/font.css">
        <link rel="stylesheet" href="./css/xadmin.css">
        @include('admin.public.script')
        @include('admin.public.style')
    </head>
    <body>
        <div class="layui-fluid">
            <div class="layui-row layui-col-space15">
                <div class="layui-col-md12">
                    <div class="layui-card">
                        <div class="layui-card-body ">
                            <blockquote class="layui-elem-quote">欢迎管理员：
                                <span class="x-red">{{session()->get('admin_user')->username}}</span>！当前时间：{{$info['time']}}
                            </blockquote>
                        </div>
                    </div>
                </div>
                <div class="layui-col-md12">
                    <div class="layui-card">
                        <div class="layui-card-header">数据统计</div>
                        <div class="layui-card-body ">
                            <ul class="layui-row layui-col-space10 layui-this x-admin-carousel x-admin-backlog">
                                <li class="layui-col-md2 layui-col-xs6">
                                    <a href="javascript:;" class="x-admin-backlog-body">
                                        <h3>文章数</h3>
                                        <p>
                                            <cite>{{$info['art_num']}}</cite>
                                        </p>
                                    </a>
                                </li>
                                <li class="layui-col-md2 layui-col-xs6">
                                    <a href="javascript:;" class="x-admin-backlog-body">
                                        <h3>会员数</h3>
                                        <p>
                                            <cite>{{$info['user_num']}}</cite>
                                        </p>
                                    </a>
                                </li>
                                <li class="layui-col-md2 layui-col-xs6">
                                    <a href="javascript:;" class="x-admin-backlog-body">
                                        <h3>留言数</h3>
                                        <p>
                                            <cite>{{$info['com_num']}}</cite>
                                        </p>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                {{--<div class="layui-col-sm6 layui-col-md3">--}}
                    {{--<div class="layui-card">--}}
                        {{--<div class="layui-card-header">下载--}}
                            {{--<span class="layui-badge layui-bg-cyan layuiadmin-badge">月</span></div>--}}
                        {{--<div class="layui-card-body  ">--}}
                            {{--<p class="layuiadmin-big-font">33,555</p>--}}
                            {{--<p>新下载--}}
                                {{--<span class="layuiadmin-span-color">10%--}}
                                    {{--<i class="layui-inline layui-icon layui-icon-face-smile-b"></i></span>--}}
                            {{--</p>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
                <div class="layui-col-md12">
                    <div class="layui-card">
                        <div class="layui-card-header">系统信息</div>
                        <div class="layui-card-body ">
                            <table class="layui-table">
                                <tbody>
                                    <tr>
                                        <th>系统版本</th>
                                        <td>{{$info['php_uname']}}</td></tr>
                                    <tr>
                                        <th>运行环境</th>
                                        <td>{{$info['php_sapi']}}</td></tr>
                                    <tr>
                                        <th>服务器IP</th>
                                        <td>{{$info['server_ip']}}</td></tr>
                                    <tr>
                                        <th>客户端IP</th>
                                        <td>{{$info['client_ip']}}</td></tr>
                                    <tr>
                                        <th>PHP版本</th>
                                        <td>{{$info['php_version']}}</td></tr>
                                    <tr>
                                        <th>MYSQL版本</th>
                                        <td>5.7.28</td></tr>
                                    <tr>
                                        <th>laravel版本</th>
                                        <td>5.5.46</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {{--<div class="layui-col-md12">--}}
                    {{--<div class="layui-card">--}}
                        {{--<div class="layui-card-header">开发团队</div>--}}
                        {{--<div class="layui-card-body ">--}}
                            {{--<table class="layui-table">--}}
                                {{--<tbody>--}}
                                    {{--<tr>--}}
                                        {{--<th>版权所有</th>--}}
                                        {{--<td>xuebingsi(xuebingsi)--}}
                                            {{--<a href="http://x.xuebingsi.com/" target="_blank">访问官网</a></td>--}}
                                    {{--</tr>--}}
                                    {{--<tr>--}}
                                        {{--<th>开发者</th>--}}
                                        {{--<td>马志斌(113664000@qq.com)</td></tr>--}}
                                {{--</tbody>--}}
                            {{--</table>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            </div>
        </div>
        </div>
    </body>
</html>