<?php

namespace App\Http\Controllers\Home;

use App\Model\Collect;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AboutController extends Controller
{
    //关于页面主页
    public function index(){
        $uid = session()->get('user')?session()->get('user')->id:null;
        $collect_arts = Collect::where('uid','=',$uid)->join('article','collect.art_id','=','article.id')->select('article.*')->get();
//        dd($collect_arts);
        return view('home.about',compact('collect_arts'));
    }
}
