<?php
namespace app\index\controller;
use app\common\model\ChenUser as U;
/*
 *用户基础控制器
 *所有后台控制器 都应该作为它的子类存在
 *目前已废弃
 */

class UserBase extends Base
{
	function initialize(){
		parent::initialize();
		if ( !$this->user ) {
    		return $this->error('请先登录','index/sign/in');
    	}

    	if ( ( $msg = $this->user->isStatus()) !== true ) {
    		return $this->error($msg,'index/sign/in');
    	}

	}	
}
