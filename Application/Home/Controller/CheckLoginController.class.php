<?php
namespace Home\Controller;
use Think\Controller;

class CheckLoginController extends Controller {
	public function _initialize(){
		$username=$_SESSION['admin'];
		if($username==''){
			$this->error('您还没有登录','/index.php/Home/Vip/adminlogin',1);	
		}
		$cfg = M('type');
		if($_SESSION['level']<10 && $_SESSION['level']>8){
			$where['level'] = array('ELT',9);
		}else if($_SESSION['level']=10){
			$where['level'] = array('ELT',10);
		}else{
			$this->error("您没有权限访问此页面");
			exit();
		}
		

		if($_SESSION['admin']==null){
			$this->error("您的登录已过期","/index.php/home/LoginAction/adminlogin",1);
			exit();
		}
		
	}
}