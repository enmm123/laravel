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
                <form class="layui-form" id="art_form" action="http://lamp.com/admin/article/{{$article->id}}" method="post" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <input type="hidden" name="aid" value="{{$article->id}}">
                    <input type="hidden" value="http://lamp.com/admin/article/{{$article->id}}">
                    <div class="layui-form-item">
                        <label for="L_username" class="layui-form-label">
                            <span class="x-red">*</span>分类</label>
                        <div class="layui-input-inline">
                            <select name="cate_id">
                                <option value="0">==顶级分类==</option>
                                @foreach($cate as $v)
                                    <option value="{{$v->id}}"@if($v->id == $article->cate_id) selected @endif>{{$v->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label for="L_email" class="layui-form-label">
                            <span class="x-red">*</span>文章标题</label>
                        <div class="layui-input-inline">
                            <input type="text" id="L_username" name="art_title" value="{{$article->art_title}}" required="" lay-verify="title" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label for="L_pass" class="layui-form-label">
                            <span class="x-red">*</span>编辑</label>
                        <div class="layui-input-inline">
                            <input type="text" id="L_pass" name="art_editor" value="{{$article->art_editor}}" required="" lay-verify="auther" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label for="L_repass" class="layui-form-label">
                            <span class="x-red">*</span>缩略图</label>
                        <div class="layui-input-inline">
                            <input type="hidden" id="img1" class="hidden" name="art_thumb">
                            <button type="button" class="layui-btn" id="test1">重新上传</button>
                            <input type="file" name="photo" id="photo_upload" style="display: none">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <div class="layui-input-block">
                            <img id="art_thumb_img" style="width: 200px; border: none" src="{{url($article->art_thumb)}}">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label for="L_repass" class="layui-form-label">
                            <span class="x-red">*</span>描述</label>
                        <div class="layui-input-inline">
                            <textarea rows="10" cols="50" name="art_description" lay-verify="describe">{{$article->art_description}}</textarea>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label for="L_repass" class="layui-form-label">
                            <span class="x-red">*</span>内容</label>
                        <div class="layui-input-block">
                            <!-- 配置文件 -->
                            <script type="text/javascript" src="/ueditor/ueditor.config.js"></script>
                            <!-- 编辑器源码文件 -->
                            <script type="text/javascript" src="/ueditor/ueditor.all.js"></script>
                            <script type="text/javascript" charset="utf-8" src="/ueditor/lang/zh-cn/zh-cn.js"></script>
                            <script id="container" name="art_content" type="text/plain" style="height: 200px;">{!!$article->art_content!!}</script>
                            <script>
                            //实例化
                            var ue = UE.getEditor('container');
                            </script>
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
                var upload = layui.upload;

                //自定义验证规则
                form.verify({
                    title: function(value) {
                        if (value.length < 1) {
                            return '请输入标题';
                        }
                    },
                    auther: function(value) {
                        if (value.length < 1) {
                            return '请输入作者';
                        }
                    },
                    describe: function(value) {
                        if (value.length < 1) {
                            return '请添加描述';
                        }
                    },
                });

                $('#test1').on('click',function () {
                    $('#photo_upload').trigger('click');
                    $('#photo_upload').on('change',function () {
                        var obj = this;
                        var formData = new FormData($('#art_form')[0]);
                        // console.log(obj);
                        $.ajax({
                            url:'/admin/article/upload',
                            type:'post',
                            data:formData,
                            //因为data值是formdata对象，不需要对数据进行处理
                            processData:false,
                            contentType:false,
                            success:function (data) {
                                if(data['ServerNo']=='200'){
                                    $('#art_thumb_img').attr('src','/uploads/'+data['ResultData']);
                                    $('input[name=art_thumb]').val('/uploads/'+data['ResultData']);
                                    $(obj).off('change');
                                }else{
                                    alert(data['ResultData']);
                                }
                            },
                            error:function (XMLHttpRequest,textStatus,errorThrown) {
                                var number = XMLHttpRequest.status;
                                var info = "错误号"+number+"文件上传失败";
                                alert(info);
                            },
                            async:true
                        })
                    })
                })


                //监听提交
                form.on('submit(edit)',
                function(data) {
                    var aid = $("input[name='aid']").val();
                    //发异步，把数据提交给php
                    $.ajax({
                        type:'PUT',
                        url:'/admin/article/'+aid,
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