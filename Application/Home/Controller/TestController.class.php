<?php
namespace Home\Controller;
use Think\Controller;


require_once("/Public/yunpay/yun.config.php");
require_once("/Public/yunpay/lib/yun_md5.function.php");

class TestController extends Controller {
	
	public function paytest(){
		

		$cfg = M('user');
		$viplog = M('viplog');
		if($_SESSION['admin']==null){
			$this->error('系统未检测到您登录！。');//登录检测
			exit();
		}


		$wa['Sid'] = array('eq',$_POST['sid']);
		$rrw = $viplog->where($wa)->find();//查询订单是否创建成功


//如果没有创建，再次尝试创建，如果该用户已经创建有订单，则跳过下方二次创建，直接建立支付请求

		if(!$rrw){//没有创建成功，再次尝试创建（二次创建订单）
			$ect = M("viplog");
			$log['Product'] = "惠民卡绑定";
			$log['Uid'] = $rs['id'];
			$log['Price'] = trim($_POST['price']);
			$log['Sid'] = $_POST['sid'];
			$log['createtime'] = time();
			$log['paystatus'] = 0;
			if(isset($_POST['xh'])){
				$log['xh'] = $_POST['xh'];
			}
			if(!$ect->add($log)){ //生成失败，写错误日志记录下来
				$file = $_SERVER['DOCUMENT_ROOT']."/Public/log/err_log.txt";
				$cont = json_encode($log);
				//var_dump($cont);
				file_put_contents($file,$cont.PHP_EOL,FILE_APPEND);
				
				echo "<script>alert('警告：您的订单异常，请勿继续支付');</script>";
				$this->error();	
				exit();
			}
			$rowq = $viplog->where($wa)->find();//再次查询订单是否生成成功，如果还是失败，那就报错。并返回原来页面
			
			
			if(!$rowq){
				echo  "<script>alert('提示：经过两次尝试，您的订单扔创建失败，请重新登录再做尝试。')</script>"	;
				$this->error();
				exit();
			}
		}
		
		
/**************************请求参数**************************/	
		
        //商户订单号
        $out_trade_no = trim($_POST['sid']);//商户网站订单系统中唯一订单号，必填

        //订单名称
        $subject = "钦州旅游惠民卡";//必填
		
		
        //付款金额
        $total_fee = $_POST['price'];//必填 需为整数

        //订单描述

        $body = "";
		
		
		//服务器异步通知页面路径
        $nourl = "http://hmk.qzlyw.gov.cn/index.php/home/test/no_url";
        //需http://格式的完整路径，不能加?id=123这类自定义参数

        //页面跳转同步通知页面路径
        $reurl = "http://hmk.qzlyw.gov.cn/index.php/home/test/pay_re_url";
        //需http://格式的完整路径，不能加?id=123这类自定义参数，不能写成http://localhost/
       
		//商品展示地址
        $orurl = "";
        //需http://格式的完整路径，不能加?id=123这类自定义参数，如原网站带有 参数请彩用伪静态或短网址解决

        //商品形象图片地址
        $orimg = "";
        //需http://格式的完整路径，必须为图片完整地址

/************************************************************/
$yun_config['partner']		= '2232146337652877';

//安全检验码
$yun_config['key']			= 'hsdYB37P3YKJ4A3TMiF7py99SwsBn8Rj';

//云会员账户（邮箱）
$seller_email = '28747267@qq.com';

		//构造要请求的参数数组，无需改动
		$parameter = array(
				"partner" => trim($yun_config['partner']),
				"seller_email"	=> $seller_email,
				"out_trade_no"	=> $out_trade_no,
				"subject"	=> $subject,
				"total_fee"	=> $total_fee,
				"body"	=> $body,
				"nourl"	=> $nourl,
				"reurl"	=> $reurl,
				"orurl"	=> $orurl,
				"orimg"	=> $orimg
		);
		
		foreach ($parameter as $pars) {
				$myparameter.=$pars;
			}
				$Sign = md5($myparameter."i2eapi".trim($yun_config['key']));
		
		
		//建立请求
		
		$html_text = i2e($parameter, "支付进行中...");
		echo $html_text;

	}
	
	function md5Verify($i1, $i2,$i3,$key,$pid) {
		$prestr = $i1 . $i2.$pid.$key;
		$mysgin = md5($prestr);
	
		if($mysgin == $i3) {
			return true;
		}
		else {
			return false;
		}
	}

	public function xiaoxi($tel,$usercname,$sid){
		$vip = A('vip');
		$vip->xiaoxi($tel,$usercname,$sid);
	}

//付款后服务器回调日志
	public function pay_log($a,$s,$p){
		
		$logid = $a;
		$time = date("Y-m-d H:i:s",time());
		$seradd = $s;
		$file=$p;
//file_put_contents($_SERVER['DOCUMENT_ROOT']."/paylog/paylog.txt", file_get_contents("php://input")."\n", FILE_APPEND);
		$str = array("logid"=>$logid,"time"=>$time,"seradd"=>$seradd);
		$cont = json_encode($str);
		//var_dump($cont);
		file_put_contents($file,$cont.PHP_EOL,FILE_APPEND);
	}



//支付成功后同步响应
	
	public function pay_re_url(){

		
	$file = $_SERVER['DOCUMENT_ROOT']."/Public/log/pay_log.txt";
	$this->pay_log($_REQUEST['i2'],$_SERVER['HTTP_REFERER'],$file);
	
	$yun_config['partner']		= '2232146337652877';

	//安全检验码
	$yun_config['key']			= 'hsdYB37P3YKJ4A3TMiF7py99SwsBn8Rj';
		//计算得出通知验证结果
		$yunNotify = $this->md5Verify($_REQUEST['i1'],$_REQUEST['i2'],$_REQUEST['i3'],$yun_config['key'],$yun_config['partner']);
		if($yunNotify) {//验证成功
		
			//商户订单号
			$out_trade_no = $_REQUEST['i2'];
			
			//云支付交易号
			$trade_no = $_REQUEST['i4'];
		
			//价格
			$yunprice=$_REQUEST['i1'];
		
			header("Content-Type:text/html; charset=utf-8");//设置编码
			$username = iconv('gbk', 'utf-8', $_SESSION['admin']);//强制转换为UTF8编码
			$cfg = M('cart');
			$cfg2 = M('user');
			$static['username'] = 'internet';
			$rrr = $cfg2->where($static)->find();
			$arra = explode("|",$rrr['fanwei']);	
			//$w['lock']=array('eq',0);
			//$w['sid']=array('between',array($arra[0],$arra[1]));
			$w = "`lock` = 0 and ";
			$sql='';
			$count = count($arra);
			for($i=1;$i<=$count;$i=$i+2){
				if($count>2){
					if($i+1<$count){
						if($i>2){
							$sql = $sql."`sid` between {$arra[$i-1]} and {$arra[$i]} or ";
						}else{
							$sql = $sql."(`sid` between {$arra[$i-1]} and {$arra[$i]} or ";
						}
					}else{
						$sql = $sql."`sid` between {$arra[$i-1]} and {$arra[$i]})";
					}
				}else{
					$sql = $sql."`sid` between {$arra[$i-1]} and {$arra[$i]}";//解决如果数组长度只有2时导致sql后面多一半)问题	
				}
			}
			$query = $w.$sql;
			$row = $cfg->where($query)->order('sid asc')->find();
			
			//获取用户信息，写订单时方便记录
			$conn = M("user");
			$where['username'] = array('eq',$username);
			$rows = $conn->where($where)->find();
			$efg = M('viplog');
			$ww['Sid'] = array('eq',$_REQUEST['i2']);
			$mm = $efg->where($ww)->find();
			if($rows['cartstatus']==1){
				//echo "该会员已经绑定会员卡，请勿重复操作！";
				$this->error('绑定成功。',"/index.php/home/index/UserSet",1);
				exit();	
			}
		  

			$data['cid'] = $row['id'];
			$data['cartstatus'] = 1;
			
			if($mm['xh']!=null || $mm['xh']!=''){
				$data['about'] = '[学生证]号：'.$mm['xh'];
				$d['etype'] = 11607;
			}else{
				$data['about'] = '通过[身份证]验证';
			}
			if($conn->where($where)->save($data)){
				$d['uid']=	$rows['id'];
				$d['username'] = $rows['username'];
				$d['startime'] = time();
				$d['endtime'] = time()+3600*24*365;
				$d['jihuotime'] = time();
				$d['lock'] = 1;
				$d['zuozhe'] = $_SESSION['admin'];
				
				$wh['id'] = $row['id'];
				if($cfg->where($wh)->save($d)){
					$a = A('vip');
					$a->xiaoxi($rows['tel'],$rows['usercname'],$row['sid']);
					
					
					$dd['paystatus'] = 1;
					$dd['PayTime'] = time();
					$efg->where($ww)->save($dd);
					$this->success('绑定成功。',"/index.php/home/index/UserSet",1);
					exit();
				}else{
					
				$file = $_SERVER['DOCUMENT_ROOT']."/Public/log/lock_err.txt";
				$this->pay_log($_REQUEST['i2'],$_SERVER['HTTP_REFERER'],$file);
				$ection->add($dat);
					echo "<script>alert('会员卡锁定失败,您必须联系管理员：13307771522')</script>";
					$this->error();
				}
			}else{
				$file = $_SERVER['DOCUMENT_ROOT']."/Public/log/err_log.txt";
				$this->pay_log($_REQUEST['i2'],$_SERVER['HTTP_REFERER'],$file);
				$this->error();
				echo "<script>alert('卡号期限错误,您必须联系管理员：13307771522')</script>";
			}	
	
			}
			else {
				//验证失败
				$file = $_SERVER['DOCUMENT_ROOT']."/Public/log/check_fail.txt";
				$this->pay_log($_REQUEST['i2'],$_SERVER['HTTP_REFERER'],$file);
				$this->error();
				echo "<script>alert('订单验证失败！请致电客服人员：0777-2807328');</script>";
			}	
	}
	



		//支付异步验证
		public function no_url(){

		$file = $_SERVER['DOCUMENT_ROOT']."/Public/log/no_pay.txt";
		$this->pay_log($_REQUEST['i2'],$_SERVER['HTTP_REFERER'],$file);	
		
		$yun_config['partner']		= '2232146337652877';

		//安全检验码
		$yun_config['key']			= 'hsdYB37P3YKJ4A3TMiF7py99SwsBn8Rj';
		//计算得出通知验证结果
		$yunNotify = md5Verify($_REQUEST['i1'],$_REQUEST['i2'],$_REQUEST['i3'],$yun_config['key'],$yun_config['partner']);
		//$yunNotify = 1;
		if($yunNotify) {//验证成功
	
			//商户订单号
			$out_trade_no = $_REQUEST['i2'];
		
			//云支付交易号
			$trade_no = $_REQUEST['i4'];	
			//价格
			$yunprice=$_REQUEST['i1'];
			//$yunprice = 36 ;
			
			//查询通知的订单记录
			$cfg = M("viplog");
			$cfg2 = M('user');//需要操作3个表以实现会员卡绑定给指定用户
			$cfg3 = M('cart');
			
			$w['Sid'] = array('eq',$out_trade_no);
			$row = $cfg->where($w)->find();
			
			$file = $_SERVER['DOCUMENT_ROOT']."/Public/log/success.txt";
			$this->pay_log($_REQUEST['i2'],$_SERVER['HTTP_REFERER'],$file);	
			
			if($row['price']==$yunprice){
				$w2['id']=array('eq',$row['uid']);
				$row2 = $cfg2->where($w2)->find();//获取下单用户信息
				
				if($row2['cartstatus']==1){
					//echo "该会员已经绑定会员卡，请勿重复操作！";
					$this->error('绑定成功。',"/index.php/home/index/UserSet",1);
					exit();	
				}
				
				$rrr = $cfg2->where("username = 'internet'")->find();
				$arra = explode("|",$rrr['fanwei']);//获取网络销售范围
				
				$w = "`lock` = 0 and ";
				$sql='';
				$count = count($arra);
				for($i=1;$i<=$count;$i=$i+2){
					if($count>2){
						if($i+1<$count){
							if($i>2){
								$sql = $sql."`sid` between {$arra[$i-1]} and {$arra[$i]} or ";
							}else{
								$sql = $sql."(`sid` between {$arra[$i-1]} and {$arra[$i]} or ";
							}
						}else{
							$sql = $sql."`sid` between {$arra[$i-1]} and {$arra[$i]})";
						}
					}else{
						$sql = $sql."`sid` between {$arra[$i-1]} and {$arra[$i]}";//解决如果数组长度只有2时导致sql后面多一半)问题	
					}
				}
				$query = $w.$sql;
				//$row = $cfg->where($query)->order('id asc')->limit(1)->find();	
					
				//$w3['lock']=array('eq',0);
				//$w3['sid'] = array('between',array($arra[0],$arra[1]));
				$row3 = $cfg3->where($query)->order('sid asc')->find();//获取当前最小卡号（按顺序绑定给用户）
				
				//更新用户状态
				$udata['cid'] = $row3['id'];
				$udata['cartstatus'] = 1;
				if($row['xh']==null || $row['xh']==''){
					$udata['about'] = '通过[身份证]验证';
				}else{
					$udata['about'] = '[学生证]号：'.$row['xh'];
					$cdata['etype'] = '11607';
				}
				$u = $cfg2->where($w2)->save($udata);
				
				//更新惠民卡状态
				$cdata['uid'] = $row2['id'];
				$cdata['username'] = $row2['username'];
				$cdata['startime'] = time();
				$cdata['endtime'] = time()+3600*24*365;
				$cdata['jihuotime'] = time();
				$cdata['lock'] = 1;
				$cdata['zuozhe'] = 'internet';
				
				$ww['id'] = array('eq',$row3['id']);
				$c = $cfg3->where($ww)->save($cdata);
				
				//更新订单信息
				
				$wq['Sid'] = array('eq',$_REQUEST['i2']);
				$vdata['paystatus'] = 1;
				$vdata['PayTime'] = time();
				$v = $cfg->where($wq)->save($vdata);
				
				
				//var_dump($row3);
				//全部更新成功
				if($u && $c && $v){
					$a = A('vip');
					$a->xiaoxi($row2['tel'],$row2['usercname'],$row3['sid']);
					$this->success('绑定成功。',"/index.php/home/index/UserSet",1);
					exit();
				}else{
					
					//付款成功绑定失败，写入错误记录
						$file = $_SERVER['DOCUMENT_ROOT']."/Public/log/lock_errlog.txt";
						$this->pay_log($_REQUEST['i2'],$_SERVER['HTTP_REFERER'],$file);	
						$this->error();
						echo "<script>alert('会员卡锁定失败,您必须联系管理员：13307771522')</script>";
						//exit();
				}
						
			}
				
		}
		else {
			//验证失败
			//echo "fail";//请不要修改或删除
					//付款成功绑定失败，写入错误记录
						$file = $_SERVER['DOCUMENT_ROOT']."/Public/log/check_fail.txt";
						$this->pay_log($_REQUEST['i2'],$_SERVER['HTTP_REFERER'],$file);	
						echo "<script>alert('付款验证失败：13307771522')</script>";
						$this->error();
						exit();
		
		
			//调试用，写文本函数记录程序运行情况是否正常
			//logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
		}
		
			
		}	
}