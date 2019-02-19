<?php

namespace app\common\validate;

class Content extends \think\Validate{
	protected $rule = [
		'title' => 'require',
		'content' => 'require',
		'content_status' => 'require|integer',
		'chen_classify_id' => 'require|integer',
	];

	protected $message = [
		'title.require' => '标题不能为空',
		'content.require' => '内容不能为空',
		'content_status.require' => '状态不能为空',
		'content_status.integer' => '非法的文章状态',
		'chen_classify_id.require' => '必须选择一个分类',
		'chen_classify_id.integer' => '非法分类',
	];

	protected $scene = [
		'add' => ['username','passwd'],
	];

	public function sceneAdd(){
		
	}
	public function sceneModify(){
		
	}




}