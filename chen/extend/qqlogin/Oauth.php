<?php
/* PHP SDK
 * @version 2.0.0
 * @author connect@qq.com
 * @copyright © 2013, Tencent Corporation. All rights reserved.
 */
namespace qqlogin;

use \qqlogin\Url;

//require_once(CLASS_PATH."URL.class.php");


class Oauth{

    const VERSION = "2.0";
    const GET_AUTH_CODE_URL = "https://graph.qq.com/oauth2.0/authorize";
    const GET_ACCESS_TOKEN_URL = "https://graph.qq.com/oauth2.0/token";
    const GET_OPENID_URL = "https://graph.qq.com/oauth2.0/me";

    public $urlUtils;
    public $state;
    public $appid = "101537871";
    public $appkey = "4da32a11840ff326a9c826144c7561e2";
    public $callback = "http://www.baldr.cn/callback";
    public $scope = "get_user_info";

    function __construct(){
        
        $this->urlUtils = new URL();
       
    }

    public function qq_login(){
        //-------生成唯一随机串防CSRF攻击
        $this->state = md5(uniqid(rand(), TRUE));

        session('state',$this->state);
        //-------构造请求参数列表
        $keysArr = array(
            "response_type" => "code",
            "client_id" => $this->appid,
            "redirect_uri" => $this->callback,
            "state" => $this->state,
            "scope" => $this->scope
        );

        $login_url =  $this->urlUtils->combineURL(self::GET_AUTH_CODE_URL, $keysArr);
        return $login_url;
        //header("Location:$login_url");
    }

    public function qq_callback(){


        //--------验证state防止CSRF攻击
        if(input('state') != session('state')){
            exit('30001');
        }

        //-------请求参数列表
        $keysArr = array(
            "grant_type" => "authorization_code",
            "client_id" => $this->appid,
            "redirect_uri" => $this->callback,
            "client_secret" => $this->appkey,
            "code" => $_GET['code']
        );

        //------构造请求access_token的url
        $token_url = $this->urlUtils->combineURL(self::GET_ACCESS_TOKEN_URL, $keysArr);
        $response = $this->urlUtils->get_contents($token_url);

        if(strpos($response, "callback") !== false){

            $lpos = strpos($response, "(");
            $rpos = strrpos($response, ")");
            $response  = substr($response, $lpos + 1, $rpos - $lpos -1);
            $msg = json_decode($response);

            if(isset($msg->error)){
                exit($msg->error);
            }
        }

        $params = array();
        parse_str($response, $params);

        
        //return $params["access_token"];
        session('access_token',$params["access_token"]);
    }

    public function get_openid(){

        //-------请求参数列表
        $keysArr = array(
            "access_token" => session('access_token'),
        );

        $graph_url = $this->urlUtils->combineURL(self::GET_OPENID_URL, $keysArr);
        $response = $this->urlUtils->get_contents($graph_url);

        //--------检测错误是否发生
        if(strpos($response, "callback") !== false){

            $lpos = strpos($response, "(");
            $rpos = strrpos($response, ")");
            $response = substr($response, $lpos + 1, $rpos - $lpos -1);
        }

        $user = json_decode($response);
        if(isset($user->error)){
            exit($user->error);
        }

        //------记录openid

        //return $user->openid;
        session('openid',$user->openid);
    }
}
