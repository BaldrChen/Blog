<?php

namespace app\common\model;
/**
 * 后台菜单模型类
 */


class ChenAdminMenu extends Base
{



   public function getTree($arr,$pid= 0, $level= '0' ){
        static $menu_tree = array();

        foreach ($arr as $k => $v) {

           if ($v['pid'] == $pid) {
                $menu_tree[$v['id']] = $v;
                $menu_tree[$v['id']]['level'] = $level;
                $this->getTree($arr,$v['id'],$level+1);
                
           }
        }
        return $menu_tree;
    }

}


?>