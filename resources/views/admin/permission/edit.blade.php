<!DOCTYPE html>
<html class="x-admin-sm">

    <head>
        <meta charset="UTF-8">
        <title>欢迎页面-X-admin2.2</title>
        <meta name="csrf-token" content="{{csrf_token()}}">
        <meta name="renderer" content="webkit">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
        @include('admin.public.script')
        @include('admin.public.style')
    </head>
    <body>
        <div class="layui-fluid">
            <div class="layui-row">
                <form class="layui-form">
                    <div class="layui-form-item">
                        <label for="L_username" class="layui-form-label">
                        <span class="x-red">*</span>权限名称</label>
                        <input type="hidden" name="pid" value="{{$permission->id}}">
                        <div class="layui-input-inline">
                            <input type="text" id="L_username" name="per_name" value="{{$permission->per_name}}" required="" lay-verify="nikename" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">
                            <span class="x-red">*</span>权限路由</label>
                        <div class="layui-input-inline">
                            <input type="text" name="per_url" value="{{$permission->per_url}}" required="" lay-verify="nikename" autocomplete="off" class="layui-input" style="width: 300px;">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label for="L_repass" class="layui-form-label"></label>
                        <button class="layui-btn" lay-filter="edit" lay-submit="">修改</button></div>
                </form>
            </div>
        </div>
        <script>layui.use(['form', 'layer','jquery'],
            function() {
                $ = layui.jquery;
                var form = layui.form,
                layer = layui.layer;


                //监听提交
                form.on('submit(edit)',
                function(data) {
                    var pid = $("input[name='pid']").val();
                    //发异步，把数据提交给php
                    $.ajax({
                        type:'PUT',
                        url:'/admin/permission/'+pid,
                        dataType:'json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data:data.field,
                        success:function (data) {
                            if(data.status==0){
                                layer.alert(data.message,{icon:6},function () {
                                    parent.location.reload(true);
                                })
                            }else{
                                layer.alert(data.message,{icon:5})
                            }
                        },
                        error:function () {

                        }
                    })
                    return false;
                });

            });</script>
        <script>var _hmt = _hmt || []; (function() {
                var hm = document.createElement("script");
                hm.src = "https://hm.baidu.com/hm.js?b393d153aeb26b46e9431fabaf0f6190";
                var s = document.getElementsByTagName("script")[0];
                s.parentNode.insertBefore(hm, s);
            })();</script>
    </body>

</html>