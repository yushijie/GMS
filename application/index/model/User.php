<?php
namespace app\index\model;

use think\Model;

class User extends Model {
	// birthday读取器
    protected function getBirthdayAttr($birthday)
    {
        return date('Y-m-d', $birthday);
    }
	
	// birthday修改器
    protected function setBirthdayAttr($birthday)
    {
        return strtotime($birthday);
    }
}
