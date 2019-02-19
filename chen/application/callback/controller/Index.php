<?php
namespace app\callback\controller;
use qqlogin\QC as qc;
use app\common\model\ChenQqUser as qu;

/*
 *qq登陆
 */

class Index extends \think\Controller
{
    public function login()
    {

    	//记录登录前的页面
    	session('beforeurl',input('server.HTTP_REFERER'));
        //实例化qqsdk
        $qq = new qc();
        $url = $qq->qq_login();
        $this->redirect($url);
    }

    public function index()
    {

        $qq = new qc();
        $qq->qq_callback();
        $qq->get_openid();
        $qq = new qc();
        $res = $qq->get_user_info();

        $beforeurl = session('beforeurl');
        $openid = session('openid');
        $data = [
        	'nick' => $res['nickname'],
        	'images' => $res['figureurl_qq_1'],
        	'openid' => $openid,
        ];
        $qu = new qu;

        $result = $qu->where('openid',$openid)->select()->toArray();
        if (!empty($result)) {
        	session('quser_id',$result[0]['id']);
        	$this->redirect($beforeurl);
        }

        $qu->save($data);
        session('quser_id',$qu->id);
        $this->redirect($beforeurl);

    }

    public function logout(){

   		\think\facade\Session::delete('quser_id');
   		return $this->redirect("index/index/index");
   	}
}
