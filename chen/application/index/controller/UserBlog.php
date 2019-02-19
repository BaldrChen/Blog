<?php
namespace app\index\controller;

use app\common\model\ChenContent as C ;
use app\common\model\ChenComment as M ;
use app\common\model\ChenClassify as F;

/*
 *普通用户文章处理页
 *目前已废弃
 */

class UserBlog extends UserBase
{
    public function initialize(){
        
        parent::initialize();
        $this->content_status = config('project.content_status');
        $this->comment_status = config('project.comment_status');
        $this->examine_status = config('project.examine_status');
        $this->comment_result_status = config('project.comment_result_status');
        $f = new F;
        $tree = $f->tree();
        $this->assign('content_status',$this->content_status);
        $this->assign('comment_status',$this->comment_status);
        $this->assign('examine_status',$this->examine_status);
        $this->assign('comment_result_status',$this->comment_result_status);
        $this->assign('tree',$tree);
    }

    public function index( \think\Request $request )
    {
        $key = $this->request->get('key');


        //预加载用户数据
        $c = C::with('chenAdminUser,chenUser');

        //搜索条件
        if ( $key ) {
            $c = $c->where('title','like',"%{$key}%");

        }


        $cData = $c->my($this->user->id)->order('id','desc')->paginate(5);
        $data = ['cData' =>$cData, 'key'=>$key];
        return view(null,$data);
    }

    /*
     *文章添加
     */
    public function add( \think\Request $request )
    {
        return view();
    }

    /*
     *文章修改
     */
    public function modify( \think\Request $request )
    {
        $id = $this->request->get('id');

        $c = new C();

        $item = $c->my($this->user->id)->where('id',$id)->find();
        if (!$item) {
            return $this->error('数据不存在');
        }
        
        $data = [
            'typename' => '修改',
            'item' => $item,
        ];
        return view("user_blog/add",$data);
    }

    
    public function save( \think\Request $request )
    {
       $r = [
            'id' => $this->request->post('id'),
            'title' => $this->request->post('title'),
            'content' => $this->request->post('content'),
            'content_status' => (int)$this->request->post('content_status'),
            'chen_user_id' => $this->user->id,
            'chen_classify_id' =>$this->request->post('chen_classify_id'),
            '__token__' => $this->request->post('__token__'),
        ];



        //插入数据
        $c = new C();
        try {
            $c->storage( $r ,$this->user->id );
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
        
        return $this->redirect("index/userblog/index");
    }

    /*
     *文章状态管理
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
            $item = C::my($this->user->id)->where('id',$id)->find();
        }
        if ($differ == 'comment') {
            $item = M::my($this->user->id)->where('id',$id)->find();
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


    /*
     *文章删除
     */
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
            $res->remove($id , $this->user->id);
        } catch (\Exception $e) {
            return $this->error($e->getMessage() );
        }
        
        
        return $this->success('操作成功');
    }

    /*
     *文章附件上传
     */
    public function up(){
            $file = request()->file('file1');
            $info = $file->validate(['size'=>1024*2048,'ext'=>'jpg,jpeg,png,gif'])->rule('uniqid')->move('./uploads/user_editor');
            
            $result = [];

            if($info){
                $result["success"] = true;
                $result["file_path"]= url("uploads/user_editor/" . $info->getSaveName());
            }else{
                // 上传失败获取错误信息
                $result["success"] = false;
                $result["msg"]= $file->getError();
             }

             return json($result);

        }


    /*
     *文章评论管理
     */
    public function comment( \think\Request $request ){



        //预加载用户数据
        $m = M::with('chenAdminUser,chenUser,chenContent');



        
        $mData = $m->my($this->user->id)->order('id','desc')->paginate(5);

        $data = ['mData' =>$mData];
        return view(null,$data);
    }


}
