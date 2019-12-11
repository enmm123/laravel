<?php

namespace App\Http\Controllers\Admin;

use App\Model\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Org\code\Code;

class LoginController extends Controller
{
    //后台登录
    public function login(){
        return view('admin.login');
    }
    //验证码
    public function code(){
        $code = new Code();
        return $code->make();
    }
    //处理用户登录到方法
    public function doLogin(Request $request){
        //接受表单提交的数据
        $input = $request->except('_token');
        //表单验证

        //验证码验证
        if(strtolower($input['code']) != strtolower(session()->get('code'))){
            return redirect('admin/login')->with('errors','验证码输入错误');
        }
        //验证规则
        $rule = [
            'username'=>'required|between:4,18',
            'password'=>'required|between:4,18|alpha_dash'
        ];
        //错误信息
        $msg = [
            'username.required'=>'用户名不能为空',
            'username.between'=>'用户名长度须在4-18位之间',
            'password.required'=>'密码不能为空',
            'password.between'=>'密码长度须在4-18位之间',
            'password.alpha_dash'=>'密码必须由数字字母下划线组成'
        ];
        $validator = Validator::make($input,$rule,$msg);

        if ($validator->fails()) {
            return redirect('admin/login')
                ->withErrors($validator)
                ->withInput();
        }
        //验证是否有此用户
        $user = User::where('username',$input['username'])->first();
        if(!$user){
            return redirect('admin/login')->with('errors','用户不存在');
        }
        //验证密码
        if(md5($input['password'])!=$user->password){
            return redirect('admin/login')->with('errors','密码错误');
        }
        if($user['status'] == 1){
            return redirect('log')->with('errors','用户已被禁用');
        }

        //保存用户信息到session
        session()->put('admin_user',$user);

        //跳转到后台首页
        return redirect('admin/index');
    }

    //没有权限
    public function noaccess(){
        return view('errors.noaccess');
    }
}
