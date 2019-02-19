<?php

namespace iplocation;


    class IpLocation{
            /**
            * QQWry.Dat文件指针
            */
            private $fp;

            /**
            * 第一条IP记录的偏移地址
            */
            private $firstip;

            /**
            * 最后一条IP记录的偏移地址
            */
            private $lastip;

            /**
            * IP记录的总条数（不包含版本信息记录）
            */
            private $totalip;

            /**
            * 构造函数，打开 QQWry.Dat 文件并初始化类中的信息
            *       *
            * @param string $filename
            * @return IpLocation
            */
 
            public function __construct($filename="qqwry.dat"){
                $this->fp=0;
                if(($this->fp=@fopen($filename,"rb"))!==false){
                    $this->firstip=$this->getlong();
                    $this->lastip=$this->getlong();
                    $this->totalip=($this->lastip-$this->firstip)/7;
                    register_shutdown_function(array(&$this,"__destruct"));
                }
            }
            
            /*
             *返回读取的长整形数
             *
             */
 
            private function getlong(){
                $result=unpack("Vlong",fread($this->fp,4));
                return $result["long"];
            }
 
            /*
             * 返回读取额3个字节的长整形数
             */
            private function getlong3(){
                $result=unpack("Vlong",fread($this->fp,3).chr(0));
                return $result["long"];
            }
 
            private function packip($ip){
                return pack("N",intval(ip2long($ip)));
            }
 
            /*
             *返回读取的字符串
             */

            private function getstring($data=""){
                $char=fread($this->fp,1);
                while(ord($char)>0){
                    $data.=$char;
                    $char=fread($this->fp,1);
                }
                return $data;
            }
 
            /*
             *返回地区信息
             */ 
            private function getarea(){
                $byte=fread($this->fp,1);
                switch(ord($byte)){
                case 0:
                    $operators="";
                break;
                case 1:
                case 2:
                    fseek($this->fp,$this->getlong3());
                    $operators=$this->getstring();
                break;
                default:
                    $operators=$this->getstring($byte);
                break;}
                return $operators;
            }
 
            /*
             *根据所给 IP地址或域名返回所在地区信息
             */
            public function getlocation($ip){
                if(!$this->fp){return null;}
                $location["ip"]=gethostbyname($ip);
                $ip=$this->packip($location["ip"]);
                $l=0;
                $u=$this->totalip;
                $findip=$this->lastip;
                while($l<=$u){
                    $i=floor(($l+$u)/2);
                    fseek($this->fp,$this->firstip+$i*7);
                    $startip=strrev(fread($this->fp,4));
                    if($ip<$startip){
                        $u=$i-1;
                    }else{
                        fseek($this->fp,$this->getlong3());
                        $endip=strrev(fread($this->fp,4));
                        if($ip>$endip){
                            $l=$i+1;
                        }else{
                            $findip=$this->firstip+$i*7;
                            break;
                        }
                    }
                }
                fseek($this->fp,$findip);
                $location["startip"]=long2ip($this->getlong());
                $offset=$this->getlong3();
                fseek($this->fp,$offset);
                $location["endip"]=long2ip($this->getlong());
                $byte=fread($this->fp,1);
                switch(ord($byte)){
                case 1:
                    $countryOffset=$this->getlong3();
                    fseek($this->fp,$countryOffset);
                    $byte=fread($this->fp,1);
                    switch(ord($byte)){
                    case 2:
                        fseek($this->fp,$this->getlong3());
                        $location["area"]=$this->getstring();
                        fseek($this->fp,$countryOffset+4);
                        $location["operators"]=$this->getarea();
                    break;
                    default:
                        $location["area"]=$this->getstring($byte);
                        $location["operators"]=$this->getarea();
                    break;}
                break;
                case 2:
                    fseek($this->fp,$this->getlong3());
                    $location["area"]=$this->getstring();
                    fseek($this->fp,$offset+8);
                    $location["operators"]=$this->getarea();
                break;
                default:
                    $location["area"]=$this->getstring($byte);
                    $location["operators"]=$this->getarea();
                break;}
                if($location["area"]=="CZ88.NET"){
                    $location["area"]="δ֪";
                }
                if($location["operators"]=="CZ88.NET"){
                    $location["operators"]="δ֪";
                }
                return $location;
            }


            /*
             *析构函数，执行结束关闭文件
             */
            public function __destruct(){
                if($this->fp){
                    @fclose($this->fp);
                }
                $this->fp=0;
            }
    }
?>