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
// $Id$

return [
	// 全局变量规则定义
    '__pattern__'         => [
        'id'    => '\d+',
    ],
    'user/index'      => 'index/user/index',
    'user/create'     => 'index/user/create',
    'user/add'        => 'index/user/add',
    'user/add_list'   => 'index/user/addList',    
    'user/update/:id' => 'index/user/update',
    'user/delete/:id' => 'index/user/delete',
    'user/:id'        => 'index/user/read',
	
	'index/hello' => 'index/index/hello'
];
