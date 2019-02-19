<?php

namespace app\common\validate;

class AdminLogin extends \think\Validate{
	protected $rule = [
		'username' => 'require|token',
		'passwd' => 'require|min:1',
		
	];

	protected $message = [
		'username.require' => '用户名不能为空',
		'username.checkUser' => '用户名已存在',
		'passwd.require' => '密码不能为空',
	];

	protected $scene = [
		'add' => ['username','passwd'],
	];

	public function sceneAdd(){
		return $this->append('username','checkUser');
	}
	public function sceneModify(){
		return $this->remove('passwd','require')->append('username','checkUser');
	}

	protected function checkUser($str,$rule,$r){
		$adminuser = new \app\common\model\ChenAdminUser();
		$row = $adminuser
		->where('username',$str)
		->where('id','<>',$r['id'] )
		->find();
		if ($row) {
			return false;
		}
		return true;
	}


}