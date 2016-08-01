<?php
namespace app\api\validate;

use think\Validate;

class User extends Validate
{
    // 验证规则
    protected $rule = [
        'nickname|昵称' => 'require|min:5',
        'email|邮箱'    => 'require|email',
        'birthday|生日' => 'dateFormat:Y-m-d',
    ];
}