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
        $uid = session()->get('user')?session()->get('user')->id:null;
        $cate_arts = Article::join('cate','article.cate_id','=','cate.id')
            ->leftjoin('collect',function ($join) use ($uid) {
                $join->on('article.id','=','collect.art_id')->where('collect.uid','=',$uid);
            })
            ->select('article.*','cate.name','collect.uid as collect')
            ->where('article.art_status','=','0')
            ->orderby('article.id')->paginate(3);
        $collect = Collect::get();
//        $cate_arts = Cate::where('pid','<>','0')->with('article')->get();
//        print_r(DB::getQueryLog());
//        dd($cate_arts->toarray());die();
        return view('home.index',compact('cate_arts','collect'));
    }
    //文章分类
    public function lists($id){
        $uid = session()->get('user')?session()->get('user')->id:null;
        $cate_arts = Article::join('cate','article.cate_id','=','cate.id')
            ->leftjoin('collect',function ($join) use ($uid) {
                $join->on('article.id','=','collect.art_id')->where('collect.uid','=',$uid);
            })
            ->select('article.*','cate.name','collect.uid as collect')
            ->where('article.cate_id','=',$id)->where('article.art_status','=','0')
            ->orderby('article.id')->paginate(5);
        $collect = Collect::get();
//        dd($cate_arts->toarray());die();
        return view('home.list',compact('cate_arts','collect'));
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
