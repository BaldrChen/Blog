<?php

namespace app\behavior;
use think\facade\Hook;
use think\db\Query; 
use think\Db;
use think\Loader;

/*
 *插件行为绑定
 */

class InitHookBehavior
{

	public function run($params)
	{
    
		 $systemHookPlugins = cache('init_hook_plugins');
		 if (empty($systemHookPlugins)) {
            $systemHooks = Db::name('chen_hook')->column('hook');

            $systemHookPlugins = Db::name('chen_hook_plugin')->field('hook,plugin')->where('status', 1)
            ->where('hook', 'in', $systemHooks)
            ->order('list_order ASC')
            ->select();
             cache('init_hook_plugins', $systemHookPlugins);
         }
       
		foreach ($systemHookPlugins as $hookPlugin) {
				$name = ucwords($hookPlugin['plugin']); 
				$pluginDir = Loader::parseName($name);
                $src = "plugins\\{$pluginDir}\\{$name}Plugin";
                Hook::add($hookPlugin['hook'], $src);

        }

	}













}












?>