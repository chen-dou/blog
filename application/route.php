<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

return [
    '__pattern__' => [
        'name' => '\w+',
    ],
    '[hello]'     => [
        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
        ':name' => ['index/hello', ['method' => 'post']],
    ],
    '[cate]'     => [
        ':cate_id'   => ['index/lst/index', ['method' => 'get'], ['cate_id' => '\d+']],
    ],
    '[article]'     => [
        ':ar_id'   => ['index/content/index', ['method' => 'get'], ['ar_id' => '\d+']],
    ],
    '[tag]'     => [
        ':tag_id'   => ['index/lst/index', ['method' => 'get'], ['tag_id' => '\d+']],
    ]
];
