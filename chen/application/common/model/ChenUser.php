<?php

namespace app\common\model;



/**
 * 用户模型类
 */

class ChenUser extends Base
{


		//取的一条用户数据
		public function getUser( $id ){
			$user = $this->where('id',$id)->find();
			if (!$user) {
				return null;
			}
			
			return $user;
		}

		public function storage($r,$scene = null){
			//数据格式验证
			$validate = new \app\common\validate\User();

		    if( !$scene ){
				$scene = $r['id'] ? 'modify' : 'add';			
			}

			if(!$validate->scene( $scene )->check($r))
			{
				return exception($validate->geterror(), 10001);
			}
				$u = $this;

			if($r['id']){
				$u = $this->where('id',$r['id'])->find();
			}

			if($r['passwd']){

				$r['passwd'] = password_hash($r['passwd'],PASSWORD_DEFAULT);
			}else{
				unset($r['passwd']);
		}
			$res = $u->allowField(true)->save($r);
		}

		public function isStatus(){
			if ($this->user_status <> 1 ) {
				return '当前用户已被禁用';
			}
			return true;
		}



		public function upload($file){
			// 移动到临时上传图片目录
			$info = $file->validate(['size'=>1024*1024*2,'ext'=>'jpg,png,gif,jpeg'])->rule('uniqid')->move( '../public/uploads/head_img');
			if($info){
			    // 成功上传后 返回上传文件名
			    return  $info->getSaveName();
			}else{

			    // 上传失败获取错误信息
			   return exception($file->getError(), 10016);
			}
		}




		/**
		 * 图片处理，将原图片等比例缩放为最大100*100
		 */
		public function image( $name ){
			//打开上传的图片
			$image = \think\Image::open('../public/uploads/head_img/'.$name);

			//将图片等比例缩放为最大100*100的文件，并转存
			$image->thumb(100, 100)->save('../public/static/head_portrait/'.$name);
			return $name;

		}







	/**
	 * 获取器，获取用户的个人中心网址
	 * @return [type] [description]
	 */
	public function getBlogurlAttr(){
		return url("index/home/index",['id'=>$this->id ]);
	}




	/**
	 * 获取器，获取用户的头像信息
	 * @return [type] [description]
	 */
	public function getHeadAttr(){

		//$user = $this->where('id',$this->id)->find();
			// if (!$user) {
			// 	return null;
			// }
			if ($this->images) {
				$img = $this->images;
			}else{
				$img = "/static/head_portrait/default.png";
			}
			return $img;
	}




}