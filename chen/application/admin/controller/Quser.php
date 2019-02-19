<?php 
namespace app\admin\controller;

use app\common\model\ChenQqUser as QU ;

/*
 *qq用户管理控制器
 */

class Quser extends Base 
{


	public function index()
	{
		$key = $this->request->get('search');

		$qu = new QU();

		//搜索条件
		if ( $key ) {
			$qu = $qu->where('nick','like',"%{$key}%");
			//用户或昵称出现关键字$key都将结果查询出来
			$qu = $qu->whereOr('openid','like',"%{$key}%");

		}


		$uData = $qu->order('id','desc')->paginate(5);
		
		$data = ['uData' =>$uData, 'search'=>$key];
		return view(null,$data);

	}	


}