<?php
namespace app\admin\validate;
use think\Validate;
class Tag extends Validate{
    protected $rule = [
        'name'=>'require',
    ];
    protected $message = [
        'name.require'=>'标签名不能为空！！！',
    ];
}