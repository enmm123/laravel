<!DOCTYPE html>
<html class="x-admin-sm">
    <head>
        <meta charset="UTF-8">
        <title>欢迎页面-X-admin2.2</title>
        <meta name="renderer" content="webkit">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
        @include('admin.public.script')
        @include('admin.public.style')
    </head>
    <body>
        <div class="x-nav">
          <span class="layui-breadcrumb">
            <a>会员管理</a>
            <a>
              <cite>会员列表</cite>
            </a>
          </span>
          <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" onclick="location.reload()" title="刷新">
            <i class="layui-icon layui-icon-refresh" style="line-height:30px"></i></a>
        </div>
        <div class="layui-fluid">
            <div class="layui-row layui-col-space15">
                <div class="layui-col-md12">
                    <div class="layui-card">
                        <div class="layui-card-body ">
                            <form class="layui-form layui-col-space5" method="get" action="{{url('admin/user')}}">
                                <div class="layui-inline">
                                <select name="num" lay-filter="aihao">
                                    <option value="3"@if($request->input('num')==3) selected @endif>3</option>
                                    <option value="5" @if($request->input('num')==5) selected @endif>5</option>
                                    <option value="10" @if($request->input('num')==10) selected @endif>10</option>
                                </select>
                                </div>
                                <div class="layui-inline layui-show-xs-block">
                                    <input type="text" name="username" value="{{$request->input('username')}}" placeholder="请输入用户名" autocomplete="off" class="layui-input">
                                </div>
                                <div class="layui-inline layui-show-xs-block">
                                    <input type="text" name="email" value="{{$request->input('email')}}" placeholder="请输入邮箱" autocomplete="off" class="layui-input">
                                </div>
                                <button class="layui-btn"  lay-submit="" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>
                            </form>
                        </div>
                        <div class="layui-card-header">
                            <button class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon"></i>批量删除</button>
                            <button class="layui-btn" onclick="xadmin.open('添加用户','{{url('admin/user/create')}}',600,400)"><i class="layui-icon"></i>添加</button>
                        </div>
                        <div class="layui-card-body layui-table-body layui-table-main">
                            <table class="layui-table layui-form">
                                <thead>
                                  <tr>
                                    <th>
                                        {{--<div class="layui-unselect header layui-form-checkbox" lay-skin="primary"><i class="layui-icon">&#xe605;</i></div>--}}
                                      <input type="checkbox" lay-filter="checkall" name="" lay-skin="primary">
                                    </th>
                                    <th>ID</th>
                                    <th>用户名</th>
                                    <th>邮箱</th>
                                    <th>最后登录ip</th>
                                    <th>最后登录地址</th>
                                    <th>状态</th>
                                    <th>操作</th>
                                  </tr>
                                </thead>
                                <tbody>
                                @foreach($user as $v)
                                  <tr>
                                    <td>
                                        {{--<div class="layui-unselect layui-form-checkbox" lay-skin="primary" data-id='{{$v->id}}'><i class="layui-icon">&#xe605;</i></div>--}}
                                      {{--<input type="checkbox" lay-skin="primary">--}}
                                        {{--<div class="layui-unselect layui-form-checked" lay-skin="primary" data-id='{{$v->id}}'>--}}
                                            {{--<i class="layui-icon layui-icon-ok"></i>--}}
                                        {{--</div>--}}
                                        <input type="checkbox" lay-skin="primary" data-html="{{$v->id}}">
                                    </td>
                                    <td>{{$v->id}}</td>
                                    <td>{{$v->username}}</td>
                                    <td>{{$v->email}}</td>
                                    <td>{{$v->lastloginip}}</td>
                                    <td>{{$v->lastlogincity}}</td>
                                    <td class="td-status">
                                        @if($v->status == 0)
                                            <span class="layui-btn layui-btn-normal layui-btn-mini" onclick="member_stop(this,{{$v->id}})" title="点击禁用">已启用</span>
                                        @else
                                            <span class="layui-btn layui-btn-danger layui-btn-mini" onclick="member_stop(this,{{$v->id}})" title="点击启用">已禁用</span>
                                        @endif
                                    </td>
                                    <td class="td-manage">
                                      <a title="授予角色" href="{{url('admin/user/auth/'.$v->id)}}">
                                        <i class="layui-icon">&#xe608;</i>
                                      </a>
                                      <a title="编辑"  onclick="xadmin.open('编辑','{{url('admin/user/'.$v->id.'/edit')}}',600,400)" href="javascript:;">
                                        <i class="layui-icon">&#xe642;</i>
                                      </a>
                                      {{--<a onclick="xadmin.open('修改密码','member-password.html',600,400)" title="修改密码" href="javascript:;">--}}
                                        {{--<i class="layui-icon">&#xe631;</i>--}}
                                      {{--</a>--}}
                                      <a title="删除" onclick="member_del(this,{{$v->id}})" href="javascript:;">
                                        <i class="layui-icon">&#xe640;</i>
                                      </a>
                                    </td>
                                  </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="layui-card-body ">
                            <div class="page">
                                {!! $user->appends($request->all())->render() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </body>
    <script>
        {{--$(".layui-form-checked").attr("data-id","{{$v->id}}");--}}
      layui.use(['laydate','form'], function(){
        var laydate = layui.laydate;
        var  form = layui.form;


        // 监听全选
        form.on('checkbox(checkall)', function(data){

          if(data.elem.checked){
            $('tbody input').prop('checked',true);
          }else{
            $('tbody input').prop('checked',false);
          }
          form.render('checkbox');
        }); 
        
        //执行一个laydate实例
        laydate.render({
          elem: '#start' //指定元素
        });

        //执行一个laydate实例
        laydate.render({
          elem: '#end' //指定元素
        });


      });

       /*用户-禁用-启用*/
      function member_stop(obj,id){
          if($(obj).attr('title') == '点击禁用'){
              layer.confirm('确认要禁用吗？',function(index){
                  $.get('/admin/user/stop/'+id,function (data) {
                      if(data.status == 0){
                          $(obj).removeClass('layui-btn layui-btn-normal layui-btn-mini').addClass('layui-btn layui-btn-danger layui-btn-mini');
                          $(obj).attr('title','点击启用');
                          $(obj).html('已禁用');
                          layer.msg(data.message,{icon:6,time:1000})
                      }else{
                          layer.msg(data.message,{icon:5,time:1000})
                      }
                  })
              });
          }else{
              layer.confirm('确认要启用吗？',function(index){
                  $.get('/admin/user/open/'+id,function (data) {
                      if(data.status == 0){
                          $(obj).removeClass('layui-btn layui-btn-danger layui-btn-mini').addClass('layui-btn layui-btn-normal layui-btn-mini');
                          $(obj).attr('title','点击禁用');
                          $(obj).html('已启用');
                          layer.msg(data.message,{icon:6,time:1000})
                      }else{
                          layer.msg(data.message,{icon:5,time:1000})
                      }
                  })
              });
          }
      }

      /*用户-删除*/
      function member_del(obj,id){
          layer.confirm('确认要删除吗？',function(index){
              $.post('/admin/user/'+id,{"_method":"delete","_token":"{{csrf_token()}}"},function (data) {
                  if(data.status == 0){
                      $(obj).parents("tr").remove();
                      layer.msg(data.message,{icon:6,time:1000})
                  }else{
                      layer.msg(data.message,{icon:5,time:1000})
                  }
              })
              //发异步删除数据
          });
      }


      function delAll (argument) {
        var ids = [];
          // $(".layui-form-checked").not('.header').each(function (i,v) {
          //     var u = $(v).attr('data-id');
          //     ids.push(u);
          // });

          $('tbody input').each(function(i, v) {
              if($(this).prop('checked')){
                  var u = $(v).attr('data-html');
                  ids.push(u);
              }
          });
        layer.confirm('确认要删除吗？',function(index){
            $.get('/admin/user/del',{'ids':ids},function (data) {
                if(data.status == 0){
                    $(".layui-form-checked").not('.header').parents('tr').remove();
                    layer.msg(data.message,{icon:6,time:1000})
                }else{
                    layer.msg(data.message,{icon:5,time:1000})
                }
            });
        });
      }
    </script>
</html>