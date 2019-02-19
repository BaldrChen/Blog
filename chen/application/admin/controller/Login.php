<?php
namespace app\admin\controller;

/*
 *登陆控制器
 */

class Login extends \think\Controller
{
    public function index()
    {
        return view();
    }

    /*
     *退出
     */
    public function logout(){
    	\think\facade\Session::delete('admin_id');
    	return $this->redirect('admin/login/index');
    }

    public function check()
    {
    	$r['username'] = $this->request->post('username');
    	$r['passwd'] = $this->request->post('passwd');
    	$r['__token__'] = $this->request->post('__token__');
    	$validate = new \app\common\validate\AdminLogin();
    	
        
    	if (!$validate->check($r)) {
    		return $this->error($validate->getError());
    	}
    	$adminuser = new \app\common\model\ChenAdminUser;
    	
    	$user = $adminuser->where('username',$r['username'])->find();
    	if (!$user) {
    		return $this->error('用户名不存在');
    	}
    	if (password_verify($r['passwd'],$user->passwd) !== true ) {
    		return $this->error('密码错误');
    	}

    	\think\facade\Session::set('admin_id',$user->id);

    	return $this->redirect('admin/index/index');
    }
}
