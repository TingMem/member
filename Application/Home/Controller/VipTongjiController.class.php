<?php
namespace Home\Controller;
use Think\Controller;

class VipTongjiController extends NavPublicController {


	public function vip_xiaoliang (){
		 $vipcount = A('VipCode');
		 $vipcount -> vipcode();
		
		$DataList = M('user');
		$SpList = M('cart');

		$diysql = M();
		$ww['a.`level`'] = 9;//已绑定用户的惠民卡0为未绑定
		$title = '全部销售记录';
		$nw = '';
		//$w['a.level'] = 9;
		$w['lock'] = 1;
		if(IS_POST){//按日期、录入用户查看

			$sd1 = strtotime(substr($_POST['date'],0,10));	
			$ed1 = strtotime(substr($_POST['date'],13,10));

			//$title = $sd1.' - '.$sd2;
			
			$w['jihuotime']=array('between',array($sd1,$ed1));
			$title = substr($_POST['date'],0,10)." - ".substr($_POST['date'],13,10);

			$sql = "SELECT c.v,d.usercname,d.username from (SELECT a.zuozhe,COUNT(zuozhe) as v FROM tp_cart a LEFT JOIN tp_user b ON a.uid=b.id WHERE a.`lock`=1 AND a.jihuotime between $sd1 and $ed1  GROUP BY a.zuozhe) c LEFT JOIN tp_user d ON c.zuozhe=d.username where username<>'' ORDER BY c.v desc";
			$nw = $diysql->query($sql);
		}else{

			$sql = "SELECT c.v,d.usercname,d.username from (SELECT a.zuozhe,COUNT(zuozhe) as v FROM tp_cart a LEFT JOIN tp_user b ON a.uid=b.id WHERE a.`lock`=1   GROUP BY a.zuozhe) c LEFT JOIN tp_user d ON c.zuozhe=d.username where username<>'' ORDER BY c.v desc";

			$nw = $diysql->query($sql);
		}
		//var_dump($sql);
		//exit;
		$rows = $DataList
		->alias('a')
		->join('LEFT JOIN __CART__ b on a.`username` = b.`zuozhe`')
		->where($ww)
		->group('a.`username`')
		->field('b.*,a.`usercname`,a.`username` as name,count(b.zuozhe) as sumval')
		->order('count(b.zuozhe) desc')
		->select();
		//var_dump($rows);
		
		$date = date('Y-m-d',(time()- 3600*24*7))." - ".date('Y-m-d',time());
		
		$maxsum = 0;
		$maxsum2 = 0;
		//var_dump($rows);
		foreach($rows as $k=>$v){
			$maxsum+=$v['sumval'];
			
		}
		
		$internet = 0;

		foreach($nw as $k2=>$v2){
			$maxsum2+=$v2['v'];
			if($v2['username']=='internet'){
				$internet += $v2['v'];
			}
		}
		$this->assign('internet',$internet);
		$this->assign('maxsum',$maxsum);
		$this->assign('maxsum2',$maxsum2);
		$this->assign('nw',$nw);
		$this->assign('title',$title);
		$this->assign('date',$date);
		$this->assign('newsvip',$rows);
//惠民卡销售统计结束		
	
//以下统计消费记录
		$conn = M('log');
			
		if(IS_POST){//按输入的日期时间段统计
			$star = substr(I('post.date'),0,10);
			$end = substr(I('post.date'),13,10);
			$wm['xftime'] = array('between',array(strtotime($star),strtotime($end)));
		}
		
		
		$wm['shopname'] = array(array('neq',''),array('neq','测试专用')); //不统计测试帐号
		$wm['_logic'] = 'AND';
		$wm2['shopname'] = array(array('neq',''),array('neq','测试专用'));
		
		$count = $conn->where($wm)->count();
		$count2 = $conn->where($wm2)->count();
		
		$tongji = $conn->field("shopname,count(username) as gnum")->where($wm)->group("shopname")->order('gnum desc')->select();
		$tongji2 = $conn->field("shopname,count(username) as gnum")->where($wm2)->group("shopname")->order('gnum desc')->select();
		
		if(isset($star)&&isset($end)){
			$msg = $star.' - '.$end;	
		}else{
			$msg = '全部';	
		}

		$this->assign('count',$count);
		$this->assign('count2',$count2);
		$this->assign('tongji',$tongji);
		$this->assign('tongji2',$tongji2);	
		$this->assign('msg',$msg);
		
		
		$this->display('manage:vip_xiaoliang');
	}
}