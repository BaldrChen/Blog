<?php
namespace app\admin\controller;

/*
 *后台基础控制器
 *所有后台控制器 都应该作为它的子类存在
 */

class Base extends \think\Controller
{

	function initialize(){

		$id = \think\facade\Session::get('admin_id');
    	if (!$id) {
    		return $this->error('请先登录',url('admin/login/index'));
    	}
    	$user = new \app\common\model\ChenAdminUser();
        $r = new \app\common\model\ChenRole();
        $role = $r->select();
    	$user = $user->where('id',$id)->find();
    	if (!$user) {
    		return $this->error('请先登录',url('admin/login/index'));
    	}
        //访问权限检查
        $auth = $this->checkAccess($id);
        if (!$auth) {
            return $this->error('您没有访问权限',url('admin/index/index'));
        }
        $menu = $this->getMenu($id);
        if (!$menu) {
            return $this->error('您没有后台访问权限',url('admin/login/index'));
        }
        $this->assign('menu',$menu);
        //赋值类属性，方便子控制器调用
        $this->user = $user;

    	$this->assign('user',$user);
        $this->assign('role',$role);
        //插件状态对应信息
        $this->plugin_status = config('project.plugin_status');
        $this->assign('plugin_status',$this->plugin_status);
        //钩子类型信息
        $this->hook_type = config('project.hook_type');
        $this->assign('hook_type',$this->hook_type);

        $this->assign('webname',setting('webname'));
        

	}



    /**
     *  检查后台用户访问权限
     * @param int $userId 后台用户id
     * @return boolean 检查通过返回true
     */
    private function checkAccess($userId)
    {
        // 如果用户id是1，则无需判断
        if ($userId == 1) {
            return true;
        }

        $module     = $this->request->module();
        $controller = $this->request->controller();
        $action     = $this->request->action();
        $rule       = $module . $controller . $action;
        $name       = strtolower($module . "/" . $controller . "/" . $action);
        $authObj = new \app\common\lib\auth\Auth();

        $notRequire = ["adminIndexindex"];
        if (!in_array($rule, $notRequire)) {
            return $authObj->check($userId, $name);
        } else {
            return true;
        }
    }



    /**
     *  获取后台菜单
     * @param int $userId 后台用户id
     * @return boolean 检查通过返回true
     */
    private function getMenu($userId)
    {
        // 如果用户id是1，则无需判断
        // if ($userId == 1) {
        //     return true;
        // }


        $r = new \app\common\model\ChenRole();
        $ar = new \app\common\model\ChenAdminRole();
        $am = new \app\common\model\ChenAdminMenu();


        


        if ($userId == '1') {
            $menu = $am->select()->toArray();
            foreach ($menu as  $value) {
                $app = $value['app'];
                $controller = $value['controller'];
                $action = $value['action'];
                $murl = $app . '/' . $controller . '/' . $action ;
                $menu_info[$value['id']] = $value;
                $menu_info[$value['id']]['rule_name'] = $murl;
            }
        }else{
            $menu_info = $ar->where('admin_user_id',$userId)
            ->alias('a')
            ->join('chen_auth_access b','a.role_id = b.role_id')
            ->join('chen_admin_menu c','b.menu_id = c.id')
            ->select()->toArray();
        }

        

        foreach ($menu_info as $n) {
            $m[$n['id']]["id"] = $n["id"];
            $m[$n['id']]["pid"] = $n["pid"];
            $m[$n['id']]["type"] = $n["type"];
            $m[$n['id']]["status"] = $n["status"];
            $m[$n['id']]["action"] = $n["action"];
            $m[$n['id']]["name"] = $n["name"];
            $m[$n['id']]["url"] = $n["rule_name"];

        }
        
        $tree = $r->getMenuTree($m);

        return $tree;

    }

}
