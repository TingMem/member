<?php 
namespace Home\Controller;
use Think\Controller;

	/**
	* 产品管理
	*20161109
	*/

//产品列表
	class StoreShopController extends StoreNavPublicController
	{
		public function ShopList()
		{
			$ShopModel = M('store_product_type');
			$rows = $ShopModel
			->alias('a')
			->join('left JOIN __STORE_TYPE__ b on a.typeid = b.id')
			->field('a.*,b.typename,b.id as bid')
			->order('a.id desc')
			->select();
			$this->assign('spt',$rows);
			$this->display("store:admin:ShopList");
		}

		public function ShopAdd()
		{
			$type = M('store_type');
			$ww['status'] = 1;
			$row = $type
			->where($ww)
			->order("weight")
			->select();
			$this->assign('tn',$row);
			$this->display("store:admin:ShopAdd");
		}

//添加商家
		public function ShopAddAjax()
		{
			$shop = D('store_product_type');
			if($shop->create()){
				$shop->add();
				echo "Success";
			}else{
				$this->error($shop->getError());
			}
		}

//修改商家信息
		public function ShopEditAjax()
		{
			$shop = D('store_product_type');
			$w['id'] = $_POST['aid'];
			if($shop->create()){
				$shop->where($w)->save();
				echo "Success";
			}else{
				$this->error($shop->getError());
			}
		}

		public function ShopEdit()
		{
			$ShopModel = M('store_product_type');
			$type = M('store_type');
			$ww['status'] = 1;
			$row = $type
			->where($ww)
			->order("weight")
			->select();

			$wk['id'] = $_GET['id'];
	//获取当前修改的信息内容
			$rows = $ShopModel
			->where($wk)
			->find();
			$this->assign('sa',$rows);
			$this->assign('tn',$row);
			$this->display("store:admin:ShopEdit");
		}

//禁用商家
		public function ShopSaveStatus()
		{
			$save = M('store_product_type');
			$s = implode(",",I('select'));
			$status = $_GET['sta'];
			if(!$s){
				$this->error('您没有选择任何选项');
				exit();
			}

			$w['id'] = array('in',$s);
			$d['status'] = $status;
			if($save->where($w)->save($d)){
				$this->success('数据修改成功','',2);
			}else{
				$this->error($save->getError());
			}
		}

//删除商家
		public function ShopDel()
		{
			$save = M('store_product_type');
			$s = implode(",",I('select'));
			if(!$s){
				$this->error('您没有选择任何选项');
				exit();
			}
			$w['id'] = array('in',$s);
			if($save->where($w)->delete()){
				$this->success('数据删除成功','',2);
			}else{
				$this->error($save->getError());
			}
		}


//图片删除处理逻辑

		public function ShopPicDel(){
			$ProductModel = M('store_product_type');
			$pid = I('id');
			$arrid = I('arrid');

			$pathurl = str_replace("-","/",I('pathurl'));

			$row = $ProductModel->where("`id`=$pid")->find();

			$arr = explode(",",$row['picsimg']);
			if($arr[$arrid] == str_replace("","-",$pathurl)){
				unset($arr[$arrid]);
				unlink($pathurl);
				$msg = 1;
				$arrstr = implode(",",$arr);
				$data['picsimg'] = $arrstr;
				if(!$ProductModel->where("`id`=$pid")->save($data)){
					$msg = "数据库更新失败，请检查参数或语法";
				}
			}else{
				$msg = '非法文件名';
			}
			//$msg = $arr[$arrid]." - ".str_replace("","-",$pathurl);
			$msg = json_encode($msg);
			echo  $msg;
			
			
		}

	}

 ?>