<?php

namespace plugin;

use think\exception\TemplateNotFoundException;
use think\Lang;
use think\Loader;
use think\facade\Request;
use think\View;
use think\facade\Config;
use think\Db;
use think\Container;

/**
 * 插件类
 */

abstract class plugin 
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
        $app = Container::get('app');
    	//实例化requesr
    	$requesr = new \think\Request;
    	//取得插件名
    	$this->name = $this->getName();
    	//将插件名首字母大写
    	$nameCStyle = Loader::parseName($this->name);
    	//插件所在路径
    	$this->pluginPath = PLUGIN_PATH . $nameCStyle . '/';
    	//插件视图所在路径
    	$this->themeRoot = $this->pluginPath . 'view' . '/';

        //实例化视图
        $view = Container::get('view')->init($app['config']->pull('template'));
    	$this->view = $view;
    }

/**
     * 加载模板输出
     * @access protected
     * @param string $template 模板文件名
     * @return mixed
     */
    final protected function fetch($template, $vars = [], $config = [])
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
        	//返回对象实例 object 所属类的路径
            $class = get_class($this);
            //将插件名提取出来（最后一个\后面的字符串再减掉倒数6个字符plugin）
            $this->name = substr($class, strrpos($class, '\\') + 1, -6);
        }

        return $this->name;

    }



    /**
     * 检查插件信息完整性
     * @return bool
     */
    final public function checkInfo()
    {
        $infoCheckKeys = ['name', 'description', 'status', 'author', 'version'];
        foreach ($infoCheckKeys as $value) {
            if (!array_key_exists($value, $this->info))
                return false;
        }
        return true;
    }

    /**
     * 获取插件根目录绝对路径
     * @return string
     */
    final public function getPluginPath()
    {

        return $this->pluginPath;
    }

    /**
     *插件视图所在目录路径
     * @return string
     */
    final public function getThemeRoot()
    {
        return $this->themeRoot;
    }

    /**
     * @return View
     */
    public function getView()
    {
        return $this->view;
    }



    //必须实现安装
    abstract public function install();

    //必须卸载插件方法
    abstract public function uninstall();





}













?>