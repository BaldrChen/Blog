<?php

namespace app\common\model;
/**
 * 内容模型类
 */


class ChenContent extends Base
{
    public function chenAdminUser()
    {
        return $this->belongsTo('ChenAdminUser');
    }


    public function chenQqUser()
    {
        return $this->belongsTo('ChenQqUser');
    }




	public function storage($r, $user_id=null){
			//数据格式验证
			$validate = new \app\common\validate\Content();

			$scene = $r['id'] ? 'modify' : 'add';
			if (!$validate->scene($scene)->check($r)) {

				return exception($validate->getError(),10005);
			}

			$content = $this;

			//如果是修改模式，就获取目标数据对象
			if ( $r['id'] ) {
				//如果传入user_id 就必须附加范围查询my
				$obj = $this;
				if ( $user_id ) {
					$obj = $this->my( $user_id );
				}
				$content = $obj->where('id',$r['id'])->find();
				
				//如果最终没有取得数据  就提示错误
				if (!$content) {
					return exception('数据不存在',10011);
				}


			}




			//如果未修改模式，则获取目标数据对象
			if ($r['id']) {
				$content = $this->where('id',$r['id'])->find();
			}
			$res = $content->allowField(true)->save($r);
	}


	/**
	 * 删除指定数据
	 */
	public function remove( $id , $user_id=null ){
		$obj = $this;
		if ($user_id) {
			$obj = $obj->my($user_id);
		}


		$item = $obj->where('id',$id)->find();
		if (!$item) {
			return exception('数据不存在',10003);;
		}
		$item->delete();
	}


	/**
	 * 查询指定用户的数据
	 * 
	 * 
	 */
	public function scopeMy($query,$chen_user_id){
		$query->where('chen_user_id',$chen_user_id);

	}


	/**
	 * 获取器，获取内容简介
	 * @return [type] [description]
	 */
	public function getIntraAttr(){
		return mb_substr(strip_tags($this->content),0,150);
	}

	/**
	 * 获取器，获取标题简介
	 * @return [type] [description]
	 */
	public function getCaptionAttr(){
		return mb_substr(strip_tags($this->title),0,8);
	}



	/**
	 * 获取器，获取内容的访问地址
	 * @return [type] [description]
	 */
	public function getUrlAttr(){
		return url('index/index/read',['id' => $this->id]);
	}




	/**
	 * 获取器，获取内容图片
	 * @return [type] [description]
	 */
	public function getImageAttr(){
		$is = preg_match("/<img.*?src=('|\")(.*?)('|\")/i" ,$this->content,$image);
		if ($is) {
			return $image[2];
		}else{
			return url("static/images/default.png");
		}
	}

}


