<?php
namespace app\index\controller;

use app\common\model\ChenContent as C;
use app\common\model\ChenComment as M;
use app\common\model\ChenClassify as F;
use app\common\model\ChenIp as I;

/*
 *前台首页
 */

class Index extends Base
{
    public function index( \think\Request $request )
    {
        $ip = $this->getIp();
        $i = new I;
        $i->ipHandle($ip);
        //user模型关联预载入
        $c = C::with('chen_qq_user');

    	$newData = $c->where('content_status',1)
			    	->order('id','desc')
			    	->paginate(10);
        
		$data = ['newData' => $newData,
                 'tplType' => 'index', ];


        return view(null,$data);
    }

    /*
     *文章阅读页
     */
    public function read( \think\Request $request , $id){
        //取出博客内容信息
    	$blogitem = C::where('id',$id)->where('content_status',1)->find();   

    	if (!$blogitem) {
    		return $this->error('数据不存在');
    	}
        
        //取出评论信息
        $comitem = M::with('chen_qq_user')->where('chen_content_id',$id)->where('comment_result_status',1)->order('id','desc')->paginate(5);
    	$data = [
    		'blogitem' => $blogitem,
            'comitem' => $comitem,
            'tplType' => 'one',
    	];
       
        //点击数+1
        $hit = $blogitem['hits'] + 1;
        $hits = C::where('id',$id)->update(['hits' => $hit]); 
    	return view(null,$data);
    }

    /**
     * 评论提交处理
     * 
     */
    public function comment(\think\Request $request){


        //获取文章信息
        $content_id = $this->request->post('content_id');
        $content = C::where('id',$content_id)->find();

        //如果评论状态为0，则返回禁止评论
        if ($content['comment_status'] == '0') {
            return $this->error('该文章已禁止评论');
        }

        //根据是否需要审核决定初始审核状态
        if ($content['examine_status'] == '0') {
            //如果需要审核，则初始审核状态为待审核
            $status = '0';
        }else{
            $status = '1';
        }

        $r = [
            'chen_qq_user_id' => $this->request->post('user_id'),
            'chen_content_id' => $content_id,
            'comment' => $this->request->post('comment'),
            'comment_result_status' => $status,
            '__token__' => $this->request->post('__token__'),
        ];
        //写入数据库
        $m = new M;
        //手动捕获异常
        try {
            $m ->storage( $r );
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
        

        if ($status == '0') {
            return $this->success('评论成功,等待作者审核通过后显示');
        }

        return $this->success('评论成功');
    }

    /*
     *无限极分类处理
     */
    public function class( \think\Request $request , $id){
        //取出博客内容信息
        $classitem = C::where('chen_classify_id',$id)
                        ->where('content_status',1)
                        ->order('id','desc')
                        ->paginate(10);

        if (!$classitem) {
            return $this->error('数据不存在');
        }
        //取出分类信息
        $classname = F::where('id',$id)->find();  

        $data = [
            'classitem' => $classitem,
            'classname' => $classname,
            'tplType' => 'two',
        ];
        
        return view(null,$data);
    }
    /*
     *获得客户端IP
     */
    public function getIp(){
        static $ip  =   NULL;

        if(isset($_SERVER['HTTP_X_REAL_IP'])){//nginx 代理模式下，获取客户端真实IP
            $ip=$_SERVER['HTTP_X_REAL_IP'];     
        }elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {//客户端的ip
            $ip     =   $_SERVER['HTTP_CLIENT_IP'];
        }elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {//浏览当前页面的用户计算机的网关
            $arr    =   explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $pos    =   array_search('unknown',$arr);
            if(false !== $pos) unset($arr[$pos]);
            $ip     =   trim($arr[0]);
        }elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip     =   $_SERVER['REMOTE_ADDR'];//浏览当前页面的用户计算机的ip地址
        }else{
            $ip=$_SERVER['REMOTE_ADDR'];
        }

        return $ip;
    }

}
