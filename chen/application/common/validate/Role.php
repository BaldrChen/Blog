<?php

namespace app\common\validate;

use think\Validate;

class Role extends Validate
{
    protected $rule =   [
        'name'  => 'require',
        'remark'   => 'require',
        'status' => 'integer|require|between:0,1',    
    ];
    
    protected $message  =   [
        'name.require' => '未输入角色名称',
        'remark.require'     => '未输入角色描述',
        'status.integer'   => '非法的状态',
        'status.require'  => '状态不能为空',
        'status.between' => '意料之外的状态',    
    ];
    
}















?>