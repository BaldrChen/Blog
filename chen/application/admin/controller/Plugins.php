<?php
namespace app\admin\controller;

use app\common\model\ChenPlugin as P;
use app\common\model\ChenHookPlugin as HP;
use think\Loader;
use think\Db;

/*
 *插件管理控制器
 */

class Plugins extends Base
{
    public function index()
    {
    	$p = new P;
    	$plugin = $p->getList();
    	$this->assign('plugin',$plugin);
        return view();
    }



    /**
     * 安装插件
     */
    public function install()
    {
    	//从参数中获得插件名字
    	$name = $this->request->param('name');

    	//获得插件类所在路径
    	$class = get_plugin_class($name);

    	if (!class_exists($class)) {
            $this->error('插件不存在!');
        }

        $p = new P;
        $pluginCount = $p->where('name',$name)->count();

        if ($pluginCount > 0) {
            $this->error('插件已安装!');
        }

        $plugin = new $class;
        $info   = $plugin->info;
        if (!$info || !$plugin->checkInfo()) {//检测信息的正确性
            $this->error('插件信息缺失!');
        }

		$installSuccess = $plugin->install();
        if (!$installSuccess) {
            $this->error('插件预安装失败!');
        }
        //插件类中所有的方法名
        $methods = get_class_methods($plugin);
		foreach ($methods as $methodKey => $method) {
            $methods[$methodKey] = Loader::parseName($method);
        }
        //获取数据库中的钩子
        $Hooks = Db::name('chen_hook')->column('hook');
        //检测插件类中是否绑定钩子方法
        $pluginHooks = array_intersect($Hooks, $methods);

        //写入数据库
         $hp = new HP;

         $p->data($info)->allowField(true)->save();

         foreach ($pluginHooks as $pluginHook) {
         	$data = ['hook' => $pluginHook, 'plugin' => $name, 'status' => 1];

             $hp->save($data);
         }
         //清空缓存，使插件行为自动加载类重新加载
         cache('init_hook_plugins',null);

         $this->success('安装成功!');
    }


    /**
     * 卸载插件
     */
    public function delete()
    {
        $p = new P();
        $id= $this->request->param('id');

        $result = $p->uninstall($id);

         if ($result !== true) {
             $this->error('卸载失败!');
         }

         cache('init_hook_plugins',null);

         $this->success('卸载成功!');
    }

    /**
     * 插件启用/禁用
	 */
    public function toggle()
    {
        $id = $this->request->param('id');
        $p = new P;
        $hp = new HP;
        $res = $p ->where('id',$id)->select()->toArray();
        if (empty($res)) {
            $this->error('插件不存在！');
        }

        $status         = 1;
        $successMessage = "启用成功！";
        if ($this->request->param('disable')) {
            $status         = 0;
            $successMessage = "禁用成功！";
        }
        
        foreach ($res as $plug) {
        	$plugin = $plug;
        }
        $resx = $p->select();
        $p->startTrans();
        try {
            $p->save(['status' => $status], ['id' => $id]);

            $hp->save(['status' => $status], ['plugin' => $plugin['name']]);

            $p->commit();

        } catch (\Exception $e) {

            $p->rollback();

            $this->error('操作失败！');

        }

        cache('init_hook_plugins',null);

        $this->success($successMessage);
    }

}
