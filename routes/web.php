<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//前台首页
Route::get('/', 'Home\IndexController@index');
//留言页面
Route::get('/leacots', 'Home\LeacotsController@index');
//相册页面
Route::get('/photo', 'Home\PhotoController@index');
//关于页面
Route::get('/about', 'Home\AboutController@index');
//登录页面
Route::get('/log', 'Home\LoginController@index');
Route::post('/dolog', 'Home\LoginController@dolog');
//注册
Route::get('/zhuce', 'Home\LoginController@zhuce');
Route::post('/dozhuce', 'Home\LoginController@dozhuce');
//退出
Route::get('/logout', 'Home\IndexController@logout');

//文章分类
Route::get('/lists/{id}', 'Home\IndexController@lists');
//文章浏览量
Route::get('/view/{id}', 'Home\IndexController@view');
//文章收藏
Route::post('collect', 'Home\IndexController@collect');
Route::post('/lists/collect', 'Home\IndexController@collect');
//文章详情
Route::get('/detail/{id}', 'Home\DetailController@index');
//文章评论
Route::get('/comment', 'Home\DetailController@comment');
//留言
Route::get('/leacot', 'Home\LeacotsController@comment');
//获取访客ip
Route::get('userip', 'Home\IndexController@userip');



//后台登录
Route::get('/admin/login', 'Admin\LoginController@login');
//验证码
Route::get('/admin/code', 'Admin\LoginController@code');
//处理登录
Route::post('/admin/dologin', 'Admin\LoginController@doLogin');

Route::get('noaccess', 'Admin\LoginController@noaccess');

//后台退出
Route::get('/admin/logout', 'Admin\IndexController@logout');
Route::group(['prefix'=>'admin','namespace'=>'Admin','middleware'=>['isLogin','hasRole']],function (){
    //后台首页
    Route::get('index', 'IndexController@index');
    //后台首页主体部分
    Route::get('welcome', 'IndexController@welcome');
    //用户管理模块路由
    //删除所有用户
    Route::get('user/del', 'UserController@delAll');
    //禁用用户
    Route::get('user/stop/{id}', 'UserController@stop');
    //启用用户
    Route::get('user/open/{id}', 'UserController@open');
    //授予角色
    Route::get('user/auth/{id}','UserController@auth');
    Route::post('user/doauth','UserController@doAuth');
    Route::resource('user','UserController');

    //角色模块
    //角色授权
    Route::get('role/auth/{id}','RoleController@auth');
    Route::post('role/doauth','RoleController@doAuth');
    Route::resource('role','RoleController');

    //权限模块
    Route::resource('permission','PermissionController');

    //分类路由
    //修改排序
    Route::post('cate/changeorder','CateController@changeOrder');
    Route::resource('cate','CateController');

    //文章模块路由
    //禁用文章
    Route::get('article/stop/{id}', 'ArticleController@stop');
    //启用文章
    Route::get('article/open/{id}', 'ArticleController@open');
    //上传路由
    Route::post('article/upload','ArticleController@upload');
    Route::resource('article','ArticleController');

    //留言模块
    //个人留言
    Route::get('comment/person', 'CommentController@person');
    //禁用留言
    Route::get('comment/stop/{id}', 'CommentController@stop');
    //启用留言
    Route::get('comment/open/{id}', 'CommentController@open');
    Route::resource('comment', 'CommentController');
});

