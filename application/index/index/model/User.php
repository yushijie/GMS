<?php
namespace app\index\model;

use think\Model;

class User extends Model {
	//protected $dateFormat = 'Y/m/d';
    protected $type       = [
        // 设置birthday为时间戳类型（整型）
        'birthday' => 'timestamp:Y/m/d',
        'create_time' => 'timestamp',
        'update_time' => 'timestamp',
    ];
}
