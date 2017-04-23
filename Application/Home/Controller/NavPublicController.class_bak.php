<?php
namespace Home\Controller;
use Think\Controller;

class NavPublicController extends Controller {
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
		
		$where['tid']=0;  //一级菜单
		$rows = $cfg->where($where)->select();
		if(isset($_GET['tid'])){
			$tid1 = $_GET['tid'];
			
		}else{
			$tid1 = '5';	
		}
		if(isset($_GET['thisid'])){
			$thisid = $_GET['thisid'];
			
		}
		
		if(!isset($_GET['tid']) && !isset($_GET['thisid'])){
			$tid1 =  5;
			$thisid = 13;
			
		}
		
		$w['tid'] = $tid1;
		$w['level']= array('ELT',$_SESSION['level']);
		$rowk = $cfg->where($w)->order("px asc")->select(); 
		

			$this->assign('type1',$tid1);
			$this->assign('thisid',$thisid);
			$this->assign('type2',$rowk);
			$this->assign('adminmenu',$rows);
		
	}
}