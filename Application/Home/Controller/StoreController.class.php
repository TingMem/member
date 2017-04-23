<?php
namespace Home\Controller;
use Think\Controller;

class StoreController extends Controller {

	public function storecheck(){
		$conn = M('cart');
		$sid = $_GET['sid'];
		$where['sid'] = $sid;
		//$where['startime'] = array('bettwen',array())
		$rows = $conn->where($where)->find();
		if($rows){
			echo 1;	
			exit();
		}else{
			echo 0;	
			exit();
		}
	}
	
	
	public function storeAppart(){
		$conn = M('cart');
		$sid = $_GET['sid'];
		$where['tp_cart.sid'] = array('eq' ,$sid);
		$where['u.cartstatus'] = array('eq',1);
		$rows = $conn
		->join("LEFT JOIN tp_user as u ON tp_cart.uid = u.id")
		->where($where)->field("u.username,u.card,u.tel,u.usercname,u.pic,u.about,tp_cart.startime,tp_cart.endtime")->find();
		if($rows){
			if(time()>=$rows['startime'] && time()<=$rows['endtime']){
				$arr = array("username"=>$rows['username'],"card"=>$rows['card'],"tel"=>$rows['tel'],"usercname"=>$rows['usercname'],"userpic" =>$rows['pic'],"about"=>$rows['about']);
				$arr = json_encode($arr);
				echo $arr;
				exit();
			}else{
				$arr = array("username"=>"此卡已过期","card"=>"此卡已过期","tel"=>"此卡已过期","usercname"=>"此卡已过期","userpic" =>$rows['pic'],"about"=>"此卡已过期，请勿继续消费！");
				$arr = json_encode($arr);
				echo $arr;
				exit();	
			}

		}else{
			echo 0;	//卡号不存在
			exit();
		}
	}
	
	
		public function storeAppuse(){
			
			if($_POST['shopid']==null||$_POST['pid']==null){
				echo 404;
				exit();	
			}
			$conn = M('log');
			$cfg = M('user');
			$w['username'] = array('eq',$_POST['username']);
			
			$row = $cfg->where($w)->find();

			$data['uid'] = $_POST['pid'];
			$data['sid'] = date('YmdHis',time()).rand(100000,999999);
			$data['pid'] = $row['id'];
			$data['xftype'] = 1;
			$data['username'] = $_POST['username'];
			$data['usercname'] = $_POST['usercname'];
			$data['xftime'] = time();
			$data['xfaddress'] = $row['address'];
			$data['usercname'] = $_POST['usercname'];
			$data['logtime'] = time();
			$data['status'] = 1;
			$data['price'] = 0;
			$data['pay'] = '会员卡';
			$data['num'] = 1;
			$data['danwei'] = '次';
			$data['shopname'] = $_POST['shangjia'];
			$data['paystatus'] = 1;
			$data['cprice'] = 0;
			$data['shop_status'] = 0;
			//验证该用户当天是否已经消费过
			$whe['username'] = array('eq',$_POST['username']);
			$whe['uid'] = array('eq',$_POST['pid']);
			$whe['xftime'] = array('between',array(strtotime(date('Y-m-d',time())),(strtotime(date('Y-m-d',time()))+(3600*24))));
			
			$row = $conn->where($whe)->find();
			if(!$row){
				$rows = $conn->add($data);
				if($rows){
					echo 1; //消费成功
					exit();
				}else{
					echo 0;	//写入发生异常
					exit();
				}
			}else{
				echo 4;	 //不允许当天重复消费
				exit();
			}
			
	}
	
	
	
	
	
	
	
	
	
	
	
	
}