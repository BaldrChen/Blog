<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\Loader;
use think\facade\Env;

// 应用公共文件

//读取系统配置
function setting($key){
	return \app\facade\Setting::get($key);
}

/**
 * 生成访问插件的url
 * @param string $url url格式：插件名://控制器名/方法
 * @param array $param 参数
 * @param bool $domain 是否显示域名 或者直接传入域名
 * @return string
 */
function plugin_url($url, $param = [], $domain = false)
{
    $url              = parse_url($url);
    $case_insensitive = true;
    $plugin           = $case_insensitive ? Loader::parseName($url['scheme']) : $url['scheme'];
    $controller       = $case_insensitive ? Loader::parseName($url['host']) : $url['host'];
    $action           = trim($case_insensitive ? strtolower($url['path']) : $url['path'], '/');

    /* 解析URL带的参数 */
    if (isset($url['query'])) {
        parse_str($url['query'], $query);
        $param = array_merge($query, $param);
    }

    /* 基础参数 */
    $params = [
        '_plugin'     => $plugin,
        '_controller' => $controller,
        '_action'     => $action,
    ];
    $params = array_merge($params, $param); //添加额外参数
    //访问插件入口文件
    return url('\\app\\common\\controller\\PluginEntry@index', $params, true, $domain);
}

/**
 * 获取插件类
 *
 */
function get_plugin_class($name)
{
    $name      = ucwords($name);
    $pluginDir = Loader::parseName($name);
    $class     = "plugins\\{$pluginDir}\\{$name}Plugin";
    return $class;
}

//定义插件路径常量
define('PLUGIN_PATH',Env::get('root_path') . 'public/plugins/');
define('APP_PATH',Env::get('app_path'));
//定义纯真IP数据库文件路径常量
define('IP_PATH',Env::get('root_path') . 'public/static/ip/');