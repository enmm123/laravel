<?php

namespace App\Providers;

use App\Model\Cate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //获取所有分类
        $cate = Cate::get();
        //存放一级类变量
        $cateone = [];
        //存放二级类变量
        $catetwo = [];
        foreach ($cate as $k=>$v){
            if($v->pid == 0){
                $cateone[$k] = $v;
                //获取一级类下的二级类
                foreach ($cate as $m=>$n){
                    if($v->id == $n->pid){
                        $catetwo[$k][$m] = $n;
                    }
                }
            }
        }
        //变量共享
        view()->share('cateone',$cateone);
        view()->share('catetwo',$catetwo);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
