<?php

namespace App\Http\Controllers\Admin;

use App\Model\Article;
use App\Model\Comment;
use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    //后台首页
    public function index(){
        return view('admin.index');
    }
    //后台首页主体
    public function welcome(){
        $time = date('Y-m-d H:i:s',time());
        $art_num = Article::count();
        $user_num = User::count();
        $com_num = Comment::count();
        $info = array(
            'time'=>$time,
            'art_num'=>$art_num,
            'user_num'=>$user_num,
            'com_num'=>$com_num,
            'php_uname'=>php_uname(),
            'php_sapi'=>php_sapi_name(),
            'php_version'=> PHP_VERSION,
            'server_ip'=>GetHostByName($_SERVER['SERVER_NAME']),
            'client_ip'=>$_SERVER['REMOTE_ADDR']
        );
//        var_dump($info);
        return view('admin.welcome',compact('info'));
    }
    //后台退出
    public function logout(){
        //清空session
        session()->flush();
        //跳转至登录页面
        return redirect('admin/login');
    }
}
