<?php
namespace Home\Controller;
use Think\Controller;

class UserCheckController extends Controller {

//商家权限限定	
    public function chksession(){
		$u = $_SESSION['admin'];
		if($u=='' ){
			$this->error('您还没有登录','/index.php/home/index/login')	;
			exit();
		}
    }
	
}