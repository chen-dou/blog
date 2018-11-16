<?php
namespace app\admin\validate;
use think\Validate;
class Flink extends Validate{
    protected $rule = [
        'name'=>'require|unique:flink',
        'url'=>'require',
        'sort'=>'require'
    ];
    protected $message = [
        'name.unique' => '链接名称不能重复复！！！',
        'name.require'=>'友情链接名称不能为空！！！',
        'url.require'=>'链接不能为空！！！',
        'sort.require'=>'排序不能为空！！！',
    ];
}
?>