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
        $article['time'] = substr($article['time'],0,10);
        $article->art_view = $article->art_view + 1;
        $res = $article->save();
//        dd($article);
        $comment = Comment::join('user','comments.uid','=','user.id')->join('article','comments.art_id','=','article.id')->where('comments.art_id','=',$id)->select('comments.*','user.username')->paginate(5);
        return view('home.details',compact('article','comment'));
    }

    public function comment(Request $request){
//        dump($request);
        $uid = $request->input('uid');
        $comment = $request->input('comment');
        $art_id = $request->input('art_id');
        $time = date('Y-m-d H:i:s',time());
        $res = Comment::create(['uid'=>$uid,'comment'=>$comment,'art_id'=>$art_id,'time'=>$time]);
        if($res){
            return response()->json(['status'=>0,'msg'=>'评论成功']);
        }else{
            return response()->json(['status'=>1,'msg'=>'评论失败']);
        }
    }
}
