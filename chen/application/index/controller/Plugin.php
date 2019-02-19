<?php

namespace app\index\controller;

use think\exception\TemplateNotFoundException;
use think\Lang;
use think\Loader;
use think\facade\Request;
use think\View;
use think\facade\Config;
use think\Db;


/**
 * 插件类
 */

 class plugin 
{
    
   /**
     * 视图实例对象
     * @var view
     * @access protected
     */
    private $view = null;

    public $info = [];
    private $pluginPath = '';
    private $name = '';
    private $themeRoot = "";

   public function __construct()
    {
        //实例化requesr
        $requesr = new \think\Request;
        //取得模板配置
        $engineConfig = Config('template.');
        //取得插件名
        $this->name = $this->getName();
        //将插件名首字母大写
        $nameCStyle = Loader::parseName($this->name);
        //插件所在路径
        $this->pluginPath = '../../public/plugins' . $nameCStyle . '/';
        //插件视图所在路径
        $this->themeRoot = $this->pluginPath . 'view' . '/';
        dump($nameCStyle);
        $engineConfig['view_base'] = $this->themeRoot;
        $this->view = new View($engineConfig);

    }

    function index(){

    }


/**
     * 加载模板输出
     * @access protected
     * @param string $template 模板文件名
     * @return mixed
     */
    final protected function fetch($template)
    {
        if (!is_file($template)) {
            $engineConfig = Config('template.view_suffix');
            $template     = $this->themeRoot . $template . '.' . $engineConfig;
        }

        // 模板不存在 抛出异常
        if (!is_file($template)) {
            throw new TemplateNotFoundException('template not exists:' . $template, $template);
        }

        return $this->view->fetch($template);
    }

    /**
     * 渲染内容输出
     * @access protected
     * @param string $content 模板内容
     * @return mixed
     */
    final protected function display($content = '')
    {
        return $this->view->display($content);
    }

    /**
     * 模板变量赋值
     * @access protected
     * @param mixed $name 要显示的模板变量
     * @param mixed $value 变量的值
     * @return void
     */
    final protected function assign($name, $value = '')
    {
        $this->view->assign($name, $value);
    }


    /**
     * 获取插件名
     * @return string
     */
    final public function getName()
    {
        if (empty($this->name)) {
            $class = get_class($this);
dump($class );
dump(strrpos($class, '\\'));
            $this->name = substr($class, strrpos($class, '\\') + 1);
dump($this->name );
        }

        return $this->name;

    }


}

?>