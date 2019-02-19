<?php
namespace app\admin\controller;

use app\common\model\ChenRole as R;
use app\common\model\ChenAdminMenu as AM;
use app\common\model\ChenAuthAccess as AA;

/*
 *权限管理控制器
 */

class Rbac extends Base
{
	public function initialize(){
		parent::initialize();
		$this->role_status = config('project.role_status');
		$this->assign('role_status',$this->role_status);
	}

    public function index()
    {
    	$r = new R;
    	$role = $r->order('id','asc')->select();
    	$this->assign('role',$role);
        return view();
    }

   public function save(){
   		$res = [
			'name' => $this->request->param('name'),
			'remark' => $this->request->param('remark'),
			'status' => $this->request->param('role_status'),
			'id' => $this->request->param('id')
   		];
    	$r = new R;
    	try{
		    $r->storage($res);
		}catch(\Exception $e){
		   return $this->error($e->getMessage());
		}
    	
    	return $this->redirect("admin/rbac/index");
    }

    public function add(){
    	$this->assign('typename','添加');
    	return view();
    }

    public function modify(){
    	$id = $this->request->param('id');
    	if ($id == 1) {
            $this->error("超级管理员角色不能被修改！");
        }
    	$r = new R;
    	$item = $r->where('id',$id)->find();
    	if (!$item) {
			return $this->error('数据不存在');
		}
        
    	$data = [
    		'item' => $item,
    		'typename' => '修改',
    	];

    	return view("add",$data);
    }

    public function delete(){
    	$id = $this->request->param('id');
    	$r = new R;
    	try {
    		$r->remove($id);
    	} catch (Exception $e) {
    		return $this->error($e->getMessage());
    	}

		return $this->redirect("admin/rbac/index");
    }

    public function auth(){
        $id = $this->request->param('id');
        if ($id == '1') {
            $this->error('该管理员已获得最高权限');
        }
        $am = new AM;
        $aa = new AA;

        $tree =  $am->order('id','asc')->select()->toArray();
        $auth_tree =$am->getTree($tree);

        $menu_id = $aa->where('role_id',$id)->field("menu_id")->select()->toArray();
        

        $this->assign('id',$id);
        $this->assign("menu_id",json_encode($menu_id));
        $this->assign("auth_tree",json_encode($auth_tree));

        return view();
    }


    public function auth_save(){
        $id = $this->request->param('id');
        $menu_id = $this->request->param('menu_id');
        if (!$id) {
            $this->error("需要授权的角色不存在！");
        }
        $am = new AM;
        $aa = new AA;
        if (is_array($menu_id) && count($menu_id) > 0) {
            $aa->where("role_id",$id)->delete();
            foreach ($menu_id as $mid) {
                $res = $am->where('id',$mid)->field("id,app,controller,action")->find();
                if ($res) {
                    $me_id = $res['id'];
                    $app    = $res['app'];
                    $model  = $res['controller'];
                    $action = $res['action'];
                    $name   = strtolower("$app/$model/$action");

                    $aa->insert(['role_id'=>$id,'rule_name'=>$name,'menu_id'=>$me_id]);
                }
             }
             $this->success("授权成功！");
        }else{
            $aa->where(["role_id" => $id])->delete();
            $this->error('未接收到数据，清空所有权限');
        }

        
        
    }






}
