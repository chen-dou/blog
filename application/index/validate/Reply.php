<?php
namespace app\index\validate;
use think\Validate;
class Reply extends Validate{
    protected $rule = [
        'content'=>'require|min:5',
    ];
    protected $message = [
        'content.require'=>'回复不能为空',
        'content.min'=>'回复内容不够长度',
    ];
}
?>