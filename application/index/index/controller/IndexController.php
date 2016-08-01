<?php
namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Request;

class IndexController extends Controller
{
    public function index()
    {
    	return $this->fetch();
    }
	
	public function hello(Request $request, $name = 'world!')
    {
		echo 'url: ' . $request->url() . '<br/>';
		
    	$data = Db::name('user')->find();
    	return json_encode($data);
    }
}
