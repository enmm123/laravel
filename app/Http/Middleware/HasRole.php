<?php

namespace App\Http\Middleware;

use App\Model\User;
use Closure;

class HasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function getCurrentAction(){
        //获取当前请求的路由对应的控制器名和方法名
        $route = \Route::current()->getActionName();
        list($class, $method) = explode('@', $route);
        return ['controller' => $class, 'method' => $method];
    }
    public function handle($request, Closure $next)
    {
        $route = $this->getCurrentAction()["controller"];
        //获取当前用户对应的权限组
        $user = User::find(session()->get('user')->id);
        //获取当前用户的角色
        $roles = $user->role;
        //根据角色寻找权限
        $arr = [];
        foreach ($roles as $v){
            $perms = $v->permission;
            foreach ($perms as $perm){
                $arr[] = $perm->per_url;
            }
        }
        //去掉重复的权限
        $arr = array_unique($arr);
        //
        if(in_array($route,$arr)){
            return $next($request);
        }else{
            return redirect('noaccess');
        }

    }
}
