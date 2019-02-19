<?php

namespace app\common\model;

/**
 * 管理员用户模型类
 */

class ChenAdminUser extends Base
{



	/**
	 * 用户的添加修改
	 * 
	 * 
	 */
	public function storage( $r ){
		//数据格式验证
		$validate = new \app\common\validate\AdminLogin();

		$scene = $r['id'] ? 'modify' : 'add';
		if (!$validate->scene($scene)->check($r)) {

			return exception($validate->getError(),10002);
		}

		
		$au = $this;

		//如果未修改模式，则获取目标数据对象
		if ($r['id']) {
			$au = $this->where('id',$r['id'])->find();

		}
		//如果没有输入新密码。则禁止数据库更新该字段
		if ($r['passwd']) {
			$r['passwd'] = password_hash($r['passwd'],PASSWORD_DEFAULT);
		}else{
			unset($r['passwd']);
		}
		$au->allowField(true)->save($r);

		if (is_array($r['role_id'])) {
			$aid = $au->id;
			$ar = new \app\common\model\ChenAdminRole();
			$ar->where('admin_user_id',$aid)->delete();
			foreach ($r['role_id'] as $rid) {
				$list = [
				'admin_user_id'=>$aid,
				'role_id'=>$rid,
				];
				$ar->insert($list);
			}
		}else{
			return exception('无效的角色信息',20003);
		}

		
		
	}

	public function remove( $id ){
		$au = $this;
		$item = $au->where('id',$id)->find();
		if (!$item) {
			return exception('数据不存在',10004);
		}
		$item->delete();

	}

    public function chenUser()
    {
        return $this->belongsTo('ChenUser');
    }



}