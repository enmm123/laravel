<?php

namespace App\Http\Controllers\Admin;

use App\Model\Article;
use App\Model\Cate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{

    //文章上传
    public function upload(Request $request)
    {
        //获取上传文件
        $file = $request->file('photo');
        //判断上传文件是否成功
        if(!$file->isValid()){
            return response()->json(['ServerNo'=>'400','ResultData'=>'无效的上传文件']);
        }
        //获取源文件拓展名
        $ext = $file->getClientOriginalExtension();

        //新文件名
        $newfile = md5(time().rand(1000,9999)).'.'.$ext;
        //文件上传的指定路径
        $path = public_path('uploads');

        //将文件从临时目录移动到制定目录
        if(! $file->move($path,$newfile)){
            return response()->json(['ServerNo'=>'400','ResultData'=>'保存文件失败']);
        }
        //如果上传成功
        return response()->json(['ServerNo'=>'200','ResultData'=>$newfile]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $article = Article::join('cate','article.cate_id','=','cate.id')->select('article.*','cate.name')->paginate(5);
//        dd($article);
        return view('admin.article.list',compact('article'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cate = (new Cate)->tree();
        return view('admin.article.add',compact('cate'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->except('_token','photo');
//        dd($input);
        $time = date('Y-m-d H:i:s',time());
        $input['time'] = $time;
        if(empty($request->input('art_content'))){
            $data=[
                'status'=>2,
                'message'=>'请输入内容'
            ];
            return $data;
        }
        if($request->input('cate_id') == 0){
            $data=[
                'status'=>3,
                'message'=>'请选择分类'
            ];
            return $data;
        }
        $res = Article::create($input);
        if($res){
            $data = [
                'status'=>0,
                'message'=>'添加成功'
            ];
        }else{
            $data = [
                'status'=>1,
                'message'=>'添加失败'
            ];
        }
        return $data;
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
        $article = Article::find($id);
        $cate = (new Cate)->tree();
        return view('admin.article.edit',compact('article','cate'));
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
        //1.根据id获取要修改的记录
        $article = Article::find($id);
        $imgpath = $article['art_thumb'];
        if(empty($request->input('art_content'))){
            $data=[
                'status'=>2,
                'message'=>'请输入内容'
            ];
            return $data;
        }
        if($request->input('cate_id') == 0){
            $data=[
                'status'=>3,
                'message'=>'请选择分类'
            ];
            return $data;
        }
        if(!empty($request->input('art_thumb'))){
            $article->art_thumb = $request->input('art_thumb');
        }
        $article->cate_id = $request->input('cate_id');
        $article->art_title = $request->input('art_title');
        $article->art_editor = $request->input('art_editor');
        $article->art_description = $request->input('art_description');
        $article->art_content = $request->input('art_content');
        $res = $article->save();
        if($res){
            $path = public_path('');
            $path = str_replace('\\','/',$path);
            if(!empty($request->input('art_thumb'))) {
                unlink($path . $imgpath);
            }
            $data=[
                'status'=>0,
                'message'=>'修改成功'
            ];
        }else{
            $data=[
                'status'=>1,
                'message'=>'修改失败'
            ];
        }
        return $data;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $article = Article::find($id);
        $imgpath = $article['art_thumb'];
        $res = $article->delete();
        if($res){
            $path = public_path('');
            $path = str_replace('\\','/',$path);
            unlink($path.$imgpath);
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
    //禁用文章
    public function stop($id){
        $article = Article::find($id);
        $article->art_status = '1';
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
    //启用文章
    public function open($id){
        $article = Article::find($id);
        $article->art_status = '0';
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
