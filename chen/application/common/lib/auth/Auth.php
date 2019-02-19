<?php
namespace app\common\lib\auth;

/**
 * 权限验证类
 */
use think\Db;


class Auth {


	public function check($uid, $name)
    {

        if (empty($uid)) {
            return false;
        }
        if ($uid == 1) {
            return true;
        }

        if (is_string($name)) {
            $name = strtolower($name);
            if (strpos($name, ',') !== false) {
                $name = explode(',', $name);
            } else {

                $findAuthRuleCount = Db::name('chen_auth_rule')->where([
                    'name' => $name
                ])->count();

                if ($findAuthRuleCount == 0) {//没有规则时,不验证!
                    return true;
                }

                $name = [$name];
            }
        }

        $list   = []; //保存验证通过的规则名
        $groups = Db::name('chen_admin_role')
            ->alias("a")
            ->join('chen_auth_rule r', 'a.role_id = r.id')
            ->where(["a.admin_user_id" => $uid, "r.status" => 1])
            ->column("role_id");
           
        if (in_array(1, $groups)) {
            return true;
        }

        if (empty($groups)) {
            return false;
        }
        $rules = Db::name('chen_auth_access')
            ->alias("a")
            ->join('chen_auth_rule b ', ' a.rule_name = b.name')
            ->where(["a.role_id" => $groups, "b.name" => $name])
            ->select();

        foreach ($rules as $rule) {
            if (!empty($rule['condition'])) { //根据condition进行验证
                $user = $this->getUserInfo($uid);//获取用户信息,一维数组

                $command = preg_replace('/\{(\w*?)\}/', '$user[\'\\1\']', $rule['condition']);
                 return dump($command);//debug
                @(eval('$condition=(' . $command . ');'));
                if ($condition) {
                    $list[] = strtolower($rule['name']);
                }
            } else {
                $list[] = strtolower($rule['name']);
            }
        }

        if (!empty($list)) {
             return true;
        }

         return false;
    }
}

























?>