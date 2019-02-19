<?php

namespace app\common\controller;

use think\Container;
use think\Loader;

/*
 *插件MVC实现
 */

class PluginEntry extends \think\Controller
{
	public function index($_plugin,$_controller,$_action)
	{
		$_controller = loader::parseName($_controller,1);
		$pluginControllerClass = "plugins\\{$_plugin}\\controller\\{$_controller}";
		$vars = [];
		$Container = new \think\Container;
		return $Container->invokeMethod([$pluginControllerClass,$_action,$vars]);
	}
}














?>