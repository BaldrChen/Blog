<?php
namespace plugins\demo;

use plugin\Plugin;


class DemoPlugin extends Plugin {
    public $info = [
        'name'        => 'Demo',//Demo插件英文名，改成你的插件英文就行了
        'description' => 'DEMO插件测试',
        'status'      => 1,
        'author'      => 'baldr',
        'version'     => '1.0',
    ];


	public function install(){
		return true;
	}


	public function uninstall(){
		return true;
	}
	
	public function chen($param)
    {
    	echo 'Demo插件已执行</br>';
    	
    }

}









?>