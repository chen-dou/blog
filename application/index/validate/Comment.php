<?php
namespace app\index\validate;
use think\Validate;
class Comment extends Validate{
    protected $rule = [
        'content'=>'require|min:5',
    ];
    protected $message = [
        'content.require'=>'评论不能为空',
        'content.min'=>'评论内容长度不够',
    ];
}
?>