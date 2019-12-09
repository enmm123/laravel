<?php

namespace App\Http\Controllers\home;

use App\Model\Article;
use App\Model\Cate;
use App\Model\Collect;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    //前台首页
    public function index(){
        //获取二级类和相关文章
        $cate_arts = Article::join('cate','article.cate_id','=','cate.id')->select('article.*','cate.name')->where('article.art_status','=','0')->paginate(3);
//        $cate_arts = Cate::where('pid','<>','0')->with('article')->get();
        return view('home.index',compact('cate_arts'));
    }
    //文章分类
    public function lists($id){
        $cate_arts = Article::join('cate','article.cate_id','=','cate.id')->where('cate_id','=',$id)->where('article.art_status','=','0')->select('article.*','cate.name')->paginate(3);
        return view('home.list',compact('cate_arts'));
    }
    public function detail($id){
        $article = Article::find($id);
        return view('home.details',compact('article'));
    }
    //文章收藏
    public function collect(Request $request)
    {
        $uid = $request->input('uid');
        $artid = $request->input('artid');
        $act = $request->input('act');


        //判断是收藏还是取消收藏
        switch ($act){
            case 'add':
                $collect = Collect::where([
                    ['uid','=',$uid],
                    ['art_id','=',$artid]
                ])->get();
                if($collect->isEmpty()){
                   $res = Collect::create(['uid'=>$uid,'art_id'=>$artid]);
                   Article::where('id',$artid)->increment('art_collect');
                   if($res){
                       return response()->json(['status'=>0,'msg'=>'已收藏']);
                   }else{
                       return response()->json(['status'=>1,'msg'=>'收藏失败']);
                   }
                }else{
                    return response()->json(['status'=>0,'msg'=>'已收藏']);
                }
                break;
            case 'remove':
                $collect = Collect::where([
                    ['uid','=',$uid],
                    ['art_id','=',$artid]
                ])->first();
                if(!empty($collect)){
                    Article::where('id',$artid)->decrement('art_collect');
                    $res = $collect->delete();
                    if($res){
                        return response()->json(['status'=>0,'msg'=>'请收藏']);
                    }else{
                        return response()->json(['status'=>1,'msg'=>'取消收藏失败']);
                    }
                }else{
                    return response()->json(['status'=>0,'msg'=>'请收藏']);
                }
                break;
        }

    }
    public function logout(){
        //清空session
        session()->flush();
        //跳转至首页
        return redirect('/');
    }
}
