<!DOCTYPE html>
<html lang="cn">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('login/img/apple-icon.png')}}">
    <link rel="icon" type="image/png" href="{{asset('login/img/favicon.png')}}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>用户注册</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />
    <!-- CSS Files -->
    <link href="{{asset('login/css/bootstrap.min.css')}}" rel="stylesheet" />
    <link href="{{asset('login/css/now-ui-kit.css?v=1.1.0')}}" rel="stylesheet" />
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="{{asset('login/css/demo.css')}}" rel="stylesheet" />
    <!-- Canonical SEO -->
    <link rel="canonical" href="" />
    <!--  Social tags      -->
    <meta name="keywords" content="">
    <meta name="description" content="">
    
    
    
</head>

<body class="login-page sidebar-collapse">

    <div class="page-header" filter-color="orange">
        <div class="page-header-image" style="background-image:url({{asset('login/img/login.jpg')}})"></div>
        <div class="container">
            <div class="col-md-4 content-center">
                <div class="card card-login card-plain">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger" style="border-radius: 25px;width: 320px;height: 46px;text-align: center;">
                            <ul style="list-style-type: none;text-align: center;">
                                @if(is_object($errors))
                                    @foreach ($errors->all() as $error)
                                        <li style="margin-right: 30px;">{{ $error }}</li>
                                    @endforeach
                                @else
                                    <li>{{ $errors }}</li>
                                @endif
                            </ul>
                        </div>
                    @endif
                    <form class="form" method="post" action="{{url('dozhuce')}}">
                        {{csrf_field()}}
                        <div class="header header-primary text-center">
                            <div class="logo-container">
                                <img src="{{asset('login/img/now-logo.png')}}" alt="">
                            </div>
                        </div>
                        <div class="content">
                            <div class="input-group form-group-no-border input-lg">
                                <span class="input-group-addon">
                                    <i class="now-ui-icons users_circle-08"></i>
                                </span>
                                <input type="text" class="form-control" placeholder="请输入帐号" name="username">
                                <span style='font-size:13px;color: #f00;line-height: 50px'></span>
                            </div>
                            <div class="input-group form-group-no-border input-lg">
                                <span class="input-group-addon">
                                    <i class="now-ui-icons text_caps-small"></i>
                                </span>
                                <input type="text" placeholder="请输入邮箱" class="form-control" name="email">
                                <span style='font-size:13px;color: #f00;line-height: 50px'></span>
                            </div>
                            <div class="input-group form-group-no-border input-lg">
                                <span class="input-group-addon">
                                    <i class="now-ui-icons text_caps-small"></i>
                                </span>
                                <input type="password" placeholder="请输入密码" class="form-control" name="password">
                                <span style='font-size:13px;color: #f00;line-height: 50px'></span>
                            </div>
                            <div class="input-group form-group-no-border input-lg">
                                <span class="input-group-addon">
                                    <i class="now-ui-icons text_caps-small"></i>
                                </span>
                                <input type="password" placeholder="请再次输入密码" class="form-control" name="repass">
                                <span style='font-size:13px;color: #f00;line-height: 50px'></span>
                            </div>
                        </div>
                        <div class="footer text-center">
                            <input type="submit" class="btn btn-primary btn-round btn-lg btn-block" value="注册">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
<!--   Core JS Files   -->
<script src="{{asset('login/js/core/jquery.3.2.1.min.js')}}" type="text/javascript"></script>
<script src="{{asset('login/js/core/popper.min.js')}}" type="text/javascript"></script>
<script src="{{asset('login/js/core/bootstrap.min.js')}}" type="text/javascript"></script>
<!--  Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
<script src="{{asset('login/js/plugins/bootstrap-switch.js')}}"></script>
<!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
<script src="{{asset('login/js/plugins/nouislider.min.js')}}" type="text/javascript"></script>
<!--  Plugin for the DatePicker, full documentation here: https://github.com/uxsolutions/bootstrap-datepicker -->
<script src="{{asset('login/js/plugins/bootstrap-datepicker.js')}}" type="text/javascript"></script>
<!-- Share Library etc -->
<script src="{{asset('login/js/plugins/jquery.sharrre.js')}}" type="text/javascript"></script>
<!-- Control Center for Now Ui Kit: parallax effects, scripts for the example pages etc -->
<script src="{{asset('login/js/now-ui-kit.js?v=1.1.0')}}" type="text/javascript"></script>

</html>
<script>
    var y=/^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/;
    $("[name='username']").blur(function() {
        var v=$(this).val();
        if (v=='') {
            $("[name='username']").next().html("账号不能为空！");
            $(this).prev().css("color","#f00");
        }else if(v.length<4){
            $("[name='username']").next().html("账号不得少于4位！");
            $("[name='username']").prev().css("color","#f00");
        }else{
            $(this).prev().css("color","#0EA74A");
            $("[name='username']").next().html("");
        }
    });
    $("[name='password']").blur(function() {
        var v=$(this).val();
        if (v=='') {
            $("[name='password']").next().html("密码不能为空！");
            $(this).prev().css("color","#f00");
        }else if(v.length<6){
            $("[name='password']").next().html("密码不能小于6位！");
            $(this).prev().css("color","#f00");
        }
    });
    $("[name='repass']").blur(function() {
        var p=$("[name='password']").val();
        var v=$(this).val();
        if (v=='' || v!=p) {
            $("[name='repass']").next().html("两次密码不一致!");
            $(this).prev().css("color","#f00");
        }
    });
    $("[name='email']").blur(function() {
        var v=$(this).val();
        if (v=='') {
            $("[name='email']").next().html("邮箱不能为空！");
            $(this).prev().css("color","#999");
        }else if(!v.match(y)){
            $("[name='email']").next().html("请填写正确的邮箱！");
            $("[name='email']").prev().css("color","#f00");
        }else{
            $(this).prev().css("color","#0EA74A");
            $("[name='email']").next().html("");
        }
    });
</script>
