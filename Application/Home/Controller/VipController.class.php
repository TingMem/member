<?php
namespace Home\Controller;
use Think\Controller;

class VipController extends NavPublicController {
	
	public function vipregister(){
		$tongji = A('VipCode');
		$tongji->VipCode();
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
	
	public function vipcheck(){
		$u = M('user');
		$w['username'] = $_SESSION['admin'];
		$row = $u->where($w)->find();
		if($row['status']==0){
			//var_dump($row);
			echo "此帐号已被管理员冻结！";
			exit();
		}
	}

//惠民卡解绑 
	
	public function viplockremove(){
		$vid = I('get.vid');
		$uid = I('get.uid');
		if(!$vid || !$uid){
			$this->error('参数错误。','',1);
			exit();	
		}else{
			$cfg = M('cart');
			$ucfg = M('user');
			
			$cw['id'] = $vid;
			$uw['id'] = $uid;
			
			$vdata['uid'] = '';
			$vdata['username'] = '';
			$vdata['startime'] = '';
			$vdata['endtime'] = '';
			$vdata['jihuotime'] = '';
			$vdata['lock'] = 0;
			$vdata['zuozhe'] = I('session.admin');
			
			$udata['cid'] = '';
 			$udata['cartstatus'] = 0;
			
			if($cfg->where($cw)->save($vdata) && $ucfg->where($uw)->save($udata)){
				$this->success('解绑成功，正在返回操作前页面','',2);
				exit();
			}else{
				$this->error('操作失败，请联系技术员');
				exit();	
			}
			
			
				
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
			$cf = 0;
			$count = 0;
			for($i = $as; $i <= $ae;$i++){
				$sid = '519777'.$this->casei($i);
				$w['sid'] = array('eq',$sid);
				$rk = $conn->where($w)->find();
				if(!$rk){
					$fileName = $path.date('YmdHis',time()).rand(1000000,9999999).'.png';
					
					$data['createtime'] = time();
					//$data['startime'] = time();
					//$data['endtime'] = time+3600*24*365;
					$data['sid'] = $sid;
					$data['lock'] = 0;
					$data['erweima'] = "/".$fileName;
					$object->png($sid, $fileName, $errorCorrectionLevel, $matrixPointSize, 1);
					//var_dump();
					//exit();
					$count++;
					if(is_file($fileName)){
						if(!$conn->add($data)){
							$error = $error + 1;
							break;
						}
					}else{
						$this->error("文件生成失败!");
						exit();
					}
				}else{
					 $cf=$cf+1;
					 continue ;	
					
				}

			}
			if($error){
				$this->success("添加错误，".$error."个数据写入失败");	
			}else{
				$this->success("成功添加".$count."张，".$cf."张卡号重复，已被系统跳过！",'',5);	
			}
	
		//header("Content-type: image/png");
		
		
	}	


//惠民卡销售信息统计




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
		$rows = $cfg->JOIN("Left JOIN tp_cart as b ON b.username = tp_user.username")->where($w)->field("tp_user.username,tp_user.password,tp_user.usercname,tp_user.card,tp_user.tel,b.sid,tp_user.about,b.startime,b.endtime")->find();
		
		if($rows){
			if(!empty($rows['startime'])||!empty($rows['endtime'])){
				$rows['startime'] = date("Y-m-d",$rows['startime']);
				$rows['endtime'] = date("Y-m-d",$rows['endtime']);
			}else{
			$rows['startime'] = '惠民卡';
			$rows['endtime'] = '今未绑定';
			}

			$arr = json_encode($rows);
			echo $arr;
			exit();	
		}else{
			echo 0;
			exit();	
		}
	}

	public function xiaoxi($tel,$usercname,$sid){
		header("Content-Type:text/html; charset=utf-8");
		$about = M('about');
		$cont = $about->field('content')->find(3);
		$arr = array('tel' => $tel,'usercname'=>$usercname,'sid'=>substr($sid,8,6));
		
		foreach($arr as $key => $val){
			$cont['content'] = str_replace('{$'.$key.'}',$val,$cont['content']);	
		}
		
		
		$info = trim(strip_tags($cont['content']));
		
		if(empty($info)){
			$info = "【钦州旅游网】您的惠民卡".$arr['sid']."已经激活，账号密码均为：".$arr['tel']."。";	
		}
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
			
			return $rstr;
	}


	
	public function vipLock(){
		header("Content-Type:text/html; charset=utf-8");
		$cfg = M('user');
		$cfg2 = M('cart');
		
		$yanqival = intval(trim(I('post.yanqi')));
		if($yanqival!='' || $yanqival!=0){
			if(is_int($yanqival)){
				$yanqi = 3600*24*$yanqival;
			}else{
				$this->error("您的填写的延期数据类型不对");	
				exit();
			}
			
		}else{
			$yanqi = 0;	
		}
		
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
		
		$sid = trim($_POST['sid']);
		$str='';
		$count = count($arrs);
		for($i=1;$i<=$count;$i=$i+2){
			if($i+1<$count){
				$str = $str."({$sid}>={$arrs[$i-1]} && {$sid}<={$arrs[$i]}) || ";
			}else{
				$str = $str."({$sid}>={$arrs[$i-1]} && {$sid}<={$arrs[$i]})";
			}
		}

		$w['sid'] = array('eq',trim($_POST['sid']));
		if(eval("return $str;")){
			$rs = $cfg2->where($w)->find(); //查询会员卡是否存在及是否已经被绑定
			
			if($rs){//存在且未绑定
				if($rs['lock']==0){
					$data['cid'] = $rs['id'];
					$data['card'] = trim($_POST['card']);
					$data['tel'] = trim($_POST['tel']);
					$data['usercname'] = $_POST['usercname'];
					$data['cartstatus'] = 1;
					$data['about'] = $_POST['about'];
					
					$rows = $cfg->where($u)->save($data);//绑定惠民卡
					if($rows){//绑定成功
							$rm = $cfg->where("cid = {$rs['id']} and username = '{$_POST['username']}'")->find();							
							$cdata['uid']=$rm['id'];
							$cdata['lock']=1;
							$cdata['username'] = $rm['username'];
							$cdata['jihuotime']=time();
							$cdata['zuozhe'] = $_SESSION['admin'];
							
							$cdata['startime'] = time()+$yanqi;
							$cdata['endtime'] = time()+(3600*24*366)+$yanqi;
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
								$this->success("绑定成功，{$art}可在微信入口处进行登录消费;");
								$this->xiaoxi($_POST['tel'],$_POST['usercname'],$_POST['sid']);
								exit();
							}else{
								$this->error("会员卡状态更新失败");	
								exit();
							}
					}
				}else{
					$vipdata['usercname'] = trim($_POST['usercname']);
					$vipdata['card'] = trim($_POST['card']);
					$vipdata['tel'] = trim($_POST['tel']);
					$vipdata['about'] = $_POST['about'];
					$msg ='';
					if($_POST['pwdtrue']==1){//用户需要修改密码
						$vipdata['password'] = md5(trim($_POST['password']));
						$msg = "密码已更改,";
					}
					
					if($_POST['xuqi']==1){//用户选择续期
						$year = 365*$_POST['sxuqi'];
						$endtime = (3600*24*$year);
						$cartdata['zuozhe'] = $_SESSION['admin'];
						$cw['sid'] = trim($_POST['sid']); 
						$cfg2->where($cw)->setInc('endtime',$endtime);
						$cfg2->where($cw)->save($cartdata);
						$msg = $msg."成功续期：".$_POST['sxuqi']."年";
					}
					
					
					$ur = $cfg->where($u)->save($vipdata);//更新用户信息
					if($ur){
						$this->success("资料更改成功！".$msg);
						exit();
					}else{
						//绑定失败
						$this->error("您没有更改任何资料，不必保存。");
						exit();
					}
					
				}
			}else{
				if(!$rs){
					$this->error("会员卡不存在");	
					exit();		
				}

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
		
		$yanqival = intval(trim(I('post.yanqi')));
		if($yanqival!='' || $yanqival!=0){
			if(is_int($yanqival)){
				$yanqi = 3600*24*$yanqival;
			}else{
				$this->error("您的填写的延期数据类型不对");	
				exit();
			}
		}else{
			$yanqi = 0;	
		}
		
		$sid = trim($_POST['sid']);
		$str='';
		$count = count($arrs);
		for($i=1;$i<=$count;$i=$i+2){
			if($i+1<$count){
				$str = $str."({$sid}>={$arrs[$i-1]} && {$sid}<={$arrs[$i]}) || ";
			}else{
				$str = $str."({$sid}>={$arrs[$i-1]} && {$sid}<={$arrs[$i]})";
			}
		}

		//var_dump(eval("return $str;"));
		if(eval("return $str;")){
			
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
					$data['username'] = trim($_POST['username']);
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
						$cdata['startime'] = time()+$yanqi;
						$cdata['endtime'] = time()+(3600*24*365+$yanqi)+$yanqi;
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
	
	
	//高校销售情况统计
	public function gxlist (){
		header("Content-Type:text/html; charset=utf-8");
		$menu = A("Index");
		$menu->adminmenu();
		$conn = M('cart');
		
		
		if(isset($_POST['search'])){
			$keyword = 	$_POST['search'];
			$where['etype']=array('eq',$keyword);
		}else if (isset($_GET['search'])){
			$keyword = 	$_GET['search'];	
			$where['etype']=array('eq',$keyword);
		}else{
			$keyword = null;
			$where['etype']=array('LIKE','%'.$keyword.'%');
		}
		//$where['etype']=array('eq',$keyword);
		
		$data = $conn->where($where)->select();
			$count = $conn->where($where)->count();
			$pagecount = 10;
			$page = new \Bootstrap\Page($count , $pagecount);
			
			$key = array("search"=>$keyword,'tid'=>I('get.tid'),'thisid'=>I('get.thisid'));
			$page->parameter = $key; //此处的row是数组，为了传递查询条件
			
			$page->setConfig('first','首页');
			$page->setConfig('prev','上一页');
			$page->setConfig('next','下一页');
			$page->setConfig('last','尾页');
			$page->setConfig('theme',''.'%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% <li><a aria-label="Next"><span aria-hidden="true">第'.I('p',1).' 页/共 %TOTAL_PAGE% 页 ( '.$pagecount.' 条/页 共 %TOTAL_ROW% 条)</span></a></li>');
			$show = $page->show();
			$lists = $conn->join("LEFT JOIN tp_user as u ON tp_cart.uid = u.id")->where($where)->order('tp_cart.uid,tp_cart.id desc')->field("u.usercname,u.card,tp_cart.id,tp_cart.uid,tp_cart.sid,tp_cart.username,tp_cart.startime,tp_cart.endtime,tp_cart.erweima,tp_cart.jihuotime,tp_cart.lock,tp_cart.etype,u.about")->limit($page->firstRow.','.$page->listRows)->order('sid asc')->select();
			$this->assign('lists',$lists);
			$this->assign('page',$show);
		$this->display('manage:gxsearch');
	}
	
	public function vipsearch(){
		header("Content-Type:text/html; charset=utf-8");
		$menu = A("Index");
		$menu->adminmenu();
		if(isset($_POST['search'])){
			$keyword = $_POST['search'];	
		}else if(isset($_GET['search'])){
			$keyword=$_GET['search'];
			$keyword=iconv('gbk', 'utf-8', $keyword);
		}
		
		$conn = M('cart');
		if($keyword=="已绑定"){
			$l = 1;	
			$where['lock']=array('eq',$l);
		}else if($keyword=="未绑定"){
			$l = 0 ;
			$where['lock']=array('eq',$l);
			
		}
		
		$key = array("search"=>$keyword,"tid"=>I('get.tid'),'thisid'=>I('get.thisid'));
		
		$where['sid']=array('LIKE','%'.$keyword.'%');
		$data = $conn->where($where)->select();
			$count = $conn->where($where)->count();
			$pagecount = 10;
			$page = new \Bootstrap\Page($count , $pagecount);
			
			$page->parameter = $key; //此处的row是数组，为了传递查询条件
			
			$page->setConfig('first','首页');
			$page->setConfig('prev','上一页');
			$page->setConfig('next','下一页');
			$page->setConfig('last','尾页');
			$page->setConfig('theme',''.'%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% <li><a aria-label="Next"><span aria-hidden="true">第'.I('p',1).' 页/共 %TOTAL_PAGE% 页 ( '.$pagecount.' 条/页 共 %TOTAL_ROW% 条)</span></a></li>');
			$show = $page->show();
			$lists = $conn->join("LEFT JOIN tp_user as u ON tp_cart.uid = u.id")->where($where)->order('tp_cart.uid,tp_cart.id desc')->field("u.usercname,u.card,tp_cart.id,tp_cart.uid,tp_cart.sid,tp_cart.username,tp_cart.startime,tp_cart.endtime,tp_cart.erweima,tp_cart.jihuotime,tp_cart.lock,tp_cart.zuozhe")->limit($page->firstRow.','.$page->listRows)->order('sid asc')->select();
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
			$pagecount = 10;
			$page = new \Bootstrap\Page($count , $pagecount);
			//$page->parameter = $row; //此处的row是数组，为了传递查询条件
			$page->setConfig('first','首页');
			$page->setConfig('prev','上一页');
			$page->setConfig('next','下一页');
			$page->setConfig('last','尾页');
			$page->setConfig('theme',''.'%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% <li><a aria-label="Next"><span aria-hidden="true">第'.I('p',1).' 页/共 %TOTAL_PAGE% 页 ( '.$pagecount.' 条/页 共 %TOTAL_ROW% 条)</span></a></li>');
			$show = $page->show();
			$lists = $conn->join("LEFT JOIN tp_user as u ON tp_cart.uid = u.id")->field("u.usercname,u.card,tp_cart.id,tp_cart.uid,tp_cart.sid,tp_cart.username,tp_cart.startime,tp_cart.endtime,tp_cart.erweima,tp_cart.jihuotime,tp_cart.lock,tp_cart.zuozhe")->order('sid asc')->limit($page->firstRow.','.$page->listRows)->select();
			$this->assign('lists',$lists);
			$this->assign('page',$show);
			//$this->display();
			$this->display('manage:viplists');
		
	}
	
	
	public function loglists(){
		$menu = A("Index");
		$menu->adminmenu();
		import("@.ORG.Page"); //导入分页类
		$conn = M('log');
			$count = $conn->count();
			$pagecount = 20;
			$page = new \Bootstrap\Page($count , $pagecount);
			//$page->parameter = $row; //此处的row是数组，为了传递查询条件
			$page->setConfig('first','首页');
			$page->setConfig('prev','上一页');
			$page->setConfig('next','下一页');
			$page->setConfig('last','尾页');
			$page->setConfig('theme',''.'%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% <li><a aria-label="Next"><span aria-hidden="true">第'.I('p',1).' 页/共 %TOTAL_PAGE% 页 ( '.$pagecount.' 条/页 共 %TOTAL_ROW% 条)</span></a></li>');
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
			$count = $conn->count();
			$pagecount = 20;
			$page = new \Bootstrap\Page($count , $pagecount);
			//$page->parameter = $row; //此处的row是数组，为了传递查询条件
			$page->setConfig('first','首页');
			$page->setConfig('prev','上一页');
			$page->setConfig('next','下一页');
			$page->setConfig('last','尾页');
			$page->setConfig('theme',''.'%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% <li><a aria-label="Next"><span aria-hidden="true">第'.I('p',1).' 页/共 %TOTAL_PAGE% 页 ( '.$pagecount.' 条/页 共 %TOTAL_ROW% 条)</span></a></li>');
			$show = $page->show();
			$lists = $conn->JOIN("LEFT JOIN tp_user as u ON u.id = tp_viplog.Uid")->order('paytime desc')->limit($page->firstRow.','.$page->listRows)->select();
			$this->assign('lists',$lists);
			$this->assign('page',$show);
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
		$page = new \Bootstrap\Page($count , $pagecount);
		$row = array("search"=>$keyword,"tid"=>I('get.tid'),'thisid'=>I('get.thisid'));
		$page->parameter = $row; //此处的row是数组，为了传递查询条件
		$page->setConfig('first','首页');
		$page->setConfig('prev','上一页');
		$page->setConfig('next','下一页');
		$page->setConfig('last','尾页');
		$page->setConfig('theme',''.'%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% <li><a aria-label="Next"><span aria-hidden="true">第'.I('p',1).' 页/共 %TOTAL_PAGE% 页 ( '.$pagecount.' 条/页 共 %TOTAL_ROW% 条)</span></a></li>');
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
		$where['falg'] = 1;
		$row = $conn->where($where)->order('id desc')->limit(5)->select();
		$this->assign('lists',$row);
		$this->display('index:vip_news_list');	
	}
	
    public function vip_news_load(){
        $Yan = M('news');
        $page = intval($_GET['page']);  //获取请求的页数
		
		$start = $page*5;
	
        $data = $Yan->where('falg=1')->order('id desc')->limit($start,5)->select();
		$i = 1;
		$ul = '<ul class="list-group">';
		
		foreach($data as $lists){
			if($i % 5 == 1){
				$str = $str.$ul.'<li class="list-group-item" style="padding:7px !important;"><a href="/index.php/home/vip/vip_news_art/id/'.$lists['id'].'"><img src="'.$lists['pic'].'" style="width:100%; height:150px;" /></a><div style="margin-top:-40px; background:#000; opacity:0.5;  position:relative;z-index:9; bottom:0px; height:40px; padding:2px; 10px; text-align:center; font-size:16px; line-height:40px;"></div><div style="margin-top:-40px; position:relative; z-index:10; bottom:0px; height:40px; padding:2px; 10px; text-align:center; font-size:16px; line-height:40px; "><a style="color:#fff !important;" href="/index.php/home/vip/vip_news_art/id/">'.$lists['title'].'</a></div></li>';
			}else if($i % 5 ==0){
				$str =$str.'<li class="list-group-item">
              	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="80%"><a style="color:#333; font-size:16px;" href="/index.php/home/vip/vip_news_art/id/'.$lists['id'].'">'.$lists['title'].'</a></td>
                    <td><a href="/index.php/home/vip/vip_news_art/id/'.$lists['id'].'"><img src="'.$lists['pic'].'" style="height:64px; width:64px; float:right; margin-left:10px;" /></a></td>
                  </tr>
                </table>
                </li></ul>';
			}else{
				$str =$str.'<li class="list-group-item">
              	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="80%"><a style="color:#333; font-size:16px;" href="/index.php/home/vip/vip_news_art/id/'.$lists['id'].'">'.$lists['title'].'</a></td>
                    <td><a href="/index.php/home/vip/vip_news_art/id/'.$lists['id'].'"><img src="'.$lists['pic'].'" style="height:64px; width:64px; float:right; margin-left:10px;" /></a></td>
                  </tr>
                </table>
              </li>';
			}
        $i++;
		}
		
	
		if($data){
			$str = $str;
		}else{
			$str = '';	
		}
        echo $str;  //转换为json数据输出
        
    }
	
	public function vip_news_art(){
		$conn = M('news');
		$aid = $_GET['id'];
		//$where['falg'] = array('eq',1);
		$where['id'] = array('eq',$aid);
		$row = $conn->where($where)->select();
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
	
		public function VipGouMains(){
		if($_SESSION['admin']==null){
			$this->error("登录过期，请重新登录！","/index.php/home/index/login")	;
			exit();
		}
		if($this->VipGouMainChecks()==0){
			$this->error("惠民卡暂时售空了！");
			exit();
		}
			$cq = M("user");
			$wherew['username'] = array('eq',$_SESSION['admin']);
			$rowq = $cq->where($wherew)->find();
			
			if($rowq['cartstatus']==1){
				echo "该会员已经绑定会员卡，请勿重复操作！";
				$this->error();
				exit();	
			}
		$cfg = M("user");
		$viplog = M("viplog");
		$w['username'] = array('eq',$_SESSION['admin']);
		$rows = $cfg->where($w)->select();
		
		$sid = date("YmdHis",time()).rand(1000,9999);//生成订单号
		
		$w['username'] = array('eq',$_SESSION['admin']);
		$rs = $cfg->where($w)->find();
		
		
		$wa['Uid'] = array('eq',$rs['id']);
		$wa['paystatus'] = 0;
		$rrw = $viplog->where($wa)->find();
		$ect = M("viplog");
		if(!$rrw){//如果该订单不存在，则创建一条新订单
			
			$log['Product'] = "惠民卡绑定";
			$log['Uid'] = $rs['id'];
			$log['Price'] = 36;
			$log['Sid'] = $sid;
			$log['createtime'] = time();
			$log['paystatus'] = 0;
			if(isset($_GET['xh'])){
				$log['xh'] = $_GET['xh'];
			}
			
			if(!$ect->add($log)){
				echo "<script>alert('提示：订单异常，请稍后再试');</script>";
				$this->error();	
				exit();
			}
		}else{
			$sid = $rrw['sid'];	 //该用户已有订单了，选中该订单，避免重复创建
			if(isset($_GET['xh'])){
				$da['xh'] = $_GET['xh'];
				$ect->where($sid)->data($da);
			}
		}
		
		
		$this->assign('arr',$rows);
		$this->assign('sid',$sid);
		if(isset($_GET['xh'])){
			$this->assign('xh',$_GET['xh']);
		}
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
			return 2;
			exit();
		}
		
		$cfg = M('cart');
		$w['lock']=array('eq',0);
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
				if($i+1<$count){
					$sql = $sql."(`sid` between {$arra[$i-1]} and {$arra[$i]}) or ";
				}else{
					$sql = $sql."(`sid` between {$arra[$i-1]} and {$arra[$i]})";
				}
			}


			$query = $w.$sql;
		
		$row = $cfg->where($query)->find();
		if($row){
			echo 1;	
			return 1;
			exit();
		}else{
			echo 0;	
			return 0;
			exit();
		}
		
	}
	
	public function VipGouMainChecks(){
		header("Content-Type:text/html; charset=utf-8");
		if($_SESSION['admin']==null){
			$this->error("登录过期，请重新登录！","/index.php/home/index/login")	;
			exit();
		}
		
		if(time()<=1463799600){ //开放购卡时间，当前时间必须大于 2016-05-21 11:00:00 ,才能购买
			return 2;
			exit();
		}
		
		$cfg = M('cart');
		$w['lock']=array('eq',0);
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
				if($i+1<$count){
					$sql = $sql."(`sid` between {$arra[$i-1]} and {$arra[$i]}) or ";
				}else{
					$sql = $sql."(`sid` between {$arra[$i-1]} and {$arra[$i]})";
				}
			}
			$query = $w.$sql;
		
		$row = $cfg->where($query)->find();
		if($row){
			return 1;
			exit();
		}else{
			return 0;
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
			$d['zuozhe'] = 'internet';
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