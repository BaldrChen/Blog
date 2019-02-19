<?php
namespace app\admin\controller;

/*
 *系统设置控制器
 */

class Setting extends Base
{

	public function initialize(){
		parent::initialize();
		$this->setting = new \app\common\model\ChenSetting();
	}

    public function index()
    {


    	
    	$data=[
    		'setting' => $this->setting->select(),
    	];

    	return view(null,$data);

    }

    public function save()
    {	$r=[];
    	$r['formdata'] = $this->request->post('formdata');
    	$r['__token__'] = $this->request->post('__token__');

    	//数据格式验证
    	$validate = new \app\common\validate\Setting();
    	if (!$validate->check($r)) {
    		return $this->error($validate->getError());
    	}

    	$list = [];


    	foreach ($this->setting->select() as $item) {
    		$list[]=[
    			'id' => $item->id,
    			'value' => $r['formdata'][$item->key],
    		];
    	}
    	$is = $this->setting->saveAll($list);
        //清空缓存
        \think\facade\Cache::rm('setting');
        return $this->success("提交成功",'admin/setting/index');
    }
}
