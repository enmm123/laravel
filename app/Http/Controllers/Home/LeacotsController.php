<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LeacotsController extends Controller
{
    //留言页面主页
    public function index(){
        return view('home.leacots');
    }
}
