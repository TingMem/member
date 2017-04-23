<?php
namespace Home\Controller;
use Think\Controller;

class UserController extends Controller {
    public function dd_list(){
		header("Content-Type:text/html; charset=utf-8");
		$this->checkadmin();
		$conn=M('cart');
		$config = M('user');
		$admin=$_SESSION['admin'];
		$where['username']=array('eq',$admin);
		
		$rows = $config
		->join('RIGHT JOIN tp_log ON tp_user.id=tp_log.uid')
		->join('RIGHT JOIN tp_product ON tp_log.pid=tp_product.id')
		->where('tp_log.username='.$admin." AND CID <> null")
		->field("tp_user.usercname,tp_log.aid,tp_log.paystatus,tp_log.pid,tp_product.product,tp_log.num,tp_product.url,tp_log.xftime")
		->order("tp_log.aid desc")->select();
		
		$row = $conn->where($where)->order("id desc")->find();
		$row2 = $config->where($where)->field("regtime")->find();
		$rs['c']=date("Y-m-d",$row['jihuotime']);
		$rs['u']=date("Y-m-d",$row2['regtime']);
		
		//var_dump($rows);
		//exit();
		$this->assign('empty','暂无订单');
		$this->assign('rs',$rs);
		$this->assign('lists',$rows);
		$this->display('index:dd_list');
    }	
	
	public function dd_art(){
		header("Content-Type:text/html; charset=utf-8");
		$this->checkadmin();
		$conn=M('cart');
		$config = M('user');
		$admin=$_SESSION['admin'];
		
		$aid=$_GET['aid'];
		$rows = $config
		->join('RIGHT JOIN tp_log ON tp_user.id=tp_log.uid')
		->join('RIGHT JOIN tp_product ON tp_log.pid=tp_product.id')
		->where('tp_log.aid='.$aid)
		->field("tp_user.usercname,tp_log.aid,tp_log.paystatus,tp_product.price,tp_log.pid,tp_product.product,tp_log.num,tp_product.url,tp_log.xftime,tp_log.pay,tp_log.cprice,tp_log.sid,tp_log.status,tp_log.shop_status,tp_product.danwei")
		->order("tp_log.aid desc")->select();
		$row = $conn->where($admin)->order("id desc")->find();
		$row2 = $config->where($admin)->order("id desc")->field("regtime")->find();
		$rs['c']=date("Y-m-d",$row['jihuotime']);
		$rs['u']=date("Y-m-d",$row2['regtime']);
		
		//var_dump($rows);
		//exit();
		$this->assign('rs',$rs);
		$this->assign('lists',$rows);
		//$this->display('index:dd_list');
		$this->display('index:dd_art');	
	}
	
	public function checkadmin(){
		
		$admin=$_SESSION['admin'];
		if(!$admin){
			$this->Error('您还没有登录','/index.php/home/index/login',2);
		}	
	}
	
	
	public function reg(){
		header("Content-Type:text/html; charset=utf-8");
		$this->display('index:reg');
	}
	public function register(){
		$conn = M('user');
		$al['username'] = array('eq',$_POST['username']);
		$row = $conn->where($al)->find();
		if($row){
			$this->error('帐号已存在。');
			exit();
		}
		$config = M('verify');
		$where['call'] = array('eq',trim($_POST['call']));
		$where['rand'] = array('eq',trim($_POST['vcode']));
		$rows = $config->where($where)->order('id desc')->find();
		if(time()>=$rows['subtime'] && time()<=($rows['subtime'])+(60*30)){
			$data['username']=trim($_POST['call']);
			$data['usercname']= $_POST['usercname'];
			$data['level']=0;
			$data['status']=1;
			$data['password'] = md5(trim($_POST['password']));
			$data['tel'] = trim($_POST['call']);
			$data['regtime'] = time();
			$data['card'] = trim($_POST['card']);

			if(!$conn->add($data)){
				$this->error('抱歉，数据写入失败。');
			}else{
				$w['id']=array('eq',$rows['id']);
				$config->where($w)->delete();
				$this->success('注册成功！','/index.php/home/index/login',2);
			}
		}else{
			header("Content-Type:text/html; charset=utf-8");
			$this->Error('抱歉，验证码不正确或已过期');	
		}
	}
	
	public function verify(){
		header("Content-Type:text/html; charset=utf-8");
		$tels = trim(trim($_GET['call']));
		$cfg = M('user');
		if(isset($_GET['call2'])){//修改密码
			$w['username'] = array('eq',$_SESSION['admin']);
			$w['tel'] = array('eq',$_GET['call2']);
			$row = $cfg->where($w)->find();
			echo 333;
			exit();
			
			if(!$row){
				echo 0;
				exit();	
			}
		}else if(isset($_GET['callback'])){//找回密码
			$ww1['username'] = array('eq',trim($_GET['username']));
			$ww1['tel'] = array('eq',I('get.callback'));
			$row2 = $cfg->where($ww1)->find();
			if(!$row2){
				echo 0;
				exit();	
			}
		}
		
		if(!isset($_GET['call2']) && !isset($_GET['callback'])){//注册
			$dds['username'] = $tels; 
			$rs = $cfg->where($dds)->find();
			if($rs){
				echo 0;
				exit();	
			}
		}
		
		
		$verifyData = M('verify');
		$se['call'] = trim($_GET['call']);
		$se['datetime'] = array('between',array((time()-60),time()));
		$resultrow = $verifyData->where($se)->find(); 
		
		if(!$resultrow){
			$vcode = rand(100000,999999);
			$conn = M('verify');
			$data['rand']=$vcode;
			$data['call']=trim($_GET['call']);
			$data['datetime']=time();
			$data['subtime']=time();
			
			//短信后缀广告
			$tips = M('about');
			$cont = $tips->find(4);
			$str = strip_tags($cont['content']);
		
			if($conn->add($data)){
				$info = "【钦州旅游网】您好，您本次验证码为：".$vcode."，验证码有效时间30分钟，请勿将验证码告诉他人。".$str;
				$post_data = array();
				$post_data['userid'] = 1225;
				$post_data['account'] = 'bbwsyw';
				$post_data['password'] = 'qq880225';
				$post_data['content'] = $info; //短信内容需要用urlencode编码下
				$post_data['mobile'] = trim($_GET['call']);
				$post_data['sendtime'] = ''; //不定时发送，值为0，定时发送，输入格式YYYYMMDDHHmmss的日期值
				$url="http://120.26.244.194:8888/sms.aspx?action=send";
				$o='';
				foreach ($post_data as $k=>$v)
				{
				   $o.="$k=".urlencode($v).'&';
				}
				
				$post_data=substr($o,0,-1);
				//var_dump($post_data);
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_POST, 1);
				//curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch, CURLOPT_URL,$url);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //如果需要将结果直接返回到变量里，那加上这句。
				$result = curl_exec($ch);
				$r = strpos($result,'Success');
				if(!$r){
					$rstr = "Fail";	
				}else{
					$rstr =  1;
				}
				//var_dump($result);
				echo $rstr;
			}else{
				echo -1;	
			}
		}else{
				echo 0;	
		}
	}
	
	public function xuzhi(){
		$conn = M('About');
		$row = $conn->where("id = 2")->find();
		$this->assign('body',$row);
		$this->display("index:VipHelp");	
	}
	
	
	public function spadmin_list(){
		$conn = M('product');
		if(isset($_GET['type'])){
			$type['sjtype'] = $_GET['type'];
			$rows = $conn->where($type)->order("id desc")->select();
		}else{
			$rows = $conn->order("id desc")->select();	
		}
		
		$this->assign('lists',$rows);
		$this->assign('gtype',$_GET['type']);
		$this->display('index:spadmin_list');
		
	}
	
	public function spadmin_search(){
		$conn = M('product');
		$where['shopCName'] = array('like','%'.$_POST['search'].'%');
		$rows = $conn->where($where)->order("id desc")->select();
		//var_dump($rows);
		$this->assign('lists',$rows);
		$this->assign('keyword',$_POST['search']);
		$this->display('index:spadmin_search');
		
	}
	
	public function spadmin_art(){
		$conn = M('product');
		$id = $_GET['id'];
		$where['tp_product.id'] = array('eq',$id);
		$row = $conn
		->join("LEFT JOIN tp_user ON tp_user.id=tp_product.uid")
		->field("tp_user.pic,tp_product.id,tp_product.product,tp_product.price,tp_product.shopAddress,tp_product.sjtype,tp_product.body,tp_product.maxNum,tp_product.url,tp_product.danwei,tp_product.shopCName,tp_product.runTime")
		->where($where)->select();
		//var_dump($row);
		$this->assign('lists',$row);
		$this->display('index:spadmin_art');
	}
	
	
	public function spadmin_artsave(){
		$conn = M('log');
		$cn = M('product');
		$cfg = M('user');
		$id = $_POST['pid'];
		$w['id'] = array('eq',$id);
		$rows = $cn->where($w)->find();
		$c['id'] = $rows['uid'];
		$row = $cfg->where($c)->find();
		if($row['cartstatus']!=0){
			$mp = $rows['price'] * $_POST['goNum'] * ($row['zhekou']/10);
		}else{
			$mp = $rows['price'] * $_POST['goNum'];
		}
		$data['uid'] = $rows['uid'];
		$data['sid'] = date('Ymd',time().time().rand(10000,99999));
		$data['pid'] = $id;
		$data['xftype'] = 0;
		$data['username'] = $row['username'];
		$data['usercname'] = $row['usercname'];
		$data['zhekou'] = $row['zhekou'];
		$data['xftime'] = time();
		$data['xfaddress'] = $rows['shopAddress'];
		$data['logtime'] = time();
		$data['price'] = $rows['price'];
		$data['status'] = 0;
		$data['num'] = $_POST['goNum'];
		$data['danwei'] = $rows['danwei'];
		$data['shopname'] = $rows['product'];
		$data['paystatus'] = 0;
		$data['cprice'] = $mp;
		$data['shop_status'] = 0;
		
		if($conn->add($data)){
			$this->Success();
		}else{
			$this->Error('数据插入失败');	
		}
		
	}
	

	
public function returnshow(){
	$this->display('index:returnpwd');
	exit();	
}	
	
//找回密码
	public function returnpwd(){
		$conn = M('user');
		$al['username'] = array('eq',$_POST['username']);
		$al['tel'] = array('eq',$_POST['call']);
		$row = $conn->where($al)->find();
		if(!$row){
			$this->error('帐号信息不正确。');
			exit();
		}
		$config = M('verify');
		$where['call'] = array('eq',trim($_POST['call']));
		$where['rand'] = array('eq',trim($_POST['vcode']));
		$rows = $config->where($where)->order('id desc')->find();
		if(time()>=$rows['subtime'] && time()<=($rows['subtime'])+(60*30)){
			$wh['id'] = array('eq',$row['id']);
			$data['password'] = md5(trim($_POST['password']));
			if(!$conn->where($wh)->save($data)){
				//echo $row['id'];
				$this->error('新密码不能与旧密码一致。');
				exit();
			}else{
				$w['id']=array('eq',$rows['id']);
				$config->where($w)->delete();
				$this->success('密码修改成功！','/index.php/home/index/login',2);
			}
		}else{
			header("Content-Type:text/html; charset=utf-8");
			$this->Error('抱歉，验证码不正确或已过期');
			exit();
		}
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}