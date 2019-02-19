<?php

namespace app\common\model;
/**
 * 访问地址统计类
 */
use \iplocation\IpLocation as L;

class ChenIp extends Base
{

	/*
	 *IP地址访问统计。以最后访问时间的24小时为一个周期
	 */
	public function ipHandle($ip){
        $location = $this->location($ip);
		$res = $this->where('ip',$ip)->select();
        if (!$res->isEmpty()) {
            $arr = $res->toArray();
            foreach ($arr as $arr_res) {
                $ip_info = $arr_res;
            }
            
            $iptime=time();

            if ($ip_info['update_time'] == 0) {
                    if ($iptime - strtotime($ip_info['create_time']) > 86400) {
                        $this->where('id',$ip_info['id'])->update(['hits'=>$ip_info['hits']+1]);
                    }else{
                        $this->where('id',$ip_info['id'])->update(['update_time'=>$iptime]);
                    }
                }
            if ($iptime - strtotime($ip_info['update_time']) > 86400) {
                        $this->where('id',$ip_info['id'])->update(['hits'=>$ip_info['hits']+1 ,'update_time'=>$iptime]);
                    }else{
                        $this->where('id',$ip_info['id'])->update(['update_time'=>$iptime]);
                }
        }else{
          $this->save(['ip'=>$ip,'location'=>$location]);  
        }
	}


    /*
     *获取IP所在省份
     */
    public function location($ip){
        $ipdata = new L(IP_PATH . 'qqwry.dat');
        $location=$ipdata->getlocation($ip);
        $str=$location['area'];
        $str=iconv("gb2312", "utf-8//IGNORE",$str);
        $sheng_is = mb_strpos($str,'省');

        if($sheng_is){
            $tmp = explode("省",$str);
            $province = $tmp[0];
        }else{
            $tmp = explode("市",$str);

            $province = $tmp[0];
        }

        return $province;
    }

}


?>