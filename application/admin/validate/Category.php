<?php
namespace app\admin\validate;
use think\Validate;
class Category extends Validate{
    protected $rule = [
        'name'=>'require|max:20',
    ];
    protected $message = [
        'name.require'=>'栏目名称不能为空！！！',
        'name.max'=>'栏目名称长度不能超过20',
    ];
}
?>