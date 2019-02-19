<?php

namespace app\common\validate;

class Comment extends \think\Validate{
	protected $rule = [
		'comment' => 'require|token',
		
	];

	protected $message = [
		'comment.require' => '评论不能为空',

	];




}