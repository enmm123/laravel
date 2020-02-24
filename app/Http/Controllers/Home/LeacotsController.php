<?php

namespace App\Http\Controllers\Home;

use App\Model\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LeacotsController extends Controller
{
    //留言页面主页
    public function index(){
        $comment = Comment::join('user','comments.uid','=','user.id')
            ->where('comments.art_id','=','0')->where('comments.status','=','0')->paginate(5);
        return view('home.leacots',compact('comment'));
    }

    public function comment(Request $request){
        $uid = $request->input('uid');
        $comment = $request->input('comment');
        $art_id = $request->input('art_id');
        $time = date('Y-m-d H:i:s',time());
        $res = Comment::create(['uid'=>$uid,'comment'=>$comment,'art_id'=>$art_id,'time'=>$time]);
        if($res){
            return response()->json(['status'=>0,'msg'=>'评论成功，请等待后台审核']);
        }else{
            return response()->json(['status'=>1,'msg'=>'评论失败']);
        }
    }
}
