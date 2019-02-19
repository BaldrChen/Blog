<?php
namespace app\index\controller;
use app\common\model\ChenUser as U;

/*
 *普通用户个人中心
 *目前已废弃
 */

class UserCenter extends UserBase
{
    public function index( \think\Request $request )
    {
    	
        return view();
    }
    /*
     *个人信息修改
     */
    public function profile( \think\Request $request )
    {
    	
        return view();
    }

    public function profile_save( \think\Request $request )
    {
    	
        $r = [
			'id' => $this->user->id,
			'passwd' => $this->request->post('passwd'),
			'nick' => $this->request->post('nick'),
			'phone' => $this->request->post('phone'),
			'email' => $this->request->post('email'),
			'__token__' => $this->request->post('__token__'),
		];


		//修改数据
		$u = new U();
		try {
			$u->storage( $r , 'profile' );
		} catch (\Exception $e) {
			return $this->error($e->getMessage());
		}
		return $this->success('修改成功');
		//return $this->redirect("index/u/index");
    }


}
