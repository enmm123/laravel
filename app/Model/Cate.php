<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Cate extends Model
{
    //关联的数据表
    public $table = 'cate';
    //允许批量操作的字段
    public $guarded = [];
    //是否维护crated_at 和 updated_at字段
    public $timestamps = false;

    //格式化分类数据
    public function tree(){
        //获取所有的分类数据
        $cates = $this->orderBy('order','asc')->get();
        //格式化（排序，二级分类缩进）
        return $this->getTree($cates);
    }

    public function getTree($cate){
        //排序
        $arr = [];
        foreach($cate as $k=>$v){
            if($v->pid == 0){
                $arr[] = $v;
                //获取一级类下的二级分类
                foreach($cate as $m=>$n){
                    if($v->id == $n->pid){
                        //给分类名称添加缩进
                        $n->name = '|---'.$n->name;
                        $arr[] = $n;
                    }
                }
            }
        }
        return $arr;
    }

    public function article(){
        return $this->hasMany('App\Model\Article','cate_id','id');
    }
}
