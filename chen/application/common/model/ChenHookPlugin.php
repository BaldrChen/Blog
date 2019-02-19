<?php

namespace app\common\model;
/**
 *插件钩子模型类
 */


class ChenHookPlugin extends Base
{
	public function pluginInfo(){
		return $this->hasOne('ChenPlugin','name','plugin');
	}

}


?>