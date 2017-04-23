<?php
namespace Home\Controller;
use Think\Controller;

class LoginActionController extends Controller {
	public function adminlogin(){
		$this->display('manage:login');	
	}
}