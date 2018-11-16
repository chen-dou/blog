<?php
namespace app\admin\validate;
use think\Validate;
class Admin extends Validate{
    protected $rule = [
        'user'=>'require|unique:admin',
        'password'=>'require',
        'confirm_password'=>'require|confirm:password',
        'captcha'=>'require|captcha',
    ];
    protected $message = [
        'user.require'=>'用户名不能为空！！！',
        'user.unique'=>'用户名不能重复',
        'password.require'=>'密码不能为空！！！',
        'captcha.require'=>'验证码不能为空',
        'captcha.captcha'=>'验证码不正确',
        'confirm_password.require'=>'确认密码不能为空！！！',
        'confirm_password.confirm'=>'两次密码不一致！！！',
    ];
    protected $scene = [
        'login'=>['user'=>'require','password','captcha'],
        'edit'  =>  ['user','password','confirm_password'],
        'add'=>['user','password','confirm_password'],
    ];
}
?>