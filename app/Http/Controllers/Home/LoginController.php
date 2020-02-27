<?php

namespace App\Http\Controllers\Home;

use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function index(){
        session(['link' => url()->previous()]);
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
        if($user['status'] == 1){
            return redirect('log')->with('errors','用户已被禁用');
        }

        //保存用户信息到session
        session()->put('user',$user);

        //保存用户最后登录ip及地址到数据库
        $lastloginip = self::getip();
        $lastlogincity = self::getCity();
        User::where('username','=',$input['username'])->update(['lastloginip'=>$lastloginip,'lastlogincity'=>$lastlogincity]);
//        var_dump($lastlogincity);
        //跳转到上一页
//        return redirect('/');
        return redirect(session('link'));

    }

    public function zhuce(){
        return view('home.zhuce');
    }

    public function dozhuce(Request $request){
        $input = $request->except('_token');
        $username = $input['username'];
        //判断用户名是否重复
        $hasuser = User::where('username','=',$username)->get();
        if(empty($hasuser)){
            return redirect('zhuce')->with('errors','用户名已存在');
        }
        $email = $input['email'];
        $password = md5($input['password']);
        $info = ['username'=>$username,'email'=>$email,'password'=>$password];
        $res = User::create($info);
        if($res){
            $user = User::where('username',$username)->first();
            session()->put('user',$user);
            //保存用户最后登录ip及地址到数据库
            $lastloginip = self::getip();
            $lastlogincity = self::getCity();
            User::where('username','=',$input['username'])->update(['lastloginip'=>$lastloginip,'lastlogincity'=>$lastlogincity]);
            return redirect('/');
        }else{
            return view('home.zhuce');
        }
    }

    //获取用户最后一次登录ip
    public static function getip(){
        if (!empty($_SERVER['HTTP_CLIENT_IP'])){   //check ip from share internet
            $ip=$_SERVER['HTTP_CLIENT_IP'];
        }elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){   //to check ip is pass from proxy
            $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
        }else{
            $ip=$_SERVER['REMOTE_ADDR'];
        }
        $one='([0-9]|[0-9]{2}|1\d\d|2[0-4]\d|25[0-5])';
        if(!@preg_match('/'.$one.'\.'.$one.'\.'.$one.'\.'.$one.'$/', $ip)){$ip='0.0.0.0';};
        return $ip;
    }
    //获取用户最后一次登录地址
    public static function getCity()
    {
        $ip = self::getip();
        // ip 接口
        $url = "http://ip.taobao.com/service/getIpInfo.php?ip=".$ip;
        // 设置请求超时时间.
        $context = stream_context_create(array('http' => array('timeout' => 5)));
        if (!empty($ip = json_decode(@file_get_contents($url, 0, $context)))) {
            if ((string)$ip->code == '1') {
                return false;
            }
            $data = (array)$ip->data;
            return $data["region"].$data["city"];
        } else {
            $data = '未知';
            return $data;
        }
    }
//    {

//        $ip = self::getip();
//        if($ip == ''){
//            $url = "http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=json";
//            $ip=json_decode(file_get_contents($url),true);
//            $data = $ip;
//        }else{
//            $url="http://ip.taobao.com/service/getIpInfo.php?ip=".$ip;
//            $ip=json_decode(file_get_contents($url));
//            if((string)$ip->code=='1'){
//                return false;
//            }
//            $data = (array)$ip->data;
//        }
//        return $data["region"].$data["city"];
//    }
}
