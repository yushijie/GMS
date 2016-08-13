<?php
namespace app\api\controller\v1;

use app\api\model\User;

class UserController
{
	//前置函数设置
//	protected $beforeActionList = [
//      //'first',
//      //'second' =>  ['except'=>'hello'],
//      'get_token_pn'  =>  ['only'=>'update'],
//  ];
	
	//token检测函数
	protected function get_token_pn($data){
		$pn = substr($data['token'], 0, 11);
		$token = cache('token_'.$pn);
		if($token){
			$pn = substr($token, 0, 11);
			return $pn;
		}else{
			return json([
				'return_code' => 'FAIL',
				'return_msg' => '请重新登陆',
			],200);
		}
	}
	
	//
	protected function send_code($pn){
		//
		import('taobao-sdk-PHP/top/request/AlibabaAliqinFcSmsNumSendRequest', EXTEND_PATH);
		import('taobao-sdk-PHP/top/TopClient.php', EXTEND_PATH);
		
		
		$c = new TopClient;
		$c ->appkey = $appkey ;
		$c ->secretKey = $secret ;
		$req = new AlibabaAliqinFcSmsNumSendRequest;
		$req ->setExtend( "" );
		$req ->setSmsType( "normal" );
		$req ->setSmsFreeSignName( "芯动科技" );
		$req ->setSmsParam( "{number:'111111'}" );
		$req ->setRecNum( $pn );
		$req ->setSmsTemplateCode( "SMS_12875803" );
		$resp = $c ->execute( $req );
		
		return $resp;
	}
	
	
// 新增用户数据
public function add(){
$data = input('post.');
if($data['vc_code'] == cache('phone_'.$data['phone_number'])){
	$user = new User;
    if ($user->data($data)->allowField(true)->validate(true)->save()) {
    	
		cache('phone_'.$data['phone_number'],NULL);
		
		return json([
			'return_code' => 'SUCCESS',
			'return_msg' => '新增用户成功',
			'user_id' => $user->id,
		],200);
    } else {
        return json([
			'return_code' => 'FAIL',
			'return_msg' => $user->getError(),
		],200);
    }
	
}else{
	return json([
			'return_code' => 'FAIL',
			'return_msg' => '验证码错误'.$data['vc_code'].' '.$data['phone_number'],
		],200);
}

}
	
// 读取用户数据
public function read($id = 1)
{
    $user = User::get($id);
    if ($user) {
		return json($user);
	} else {
		return json(['error' => '用户不存在'], 404);
	}
}

// 获取手机验证码
public function vccode()
{
	$phone = input('phone_number');
    $user = User::get(['phone_number' => $phone]);
	if($user){
		return json([
			'return_code' => 'FAIL',
			'return_msg' => '用户已存在',
		],200);
	}else{
		//验证码发送
		$code = '111111';
		$test_rs = $this -> send_code($phone);
	
		// 设置缓存数据30分钟
		cache('phone_'.$phone, $code, 60*30);

		return json([
			'return_code' => 'SUCCESS',
			'return_msg' => '验证码发送成功',
			'vc_phone' => $phone,
			'test_rs' => $test_rs,
		],200);
	}
	
}

// 查询手机验证码
public function get_vccode()
{
	$phone = 'phone_'.input('phone_number');
    
	if(cache($phone)){

	return json([
		'return_code' => 'SUCCESS',
		'return_msg' => '验证码查询成功',
		'vc_code' => cache($phone),
		'vc_phone' => $phone
	],200);
	
	}else{
		
	return json([
		'return_code' => 'FAIL',
		'return_msg' => '此手机无验证码',
		'vc_phone' => $phone
	],200);
	
	}
}

// 登录
public function login()
{
	$data = input('post.');
	$user = User::get(['phone_number' => $data['phone_number']]);
	if($user){
		if($user['password'] == $data['password']){
			//生成token
			$token = $user['phone_number'].time().rand(1000, 9999);
			//存储token时效1周
			$token_key = 'token_'.$user['phone_number'];
			cache($token_key,$token,7*24*60*60);
			//
			return json([
				'return_code' => 'SUCCESS',
				'return_msg' => '登录成功',
				'token' => $token,
			],200);
		}else{
			return json([
				'return_code' => 'FAIL',
				'return_msg' => '登录失败,密码错误',
			],200);
		}
	}else{
		return json([
			'return_code' => 'FAIL',
			'return_msg' => '登录失败，用户名不存在',
		],200);
	}
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
	return json($list);
}

// 更新用户数据
public function update()
{
	$data = input('post.');
	$pn = $this -> get_token_pn($data);
	
	$user = User::get(['phone_number' => $pn]);
	if ($user->allowField(true)->validate(true)->save($data)) {
    		
		return json([
			'return_code' => 'SUCCESS',
			'return_msg' => '用户信息更新成功',
			'user_id' => $user->id,
		],200);
    } else {
        return json([
			'return_code' => 'FAIL',
			'return_msg' => $user->getError(),
		],200);
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
