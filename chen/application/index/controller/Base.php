<?php
namespace app\index\controller;
use app\common\model\ChenUser as U;
use app\common\model\ChenQqUser as QU;
use app\common\model\ChenContent as C;
use app\common\model\ChenClassify as F;
/*
 *前台基础控制器
 *所有后台控制器 都应该作为它的子类存在
 */

class Base extends \think\Controller
{
	function initialize(){

        $this->assign('webname',setting('webname'));
        $this->assign('tplType','two');


        //取出用户信息
        //$u = new U();
        $qu = new QU();
        //$user_id =  (int)\think\facade\Session::get('user_id');
        $quser_id =  (int)\think\facade\Session::get('quser_id');
        //$this->user = $u -> getUser( $user_id );
        $this->quser = $qu -> getUser( $quser_id );
        //$this->assign('user',$this->user);
        $this->assign('quser',$this->quser);
        //取出用户头像信息
        //$img_res = $this->user ['images'];
        $qimg_res = $this->quser ['images'];
        //如果不存在头像则使用默认头像
        // if ($img_res) {
        //         $img = $img_res;
        // }else{
        //        $img = "/static/head_portrait/default.png";
        // }
        // $this->assign('img',$img);
        $this->assign('qimg',$qimg_res);
        
        //取出分类
        $f = new F;
        $classify = $f->tree();
        $this->assign('classify',$classify);
        
        //取出最新的5个用户
        $newUsers = U::where('user_status',1)->order('id','desc')->limit(5)->select();
        $this->assign('newUsers',$newUsers);

        //取出点击数最多的5条文章
        $newBlogs = C::where('content_status',1)->order('hits','desc')->limit(5)->select();
        $this->assign('newBlogs',$newBlogs);




	}	
}
