<?php
namespace app\admin\controller;

use app\common\model\ChenClassify as F;
/*
 *分类控制器
 */

class Classify extends Base
{
	public function initialize(){
        parent::initialize();
        $this->classify_level = config('project.classify_level');
        $this->assign('classify_level',$this->classify_level);
	}


    public function index()
    {

    	$f = new F;
    	//获取分类树
    	$cdata = $f->tree();


		$data = ['cdata' => $cdata];

        return view(null,$data);
    }


    public function save()
    {
    	$r['name'] = $this->request->post('classname');
    	$r['__token__'] = $this->request->post('__token__');

    	$type = $this->request->post('type');

    	//判断是修改还是添加模式
    	if ($type == 'add') {
    		$r['pid'] = $this->request->post('father_id');
    		$r['id'] = null;
    	}

    	if ($type == 'modify') {
    		$r['id'] = $this->request->post('father_id');
    	}




    	$f = new F;
    	try {
			$f->storage( $r );
		} catch (\Exception $e) {
			return $this->error($e->getMessage());
		}
    	return $this->success('操作成功');
     }


    public function del()
	{
		$id = $this->request->get('id');

		$f = new F();

		try {
			$f->remove($id);
		} catch (\Exception $e) {
			return $this->error($e->getMessage() );
		}
		
		return $this->success('删除成功');
	}


}
