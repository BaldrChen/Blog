<?php
namespace plugins\ceshi;

use plugin\Plugin;


class CeshiPlugin extends Plugin {
    public $info = [
        'name'        => 'Ceshi',//Demo插件英文名，改成你的插件英文就行了
        'description' => '插件演示',
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
        dump($this->getPluginPath());
    	echo 'Ceshi插件已执行</br>';
    	echo $this->fetch('index');
    }

}









?>