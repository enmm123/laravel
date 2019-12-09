<?php

namespace App\Http\Controllers\Admin;

use App\Model\Role;
use App\Model\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{

    //获取授权页面
    public function auth($id){
        //获取当前用户
        $user = User::find($id);
        //获取所有角色列表
        $role = Role::get();
        //获取当前用户的角色
        $own_roles = $user->role;
        //角色拥有的权限id
        $own_pers = [];
        foreach ($own_roles as $v){
            $own_pers[] = $v->id;
        }
        return view('admin.user.auth',compact('user','role','own_pers'));
    }

    //处理授权
    public function doAuth(Request $request){
        $input = $request->except('_token');
        //删除当前角色已经有的权限
        \DB::table('user_role')->where('user_id',$input['user_id'])->delete();
        //添加新授予的权限
        if(!empty($input['role_id'])){
            foreach ($input['role_id'] as $v){
                \DB::table('user_role')->insert(['user_id'=>$input['user_id'],'role_id'=>$v]);
            }
        }
        return redirect('admin/user')->with('msg','授权成功');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //用户列表
        $user = User::orderBy('id','asc')
            ->where(function ($query) use ($request){
                $username = $request->input('username');
                $email = $request->input('email');
                if(!empty($username)){
                    $query->where('username','like','%'.$username.'%');
                }
                if(!empty($email)){
                    $query->where('email','like','%'.$email.'%');
                }
            })
            ->paginate($request->input('num')?$request->input('num'):5);
//        foreach ($user['id'] as $k=>$v){
//            $user['id']['aaa'][$k] = 123456;
//        }
        return view('admin.user.list',compact('user','request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //添加用户页面
        return view('admin.user.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

//        $flight = new User();
//
//        $flight->username = $request->username;
//        $flight->password = $request->password;
//        $flight->email = $request->email;
//
//        $res = $flight->save();

        //执行添加操作
        //1.接收表单提交的数据
        $input = $request->all();
        //2.进行表单验证
        //3.添加到数据库
        $username = $input['username'];
        $email = $input['email'];
        $password = md5($input['pass']);
        $info = ['username'=>$username,'email'=>$email,'password'=>$password];
        $res = User::create($info);
        //4.根据是否添加成功，给客户端返回一个json格式的反馈
        if($res){
            $data = [
                'status'=>0,
                'message'=>'添加成功'
            ];
        }else{
            $data = [
                'status'=>1,
                'message'=>'添加失败'
            ];
        }
        return $data;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user =User::find($id);
        return view('admin.user.edit',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //1.根据id获取要修改的记录
        $user = User::find($id);
        $user->username = $request->input('username');
        $user->password = $request->input('pass');
        $user->email = $request->input('email');
        $res = $user->save();
        if($res){
            $data=[
                'status'=>0,
                'message'=>'修改成功'
            ];
        }else{
            $data=[
                'status'=>1,
                'message'=>'修改失败'
            ];
        }
        return $data;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //删除用户
        $user = User::find($id);
        $res = $user->delete();
        if($res){
            $data=[
                'status'=>0,
                'message'=>'删除成功'
            ];
        }else{
            $data=[
                'status'=>1,
                'message'=>'删除失败'
            ];
        }
        return $data;
    }
    //删除所有选中的用户
    public function delAll(Request $request){
        $input = $request->input('ids');
        $res = User::destroy($input);
        if($res){
            $data=[
                'status'=>0,
                'message'=>'删除成功'
            ];
        }else{
            $data=[
                'status'=>1,
                'message'=>'删除失败'
            ];
        }
        return $data;
    }
    //禁用用户
    public function stop($id){
        $user = User::find($id);
        $user->status = '1';
        $res = $user->save();
        if($res){
            $data=[
                'status'=>0,
                'message'=>'操作成功'
            ];
        }else{
            $data=[
                'status'=>1,
                'message'=>'操作失败'
            ];
        }
        return $data;
    }
    //启用用户
    public function open($id){
        $user = User::find($id);
        $user->status = '0';
        $res = $user->save();
        if($res){
            $data=[
                'status'=>0,
                'message'=>'操作成功'
            ];
        }else{
            $data=[
                'status'=>1,
                'message'=>'操作失败'
            ];
        }
        return $data;
    }
}
