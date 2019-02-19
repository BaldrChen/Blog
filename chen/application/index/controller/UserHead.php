<?php
namespace app\index\controller;
use app\common\model\ChenUser as U;

/*
 *普通用户头像管理
 *目前已废弃
 */

class UserHead extends UserBase
{
	function index(){


		return view();
	}



	function upload(\think\Request $request ){

		// 获取表单上传文件 
	    $file = request()->file('image');


	    if (!$file) {
	    	$this->error('未上传文件');
	    }

		$u = new U;

		//上传图片
		try {
		    $name = $u->upload($file);
		} catch (\Exception $e) {
		    
		    return $this->error($e->getMessage());
		}

		
		//处理图片
		$newImg = $u->image($name);
		//新图片路径
		$position = '/static/head_portrait/' . $newImg ;

		$r = [
			'id' => $this->user->id,
			'images' => $position,
			'__token__' => $this->request->post('__token__'),
			'passwd' => null,
		];
		

		//取出头像数据
		$oldImg = $this->user['images'];
		//如果原来有头像数据则删除原头像文件
		if ($oldImg) {
			unlink('../public/'. $oldImg);
		}

		//将地址写入数据库
		try {
			$u->storage($r, 'head');
		} catch (\Exception $e) {
			return $this->error($e->getMessage());
		}


		//删除原上传文件
		unlink('../public/uploads/head_img/'.$name);
		
		$this->success('修改成功');

	}	





}
