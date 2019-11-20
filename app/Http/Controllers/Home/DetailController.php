<?php

namespace App\Http\Controllers\Home;

use App\Model\Article;
use App\Model\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DetailController extends Controller
{
    public function index($id){
        $article = Article::join('cate','article.cate_id','=','cate.id')->select('article.*','cate.name')->find($id);
//        dd($article);
        $comment = Comment::join('user','comments.uid','=','user.id')->select('comments.*','user.username')->get();
        return view('home.details',compact('article','comment'));
    }

    public function comment(Request $request){
//        dump($request);
        $uid = $request->input('uid');
        $comment = $request->input('comment');
        $art_id = $request->input('art_id');
        $res = Comment::create(['uid'=>$uid,'comment'=>$comment,'art_id'=>$art_id]);
        if($res){
            return response()->json(['status'=>0,'msg'=>'评论成功']);
        }else{
            return response()->json(['status'=>1,'msg'=>'评论失败']);
        }
    }
}
