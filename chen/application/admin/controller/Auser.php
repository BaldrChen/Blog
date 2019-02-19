<?php 
namespace app\admin\controller;

use app\common\model\ChenAdminUser as AU;
use app\common\model\ChenAdminRole as AR;
use app\common\model\ChenAdminMenu as AM;
use app\common\model\ChenRole as R;
use think\facade\Hook;
use think\facade\Env;
/*
 *管理员用户控制器
 *
 */

class Auser extends Base 
{


	/**
	 * 管理员列表页
	 *
	 */
	public function index()
	{
		//实例化模型并取得管理员用户数据
		$param = "test1";
		$au = new AU();
		$auData = $au->order('id','asc')->select();
		Hook::listen('chen',$param);


		$data = ['auData' =>$auData];
		return view(null,$data);
	}



	/**
	 * 管理员添加与修改
	 * 
	 */
	public function save()
	{
		//将从表单获取的数据写入数组r
		$r = [
			'username' => $this->request->post('username'),
			'passwd' => $this->request->post('passwd'),
			'__token__' => $this->request->post('__token__'),
			'id' => $this->request->post('id'),
			'role_id' => $this->request->post('role'),
		];
		//插入数据
		$au = new AU();
		
		//手动捕获异常
		try {
			$au->storage( $r );
		} catch (\Exception $e) {
			return $this->error($e->getMessage());
		}
		
		return $this->redirect("admin/auser/index");
	}


	/**
	 * 管理员添加页
	 */
	public function add()
	{

		$data = ['typename' => '添加'];
		return view(null,$data);
	}


	/**
	 * 管理员修改页
	 * 
	 */
	public function modify()
	{
		$id = $this->request->get('id');

		$au = new AU();
		//取得管理员数据
		$item = $au->where('id',$id)->find();
		$ar = new AR();
		$role_id = $ar->where('admin_user_id',$id)->select()->toArray();

		if (!$item) {
			return $this->error('数据不存在');
		}
		$this->assign('role_id',json_encode($role_id));
		$data = [
			'typename' => '修改',
			'item' => $item,
		];
		return view("add",$data);
	}

	/**
	 * 管理员删除页
	 * 
	 */
	public function del()
	{
		$id = $this->request->get('id');

		$au = new AU();

		try {
			$au->remove($id);
		} catch (\Exception $e) {
			return $this->error($e->getMessage() );
		}
		
		return $this->redirect('admin/auser/index');
	}






}
