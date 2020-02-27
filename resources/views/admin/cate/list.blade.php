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
            <a>分类管理</a>
            <a>
              <cite>分类列表</cite>
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
                                    <th>排序</th>
                                    <th>ID</th>
                                    <th>分类名称</th>
                                    <th>分类标题</th>
                                    <th>操作</th></tr>
                                </thead>
                                <tbody>
                                @foreach($cate as $v)
                                  <tr id="foo">
                                    <td>
                                        <input onchange="changeOrder(this,{{$v->id}})" type="text" name="order" value="{{$v->order}}" class="layui-input" style="width: 50px">
                                    </td>
                                    <td>{{$v->id}}</td>
                                    <td>{{$v->name}}</td>
                                    <td>{{$v->title}}</td>
                                    <td class="td-manage">
                                      <a title="编辑"  onclick="xadmin.open('编辑','{{url('admin/cate/'.$v->id.'/edit')}}',600,400)" href="javascript:;">
                                        <i class="layui-icon">&#xe642;</i>
                                      </a>
                                      <a title="删除" onclick="member_del(this,{{$v->id}})" href="javascript:;">
                                        <i class="layui-icon">&#xe640;</i>
                                      </a>
                                    </td>
                                  </tr>
                                @endforeach
                                </tbody>
                            </table>
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

      function changeOrder(obj,id) {
          var order_id = $(obj).val();
          $.post('/admin/cate/changeorder',{'_token':"{{csrf_token()}}","id":id,"cate_order":order_id,function(data){
                    // alert(1);
                  console.log(typeof (data));
                  // location.reload();
                  if(typeof (data) == 'undefined'){
                      layer.msg('排序修改成功',{icon:6},function () {
                          location.reload();
                      });
                  }else{
                      layer.msg('排序修改失败',{icon:5})
                  }
              }})
      }

      /*用户-删除*/
      function member_del(obj,id){
          layer.confirm('确认要删除吗？',function(index){
              $.post('/admin/cate/'+id,{"_method":"delete","_token":"{{csrf_token()}}"},function (data) {
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