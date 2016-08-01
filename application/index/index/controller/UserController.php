<?php
namespace app\index\controller;

use app\index\model\User;

class UserController
{
    // 新增用户数据
public function add(){
	$user = new User;
    if ($user->validate(true)->save(input('post.'))) {
        return '用户[ ' . $user->nickname . ':' . $user->id . ' ]新增成功';
    } else {
        return $user->getError();
    }
}
	
	// 批量新增用户数据
	public function addList(){
    	$user = new User;
    	$list = [
			['nickname' => '张三', 'email' => 'zhanghsan@qq.com', 'birthday' => '1988-01-15'],
        	['nickname' => '李四', 'email' => 'lisi@qq.com', 'birthday' => '1990-09-19'],
   		];
    	if ($user->saveAll($list)) {
        	return '用户批量新增成功';
    	} else {
        	return $user->getError();
    	}
	}
	
// 读取用户数据
public function read($id='')
{
    $user = User::get($id);
    echo $user['nickname'] . '<br/>';
    echo $user['email'] . '<br/>';
    echo $user['birthday'] . '<br/>';
}

// 获取用户数据列表
public function index()
{
    $list = User::all();
    foreach ($list as $user) {
        echo $user->nickname . '<br/>';
        echo $user->email . '<br/>';
        echo $user->birthday . '<br/>';
        echo $user->create_time . '<br/>';
        echo $user->update_time . '<br/>';
        echo '----------------------------------<br/>';
    }
}

// 更新用户数据
public function update($id)
{
    $user           = User::get($id);
    $user->nickname = '刘晨';
    $user->email    = 'liu21st@gmail.com';
    if (false !== $user->save()) {
        return '更新用户成功';
    } else {
        return $user->getError();
    }
}

// 删除用户数据
public function delete($id)
{
    $user = User::get($id);
    if ($user) {
        $user->delete();
        return '删除用户成功';
    } else {
        return '删除的用户不存在';
    }
}

}
