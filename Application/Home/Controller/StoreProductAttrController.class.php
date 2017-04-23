<?php 
namespace Home\Controller;
use Think\Controller;

	/**
	* 产品管理
	*/

//产品列表
	class StoreProductAttrController extends StoreNavPublicController
	{
		public function AttrList()
		{
			$AttrModel = M('store_attr');
			$rows = $AttrModel
			->alias('a')
			->join('left join __STORE_TYPE__ b ON b.id=a.typeid')
			->field('a.*,b.typename')
			->order('id desc')
			->select();
			$this->assign('attrlist',$rows);
			$this->display("store:admin:AttrList");
		}

//属性添加
		public function AttrAdd()
		{
			$modelData = M('store_type');
			$rows = $modelData->select();

			if(IS_POST){

			//添加流程： 写入属性 => 写入属性选项 =>属性选项绑定给属性[因为之前写入的时候是不知道属性选项的ID的，所以要更新上去]
				$AttrModel = M('store_attr');
				$AttrValue = M('store_attr_value');

				$attrdata['typeid'] = I('typeid');
				$attrdata['attr_name'] = I('attrname');
				$attrdata['attr_text_type'] = I('text_type');
				$attrdata['attr_status'] = I('attr_status');
				$attrVals =$_POST['attr_value'];
				$arrlen = count($attrVals);      //统计该属性有多少选项

				$attrID = $AttrModel->add($attrdata);//属性信息写入

				$arrID = array();

				//属性选项循环写入
				foreach ($attrVals as $key => $value) {
					$data['attr_id'] = $attrID;
					$data['attr_value'] = $value;
					$id = $AttrValue->add($data);
					$arrID[$key] = $id;
				}

				$w['id']=$attrID;
				$valid = implode(",",$arrID);
				$att['attr_valuesid'] = $valid;
				$result = $AttrModel->where($w)->save($att); //把写入的属性选项绑定到当前属性

				if($result){
					$this->success('属性添加成功','',2);
					exit();
				}
			}

			$this->assign('typename',$rows);
			$this->display("store:admin:AttrAdd");
		}

//属性删除
		public function AttrDel(){
			$AttrModel = M('store_attr');
			$AttrValue = M('store_attr_value');

			if($_GET['attrid']!=''){
				$w['id']=$_GET['attrid'];
				$row = $AttrModel->where($w)->delete();

				$wv['attr_id'] = $_GET['attrid'];
				$rs = $AttrValue->where($wv)->delete();

				$this->success('成功删除一条属性，属性ID为：'.$_GET['attrid'],'',2);
				exit();
			}else if(IS_POST){
				$arrid = $_POST['select'];
				foreach ($arrid as $key => $value){
					$w['id']=$value;
					$row = $AttrModel->where($w)->delete(); //删除属性信息

					$wv['attr_id'] = $value;
					$rs = $AttrValue->where($wv)->delete();//删除属性值

					$num = $key;
				}
				$this->success('成功删除'.$num.'条属性，属性ID为：'.implode(',',$arrid),'',2);
				exit();
			}
		}

//属性编辑
		public function AttrEdit(){
			header("Content-Type:text/html; charset=utf-8");
			$modelData = M('store_type');
			$AttrModel = M('store_attr');
			$AttrValue = M('store_attr_value');
			$rows = $modelData->select();

			$eid = $_GET['id'];
			if(!$eid){
				$this->error('获取参数失败');
				exit();
			}

			$w['id'] = $eid;
			$wv['attr_id'] = $eid;
			$attrdata  = $AttrModel->where($w)->find();
			$attrval = $AttrValue->where($wv)->select();

			if(IS_POST){
				$attr_name = trim(I('attr_name'));
				$text_type = I('text_type');
				$attr_status = I('attr_status');
				$typeid = I('typeid');

				$attr_value = I('attr_value');
				$attr_value_id = I('attr_value_id');
				$aid = explode(",",$attrdata['attr_valuesid']);

				foreach ($attr_value as $key => $value) {
					$n = 0;
					foreach ($aid as $k => $v) {
						if($attr_value_id[$key] == $v){
							$n=1;
							break 1;
						}
					}

					if($n==1){
						$w['id'] = $attr_value_id[$key];
						$data['attr_value'] = $value;
						$AttrValue->where($w)->save($data);
					}else{
						$data['attr_value'] = $value;
						$data['attr_id'] = $eid;
						$AttrValue->add($data);
					}
				}
				$rs = $AttrValue->where($wv)->select();
				$arrs = array();
				foreach ($rs as $ke => $val) {
					$arrs[$ke] = $val['id'];
				}

				$estr = implode(",",$arrs);
				$editdata['attr_valuesid'] = $estr;
				$editdata['typeid'] =$typeid;
				$editdata['attr_name'] =$attr_name;
				$editdata['attr_status'] =$attr_status;
				$editdata['text_type'] =$text_type;
				$ww['id'] = $_GET['id'];
				
				$AttrModel->where($ww)->save($editdata);
				$this->success("信息保存成功",'',2);
				exit();
			}

			$this->assign('ata',$attrdata);
			$this->assign('al',$attrval);
			$this->assign('typename',$rows);
			$this->display('store:admin:AttrEdit');
		}

//属性值删除
		public function AttrValueDel(){
			$id = $_POST['id'];
			$attrid = $_POST['attrid'];
			$AttrModel = M('store_attr');
			$AttrValue = M('store_attr_value');

			$w['id'] = $attrid;
			if($AttrValue->delete($id)){
			//把该属性值从属性表中移除
				$row = $AttrModel->where($w)->find();
				$str = $row['attr_valuesid'];
				$arr = explode(",",$str);

				foreach ($arr as $key => $value) {
					if($value==$id) unset($arr[$key]); 
				}

				$d['attr_valuesid'] = implode(',',$arr);
				$AttrModel->where($w)->save($d);
				echo 1; //Success
			}else{
				echo 0; //Error
			}
		}
	}

 ?>