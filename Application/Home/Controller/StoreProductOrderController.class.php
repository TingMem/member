<?php
namespace Home\Controller;
use Think\Controller;
use Think\Model;

class StoreProductOrderController extends Controller {

    public function ProductOrder(){
		header("Content-Type:text/html; charset=utf-8");
		$id = $_GET['id'];
		$sid = $_GET['tid'];
		$w['id'] = $id;
		$pm = M('store_product');
		$attrModel = M('store_attr');
		$attrvModel = M('store_attr_value');

		$row = $pm->where($w)->find();//产品信息

		$specModel = M('store_spec');
		$spw['typeid'] = $sid;
		$spec = $specModel->where($spw)->select();//规格

		$aw['id'] = array('in',$row['attr_id']);
		$avw['id'] = array('in',$row['attr_value_id']);
		$attr = $attrModel->where($aw)->select();
		$attrv = $attrvModel->where($avw)->select();//附加信息


		$this->assign('attr',$attr);
		$this->assign('attrv',$attrv);
		$this->assign('spec',$spec);
		$this->assign('odr',$row);
		$this->display('index:store_product_order');
	}



	public function OrderPost(){

		$OrderModel = M('store_order');

		$product = M('store_product'); //产品表
		$user = M('user');
		$spec = M('store_spec');

		$sprice = 0;
		$num =  $_POST['num'];

		if(isset($_POST['spec'])){
			$sid = implode(",",$_POST['spec']); //所选规格
		}else{
			$sid = 0;
		}
			
		if($sid!=0){
			$inw['id'] = array('in',$sid);
			$arr = $spec->where($inw)->select();
			foreach($arr as $key => $v){
				$sprice += $v['spec_price']*$num; //规格价格
			}
		}
		$pid = $_POST['pid'];
		$pw['id'] = $pid;
		$rs = $product->where($pw)->find(); //产品详情
		$tid = $rs['type_id'];//分类名
		$shopid = $rs['shop_id']; //商家
		$user = M('user');
		$username = $_SESSION['admin']; //用户信息
		$uw['username'] = $username;
		if(!$username){
			$this->error('请先登录',U('Index/Login'),2);
			exit();
		}

		$userdata = $user->where($uw)->find();

		if(!$userdata){
			$this->error('请先登录',U('Index/Login'),2);
			exit();
		}
		$attrvalue = implode(",",$_POST['attrvalue']);

		$order_id = date('Ymd',time()).time().rand(1000,9999);//构造订单号 日期+时间戳+1000到9999的随机数

		$data['order_id'] = $order_id;
		$data['uid'] = $userdata['id'];
		$data['pid'] = $pid;
		$data['attr_value'] = $attrvalue;
		$data['tid'] = $tid;
		$data['spec_id'] = $sid;
		$data['username'] = $userdata['username'];
		$data['product_name'] = $rs['product_name'];
		$data['price'] = $rs['price'];
		$data['num'] = $num;
		$data['total_price'] = $rs['price']*$_POST['num']+$sprice;
		$data['createtime'] = time();
		$data['order_status'] = 0;
		$data['recovery'] = 0;  //用户删除后的回收站，管理员依然可见。
		$data['pay_type'] =$_POST['pay'];

		if(!isset($_SESSION['fresh']) || $_SESSION['fresh']!=1){
			if($OrderModel->add($data)){
				$lastid = $OrderModel->getLastInsID();
				$where['a.id'] = $lastid;
				$rows = $OrderModel
				->alias('a')
				->join('left join __STORE_PRODUCT__ b on a.pid=b.id')
				->field("a.*,b.product_name")
				->where($where)->find();

				$specModel = M('store_spec');

				if(isset($rows['spec_id'])){
					$w['id'] = array('in',$rows['spec_id']);
					$sp = $specModel->where($w)->select();
				}

				$arr = array();
				foreach ($sp as $key => $value) {
					$arr[$key] = $value['spec_name'];
				}
				$arr = implode(",",$arr);
				$rows['spec'] = $arr;
				$_SESSION['fresh'] = 1;
				
//库存操作
				$stock = M('store_product');
				$prew['id'] = $pid;
				$stock->where($prew)->setDec('stock',$num);

				$this->assign('order',$rows);
				$this->display('index:store_order_pay');//订单确认
			}else{
				var_dump($OrderModel->getError());
			}
		}else{
			$_SESSION['fresh'] = 0;
			$this->error('页面已过期',U('StoreIndex/index'),2);
		}
	}



	public function  UserOrderList()
	{

		$check = A('UserCheck');
		$check->chksession();
		$order = M('store_order');
		$username = $_SESSION['admin'];
		$w['username'] = $username;
		$OrderList = $order
		->alias("a")
		->join("left join __STORE_PRODUCT__ b on a.pid = b.id")
		->join('left join __STORE_PRODUCT_TYPE__ c on b.shop_id =c.id')
		->field("a.*,b.product_pics,c.shopname")
		->where($w)->order('createtime desc')->limit(0,5)->select();
		//var_dump($OrderList);

		$this->assign('order',$OrderList);
		$this->display("index:store_order_list");
	}
}