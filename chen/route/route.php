<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

//插件路由
Route::get('plugin/[:_plugin]/[:_controller]/[:_action]', "\\app\\common\\controller\\PluginEntry@index");

//前台路由

Route::get('/', 'index/index/index');


Route::get('/home/:id', 'index/Home/index')->pattern(['id' => '\d+']);
Route::get('/read/:id', 'index/index/read')->pattern(['id' => '\d+']);
Route::get('/class/:id', 'index/index/class')->pattern(['id' => '\d+']);
Route::post('comment', 'index/index/comment');

Route::group('plugin', function () {
    Route::get('plugin', 'index/plugin/index');
});

//前台登陆（废弃）
// Route::group('index', function () {
//     Route::group('sign', function (){
//         //注册
//         Route::post('up', 'index/sign/up_save');
//         Route::get('up', 'index/sign/up');
//         //登录
//         Route::get('in', 'index/sign/in');
//         Route::post('in', 'index/sign/in_check');

//         Route::get('logout', 'index/sign/logout');
//     });

// });

//个人中心（废弃）
// Route::group('index/u', function () {
//     Route::get('index', 'index/UserCenter/index');
//     Route::get('profile', 'index/UserCenter/profile');
//     Route::post('profile', 'index/UserCenter/profile_save');
//     //头像上传
//     Route::get('head', 'index/UserHead/index');
//     Route::post('head', 'index/UserHead/upload');


//     //文章管理
//     Route::get('blog/index', 'index/UserBlog/index');
//     Route::get('blog/class', 'index/UserBlog/class');   
//     //添加博客
//     Route::get('blog/add', 'index/UserBlog/add');
//     Route::get('blog/modify', 'index/UserBlog/modify');
//     Route::post('blog/save', 'index/UserBlog/save');
//     Route::post('blog/up', 'index/UserBlog/up');
//     Route::get('blog/status','index/UserBlog/status');
//     Route::get('blog/del','index/UserBlog/del');
//     //评论管理
//     Route::get('blog/comment', 'index/UserBlog/comment');
// });

//访问统计
Route::group('statistics',function(){
    Route::get('index', 'index/statistics/index');
});


//后台路由

Route::group('baldr_admin', function () {

    //后台首页
    Route::get('index', 'admin/index/index');
    Route::get('/', 'admin/login/index');

    //登录处理
    Route::group('login', function (){
        Route::post('check','admin/login/check');
        Route::get('logout','admin/login/logout');
        Route::get('/', 'admin/login/index');
    });

    //登录处理
    Route::group('setting', function (){        
        Route::get('index','admin/setting/index');
        Route::post('save','admin/setting/save');
    });

    //角色管理
    Route::group('rbac', function (){
        Route::get('index','admin/rbac/index');
        Route::get('add','admin/rbac/add');
        Route::post('save','admin/rbac/save');
        Route::get('modify','admin/rbac/modify');
        Route::get('delete','admin/rbac/delete');
        Route::get('auth','admin/rbac/auth');
        Route::post('auth_save','admin/rbac/auth_save');

    });

    //管理员页
    Route::group('auser', function (){
        Route::post('save','admin/auser/save');
        Route::get('index','admin/auser/index');
        Route::get('add','admin/auser/add');
        Route::get('modify','admin/auser/modify');
        Route::get('del','admin/auser/del');
    });

    //用户管理
    Route::group('user', function (){
        Route::post('save','admin/user/save');
        Route::get('index','admin/user/index');
        Route::get('add','admin/user/add');
        Route::get('modify','admin/user/modify');
        Route::get('head','admin/user/head');
        Route::post('head','admin/user/upload');
        Route::get('status','admin/user/status');
    });

    //QQ用户查看
    Route::group('quser', function (){
        Route::get('index','admin/quser/index');
    });

    //内容管理
    Route::group('content', function (){
        Route::post('save','admin/content/save');
        Route::post('up','admin/content/up');
        Route::get('index','admin/content/index');
        Route::get('add','admin/content/add');
        Route::get('modify','admin/content/modify');
        Route::get('status','admin/content/status');
        Route::get('del','admin/content/del');
        //评论管理
        Route::get('comment','admin/content/comment');

    });

    //分类管理
    Route::group('classify', function (){
        Route::get('classify','admin/classify/index');
        Route::post('add','admin/classify/add');
        Route::post('classify','admin/classify/save');
        Route::get('del','admin/classify/del');

    });

    //插件管理
    Route::group('plugins', function (){
        Route::get('index','admin/plugins/index');
        Route::get('install','admin/plugins/install');
        Route::get('delete','admin/plugins/delete');
        Route::get('toggle','admin/plugins/toggle');
    });

    Route::group('hooks', function (){
        Route::get('index','admin/hooks/index');
        Route::get('hookplugin','admin/hooks/hookplugin');
        Route::get('sync','admin/hooks/sync');
     });



});

//qq登录回调
Route::group('callback', function () {
    Route::get('login', 'callback/index/login');
    Route::get('/', 'callback/index/index');
    Route::get('logout', 'callback/index/logout');

});


return [

];
