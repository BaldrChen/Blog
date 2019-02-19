<?php

namespace app\common\controller;

use think\exception\ValidateException;
use think\Request;
use think\facade\Config;
use think\Loader;
use think\exception\TemplateNotFoundException;

/*
 *插件基础类，插件类需继承
 */

class PluginBase extends \think\Controller
{

    /**
     * 插件名
     * 
     */
    private $plugin;



    /**
     * 构造函数
     * @param Request $request Request对象
     * @access public
     */
    public function initialize()
    {

        //获取插件参数
        $this->getPlugin();
        //获取插件视图
        $this->view = $this->plugin->getView();

        // 控制器初始化
        $this->_initialize();
    }

    public function getPlugin()
    {

        if (is_null($this->plugin)) {
            $pluginName   = request()->param('_plugin');
            $pluginName   = Loader::parseName($pluginName, 1);
            $class     = get_plugin_class($pluginName);
            $this->plugin = new $class;
        }

        return $this->plugin;

    }

    // 初始化
    protected function _initialize()
    {
    }


    /**
     * 加载模板输出(支持:/index/index,index/index,index,空,:index,/index)
     * @access protected
     * @param string $template 模板文件名
     * @param array $vars 模板输出变量
     * @param array $replace 模板替换
     * @param array $config 模板参数
     * @return mixed
     */
    protected function fetch($template = '', $vars = [], $replace = [], $config = [])
    {
        $template = $this->parseTemplate($template);

        // 模板不存在 抛出异常
        if (!is_file($template)) {
            throw new TemplateNotFoundException('template not exists:' . $template, $template);
        }

        return $this->fetch($template, $vars, $replace, $config);
    }

    /**
     * 自动定位模板文件
     * @access private
     * @param string $template 模板文件规则
     * @return string
     */
    private function parseTemplate($template)
    {
    	//从插件信息中获取插件视图所在目录路径
        $path = $this->plugin->getThemeRoot();
        //从配置中获取模板分隔符
        $depr = Config('template.view_depr');
        //从地址栏获得所有数据
        $data       = request()->param();

        $controller = $data['_controller'];
        $action     = $data['_action'];
        //根据传入的模板文件名称定位路径
        if (0 !== strpos($template, '/')) {
            $template   = str_replace(['/', ':'], $depr, $template);
            $controller = Loader::parseName($controller);
            if ($controller) {
                if ('' == $template) {
                    // 如果模板文件名为空 按照默认规则定位
                    $template = str_replace('.', DS, $controller) . $depr . $action;
                } elseif (false === strpos($template, $depr)) {
                    $template = str_replace('.', DS, $controller) . $depr . $template;
                }
            }
        } else {
            $template = str_replace(['/', ':'], $depr, substr($template, 1));
        }
        return $path . ltrim($template, '/') . '.' . ltrim(Config('template.view_suffix'), '.');
    }




}

















?>