<?php
namespace Home\Controller;
use Think\Controller;

class NavPublicController extends Controller {
	public function _initialize(){
		$username=$_SESSION['admin'];
		if($username==''){
			if(Think.CONTROLLER_NAME=='manage'){
				$this->error('您还没有登录','/index.php/Home/LoginAction/adminlogin',1);	
			}else{
				$this->error('您还没有登录','/index.php/Home/Index/Login',1);	
			}
			
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
		
		header('Content-Type:text/html; charset="utf-8"');


		if($_SESSION['admin']==null){
			$this->error("您的登录已过期","/index.php/home/LoginAction/adminlogin",1);
			exit();
		}
		
		
		$cc = ACTION_NAME;
		
		//var_dump($c);
		$where['tid']=0;  //一级菜单
		$rows = $cfg->where($where)->select();

		$wwws['level']= array('ELT',$_SESSION['level']);//二级菜单
		$ttt = $cfg->where($wwws)->order("px asc")->select(); 
		
		$rs = $cfg->where("action = '{$cc}'")->find();
		
			$this->assign('cc',$cc);
			$this->assign('c',$rs);
			$this->assign('ttt',$ttt);
			$this->assign('adminmenu',$rows);
		
	}

	
}