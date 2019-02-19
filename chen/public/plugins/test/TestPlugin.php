<?php
namespace plugins\test;

use plugin\Plugin;


class TestPlugin extends Plugin {
    public $info = [
        'name'        => 'Test',//Demo插件英文名，改成你的插件英文就行了
        'description' => '插件测试',
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
    	echo 'Test插件已执行</br>';
    	echo $this->fetch('index');
    }

}









?>