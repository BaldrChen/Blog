<?php

namespace app\common;
 class Setting {

 	protected $data = false;

 	/**
 	 *只从数据库中取配置，取一次，不会重复执行
 	 * 
 	 */


 	public function get($key){
 		//如果data为false，则表示未取过数据  执行查询
 		if ($this->data === false) {
 			//从缓存中取数据
 			$list = \think\facade\Cache::get('setting');

 			//如果缓存中没数据  则执行查询
 			if ($list === false) {
	 			$setting = new \app\common\model\ChenSetting();
			 	$list=[];
			 	$setting->select()->each(function($item,$k) use (&$list){
			 		$list[$item->key] = $item;
	 			});

			 	//将查询结果写入缓存
			 	\think\facade\Cache::set('setting',$list);
		 	}

		 	//将数据赋值给类属性
		 	$this->data = $list;
		
		 	
 		}
	 	
	 	return isset($this->data[$key]) ? $this->data[$key]->value : null;
 	}

 }