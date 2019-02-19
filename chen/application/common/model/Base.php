<?php
namespace app\common\model;

/*
 *后台基础模型类
 *所有后台数据模型 都应该作为它的子类存在
 */

class Base extends \think\Model
{
	use \think\model\concern\SoftDelete;

}
