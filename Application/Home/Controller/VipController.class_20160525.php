<?php
namespace Home\Controller;
use Think\Controller;

class VipController extends Controller {
	
	public function vipregister(){
		$username=$_SESSION['admin'];
		if($username==''){
			$this->error('您还没有登录','/index.php/Home/Vip/adminlogin',1);	
		}
		$menu = A("Index");
		$menu->adminmenu();
		
		$cfg = M('cart');
		$cfg2 = M('user');
		$row = $cfg2->where("username = '{$_SESSION['admin']}'")->find();
		$fanwei = $row['fanwei'];
		
		$arr = explode("|",$fanwei);//取出用户售卡范围
		
		$starts = $arr[0];
		$ends  = $arr[1];
		
		$start = substr($arr[0],6);
		$end  = substr($arr[1],6);
		$count =$end - $start+1;//该用户售卡范围
		
		$w['sid'] = array('between',array($starts,$ends));
		$w['lock'] = array('eq',1);
		
		//统计该用户已发售卡数
		$locks= $cfg->where($w)->count();
		
		$ok = ($count)-($locks);//剩余卡数
		
		if($_SESSION['level']<10){
			$ww['sid'] = array('between',array($starts,$ends));
			$ww['lock'] = array('eq',0);
			$rs = $cfg->where($ww)->order('sid asc')->limit(0,1)->find();
			$minsid = $rs['sid'];

			
		}else{
			$minsid = '';
		}
		
			
		$ws['sid'] = array('between',array($starts,$ends));
		$ws['lock'] = array('eq',1);
		$viplock = $cfg->where($ws)->order('sid desc')->limit(0,12)->select();
		
		$vip = array("start"=>$starts,"end"=>$ends,"count"=>$count,"ok"=>$ok,"locks"=>$locks,"sid"=>$minsid);
		
		$this->assign('vip',$vip);
		$this->assign('viplock',$viplock);
		$this->display("manage:vipreg");
	}
	
	public function cartdel(){
		$conn = M('cart');
		$select_id = $_POST['select'];
		//var_dump($select_id)
		if(count($select_id)>0){
			$where['id']=array('in',$select_id);
			$val = $conn->where($where)->delete();
			$this->success("删除成功");
		}
		
	}
	
	
	public function vipaddcode(){
		//header("Content-Type:text/html; charset=utf-8");
		$conn = M('cart');
            Vendor('phpqrcode.phpqrcode');
            //生成二维码图片
			
            $object = new \QRcode();
            $s = $_POST['start'];
			$e = $_POST['end'];
			$slen = strlen($_POST['start']);
			$elen = strlen($_POST['end']);
			if($s>$e){
				$this->error('您的起始数比结尾数要大;');
				exit();	
			}


			switch ($slen){
				case 1:
					$as = "0000000".$s;
					break;
				case 2:
					$as = "000000".$s;
					break;
				case 3:
					$as = "00000".$s;
					break;
				case 4:
					$as = "0000".$s;
					break;
				case 5:
					$as = "000".$s;
					break;
				case 6:
					$as = "00".$s;
					break;
				case 7:
					$as = "0".$s;
					break;
				case 8:
					$as = $s;
					break;
			}
			
			switch ($elen){
				case 1:
					$ae = "0000000".$e;
					break;
				case 2:
					$ae = "000000".$e;
					break;
				case 3:
					$ae = "00000".$e;
					break;
				case 4:
					$ae = "0000".$e;
					break;
				case 5:
					$ae = "000".$e;
					break;
				case 6:
					$ae = "00".$e;
					break;
				case 7:
					$ae = "0".$e;
					break;
				case 8:
					$ae = $e;
					break;
					
			}
		
			$path = 'Public/Images/twoCode/';
			$size = 5;
			$level = 'L';
			
            $errorCorrectionLevel =intval($level) ;//容错级别
            $matrixPointSize = intval($size);//生成图片大小
            $error = 0;
			
			for($i = $as; $i <= $ae;$i++){
				
				$fileName = $path.date('YmdHis',time()).rand(1000000,9999999).'.png';
				$sid = '519777'.$this->casei($i);
				$data['createtime'] = time();
				//$data['startime'] = time();
				//$data['endtime'] = time+3600*24*365;
				$data['sid'] = $sid;
				$data['lock'] = 0;
				$data['erweima'] = "/".$fileName;
				$object->png($sid, $fileName, $errorCorrectionLevel, $matrixPointSize, 1);
				//var_dump();
				//exit();
				if(is_file($fileName)){
					if(!$conn->add($data)){
						$error = $error + 1;
						break;
					}
				}else{
					$this->error("文件生成失败!");
					exit();
				}

			}
			if($error){
				$this->success("添加错误，".$error."个数据写入失败");	
			}else{
				$this->success("所有会员卡添加成功!");	
			}
	
		//header("Content-type: image/png");
		
		
	}	

//把$i前面加0	
	public function casei($val){
		$v = strlen($val);
			switch ($v){
				case 1:
					$ae = "0000000".$val;
					break;
				case 2:
					$ae = "000000".$val;
					break;
				case 3:
					$ae = "00000".$val;
					break;
				case 4:
					$ae = "0000".$val;
					break;
				case 5:
					$ae = "000".$val;
					break;
				case 6:
					$ae = "00".$val;
					break;
				case 7:
					$ae = "0".$val;
					break;
				case 8:
					$ae = $val;
					break;
			}
			return $ae;
	}
	
    public function vipCenter(){
		header("Content-Type:text/html; charset=utf-8");
		$conn = M('user');
		$username=$_SESSION['admin'];
		if($username==0){
			$this->error('您还没有登录','/index.php/Home/Index/Login',1);	
		}else{
			//$where['username']=array('eq',$username);
			$row=$conn->join('LEFT JOIN tp_cart ON (tp_user.username = tp_cart.username)')->where("tp_user.username='$username'")->field("tp_cart.sid,tp_user.username,tp_user.jifen,tp_user.tel,tp_user.usercname,tp_user.card,tp_cart.erweima,tp_user.avatar,tp_cart.startime,tp_cart.endtime")->select();

			//$row['cardstr']=substr($rows['card'],0,4)."**********".substr($rows['card'],13,4);
			//var_dump($row);
			$this->assign('lists',$row);
			$this->display('index:VipCenter');
		}
    }

//用户更改资料
    public function vipCenterSave(){
		header("Content-Type:text/html; charset=utf-8");
		$conn = M('user');
		$username=$_SESSION['admin'];
		if(!$username){
			$this->error('您还没有登录','/index.php/Home/Index/Login',1);	
		}else{
			$un = $_POST['usercname'];
			$p1 = $_POST['password'];
			$p2 = $_POST['npassword'];
			if($p1=='' || $p2==''){
				$w['username'] = array('eq',$username);
				$data['usercname'] = $un;
				if($conn->where($w)->save($data)){
					$this->success('资料更新成功','/index.php/home/index/UserSet');
				}else{
					$this->error('操作失败，您没有更改任何数据');		
				}
			}else{
				$w['username'] = array('eq',$username);
				$w['password'] = array('eq',md5($p1));
				$rows = $conn->where($w)->find();
				if($rows){
					$data['usercname'] = $un;
					$data['password'] = md5($p2);
					$conn->where($w)->save($data);
					$this->success('密码更新成功','/index.php/home/index/UserSet');
				}else{
					$this->error('更改失败');	
				}
			}
		}
    }

	public function vipupdate(){
		header("Content-Type:text/html; charset=utf-8");
		$config = M('verify');
		$conn = M('User');
		$where['call'] = array('eq',trim($_POST['tel2']));
		$where['rand'] = array('eq',trim($_POST['vcode']));
		$rows = $config->where($where)->order('id desc')->find();
		if(time()>=$rows['subtime'] && time()<=($rows['subtime'])+(60*30)){
			$data['tel']=$_POST['tel2'];
			
			$rs = $conn->where("username = {$_POST['tel2']}")->find();
			if($rs){
				$this->error('抱歉，您输入的新手机已经绑定其它帐号。');	
				exit();
			}
			$data['username'] = $_POST['tel2'];
			$wh['username']=array('eq',$_SESSION['admin']);
			if(!$conn->where($wh)->save($data)){
				//echo $_POST['tel2'];
				$this->error('抱歉，您没有修改任何数据。');
				exit();
			}else{
				
				$w['id']=array('eq',$rows['id']);
				$config->where($w)->delete();
				session("admin",null);
				$this->success('电话已更新成功，您需要重新登录！','/index.php/home/index/UserSet');
			}
		}else{
			header("Content-Type:text/html; charset=utf-8");
			$this->Error('抱歉，验证码不正确或已过期');
			exit();
		}			
	}
	
	
	public function vipadd(){
		$menu = A("Index");
		$menu->adminmenu();
		$cfg = M('cart');
		$rows = $cfg->count();
		$row = $cfg->order('id desc')->find();
		$arr = array("c"=>$rows,"maxsid"=>$row['sid']+1);
		$this->assign('arr',$arr);
		$this->display("manage:vipadd");
	}

	public function vipTelEdit(){
		
		$this->display("index:vipTelEdit");
	}
	
	public function vipload(){
		$cfg = M("user");
		$name = $_POST['username'];
		$w['tp_user.username'] = array('eq',$name);
		$rows = $cfg->JOIN("Left JOIN tp_cart as b ON b.username = tp_user.username")->where($w)->field("tp_user.username,tp_user.password,tp_user.usercname,tp_user.card,tp_user.tel,b.sid,tp_user.about")->find();
		
		if($rows){
			$arr = json_encode($rows);
			echo $arr;
			exit();	
		}else{
			echo 0;
			exit();	
		}
	}

	public function xiaoxi($tel,$usercname,$sid){
	$info = $usercname."，您好，您的钦州旅游惠民卡已于".date("Y-m-d H:i:s",time)."激活成功，卡号为：".$sid."有效期从".date("Y-m-d",time())."至".date("Y-m-d",time()+3600*24*365)."，平台初始帐号密码为您的手机号码：".$tel."，在钦州旅游微信工作平台处即可登录。【钦州旅游网】";
			$post_data = array();
			$post_data['userid'] = 1225;
			$post_data['account'] = 'bbwsyw';
			$post_data['password'] = 'qq880225';
			$post_data['content'] = $info; //短信内容需要用urlencode编码下
			$post_data['mobile'] = $tel;
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
			return $rstr;
	}


	
	public function vipLock(){
		header("Content-Type:text/html; charset=utf-8");
		$cfg = M('user');
		$cfg2 = M('cart');
		$w['sid'] = array('eq',trim($_POST['sid']));
		$w['lock'] = array('eq',0);
		$u['username'] = array('eq',trim($_POST['username']));
		
		$admin['username'] = array('eq',$_SESSION['admin']);
		$r = $cfg->where($admin)->find();
		if($r['fanwei']!=""){
			$arrs = explode('|',$r['fanwei']); //售卡范围
			//var_dump($arrs[0]);	
		}else{
			echo  "没有设置售卡范围";
			exit();
		}
		
		$sid = substr(trim($_POST['sid']),6);
		if(count($arrs)>3&&count($arrs)<5){
			$arrs[4] =substr($arrs[0],6);
			$arrs[5] =substr($arrs[1],6);
		}else if(count($arrs)<3){
			$arrs[2] =substr($arrs[0],6);
			$arrs[3] =substr($arrs[1],6);
			$arrs[4] =substr($arrs[0],6);
			$arrs[5] =substr($arrs[1],6);	
		}else{
			for($i=1; $i<7; $i++){
				$arrs[$i-1] = substr($arrs[$i-1],6);
			}	
		}
		
		
		
		if(($sid>=$arrs[0] && $sid<=$arrs[1]) || ($sid>=$arrs[2] && $sid<=$arrs[3]) || ($sid>=$arrs[4] && $sid<=$arrs[5])){
		$rs = $cfg2->where($w)->find(); //查询会员卡是否存在及是否已经被绑定
		if($rs){//存在且未绑定
			$data['cid'] = $rs['id'];
			$data['card'] = trim($_POST['card']);
			$data['tel'] = trim($_POST['tel']);
			$data['usercname'] = $_POST['usercname'];
			$data['cartstatus'] = 1;
			$data['about'] = $_POST['about'];
			
			$rows = $cfg->where($u)->save($data);//绑定给当前管理员提交会员
			if($rows){//绑定成功
					$rm = $cfg->where("cid = {$rs['id']} and username = '{$_POST['username']}'")->find();
					$cdata['startime'] = time();
					$cdata['endtime'] = time()+(3600*24)*365;
					$cdata['uid']=$rm['id'];
					$cdata['lock']=1;
					$cdata['username'] = $rm['username'];
					$cdata['jihuotime']=time();
					$cdata['zuozhe'] = $_SESSION['admin'];
					
					$dd['uid']=array('eq',$rm['id']);
					$dd['lock'] =array('eq',1);
					$rl = $cfg2->where($dd)->find();
					if($rl){
						$da['uid'] = null;
						$da['username']="";
						$da['lock'] = 0;
						$cfg2->where($dd)->save($da);
					}
					if($cfg2->where($w)->save($cdata)){
						$this->success("绑定成功，可在微信入口处进行登录消费;");
						$this->xiaoxi($_POST['tel'],$_POST['usercname'],$_POST['sid']);
						exit();
					}else{
						$this->error("会员卡状态更新失败");	
						exit();
					}
			}else{
				//绑定失败
				$this->error("保存失败,您没有更改任何资料，不必保存。");
				exit();
				
			}
		}else{
			$this->error("会员卡不存在或已被绑定");	
			exit();	
		}
		}else{
			$this->error("此卡不在您的销售范围内");
			exit();	
		}
	}
	
	
	public function vipAddLock(){
		 header("Content-Type:text/html; charset=utf-8");
		$cfg = M('user');
		$cfg2 = M('cart');
		$admin['username'] = array('eq',$_SESSION['admin']);
		$r = $cfg->where($admin)->find();
		if($r['fanwei']!=''){
			$arrs = explode('|',$r['fanwei']); //售卡范围
			//var_dump($arrs[0]);	
		}else{
			echo  "没有设置售卡范围";
			exit();
		}
		$sid = substr(trim($_POST['sid']),6);
		if(count($arrs)>3&&count($arrs)<5){
			$arrs[4] =substr($arrs[0],6);
			$arrs[5] =substr($arrs[1],6);
		}else if(count($arrs)<3){
			$arrs[2] =substr($arrs[0],6);
			$arrs[3] =substr($arrs[1],6);
			$arrs[4] =substr($arrs[0],6);
			$arrs[5] =substr($arrs[1],6);	
		}else{
			for($i=1; $i<7; $i++){
				$arrs[$i-1] = substr($arrs[$i-1],6);
			}	
		}
		
		if(($sid>=$arrs[0] && $sid<=$arrs[1]) || ($sid>=$arrs[2] && $sid<=$arrs[3]) || ($sid>=$arrs[4] && $sid<=$arrs[5])){
			$w['username'] = array('eq',$_POST['username']);
			$w2['sid'] = array('eq',$_POST['sid']);
			$w2['lock'] = array('eq',0);
			$row = $cfg->where($w)->find();
			
			if($row){
				$this->error("用户名已存在!");
				exit();	
			}else{
				$rs = $cfg2->where($w2)->find();		
			
				if($rs){
					$data['username'] = $_POST['username'];
					$data['password'] = md5($_POST['password']);	
					$data['cid'] = $rs['id'];
					$data['level'] = 0;	
					$data['card'] = trim($_POST['card']);	
					$data['tel'] = trim($_POST['tel']);
					//$data['password'] = $_POST
					$data['regtime'] = time();
					$data['status'] = 1;
					$data['usercname'] = $_POST['usercname'];
					$data['cartstatus'] = 1;
					$data['about'] = $_POST['about'];
					if($cfg->add($data)){
						$rm = $cfg->where("cid = {$rs['id']} and username = {$_POST['username']}")->find();
						$cdata['uid']=$rm['id'];
						$cdata['lock']=1;
						$cdata['username'] = $rm['username'];
						$cdata['startime'] = time();
						$cdata['endtime'] = time()+3600*24*365;
						$cdata['jihuotime'] = time();
						$cdata['zuozhe'] = $_SESSION['admin'];
						
						if($cfg2->where($w2)->save($cdata)){
							$this->success("注册绑定成功，可在微信入口处进行登录;");
							$this->xiaoxi($_POST['tel'],$_POST['usercname'],$_POST['sid']);
							exit();
						}else{
							$this->error("会员卡状态更新失败");	
							exit();
						}
					}else{
						$this->error("操作失败，您没有任何进行任何修改。");
						exit();
					}
				}else{
					$this->error($_POST['sid']."该会员卡不存在，或已被绑定!");
					exit();
				}
			}
		}else{
			$this->error("此卡不在您的销售范围内");
			exit();	
		}
		
	}
	
	public function vipsearch(){
		header("Content-Type:text/html; charset=utf-8");
		$menu = A("Index");
		$menu->adminmenu();
		if(isset($_POST['search'])){
			$keyword = $_POST['search'];	
		}else if(isset($_GET['search'])){
			$keyword=$_GET['search'];
		}
		
		//exit();
		if($_GET['search']!=""){
			$keyword=iconv('gbk', 'utf-8', $_GET['search']);
		}
		$conn = M('cart');
		if($keyword=="已绑定"){
			$l = 1;	
		}else if($keyword=="未绑定"){
			$l = 0 ;
			
		}
		//echo $_POST['search'];
		//var_dump($l);
		//exit();
		$where['sid']=array('LIKE','%'.$keyword.'%');
		$where['lock']=array('eq',$l);
		$where['_logic'] = "OR";
		$data = $conn->where($where)->select();
			$count = $conn->where($where)->count();
			$pagecount = 7;
			$page = new \Think\Page($count , $pagecount);
			
			$key = array("search"=>$keyword);
			$page->parameter = $key; //此处的row是数组，为了传递查询条件
			
			$page->setConfig('first','首页');
			$page->setConfig('prev','上一页');
			$page->setConfig('next','下一页');
			$page->setConfig('last','尾页');
			$page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% 第 '.I('p',1).' 页/共 %TOTAL_PAGE% 页 ( '.$pagecount.' 条/页 共 %TOTAL_ROW% 条)');
			$show = $page->show();
			$lists = $conn->join("LEFT JOIN tp_user as u ON tp_cart.uid = u.id")->where($where)->order('tp_cart.uid,tp_cart.id desc')->field("u.usercname,u.card,tp_cart.id,tp_cart.uid,tp_cart.sid,tp_cart.username,tp_cart.startime,tp_cart.endtime,tp_cart.erweima,tp_cart.jihuotime,tp_cart.lock")->limit($page->firstRow.','.$page->listRows)->select();
			$this->assign('lists',$lists);
			$this->assign('page',$show);
		$this->display('manage:vipsearch');
	}
	
	public function viplists(){
		header("Content-Type:text/html; charset=utf-8");
		$menu = A("Index");
		$menu->adminmenu();
		
		import("@.ORG.Page"); //导入分页类
		$conn = M('cart');

			$where['level'] = array('between',array(1,8));
			$count = $conn->count();
			$pagecount = 7;
			$page = new \Think\Page($count , $pagecount);
			//$page->parameter = $row; //此处的row是数组，为了传递查询条件
			$page->setConfig('first','首页');
			$page->setConfig('prev','上一页');
			$page->setConfig('next','下一页');
			$page->setConfig('last','尾页');
			$page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% 第 '.I('p',1).' 页/共 %TOTAL_PAGE% 页 ( '.$pagecount.' 条/页 共 %TOTAL_ROW% 条)');
			$show = $page->show();
			$lists = $conn->join("LEFT JOIN tp_user as u ON tp_cart.uid = u.id")->field("u.usercname,u.card,tp_cart.id,tp_cart.uid,tp_cart.sid,tp_cart.username,tp_cart.startime,tp_cart.endtime,tp_cart.erweima,tp_cart.jihuotime,tp_cart.lock")->order('uid desc')->limit($page->firstRow.','.$page->listRows)->select();
			$this->assign('lists',$lists);
			$this->assign('page',$show);
			//$this->display();
			$this->display('manage:viplists');
		
	}
	
	
	public function adminlogin(){
		$this->display('manage:login');	
	}
	
	
	public function loglists(){
		$menu = A("Index");
		$menu->adminmenu();
		import("@.ORG.Page"); //导入分页类
		$conn = M('log');
			$count = $conn->count();
			$pagecount = 20;
			$page = new \Think\Page($count , $pagecount);
			//$page->parameter = $row; //此处的row是数组，为了传递查询条件
			$page->setConfig('first','首页');
			$page->setConfig('prev','上一页');
			$page->setConfig('next','下一页');
			$page->setConfig('last','尾页');
			$page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% 第 '.I('p',1).' 页/共 %TOTAL_PAGE% 页 ( '.$pagecount.' 条/页 共 %TOTAL_ROW% 条)');
			$show = $page->show();
			$lists = $conn->order('aid desc')->limit($page->firstRow.','.$page->listRows)->select();
			$this->assign('lists',$lists);
			$this->assign('page',$show);
			//$this->display();
		
		$this->display('manage:log_list');	
	}
	
	public function viplog_list(){
		$menu = A("Index");
		$menu->adminmenu();
		import("@.ORG.Page"); //导入分页类
		$conn = M('viplog');
			
			$lists = $conn->JOIN("LEFT JOIN tp_user as u ON u.id = tp_viplog.Uid")->order('tp_viplog.id desc')->select();
			$this->assign('lists',$lists);
			//$this->display();
		
		$this->display('manage:viplog_list');	
	}
	
	
	public function log_search(){
		$menu = A("Index");
		$menu->adminmenu();
		if(!isset($_POST['search'])){
			$keyword = $_GET['search'];
		}else{
			$keyword = $_POST['search'];
		}
		
		
		$conn = M('log');
		$where['sid']=array('LIKE','%'.$keyword.'%');
		$where['username']=array('LIKE','%'.$keyword.'%');
		$where['usercname']=array('LIKE','%'.$keyword.'%');
		$where['shopname']=array('LIKE','%'.$keyword.'%');
		$where['_logic']='OR';
		$count = $conn->where($where)->count();
		$pagecount = 20;
		$page = new \Think\Page($count , $pagecount);
		$row = array("search"=>$keyword);
		$page->parameter = $row; //此处的row是数组，为了传递查询条件
		$page->setConfig('first','首页');
		$page->setConfig('prev','上一页');
		$page->setConfig('next','下一页');
		$page->setConfig('last','尾页');
		$page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% 第 '.I('p',1).' 页/共 %TOTAL_PAGE% 页 ( '.$pagecount.' 条/页 共 %TOTAL_ROW% 条)');
		$show = $page->show();
		$lists = $conn->where($where)->order('aid desc')->limit($page->firstRow.','.$page->listRows)->select();
		$this->assign('lists',$lists);
			$this->assign('page',$show);
		$this->display('manage:log_search');
		
		
	}
	public function logdel(){
		$conn = M('log');
		$select_id = $_POST['select'];
		if(count($select_id)>0){
			$conn = M('log');
			$where['aid']=array('in',$select_id);
			$val = $conn->where($where)->delete();
			$this->success("删除成功");
		}	
	}	
	
	
	public function vipAvater(){
		header("Content-Type:text/html; charset=utf-8");
		$conn = M('user');
		$username=$_SESSION['admin'];
		if($username==0){
			$this->error('您还没有登录','/index.php/Home/Index/Login',1);	
		}else{
			//$where['username']=array('eq',$username);
			$row=$conn->join('LEFT JOIN tp_cart ON (tp_user.username = tp_cart.username)')->where("tp_user.username='$username'")->field("tp_cart.sid,tp_user.username,tp_user.jifen,tp_user.tel,tp_user.usercname,tp_user.card,tp_cart.erweima,tp_user.avatar")->select();

			//$row['cardstr']=substr($rows['card'],0,4)."**********".substr($rows['card'],13,4);
			//var_dump($row);
			$this->assign('lists',$row);
			$this->display('index:vipAvater');
		}
		
	}
	
	public function vipAvaterSave(){
		$upload = new \Think\Upload();// 实例化上传类
		$upload->maxSize  = 3145728 ;// 设置附件上传大小
		$upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		$upload->rootPath =  './Public/';// 设置附件上传目录
		$upload->savePath = 'Images/avatar/';
		$upload->autoSub = true;
		$upload->subName='';
		
		//$upload->subName = array('date','Ymd');
		$upload->saveName = date('YmdHis',time()).rand(1000,9999); 
		
		$infos   =  $upload->uploadOne($_FILES['avaterfile']);
		if(!$infos) {// 上传错误提示错误信息
			$this->error($upload->getError());
			exit();
		}
		$conn = M('user');
		
		$w['username'] = $_POST['h_u'];
		$d['avatar'] = '/Public/'.$upload->savePath.$upload->saveName.".".$infos['ext'];
		//exit();
		if($conn->where($w)->save($d)){
			$this->success('头像更改成功','/index.php/home/index/UserSet');
		}else{
			$this->error('数据保存失败');
			//echo $_POST['h_u'];
		}
		
	}
	
	public function vip_news_list(){
		$conn = M('news');
		$where['falg'] = array('eq',1);
		$row = $conn->where($where)->field("id,title,pic,content,falg")->select();
		$this->assign('lists',$row);
		$this->display('index:vip_news_list');	
	}
	
	public function vip_news_art(){
		$conn = M('news');
		$aid = $_GET['id'];
		//$where['falg'] = array('eq',1);
		$where['id'] = array('eq',$aid);
		$row = $conn->where($where)->field("id,title,pic,content")->select();
		$this->assign('lists',$row);
		$this->display('index:vip_news_art');
	}
	
	public function user_shop_edit(){
		$conn = M('user');
		$id = $_SESSION['admin'];
		$where['username'] = array('eq',$id);
		$row = $conn
		->where($where)
		->select();
		//var_dump($row);
		$this->assign('lists',$row);
		$this->display('index:user_shop_edit');
	}
	
	public function user_shop_edit_save(){
		$upload = new \Think\Upload();// 实例化上传类
		$upload->maxSize  = 3145728 ;// 设置附件上传大小
		$upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		$upload->rootPath =  './Public/';// 设置附件上传目录
		$upload->savePath = 'Images/Fm/';
		$upload->autoSub = true;
		$upload->subName='';
		
		//$upload->subName = array('date','Ymd');
		$upload->saveName = date('YmdHis',time()).rand(1000,9999); 
		
		$infos   =  $upload->uploadOne($_FILES['picFile']);
		if(!$infos) {// 上传错误提示错误信息
			$this->error($upload->getError());
			exit();
		}
		
		$conn = M('user');
		$id = $_SESSION['admin'];
		$where['username'] = array('eq',$id);
		$data['runtime'] = $_POST['runtime'];
		$data['about'] = $_POST['about'];
		$data['pic'] = '/Public/'.$upload->savePath.$upload->saveName.".".$infos['ext'];//图片路径拼接
		if($conn->where($where)->save($data)){
			$this->success('保存成功');
			exit();
		}else{
			$this->error('保存失败');
			exit();
		}
	}	
	
	
	public function user_shop_pwd_edit(){
		$conn = M('user');
		$id = $_SESSION['admin'];
		$where['username'] = array('eq',$id);
		$row = $conn
		->where($where)
		->select();
		//var_dump($row);
		$this->assign('lists',$row);
		$this->display('index:user_shop_pwd_edit');
	}
	
    public function vip_pwd_save(){
		header("Content-Type:text/html; charset=utf-8");
		$conn = M('user');
		$username=$_SESSION['admin'];
		if(!$username){
			$this->error('您还没有登录','/index.php/Home/Index/Login',1);	
		}else{
			//$un = $_POST['usercname'];
			$p1 = $_POST['pwd'];
			$p2 = $_POST['pwd2'];
			if($p1!='' && $p2!=''){
				$w['username'] = array('eq',$username);
				$w['password'] = array('eq',md5($p1));
				$rows = $conn->where($w)->find();
				if($rows){
					//$data['usercname'] = $un;
					$data['password'] = md5($p2);
					$conn->where($w)->save($data);
					$this->success('更改成功');
				}else{
					$this->error('原密码不正确');	
				}
			}
		}
    }
	
	//惠民卡购买
	
	public function VipGouMain(){
		if($_SESSION['admin']==null){
			$this->error("登录过期，请重新登录！","/index.php/home/index/login")	;
			exit();
		}
		$conn = M("user");
		$w['username'] = array('eq',$_SESSION['admin']);
		$rows = $conn->where($w)->select();
		//$getarr = $rows;
		$sid = date("Ymd",time()).rand(1000000,9999999);
		$this->assign('arr',$rows);
		$this->assign('sid',$sid);
		$this->display("index:GouMai");
		
	}
	
		public function VipGouMains(){
		if($_SESSION['admin']==null){
			$this->error("登录过期，请重新登录！","/index.php/home/index/login")	;
			exit();
		}
		$cfg = M("user");
		$viplog = M("viplog");
		$w['username'] = array('eq',$_SESSION['admin']);
		$rows = $cfg->where($w)->select();
		
		$sid = date("YmdHis",time()).rand(1000,9999);
		$w['username'] = array('eq',$_SESSION['admin']);
		$rs = $cfg->where($w)->find();
		$wa['Uid'] = array('eq',$rs['id']);
		$wa['paystatus'] = 0;
		$rrw = $viplog->where($wa)->find();
		
		if(!$rrw){
			$ect = M("viplog");
			$log['Product'] = "惠民卡绑定";
			$log['Uid'] = $rs['id'];
			$log['Price'] = 36;
			$log['Sid'] = $sid;
			$log['createtime'] = time();
			$log['paystatus'] = 0;
			if(!$ect->add($log)){
				echo "<script>alert('提示：订单异常，请稍后再试');</script>";
				$this->error();	
				exit();
			}
		}else{
			$sid = $rrw['sid'];	
		}
		
		
		$this->assign('arr',$rows);
		$this->assign('sid',$sid);
		$this->display("index:GouMais");
		
	}
	
	
	//余卡库存查询
	public function VipGouMainCheck(){
		header("Content-Type:text/html; charset=utf-8");
		if($_SESSION['admin']==null){
			$this->error("登录过期，请重新登录！","/index.php/home/index/login")	;
			exit();
		}
		
		if(time()<=1463799600){ //开放购卡时间，当前时间必须大于 2016-05-21 11:00:00 ,才能购买
			echo 2;
			exit();
		}
		
		$cfg = M('cart');
		$w['lock']=array('eq',0);
		$cfg2 = M('user');
		$static['username'] = 'internet';
		$rrr = $cfg2->where($static)->find();
		$arra = explode("|",$rrr['fanwei']);	
		$w['lock']=array('eq',0);
		$w['sid']=array('between',array($arra[0],$arra[1]));
		$row = $cfg->where($w)->limit(1)->find();
		if($row){
			echo 1;	
			exit();
		}else{
			echo 0;	
			exit();
		}
		
	}
	
	
	
	
	
	public function VipGouMaiRet(){
		header("Content-Type:text/html; charset=utf-8");
		$mid = $_GET['sid'];
		if($_SESSION['admin']==null){
			$this->error("登录过期，请重新登录！","/index.php/home/index/login")	;
			exit();
		}
				$ect = M("viplog");
				$log['Product'] = "惠民卡绑定";
				$log['Uid'] = $rows['id'];
				$log['Price'] = $price;
				$log['Sid'] = $mid;
				$log['PayTime'] = time();

				$ect->add($log);
		
		$username = iconv('gbk', 'utf-8', $_SESSION['admin']);
		$price = $_GET['price'];
		
		$cfg = M('cart');
		$cfg2 = M('user');
		$static['username'] = 'internet';
		$rrr = $cfg2->where($static)->find();
		$arra = explode("|",$rrr['fanwei']);	
		$w['lock']=array('eq',0);
		$w['sid']=array('between',array($arra[0],$arra[1]));
		$row = $cfg->where($w)->limit(1)->find();
		
		$conn = M("user");
		$where['username'] = array('eq',$username);
		$rows = $conn->where($where)->find();
		if($rows['cartstatus']==1){
			echo "该会员已经绑定会员卡，请勿重复操作！";
			exit();	
		}
		$data['cid'] = $row['id'];
		$data['cartstatus'] = 1;
		
		if($conn->where($where)->save($data)){
			$d['uid']=	$rows['id'];
			$d['username'] = $rows['username'];
			$d['startime'] = time();
			$d['endtime'] = time()+3600*24*365;
			$d['jihuotime'] = time();
			$d['lock'] = 1;
			$wh['id'] = $row['id'];
			if($cfg->where($wh)->save($d)){
				$this->xiaoxi($rows['tel'],$rows['usercname'],$row['sid']);

				$this->success('绑定成功。',"/index.php/home/index/UserSet",1);
			 	exit();
			}else{
				echo "会员卡信息更新失败";
			}
		}else{
			echo "用户信息更新失败";
			
		}
		
		//$this->display("index:UserSet");
		
	}
	
	
	
	
}