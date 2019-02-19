<?php
namespace app\index\controller;

use app\common\model\ChenUser as u ;
/*
 *用户登陆页
 *目前已废弃
 */


class Sign extends Base
{
	public function initialize(){
			parent::initialize();
			$this->assign('tplType','one');
		}

    public function index( \think\Request $request )
    {
        return view();
    }

    public function in( \think\Request $request )
    {
        return view();
    }
    public function in_check( \think\Request $request )
    {
        $r['username'] = $this->request->post('username');
    	$r['passwd'] = $this->request->post('passwd');
    	$r['__token__'] = $this->request->post('__token__');
    	$validate = new \app\common\validate\User();
    	
        
    	if (!$validate->scene('login')->check($r)) {
    		return $this->error($validate->getError());
    	}
    	$u = new u;
    	
    	$user = $u->where('username',$r['username'])->find();
        //var_dump($r);exit;
    	if (!$user) {
    		return $this->error('用户名不存在');
    	}
    	if (password_verify($r['passwd'],$user->passwd) !== true ) {
    		return $this->error('密码错误');
    	}
    	if ($user->user_status <> 1) {
    		return $this->error('该用户已被禁止登录');
    	}

    	\think\facade\Session::set('user_id',$user->id);

    	return $this->redirect('index/u/index');
    }

    public function up( \think\Request $request )
    {
        return view();
    }

    public function up_save( \think\Request $request )
    {
        $r = [
			'id' =>0,
			'username' => $this->request->post('username'),
			'passwd' => $this->request->post('passwd'),
			'nick' => $this->request->post('nick'),
			'phone' => $this->request->post('phone'),
			'email' => $this->request->post('email'),
			'user_status' => setting('reg_status'),
			'__token__' => $this->request->post('__token__'),
		];

		//如果为添加模式  则追加用户名数据
		if ($r['id'] < 1) {
			$r['username'] = $this->request->post('username');
		}

		//插入数据
		$u = new U();
		try {
			$u->storage( $r );
		} catch (\Exception $e) {
			return $this->error($e->getMessage());
		}
		
		return $this->redirect("index/sign/in");
   	}


   	public function logout(){

   		\think\facade\Session::delete('user_id');
   		return $this->redirect("index/sign/in");
   	}

}
