<?php

namespace App\Http\Controllers\Admin;

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
        return view('admin.welcome');
    }
    //后台退出
    public function logout(){
        //清空session
        session()->flush();
        //跳转至登录页面
        return redirect('admin/login');
    }
}
