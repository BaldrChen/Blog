<?php

namespace app\common\model;
/**
 * 角色模型类
 */
use \app\common\validate\Role;

class ChenRole extends Base
{






	public function storage($res){
		
		$validate = new \app\common\validate\Role;
        if (!$validate->check($res)) {
           return exception($validate->getError(),20001);
        }

        $role = $this;
        if ($res['id']) {
        	$role = $this->where('id',$res['id'])->find();
        }
        
        $role->allowField(true)->save($res);



	}

	public function remove($id){
		$role = $this->where('id',$id)->find();
		if(!$role){
			return exception('数据不存在',20002);
		}
		$role->delete();
	}


	public function chenAdminMenu()
    {
        return $this->belongsToMany('ChenAdminMenu','ChenAuthAccess','menu_id','role_id');
    }



   public function getMenuTree($arr,$pid= 0, $level= '0' ){
        static $menu_tree = array();

        foreach ($arr as $k => $v) {

           if ($v['pid'] == $pid) {
                $menu_tree[$v['id']] = $v;
                $menu_tree[$v['id']]['level'] = $level;
                if ($level < 1) {
                	$this->getMenuTree($arr,$v['id'],$level+1);
                }
                
                
           }

        }
        return $menu_tree;
    }








}


?>