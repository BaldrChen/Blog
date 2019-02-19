<?php
namespace app\admin\controller;
use app\common\model\ChenHook as H;
use app\common\model\ChenPlugin as P;
use app\common\model\ChenHookPlugin as HP;

/*
 *钩子管理控制器
 */

class Hooks extends Base
{
    public function index()
    {
        $h = new h;
        $hook = $h->order('id', 'desc')->select();
        $this->assign('hook',$hook);
        return view();
    }

    /*
     *该钩子下挂的所有插件
     */
    public function hookplugin()
    {
        $hook = $this->request->param('name');
        $hp = new HP;

        
        $pluginInfo = $hp->where('hook',$hook)->alias('a')->join('chen_plugin b','a.plugin = b.name')->select();
        
        // $plugin = $hp->where('hook',$hook)->select()->toArray();
        // $pluginInfo = [];
        // if (!empty($plugin)) {      
        //     foreach ($plugin as $info) {
        //         $pluginName = $info['plugin'];
        //         $pluginInfo[$pluginName] = $p->where('name',$pluginName)->order('id', 'desc')->select()->toArray();
        //     }
            
        // }
         $this->assign('hook',$hook);
         $this->assign('pluginInfo',$pluginInfo);
         return view();
    }

    /**
     * 更新目录下所有的钩子
     * 
     */
    public function sync()
    {
        //获取所有应用模块
        $apps = array_map('basename',glob(APP_PATH . '*',GLOB_ONLYDIR));
        
        foreach ($apps as $app) {
            //所有应用模块下的钩子配置文件
            $hookFile = APP_PATH . $app . '/hooks.php';
            //判断是否存在该文件
            if (file_exists($hookFile))
            {
                //引入钩子配置文件
                $hookInFile = include $hookFile;

                foreach ($hookInFile as $hookName => $hookInfo) {
                    //若未定义钩子类型，则默认为应用钩子
                    $hookInfo['type'] = empty($hookInfo['type']) ? 2: $hookInfo['type'];
                    //查询数据库中是否已存在该钩子
                    $h = new H;
                    $findHook = $h->where('hook',$hookName)->count();

                    if ($findHook > 0) {
                        //如果已存在该钩子，则更新信息
                        $h->where('hook',$hookName)->strict(false)->field(true)->update($hookInfo);
                    }else{
                        //如果不存在钩子，则新写入该钩子
                        $hookInfo['hook'] = $hookName;
                        $h->allowField(true)->save($hookInfo);
                    }
                }

            }
            return $this->success('更新成功');

        }





    }

}
