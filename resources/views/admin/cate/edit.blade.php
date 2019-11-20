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
                    {{csrf_field()}}
                    <input type="hidden" name="cid" value="{{$cate->id}}">
                    <div class="layui-form-item">
                        <label for="L_username" class="layui-form-label">
                            <span class="x-red">*</span>父级分类</label>
                        <div class="layui-input-inline">
                            <select name="pid">
                                <option value="0">==顶级分类==</option>
                                @foreach($cates as $v)
                                    <option value="{{$v->id}}"@if($v->id == $cate->pid) selected @endif>{{$v->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label for="L_email" class="layui-form-label">
                            <span class="x-red">*</span>分类名称</label>
                        <div class="layui-input-inline">
                            <input type="text" id="L_username" name="name" value="{{$cate->name}}" required="" lay-verify="nikename" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label for="L_pass" class="layui-form-label">
                            <span class="x-red">*</span>分类标题</label>
                        <div class="layui-input-inline">
                            <input type="text" id="L_pass" name="title" value="{{$cate->title}}" required="" lay-verify="pass" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label for="L_repass" class="layui-form-label">
                            <span class="x-red">*</span>排序</label>
                        <div class="layui-input-inline">
                            <input type="text" id="L_repass" name="order" value="{{$cate->order}}" required="" lay-verify="repass" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label for="L_repass" class="layui-form-label"></label>
                        <button class="layui-btn" lay-filter="edit" lay-submit="">修改</button>
                    </div>
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
                    var cid = $("input[name='cid']").val();
                    //发异步，把数据提交给php
                    $.ajax({
                        type:'PUT',
                        url:'/admin/cate/'+cid,
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