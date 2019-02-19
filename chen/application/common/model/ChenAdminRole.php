<?php

namespace app\common\model;
/**
 * 管理员角色模型类
 */


class ChenAdminRole extends Base
{
	public function chenAdminMenu()
    {
        return $this->belongsToMany('ChenAdminMenu','ChenAuthAccess','role_id','menu_id');
    }








}


?>