<?php

namespace app\common\model;
/**
 * QQ用户模型类
 */


class ChenQqUser extends Base
{
	//取的一条用户数据
	public function getUser( $id ){
		$user = $this->where('id',$id)->find();
		if (!$user) {
			return null;
		}
		
		return $user;
	}

}


?>