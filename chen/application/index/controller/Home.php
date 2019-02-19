<?php
namespace app\index\controller;

use app\common\model\ChenContent as C;
use app\common\model\ChenUser as U;

/*
 *用户个人简介页
 *当前已废弃
 */

class Home extends Base
{
    public function index( \think\Request $request , $id )
    {
    	$u = new u();
    	$homeUser = $u -> getUser( $id );

    	if (!$homeUser) {
    		return $this->error('不存在的用户');
    	}

    	$newData = C::where('content_status',1)
    				->where('chen_user_id',$id)
			    	->order('id','desc')
			    	->limit(10)
			    	->paginate(10);

		$data = [

			'newData' => $newData,
			'homeUser' => $homeUser,

		 ];


        return view(null,$data);
    }


}
