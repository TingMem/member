<?php
namespace Home\Controller;
use Think\Controller;

class ManageController extends NavPublicController {
	

	public function help_lists(){
		import("@.ORG.Page"); //导入分页类
		$conn = M('zhinan');
			//$where['level'] = array('between',array(1,8));
			$count = $conn->count();
			$pagecount = 25;
			$page = new \Bootstrap\Page($count , $pagecount);
			//$page->parameter = $row; //此处的row是数组，为了传递查询条件
			$page->setConfig('first','首页');
			$page->setConfig('prev','上一页');
			$page->setConfig('next','下一页');
			$page->setConfig('last','尾页');
			$page->setConfig('theme',''.'%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% <li><a aria-label="Next"><span aria-hidden="true">第'.I('p',1).' 页/共 %TOTAL_PAGE% 页 ( '.$pagecount.' 条/页 共 %TOTAL_ROW% 条)</span></a></li>');
			$show = $page->show();
			$lists = $conn
			->order('id desc')
			->limit($page
			->firstRow.','.$page->listRows)
			->select();
			$this->assign('lists',$lists);
			$this->assign('page',$show);
			//$this->display();
			$this->display('manage:help_lists');
	}

	public function about_src(){
		import("@.ORG.Page"); //导入分页类
		$conn = M('About');
		$menu = A("Index");
		$menu->adminmenu();
			$count = $conn->count();
			$pagecount = 25;
			$page = new \Bootstrap\Page($count , $pagecount);
			//$page->parameter = $row; //此处的row是数组，为了传递查询条件
			$page->setConfig('first','首页');
			$page->setConfig('prev','上一页');
			$page->setConfig('next','下一页');
			$page->setConfig('last','尾页');			$page->setConfig('theme',''.'%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% <li><a aria-label="Next"><span aria-hidden="true">第'.I('p',1).' 页/共 %TOTAL_PAGE% 页 ( '.$pagecount.' 条/页 共 %TOTAL_ROW% 条)</span></a></li>');
			$show = $page->show();
			$lists = $conn
			->order('id desc')
			->limit($page
			->firstRow.','.$page->listRows)
			->select();
			$this->assign('lists',$lists);
			$this->assign('page',$show);
			//$this->display();
			$this->display('manage:about_src');
	}

	public function about_edit(){
		$conn = M('Message');
		$menu = A("Index");
		$menu->adminmenu();//调用Index方法头部菜单，方便控制用户登录
		$id = $_GET['id'];
		$conn = M("about");
		$w['id'] = array('eq',$id);
		$row = $conn->where($w)->find();
		$this->assign("body",$row);
		$this->display("Manage:about_edit");
	}

	public function about_save(){
		$id = $_POST['id'];

		$conn = M("about");
		$w['id'] = array('eq',$id);
		$data['title'] = $_POST['title'];
		$data['content'] = $_POST['content'];
		$data['uptime'] = time();
		$data['admins'] = $_SESSION['admin'];
		$row = $conn->where($w)->save($data);
		if($row){
			$this->assign("body",$row);
			$this->success("更新成功",'',1);
		}else{
			$this->error('保存失败');
			exit();
		}
		
	}

	public function retmsg(){
		
		$cfg = M('retmsg');
		$cfg2 = M('message');
		
		if(isset($_POST['retid'])){
			$w['id'] = $_POST['retid'];
			$rs = $cfg->where($w)->find();
			$data['retcont'] = $_POST['cont'];
			$w2['id'] = $rs['msgid'];
			if($cfg->where($w)->save($data)){
				$d['look'] = 1;
				$cfg2->where($w2)->save($d);
				echo 1;
				exit();
			}else{
				echo 0;
				exit();	
			}
		}else{
			$data['msgid'] = $_POST['id'];
			$data['retcont'] = $_POST['cont'];
			$data['rettime'] = time();
			$data['retadmin'] = $_SESSION['admin'];
			$w2['id'] = $_POST['id'];
			if($cfg->add($data)){
				$d['look'] = 1;
				$cfg2->where($w2)->save($d);
				echo 1;
			}else{
				echo 0;	
			}
		}
	}

	public function message_add(){
		//$this->checksession();
		if($_SESSION['admin']==null){
			$this->error("您的登录已过期","/index.php/home/index/login");
		}
		$conn = M("Message");
		$data['title'] = $_POST['title'];
		$data['body'] = $_POST['cont'];
		$data['author'] = $_SESSION['admin'];
		$data['mTime'] = time();
		if($conn->add($data)){
			$this->success("您反馈的问题我们已经收到，感谢您一直以来对我们的支持！");
			exit();
		}else{
			$this->error("抱歉，反馈失败。");
			exit();
		}
	}


	public function MessageList(){
		import("@.ORG.Page"); //导入分页类
		$conn = M('Message');
		$resultModel = M('retmsg');
		$menu = A("Index");
		$menu->adminmenu();//调用Index方法头部菜单，方便控制用户登录
			$count = $conn->count();
			$pagecount = 20;
			$page = new \Bootstrap\Page($count , $pagecount);
			//$page->parameter = $row; //此处的row是数组，为了传递查询条件
			$page->setConfig('first','首页');
			$page->setConfig('prev','上一页');
			$page->setConfig('next','下一页');
			$page->setConfig('last','尾页');			$page->setConfig('theme',''.'%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% <li><a aria-label="Next"><span aria-hidden="true">第'.I('p',1).' 页/共 %TOTAL_PAGE% 页 ( '.$pagecount.' 条/页 共 %TOTAL_ROW% 条)</span></a></li>');
			$show = $page->show();
			$lists = $conn
			->order('rstatus,mtime desc')
			->limit($page
			->firstRow.','.$page->listRows)
			->select();
			$this->assign('lists',$lists);
			$this->assign('page',$show);
			$tmp = '';
			foreach($lists as $k => $v){
				if($tmp){
					$tmp .= ','.$v['id'];
				}else{
					$tmp = $v['id'];
				}
			}
			
			$result = $resultModel->where(array('msgid'=>array('in',$tmp)))->select();
			
			//var_dump($result);
			//$this->display();
			$this->assign('result',$result);
			$this->display('manage:MessageList');
	}

	public function Message_Edit(){
		$conn = M('Message');
		$cfg = M('retmsg');
		$menu = A("Index");
		$menu->adminmenu();//调用Index方法头部菜单，方便控制用户登录
		$id = $_GET['id'];
		$conn = M("Message");
		$w['id'] = array('eq',$id);

		$row = $conn->where($w)->find();
		$wh['msgid'] = $row['id'];
		$rows = $cfg->where($wh)->select();
		
		$this->assign("body",$row);
		$this->assign("result",$rows);
		$this->display("Manage:MessageEdit");
	}

	public function msgedit(){
		$id = $_POST['id'];
		$cfg = M('retmsg');
		$w['id'] = $id;
		$row = $cfg->where($w)->find();
		$Json = json_encode($row);
		if($row){
			echo $Json;
		}else{
			echo 0;	
		}
		
	}

	public function news_list(){
		import("@.ORG.Page"); //导入分页类
		$conn = M('news');
		$menu = A("Index");
		$menu->adminmenu();
			//$where['level'] = array('between',array(1,8));
			$count = $conn->count();
			$pagecount = 25;
			$page = new \Bootstrap\Page($count , $pagecount);
			//$page->parameter = $row; //此处的row是数组，为了传递查询条件
			$page->setConfig('first','首页');
			$page->setConfig('prev','上一页');
			$page->setConfig('next','下一页');
			$page->setConfig('last','尾页');			$page->setConfig('theme',''.'%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% <li><a aria-label="Next"><span aria-hidden="true">第'.I('p',1).' 页/共 %TOTAL_PAGE% 页 ( '.$pagecount.' 条/页 共 %TOTAL_ROW% 条)</span></a></li>');
			$show = $page->show();
			$lists = $conn
			->order('id desc')
			->limit($page
			->firstRow.','.$page->listRows)
			->select();
			$this->assign('lists',$lists);
			$this->assign('page',$show);
			//$this->display();
			$this->display('manage:news_lists');
	}


	public function news_add(){
		$menu = A("Index");
		$menu->adminmenu();
		if($_POST){
			$upload = new \Think\Upload();// 实例化上传类
			$upload->maxSize  = 3145728 ;// 设置附件上传大小
			$upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
			$upload->rootPath =  './Uploads/';// 设置附件上传目录
			//$upload->savePath = 'images/';
			$upload->autoSub = true;
			$d = date('Ymd',time());
			$upload->subName = array('date','Ymd');
			$upload->saveName = date('YmdHis',time()).rand(1000,9999); 
			
			$infos   =  $upload->uploadOne($_FILES['picurl']);
			if(!$infos) {// 上传错误提示错误信息
				$this->error($upload->getError());
				exit();
			}
			
			$conn = M('news');
			$data['title']=$_POST['title'];
			$data['falg']=$_POST['radio'];
			$data['pic'] = '/Uploads/'.$d."/".$upload->saveName.".".$infos['ext'];
			$data['content']=$_POST['content'];
			$data['sub_user']= $_SESSION['admin'];
			$data['createtime']=time();
			$row = $conn->add($data);
			$this->Success('优惠信息发布成功。');
			exit();
		}else{
			$this->display();	
		}
	}

	public function news_edit(){
		$menu = A("Index");
		$menu->adminmenu();
		$conn = M('news');
		if($_POST){
			$upload = new \Think\Upload();// 实例化上传类
			$upload->maxSize  = 3145728 ;// 设置附件上传大小
			$upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
			$upload->rootPath =  './Uploads/';// 设置附件上传目录
			//$upload->savePath = 'images/';
			$upload->autoSub = true;
			$d = date('Ymd',time());
			$upload->subName = array('date','Ymd');
			$upload->saveName = date('YmdHis',time()).rand(1000,9999); 
			
			
			if(I('post.picurl')!=''){
				$infos   =  $upload->uploadOne($_FILES['picurl']);
				if(!$infos) {// 上传错误提示错误信息
					$this->error($upload->getError());
					exit();
				}
				$data['pic'] = '/Uploads/'.$d."/".$upload->saveName.".".$infos['ext'];
			}
			
			$data['title']=$_POST['title'];
			$data['falg']=$_POST['radio'];

			$data['content']=$_POST['content'];
			$data['sub_user']= $_SESSION['admin'];
			$data['createtime']=time();
			$w['id']=trim($_POST['aid']);
			$row = $conn->where($w)->save($data);
			$this->Success('优惠信息修改成功。');
			exit();
		}else{
			
			$ww['id'] = trim($_GET['aid']); 
			$rows = $conn->where($ww)->select();
			$this->assign('vo',$rows);
			$this->display();	
		}
	}
//新闻审核
	public function updatenews(){
		$this->checksession();
		 header("Content-Type:text/html; charset=utf-8");
		//var_dump('Success');
		$id=$_POST['select'];
		$conn=M('news');
		$where['id']=array('in',$id);
		$row=$conn->where($where)->select();
		
		
		foreach($row as $val){
			if($val['falg']==0){
				$sql['id'] = array('eq',$val['id']);
				$data['falg']=1;
				$conn->where($sql)->save($data);
			}else{
				$sql['id'] = array('eq',$val['id']);
				$data['falg']=0;
				$conn->where($sql)->save($data);
			}
		   
		}
		$this->success('更新成功');	
		
	}




//新闻删除操作
	public function news_del(){
		$conn = M('news');
		$select_id = $_POST['select'];
		if(count($select_id)>0){
			$conn = M('news');
			$where['id']=array('in',$select_id);
			$val = $conn->where($where)->delete();
			$this->success("删除成功");
		}	
	}

	public function lists(){
		import("@.ORG.Page"); //导入分页类
		$conn = M('user');
			$where['level'] = array('eq',5);
			$count = $conn->where($where)->count();
			$pagecount = 25;
			$page = new \Bootstrap\Page($count , $pagecount);
			//$page->parameter = $row; //此处的row是数组，为了传递查询条件
			$page->setConfig('first','首页');
			$page->setConfig('prev','上一页');
			$page->setConfig('next','下一页');
			$page->setConfig('last','尾页');			$page->setConfig('theme',''.'%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% <li><a aria-label="Next"><span aria-hidden="true">第'.I('p',1).' 页/共 %TOTAL_PAGE% 页 ( '.$pagecount.' 条/页 共 %TOTAL_ROW% 条)</span></a></li>');
			$show = $page->show();
			$lists = $conn->where($where)->order('id desc')->limit($page->firstRow.','.$page->listRows)->select();
			$this->assign('lists',$lists);
			$this->assign('page',$show);
			//$this->display();
			$this->display('manage:lists');
	}

//留言删除操作
	public function Message_del(){
		//$CheckSession = A("Index");
		$conn = M('Message');
		$select_id = $_POST['select'];
		if(count($select_id)>0){
			//$conn = M('Message');
			$where['id']=array('in',$select_id);
			$val = $conn->where($where)->delete();
			$this->success("删除成功");
		}else{
			$this->error("请选择您要删除的留言");
			exit();	
		}
	}


//帮助删除操作
	public function help_del(){
		$conn = M('zhinan');
		$this->checksession();
		$select_id = $_POST['select'];
		if(count($select_id)>0){
			$conn = M('zhinan');
			$where['id']=array('in',$select_id);
			$val = $conn->where($where)->delete();
			$this->success("删除成功");
		}	
	}


	public function help_add(){
		$menu = A("Index");
		$menu->adminmenu();
		$this->display('manage:help_add');
	}


	public function help_edit(){
		$menu = A("Index");
		$menu->adminmenu();
		$HelpData = M('zhinan');
		
		if(IS_POST){
			$ww['id'] = $_POST['id'];
			$data['title']=$_POST['title'];
			$data['content']=$_POST['content'];
			$ret = $HelpData->where($ww)->save($data);
			$this->success('保存成功');
			exit();
		}
		
		$wf['id']=array('eq',(integer)$_GET['id']);
		$rs = $HelpData->where($wf)->select();
			//var_dump($rs);
			
		$this->assign("listl",$rs);
		$this->display('manage:help_edit');
	}
	
	public function help_add_save(){
		$conn = M('zhinan');
		$t['title'] = $_POST['title'];
		$t['content'] = $_POST['content'];
		$t['createtime'] = time();
		$t['sub_user'] = $_SESSION['admin'];
		if($conn->add($t)){
			$this->success('添加成功!');
			exit();
		}else{
			$this->error('添加失败');	
			exit();
		}
	}
//管理员管理商家列表
	public function user_list(){
		import("@.ORG.Page"); //导入分页类
		$conn = M('user');
		$menu = A("Index");
		$menu->adminmenu();
			//$where['level'] = array('between',array(1,8));
			$count = $conn->count();
			$pagecount = 10;
			$page = new \Bootstrap\Page($count , $pagecount);
			//$page->parameter = $row; //此处的row是数组，为了传递查询条件
			if($_SESSION['level']!=10){
				$where['level'] = array('eq',0);	
			}else{
				$where['level'] = array('elt',10);
			}
			
			$page->setConfig('first','首页');
			$page->setConfig('prev','上一页');
			$page->setConfig('next','下一页');
			$page->setConfig('last','尾页');
			$page->setConfig('theme',''.'%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% <li><a aria-label="Next"><span aria-hidden="true">第'.I('p',1).' 页/共 %TOTAL_PAGE% 页 ( '.$pagecount.' 条/页 共 %TOTAL_ROW% 条)</span></a></li>');
			$show = $page->show();
			$lists = $conn
			->alias('a')
			->join('LEFT JOIN __CART__ b on a.cid=b.id')
			->where($where)
			->order('a.id desc')
			->limit($page->firstRow.','.$page->listRows)->field('a.*,b.sid,b.startime,b.endtime')
			->select();
			
			
			
			$this->assign('lists',$lists);
			$this->assign('page',$show);
			//$this->display();
			$this->display('manage:user_list');
	}

//会员搜索
	public function user_search(){
		header("Content-Type:text/html; charset=utf-8");
		$menu = A("Index");
		$menu->adminmenu();
		if(isset($_POST['search'])){
			$keyword = $_POST['search'];	
		}else if(isset($_GET['search'])){


			$keyword=$_GET['search'];
			$encode = mb_detect_encoding($keyword,array('ASCII','utf-8','GB2312','GBK','BIG5'));
			if ($encode!='UTF-8'){
				$keyword=iconv('GBK', 'UTF-8', $keyword);
			} 
			
		}else{
			$keyword = '';	
		}
		
		if($_SESSION['level']==10){
			if($keyword=='代理商'){
				$lv = 9;
				$k = 1;
				$where['level']=array('eq',$lv);
			}else if($keyword=='管理员'){
				$lv = 10;	
				$k = 1;
			}else{
				$lv = 10;
				$k = 2;
			}
		}else{
			$lv  = $_SESSION['level']-1;
			$k=2;
		}
		$where['level']=array('eq',$lv);

		$row = array("search"=>$keyword,"tid"=>I('get.tid'),'thisid'=>I('get.thisid'));
		
		if(empty($lv)){
			$lv = 0;
		}
		
		if($k==2){
			$where['a.username|a.usercname|b.sid']=array('like','%'.$keyword.'%');
			$where['level'] = array('elt',$lv);
		}else{
			$where['level'] = array('eq',$lv);
		}
		
		$where['_logic']='and';
		$conn = M('user');
			$count = $conn
			->alias('a')
			->join('LEFT JOIN __CART__ b ON a.cid = b.id')
			->where($where)->count();
			$pagecount = 10;
			$page = new \Bootstrap\Page($count , $pagecount);
			$page->parameter = $row; //此处的row是数组，为了传递查询条件
			$page->setConfig('first','首页');
			$page->setConfig('prev','上一页');
			$page->setConfig('next','下一页');
			$page->setConfig('last','尾页');
			$page->setConfig('theme',''.'%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% <li><a aria-label="Next"><span aria-hidden="true">第'.I('p',1).' 页/共 %TOTAL_PAGE% 页 ( '.$pagecount.' 条/页 共 %TOTAL_ROW% 条)</span></a></li>');
			$show = $page->show();
		
		if($k==2){
			$ww['a.level'] = $where['level'];
			$ww['a.username|a.usercname|b.sid']=array('like','%'.$keyword.'%');
		}else{
			$ww['a.level'] = $lv;	
		}
		$data = $conn
		->alias('a')
		->join('LEFT JOIN __CART__ b ON a.cid=b.id')
		->where($ww)
		//->field('a.*,b.sid,b.startime,b.endtime')
		->order('a.id desc')
		->limit($page->firstRow.','.$page->listRows)
		->field('a.*,b.sid,b.startime,b.endtime')
		->select();
		$this->assign('searchlist',$data);
		$this->assign('page',$show);
		$this->display('manage:user_searchlist');
	}

//禁用用户
	public function user_update(){
		$user = M('user');
		$s = $_GET['s'];
		$id = I('select');
		$w['id'] = array('in',$id);
		$data['status'] = $s;
		if($user->where($w)->save($data)){
			$this->success("用户状态更新成功");
			exit();
		}else{
			echo "Error";
			exit();
		}
	}

	public function user_edit(){
		header("Content-Type:text/html; charset=utf-8");
		$menu = A("Index");
		$menu->adminmenu();
		$conn=M('user');
		$id=$_GET['id'];
		$where['id']=array('eq',$id);
		$lists=$conn->where($where)->select();
		$this->assign('lists',$lists);
		$this->display('manage:user_edit');
	}

	public function listeditsaves(){
		header("Content-Type:text/html; charset=utf-8");
		if($_SESSION['admin']==null || $_SESSION['level']<9){
			$this->error('非法操作！',"/index.php/home/index/index",1);
			exit();
		}
		
		if(trim($_POST['username'])=='' || trim($_POST['usercname'])==''){
			$this->error('您没有填写必要资料。');
			exit();		
		}
		$conn=M('user');
		$id=$_POST['editids'];
		$where['id']=array('eq',$id);
		$data['usercname']=trim($_POST['usercname']);
		
		if($_POST['mp']==1){
			$data['password'] = md5(trim($_POST['username']));
		}
		$data['username']=trim($_POST['username']);
		$data['jiesuan']=trim($_POST['jiesuan']);
		$data['card'] = trim($_POST['card']);
		$data['tel']=trim($_POST['tel']);
		$data['address']=trim($_POST['address']);
		$data['email']=trim($_POST['email']);
		if(isset($_POST['fanwei'])){
			$data['fanwei'] = trim($_POST['fanwei']);
		}
		$where['id']=array('eq',$id);
		//var_dump($data);
		$ret = $conn->where($where)->save($data);
		if($ret){
			
			
			$cfg = M('cart');
			$rs = $cfg->where($w)->find();
			$mm['uid'] = array('eq',$id);
			if($rs){
				$ds['username'] = $_POST['username'];
				$cfg->where($mm)->save($ds);
			}
			
			$this->epwd(trim($_POST['username']),trim($_POST['usercname']),trim($_POST['username']));
			$this->success('保存成功','user_list');
		}else{
			$this->error('您没有更改任何资料');	
		}
		
	}

	public function epwd($tel,$usercname,$sid){
		
			$tips = M('about');
			$cont = $tips->find(4);
			$str = strip_tags($cont['content']);
			
			$info = $usercname."【钦州旅游网】更改成功，帐号密码均为：".$tel."，在钦州旅游微信工作平台处即可登录。".$str;
			
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


	
	public function user_add(){
		header("Content-Type:text/html; charset=utf-8");
		$menu = A("Index");
		$menu->adminmenu();	
		$this->display('user_add');
	}
	
	public function user_add_save(){
		
		if(trim($_POST['fanwei'])!=0){
			if($len = strlen(trim($_POST['fanwei'])) % 29 == 0){
				$data['fanwei'] = trim($_POST['fanwei']);
				//echo trim($_POST['fanwei']);
				//exit();
			}else{
				$this->error('您分配的卡号范围类型不正确');
				//echo $len;
				exit();	
			}
			
		}else{
			if($_POST['type']>=9){
				$data['fanwei'] = '51977700000000|51977700000001';
			}
		}
		if($_POST['type']==5){
			$upload = new \Think\Upload();// 实例化上传类
			$upload->maxSize  = 3145728 ;// 设置附件上传大小
			$upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
			$upload->rootPath =  './Public/';// 设置附件上传目录
			$upload->savePath = 'images/Fm/';
			$upload->autoSub = true;
			$d = date('Ymd',time());
			$upload->subName = ''; //本次上传子目录
			$upload->saveName = date('YmdHis',time()).rand(1000,9999); 
			
			$infos   =  $upload->uploadOne($_FILES['fengmian']);
			if(!$infos) {// 上传错误提示错误信息
				$this->error($upload->getError());
				exit();
			}
			
			$data['pic']='/Public/'.$upload->savePath.$upload->saveName.".".$infos['ext'];
			$data['zhekou']=$_POST['zhekou'];
			$data['yuanjia']=$_POST['yuanjia'];
			$data['jiesuan']=$_POST['jiesuan'];
			$data['runtime']=$_POST['runtime'];
			$data['address']=$_POST['address'];
			$data['about']=$_POST['about'];
			$data['status']=$_POST['status'];
		}

		
		$conn = M('user');
		$w['username']= array('eq',$_POST['username']);
		$rows = $conn->where($w)->find();
		if($rows){
			$this->error('抱歉，用户名已经存在!');
			exit();
		}else{	
			$data['username']=$_POST['username'];
			$data['password']=md5($_POST['pwd']);
			$data['usercname']=$_POST['usercname'];
			$data['level']=$_POST['type'];
			$data['card']=$_POST['card'];
			$data['tel']=$_POST['tel'];
			$data['email']=$_POST['email'];
			$data['cart'] = 0;
	
			$data['regtime']=time();
			//var_dump($data);
			//exit();
			$row = $conn->add($data);
			$this->Success('添加成功');
		}
	}
	

}