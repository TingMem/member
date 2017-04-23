<?php 
namespace Home\Controller;
use Think\Controller;

	/**
	* 商品规格
	* Edit Time 2016.11.14
	*/

//规格列表
	class StoreSpecController extends StoreNavPublicController
	{
		public function SpecList()
		{
			$SpecModel = M('store_spec');
			$row = $SpecModel
			->alias('a')
			->join('left join __STORE_TYPE__ b on a.typeid=b.id')
			->field("a.*,b.typename")
			->select();
			$empty = "<tr><td colspan='10'>暂无规格</td></tr>";
			$this->assign('emp',$empty);
			$this->assign('spec',$row);
			$this->display('store:admin:SpecList');

		}


//添加规格
		public function SpecAdd()
		{
			$typeMode = M('store_type');
			$tw['status'] = 1;
			$rows = $typeMode->where($tw)->order('weight asc')->select();

			if(IS_POST){
				$specModel = D('StoreSpec');
				if(!$specModel->create($_POST,1)){
					$this->error($specModel->getError());
					exit();
				}else{
					$specModel->add();
					$this->success('添加成功');
					exit();
				}

			}

			$this->assign('tm',$rows);
			$this->display('store:admin:SpecAdd');

		}


//修改规格
		public function SpecEdit()
		{
			$typeMode = M('store_type');
			$tw['status'] = 1;
			$rows = $typeMode->where($tw)->order('weight asc')->select();

			if(IS_POST){
				$specModel = D('StoreSpec');
				$we['id'] = $_POST['id'];
				if(!$specModel->create($_POST,2)){
					$this->error($specModel->getError());
					exit();
				}else{
					$specModel->where($we)->save($_POST);
					$this->success('修改成功');
					exit();
				}

			}

			$specMode=M('store_spec');
			$w['id'] = $_GET['id'];
			$row = $specMode->where($w)->find();
			$this->assign('spec',$row);
			$this->assign('tm',$rows);
			$this->display('store:admin:SpecEdit');

		}


		//规格删除
		public function SpecDel()
		{
			$DelList = I('select');
			$OrderModel = M('store_spec');
			$w['id'] = array('in',$DelList);
			$rs = $OrderModel->where($w)->delete();

			$this->success('规格删除成功','',1);
		}		
	}

 ?>