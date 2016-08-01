<?php
namespace app\api\controller\v1;

use think\Controller;
use think\Db;
use think\Request;

class IndexController extends Controller
{
    public function index()
    {
    	return $this->fetch();
    }
	
	public function phpinfo()
    {
    	return phpinfo();
    }
}
