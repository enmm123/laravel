<div class="header">
    <div class="menu-btn">
        <div class="menu"></div>
    </div>
    <h1 class="logo">
        <a href="../">
            <span>MYBLOG</span>
            <img src="{{asset('/home/img/logo.png')}}">
        </a>
    </h1>
    <div class="nav">
        <a href="../">文章</a>
        <a href="{{url('leacots')}}">留言</a>
        <a href="{{url('photo')}}">相册</a>
        <a href="{{url('about')}}">关于</a>
    </div>
    <ul class="layui-nav header-down-nav">
        <li class="layui-nav-item"><a href="index.html" class="active">文章</a></li>
        <li class="layui-nav-item"><a href="leacots.html">留言</a></li>
        <li class="layui-nav-item"><a href="album.html">相册</a></li>
        <li class="layui-nav-item"><a href="about.html">关于</a></li>
    </ul>
    <p class="welcome-text">
        @if(empty(session()->get('user')))
            <a href="{{url('log')}}">登录</a>  | <a href="{{url('zhuce')}}">注册</a>
        @else
            {{session()->get('user')->username}},  <a href="{{url('logout')}}">退出</a>
        @endif
    </p>
</div>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script>
    $(".nav").children().click(function () {
        $(this).addClass("active").siblings().removeClass("active");
    })
</script>