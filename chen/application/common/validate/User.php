<?php

namespace app\common\validate;

class User extends \think\Validate{
	protected $rule = [
		'passwd' => 'require|min:1',
		'nick' => 'require',
		'phone' => 'require|mobile',
		'email' => 'require|email',
		'user_status' => 'require|integer',
	];

	protected $message = [
		'username.require' => '用户名不能为空',
		'username.checkUser' => '用户名已存在',
		'passwd.require' => '密码不能为空',
		'nick.require' => '昵称不能为空',
		'phone.require' => '手机不能为空',
		'phone.mobile' => '请输入正确的手机号',
		'email.require' => '邮箱不能为空',
		'email.email' => '请输入正确的邮箱',
		'user_status.require' => '状态不能为空',
		'user_status.integer' => '非法的用户状态',
		'images.require' => '头像上传失败',
	];

	protected $scene = [
		'add' => ['username','passwd'],
	];

	public function sceneLogin(){
		return $this->append('username','require')->only(['username','passwd']);
	}



	public function sceneAdd(){
		return $this->append('username','require|checkUser');
	}
	public function sceneModify(){
		return $this->remove('passwd','require');
	}

	public function sceneProfile(){
		return $this->remove('passwd','require')
					->remove('user_status','require');
	}

	public function sceneHead(){
		return $this->append('images','require')
					->only(['images','__token__']);
	}

	protected function checkUser($str,$rule,$r){
		$user = new \app\common\model\ChenUser();
		$row = $user
		->where('username',$str)
		->where('id','<>',$r['id'] )
		->find();
		if ($row) {
			return false;
		}
		return true;
	}


}