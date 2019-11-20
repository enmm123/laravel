<?php

namespace App\Http\Controllers\Home;

use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function index(){
        return view('home.login');
    }

    public function dolog(Request $request){
        $input = $request->except('_token');

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
            return redirect('/log')
                ->withErrors($validator)
                ->withInput();
        }

        //验证是否有此用户
        $user = User::where('username',$input['username'])->first();
        if(!$user){
            return redirect('log')->with('errors','用户不存在');
        }
        //验证密码
        if(md5($input['password'])!=$user->password){
            return redirect('log')->with('errors','密码错误');
        }

        //保存用户信息到session
        session()->put('user',$user);

        //跳转到首页
        return redirect('/');


    }

    public function zhuce(){
        return view('home.zhuce');
    }

    public function dozhuce(Request $request){
        $input = $request->except('_token');
        $username = $input['username'];
        $email = $input['email'];
        $password = md5($input['password']);
        $info = ['username'=>$username,'email'=>$email,'password'=>$password];
        $res = User::create($info);
        if($res){
            return view('home.login');
        }else{
            return view('home.zhuce');
        }
    }
}
