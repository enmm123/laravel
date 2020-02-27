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
            <a>留言管理</a>
            <a>
              <cite>文章留言</cite>
            </a>
          </span>
          <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" onclick="location.reload()" title="刷新">
            <i class="layui-icon layui-icon-refresh" style="line-height:30px"></i></a>
        </div>
        <div class="layui-fluid">
            <div class="layui-row layui-col-space15">
                <div class="layui-col-md12">
                    <div class="layui-card">
                        <div class="layui-card-body layui-table-body layui-table-main">
                            <table class="layui-table layui-form">
                                <thead>
                                  <tr>
                                    <th>文章标题</th>
                                    <th>评论内容</th>
                                    <th>评论者</th>
                                    <th>状态</th>
                                    <th>时间</th>
                                    <th>编辑</th>
                                  </tr>
                                </thead>
                                <tbody>
                                @foreach($comment as $v)
                                  <tr>
                                    <td>{{$v->art_title}}</td>
                                    <td><div style="width: 300px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">{{$v->comment}}</div></td>
                                    <td>{{$v->username}}</td>
                                    <td>
                                        @if($v->status == 0)
                                            <span class="layui-btn layui-btn-normal layui-btn-mini" onclick="member_stop(this,{{$v->id}})" title="点击禁用">已启用</span>
                                        @else
                                            <span class="layui-btn layui-btn-danger layui-btn-mini" onclick="member_stop(this,{{$v->id}})" title="点击启用">已禁用</span>
                                        @endif
                                    </td>
                                    <td>{{$v->time}}</td>
                                    <td class="td-manage">
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
                                {{$comment->render()}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </body>
    <script>
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

      /*文章-禁用-启用*/
      function member_stop(obj,id){
          if($(obj).attr('title') == '点击禁用'){
              layer.confirm('确认要禁用吗？',function(index){
                  $.get('/admin/comment/stop/'+id,function (data) {
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
                  $.get('/admin/comment/open/'+id,function (data) {
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

      /*留言-删除*/
      function member_del(obj,id){
          layer.confirm('确认要删除吗？',function(index){
              $.post('/admin/comment/'+id,{"_method":"delete","_token":"{{csrf_token()}}"},function (data) {
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
    </script>
</html>