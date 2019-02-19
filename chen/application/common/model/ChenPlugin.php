<?php

namespace app\common\model;
/**
 * 插件模型类
 */
use think\Loader;
use think\db;


class ChenPlugin extends Base
{
	/**
	 * 获得所有插件信息
	 */
	public function getList()
	{
		//获取插件文件夹下的所有插件信息，并将插件名以数组的形式提现
		$dirs = array_map('basename', glob(PLUGIN_PATH . '*',GLOB_ONLYDIR));

		if ($dirs === false) {
			return $this->error = '无法打开插件目录';
		}

        $plugins = [];
        //如果插件文件夹无文件，则返回空数组
        if (empty($dirs)) return $plugins;
        //获取数据库中的插件信息
        $list = $this->select();
        foreach ($list as $plugin) {
            $plugins[$plugin['name']] = $plugin;
            
        }

        foreach ($dirs as $pluginDir) {
            $pluginDir = Loader::parseName($pluginDir, 1);

            if (!isset($plugins[$pluginDir])) {

			    $class     = get_plugin_class($pluginDir);

                if (!class_exists($class)) { // 实例化插件失败忽略
                    //TODO 加入到日志中
                    continue;
                }
                $obj                 = new $class;
                //dump($obj);exit;
                $plugins[$pluginDir] = $obj->info;

                if ($plugins[$pluginDir]) {
                        $plugins[$pluginDir]['status'] = 3;//未安装
                }
            }
        }


		return $plugins;
	}

	/**
	 * 卸载插件
	 */
    public function uninstall($id)
    {
    	//从数据库中获得插件信息
        $findPlugin = $this->find($id);

        if (empty($findPlugin)) {
            return -1; //插件不存在;
        }
        //获得插件类所在路径
        $class = get_plugin_class($findPlugin['name']);

        //开启事务
        Db::startTrans();
        try {
        	//删除plugin表中的数据
            $this->where(['name' => $findPlugin['name']])->delete();
			//删除hook_plugin表中的数据
            Db::name('chen_hook_plugin')->where('plugin', $findPlugin['name'])->delete();

            //如果插件类存在，则实例化类并执行类中的卸载方法
            if (class_exists($class)) {
                $plugin = new $class;
                $uninstallSuccess = $plugin->uninstall();

                //插件类卸载失败
                if (!$uninstallSuccess) {
                    Db::rollback();
                    return -2;
                }
            }

            Db::commit();
        } catch (\Exception $e) {
            Db::rollback();
            return false;
        }

        return true;

    }















}


?>