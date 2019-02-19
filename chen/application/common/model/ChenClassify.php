<?php

namespace app\common\model;
/**
 * 分类设置模型类
 */


class ChenClassify extends Base
{
	public function storage( $r){
			//数据格式验证
			$validate = new \app\common\validate\Classify();

			if (!$validate->check($r)) {

				return exception($validate->getError(),10019);
			}

			$class = $this;

			if ($r['id']) {
				$class = $this->where('id',$r['id'])->find();
			}

			$res = $class->allowField(true)->save($r);
	}

	public function remove( $id ){
		$f = $this;
		$item = $f->where('id',$id)->find();
		if (!$item) {
			return exception('数据不存在',10004);
		}
		$item->delete();

	}

	/**
	 * 获取分类树
	 */
	public function tree (){
		$arr = $this->select()->toArray();


		function category($arr,$pid=0,$level=0){
		    //定义一个静态变量，存储一个空数组，用静态变量，是因为静态变量不会被销毁，会保存之前保留的值，普通变量在函数结束时，会死亡，生长周期函数开始到函数结束，再次调用重新开始生长
		    //保存一个空数组
		    static $list=array();
		    //通过遍历查找是否属于顶级父类，pid=0为顶级父类，
		    foreach($arr as $value){
		        //进行判断如果pid=0，那么为顶级父类，放入定义的空数组里
		        if($value['pid']==$pid){

		            //将等级信息提交进数组 方便显示使用
		            $value['level'] =$level;
		            $list[]=$value;
		            //递归点，调用自身，把顶级父类的主键id作为父类进行再调用循环，等级+1
		            category($arr,$value['id'],$level+1);
		        }
		    }

		    return $list;//递归出口
		}
	
		$cdata = category($arr);
		return $cdata;
	}




}


?>