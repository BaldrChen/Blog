<?php 
namespace app\admin\controller;

use app\common\model\ChenUser as U ;

/*
 *普通用户管理控制器
 *目前已关闭，直接使用QQ用户
 */

class User extends Base 
{
	public function initialize(){
		parent::initialize();
		$this->user_status = config('project.user_status');
		$this->assign('user_status',$this->user_status);
	}

	public function index()
	{
		$key = $this->request->get('key');

		$u = new U();

		//搜索条件
		if ( $key ) {
			$u = $u->where('username','like',"%{$key}%");
			//用户或昵称出现关键字$key都将结果查询出来
			$u = $u->whereOr('nick','like',"%{$key}%");
			$u = $u->whereOr('phone',$key);
			$u = $u->whereOr('email',$key);
		}


		$uData = $u->order('id','desc')->paginate(5);
		
		$data = ['uData' =>$uData, 'ukey'=>$key];
		return view(null,$data);

	}	

	//添加用户
	public function add()
	{	
		$data = [
			'typename' => '添加'
		];
		return view(null,$data);
	}	

	//保存用户信息
	public function save()
	{
		$r = [
			'id' => $this->request->post('id'),
			'passwd' => $this->request->post('passwd'),
			'nick' => $this->request->post('nick'),
			'phone' => $this->request->post('phone'),
			'email' => $this->request->post('email'),
			'user_status' => $this->request->post('user_status'),
			'__token__' => $this->request->post('__token__'),
		];

		//如果为添加模式  则追加用户名数据
		if ($r['id'] < 1) {
			$r['username'] = $this->request->post('username');
		}

		//插入数据
		$u = new U();
		try {
			$u->storage( $r );
		} catch (\Exception $e) {
			return $this->error($e->getMessage());
		}
		
		return $this->redirect("admin/user/index");
		
	}


	//修改用户
	public function modify()
	{
		$id = $this->request->get('id');

		$u = new U();

		$item = $u->where('id',$id)->find();
		if (!$item) {
			return $this->error('数据不存在');
		}
		
		$data = [
			'typename' => '修改',
			'disabled' => 'disabled',
			'item' => $item,
		];
		return view("user/add",$data);
	}	


	//修改头像页面
	public function head()
	{	
		$id = $this->request->get('id');

		$u = new U();

		$item = $u->where('id',$id)->find();
		if (!$item) {
			return $this->error('数据不存在');
		}

		$data = [
			'item' => $item,
		];

		return view(null,$data);
	}
	

	public function upload()
	{	

		// 获取表单上传文件 
	    $file = request()->file('image');

	    if (!$file) {
	    	$this->error('未上传文件');
	    }



		$u = new U;


		$id = $this->request->post('id');
		$item = $u->where('id',$id)->find();

		//上传图片
		try {
		    $name = $u->upload($file);
		} catch (\Exception $e) {
		    
		    return $this->error($e->getMessage());
		}

		
		//处理图片
		$newImg = $u->image($name);
		//新图片路径
		$position = '/static/head_portrait/' . $newImg ;



		$r = [
			'id' => $id,
			'images' => $position,
			'passwd' => null,
		];
		

		//取出头像数据
		$oldImg = $item['images'];
		//如果原来有头像数据则删除原头像文件
		if ($oldImg) {
			unlink('../public/'. $oldImg);
		}

		//将地址写入数据库
		try {
			$u->storage($r, 'head');
		} catch (\Exception $e) {
			return $this->error($e->getMessage());
		}


		//删除原上传文件
		unlink('../public/uploads/head_img/'.$name);
		
		$this->success('修改成功');

	}	



	//管理用户状态
	public function status()
	{
		$status = (int)$this->request->get('status');
		$id = (int)$this->request->get('id');
		if ($id <1 ) {
			return $this->error('数据无效');
		}
		$new_status = $status == 1 ? 0 : 1;
		$item = U::where('id',$id)->find();
		if ( !$item ) {
			return $this->error('数据无效');
		}

		$item ->save([
				'user_status' => $new_status
			]);


		return $this->success("操作成功");

		
	}
}