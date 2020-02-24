<?php

namespace App\Http\Controllers\Admin;

use App\Model\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comment = Comment::join('user','comments.uid','=','user.id')
        ->join('article','comments.art_id','=','article.id')
        ->select('comments.*','article.art_title','user.username')->paginate(5);
        return view('admin.comment.art_comment',compact('comment'));
    }

    public function person(){
        $comment = Comment::join('user','comments.uid','=','user.id')
            ->where('comments.art_id','=','0')
            ->select('comments.*','user.username')->paginate(5);
        return view('admin.comment.per_comment',compact('comment'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comment = Comment::find($id);
        $res = $comment->delete();
        if($res){
            $data=[
                'status'=>0,
                'message'=>'删除成功'
            ];
        }else{
            $data=[
                'status'=>1,
                'message'=>'删除失败'
            ];
        }
        return $data;
    }

    //禁用留言
    public function stop($id){
        $article = Comment::find($id);
        $article->status = '1';
        $res = $article->save();
        if($res){
            $data=[
                'status'=>0,
                'message'=>'操作成功'
            ];
        }else{
            $data=[
                'status'=>1,
                'message'=>'操作失败'
            ];
        }
        return $data;
    }
    //启用留言
    public function open($id){
        $article = Comment::find($id);
        $article->status = '0';
        $res = $article->save();
        if($res){
            $data=[
                'status'=>0,
                'message'=>'操作成功'
            ];
        }else{
            $data=[
                'status'=>1,
                'message'=>'操作失败'
            ];
        }
        return $data;
    }
}
