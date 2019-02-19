<?php

namespace app\common\validate;

class Classify extends \think\Validate{
	protected $rule = [
		'name' => 'require|token',
		
	];

	protected $message = [
		'name.require' => '栏目不能为空',

	];




}