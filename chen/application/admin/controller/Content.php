<?php 

namespace app\admin\controller;

use app\common\model\ChenContent as C;
use app\common\model\ChenComment as M;
use app\common\model\ChenClassify as F;

/*
 *文章管理控制器
 */

class Content extends Base
{

	public function initialize(){
        parent::initialize();
        $this->content_status = config('project.content_status');
        $this->comment_status = config('project.comment_status');
        $this->examine_status = config('project.examine_status');
        $f = new F;
    	$tree = $f->tree();
        $this->comment_result_status = config('project.comment_result_status');
        $this->assign('content_status',$this->content_status);
        $this->assign('comment_status',$this->comment_status);
        $this->assign('examine_status',$this->examine_status);
        $this->assign('comment_result_status',$this->comment_result_status);
        $this->assign('tree',$tree);
	}


	public function index(){
		$key = $this->request->get('key');


		//预加载用户数据
		$c = C::with('chenAdminUser,chenQqUser');

		//搜索条件
		if ( $key ) {
			$c = $c->where('title','like',"%{$key}%");

		}


		$cData = $c->order('id','desc')->paginate(10);
		$data = ['cData' =>$cData, 'ckey'=>$key];
		return view(null,$data);
	}	

	/*
	 *文章添加
	 */
	public function add(){
		$data = [
			'typename' => '添加'
		];

		return view(null,$data);
	}	


	public function save(){
		$r = [
			'id' => $this->request->post('id'),
			'title' => $this->request->post('title'),
			'content' => $this->request->post('content'),
			'content_status' => (int)$this->request->post('content_status'),
			'chen_admin_user_id' => $this->user->id,
			'chen_classify_id' => (int)$this->request->post('chen_classify_id'),
			'__token__' => $this->request->post('__token__'),
		];


		//插入数据
		$c = new C();
		try {
			$c->storage( $r );
		} catch (\Exception $e) {
			return $this->error($e->getMessage());
		}
		
		return $this->redirect("admin/content/index");
	}

	/*
	 *文章修改
	 */
	public function modify(){
		$id = $this->request->get('id');

		$c = new C();

		$item = $c->where('id',$id)->find();
		if (!$item) {
			return $this->error('数据不存在');
		}

		$data = [
			'typename' => '修改',
			'item' => $item,
		];
		return view("content/add",$data);
	}	

	/*
	 *文章状态
	 */
	public function status(){
		$status = (int)$this->request->get('status');
        $id = (int)$this->request->get('id');
        $type = $this->request->get('type');
        $differ = $this->request->get('differ');
        if ($id <1 ) {
            return $this->error('数据无效');
        }

        $new_status = $status == 1 ? 0 : 1;


        //判断是由博客管理传入还是由评论管理传入
        if ($differ == 'content') {
            $item = C::where('id',$id)->find();
        }
        if ($differ == 'comment') {
            $item = M::where('id',$id)->find();
        }


        if ( !$item ) {
            return $this->error('数据无效');
        }

        //根据传回来的值类型来决定修改文章状态还是评论状态
        if ($type == 'content') {
            $item ->save([
                'content_status' => $new_status
            ]);
        }

        if ($type == 'comment') {
            $item ->save([
                'comment_status' => $new_status
            ]);
        }

        if ($type == 'examine') {
            $item ->save([
                'examine_status' => $new_status
            ]);
        }

        if ($type == 'comment_result') {
            $item ->save([
                'comment_result_status' => $new_status
            ]);
        }
        return $this->success("操作成功");
	}

	public function del(){
		$id = $this->request->get('id');
        $differ = $this->request->get('differ');

        //判断是由博客管理传入还是由评论管理传入
        if ($differ == "content") {
            $res = new C();
        }
        
        if ($differ == "comment") {
           $res = new M();
        }

		try {
			$res->remove($id);
		} catch (\Exception $e) {
			return $this->error($e->getMessage() );
		}
		
		
		return $this->success('操作成功');
	}
	/*
	 *文章附件上传
	 *只允许图片上传
	 */
	public function up(){
		$file = request()->file('file1');

		$info = $file->validate(['size'=>1024*2048,'ext'=>'jpg,jpeg,png,gif'])->rule('uniqid')->move('./uploads/editor');

		$result = [];

		if($info){
			$result["success"] = true;
			$result["file_path"]= url("uploads/editor/" . $info->getSaveName());
    	}else{
	        // 上传失败获取错误信息
			$result["success"] = false;
			$result["msg"]= $file->getError();
   		 }

   		 return json($result);

	}
	
	/*
	 *文章评论
	 */
	public function comment(){


        //预加载用户数据
        $m = M::with('chenContent,chenQqUser');

        
        $mData = $m->order('id','desc')->paginate(10);

        
        $data = ['mData' =>$mData];
        return view(null,$data);
	}



}











