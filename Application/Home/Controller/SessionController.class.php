<?php
namespace Home\Controller;
use Think\Controller;

class SessionController extends Controller {

//商家权限限定	
    public function chksession(){
		$u = $_SESSION['admin'];
		$l = $_SESSION['level'];
		if($u=='' ){
			$this->error('您还没有登录','/index.php/home/index/login')	;
			exit();
		}else if($l<5){
			$this->error('您没有权限访问')	;	
			exit();
		}
    }
	
}