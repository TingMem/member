<?php 
namespace Home\Controller;
use Think\Controller;

	/**
	* 订单管理
	*/

//订单列表
	class StoreOrderController extends StoreNavPublicController
	{
		public function OrderList()
		{
			import("@.ORG.Page"); //导入分页类

			//搜索菜单分类
			$modelData = M('store_type');
			$rows = $modelData->select();

			$t1='';
			$t2='';
			$keyword='';

			//订单列表
			$OrderModel = M("store_order");
			$w['recovery'] = 0;
			//订单搜索
			if(IS_POST){
				$t1 = trim(I('t1'));
				$t2 = trim(I('t2'));
				$keyword = trim(I('search'));

				//查询条件一=>分类查询
				if($t1 != 0){
					$w['tid'] = $t1;
				}

				//查询条件二=>付款状态查询
				if($t2 != 0){
					$w['status'] = $t2;
				}

				$w['order_id|product_name'] = array('like','%'.$keyword.'%');

				$count = $OrderModel->where($w)->count();
				$pagecount = 25;
				$page = new \Bootstrap\Page($count , $pagecount);

				$row = array('t1'=>$t1,'t2'=>$t2,'keyword'=>$keyword);
				$page->parameter = $row; //此处的row是数组，为了传递查询条件
				$page->setConfig('first','首页');
				$page->setConfig('prev','上一页');
				$page->setConfig('next','下一页');
				$page->setConfig('last','尾页');
				$page->setConfig('theme',''.'%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% <li><a aria-label="Next"><span aria-hidden="true">第'.I('p',1).' 页/共 %TOTAL_PAGE% 页 ( '.$pagecount.' 条/页 共 %TOTAL_ROW% 条)</span></a></li>');
				$show = $page->show();
				$OrderList = $OrderModel
				->where($w)
				->order('createtime desc')
				->limit($page->firstRow.','.$page->listRows)
				->select();
				
			}else{
				$count = $OrderModel->where($w)->count();
				$pagecount = 25;
				$page = new \Bootstrap\Page($count , $pagecount);

				//$row = array('t1'=>$t1,'t2'=>$t2,'keyword'=>$keyword);
				//$page->parameter = $row; //此处的row是数组，为了传递查询条件
				$page->setConfig('first','首页');
				$page->setConfig('prev','上一页');
				$page->setConfig('next','下一页');
				$page->setConfig('last','尾页');
				$page->setConfig('theme',''.'%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% <li><a aria-label="Next"><span aria-hidden="true">第'.I('p',1).' 页/共 %TOTAL_PAGE% 页 ( '.$pagecount.' 条/页 共 %TOTAL_ROW% 条)</span></a></li>');
				$show = $page->show();
				$OrderList = $OrderModel
				->where($w)
				->order('createtime desc')
				->limit($page->firstRow.','.$page->listRows)
				->select();
			}
			if(!$OrderList){
				$message = "<tr><td colspan='10'>没有找到符合条件的订单</td></tr>";
			}else{
				$message = '';
			}

			$keysave = array('t1'=>$t1,'t2'=>$t2,'keyword'=>$keyword);
			$this->assign('keysave',$keysave);
			$this->assign('msg',$message);
			$this->assign('ol',$OrderList);
			$this->assign('page',$show);
			$this->assign('shop',$rows);
			$this->display("store:admin:order_list");
		}

//订单放入回收站
		public function OrderDel(){
			$DelList = I('select');
			$OrderModel = M('store_order');
			$w['id'] = array('in',$DelList);
			$data['recovery'] = 1;
			$rs = $OrderModel->where($w)->save($data);
			$this->success('订单已经被放入回收站');
		}
	}

 ?>