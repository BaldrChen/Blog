<?php
namespace app\index\controller;

use app\common\model\ChenIp as I;

/*
 *访问统计记录页
 */

class Statistics extends Base
{

    public function index()
    {
    	$visithit = $this->visithit();
    	$visithit = json_encode($visithit);
    	$this->assign('visithit',$visithit);
        return view();
    }

    /*
     *获取数据库中所有IP所在省份的访问次数
     */
    public function visithit(){

    	$i = new I;
    	$visithit = array();
    	$z = $i->select()->toArray();
    	foreach ($z as $v) {
    		$arr[][$v['location']] = $v['hits'];
    	}
    	foreach($arr as $key=>$value){

	        foreach($value as $k=>$v){
	            if(isset($res[$k])){
	                $res[$k] = $res[$k] +$v;
	            }else{
	                $res[$k] = $v;
	            }
	        }
    	}

    	foreach ($res as $k => $v) {
    		static $i = 0;
    		$visithit[$i]['name'] = $k;
    		$visithit[$i]['value'] = $v;
    		$i++;
    	}


    	return $visithit;
    }




}
