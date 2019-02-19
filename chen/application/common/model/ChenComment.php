<?php

namespace app\common\model;
/**
 * 评论模型类
 */


class ChenComment extends Base
{
	public function chenAdminUser()
    {
        return $this->belongsTo('ChenAdminUser');
    }

    public function chenQqUser()
    {
        return $this->belongsTo('ChenQqUser');
    }

    public function chenContent()
    {
        return $this->belongsTo('ChenContent');
    }

    public function scopeMy($query,$chen_user_id){
		$query->where('chen_user_id',$chen_user_id);

	}

	public function storage( $r ){
			//数据格式验证
			$validate = new \app\common\validate\Comment();

			if (!$validate->check($r)) {

				return exception($validate->getError(),10016);
			}

			$comment = $this;

			//如果未取得用户id  则返回错误
	        if (!$r['chen_qq_user_id']) {
	            return exception('未登录',10017);
	        }

	        //如果未取得文章id  则返回错误
	        if (!$r['chen_content_id']) {
	            return exception('数据错误',10018);
	        }



			$res = $comment->allowField(true)->save($r);
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
			return exception('数据不存在',10014);;
		}
		$item->delete();
	}


	/**
	 * 获取器，获取评论内容简介
	 * @return [type] [description]
	 */
	public function getComAttr(){
		return mb_substr(strip_tags($this->comment),0,10);
	}


}


?>