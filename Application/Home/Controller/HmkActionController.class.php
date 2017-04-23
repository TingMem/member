<?php
namespace Home\Controller;
use Think\Controller;


class hmkActionController extends NavPublicController {



//消费记录统计。
	public function fenxi(){
		header("Content-Type:text/html; charset=utf-8");
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
			$msg = $star.' - '.$end.'消费次数：';	
		}else{
			$msg = '总消费次数：';	
		}
		
		
		$date = date('Y-m-d',(time()-3600*24*7))." - ".date('Y-m-d',time());//初始化日期输入框的时间段
		$this->assign('date',$date);
		$this->assign('count',$count);
		$this->assign('count2',$count2);
		$this->assign('msg',$msg);
		$this->assign('tongji',$tongji);
		$this->assign('tongji2',$tongji2);
		$this->display('manage:fenxi');
	}
}