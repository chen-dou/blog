<?php
namespace app\index\validate;
use think\Validate;
class Member extends Validate{
    protected $rule = [
        'telnum'=>'require|unique:member',
        'password'=>'require',
        'name'=>'require|unique:member',
        'captcha'=>'require|captcha',
    ];
    protected $message = [
        'telnum.require'=>'0_号码不能为空',
        'telnum.unique'=>'0_该号码已注册',
        'password.require'=>'1_密码不能为空',
        'name.require'=>'3_名称不能为空',
        'name.unique'=>'3_名称已存在',
        'captcha.require'=>'2_验证码不能为空',
        'captcha.captcha'=>'2_验证码不正确',
    ];
    protected $scene = [
        'add'=>['telnum','password','name'],
        'login'  =>  ['telnum'=>'require','password','captcha'],
    ];
}
?>