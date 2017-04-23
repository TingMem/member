<?php 
namespace Home\Controller;
use Think\Controller;

	/**
	* 顶级分类管理
	*/

//顶级分类管理
	class StoreTypeController extends StoreNavPublicController
	{
		public function TypeList()
		{
			$TypeModel = M('store_type');

			if(IS_POST){
				$arr = $_POST['weight'];
				$arrid = $_POST['typeid'];

				foreach ($arr as $key => $value) {
					$w['id'] = $arrid[$key];
					$data['weight'] = $value;
					$TypeModel->where($w)->save($data);
				}

				$this->success('排序更新成功！');
				exit();
			}
			$ww['status'] = 1;
			$rows = $TypeModel->where($ww)->order('weight asc')->select();

			if(!$rows){
				$message = "<tr><td colspan='10'>没有找到符合条件的分类</td></tr>";
			}else{
				$message = '';
			}
			$this->assign('msg',$message);
			$this->assign('typelist',$rows);
			$this->display("store:admin:TypeList");
		}

//分类回收站
		public function TypeRecovery()
		{
			$TypeModel = M('store_type');
			$ww['status'] = 0;
			$rows = $TypeModel->where($ww)->order('weight asc')->select();

			if(!$rows){
				$message = "<tr><td colspan='10'>没有找到符合条件的分类</td></tr>";
			}else{
				$message = '';
			}

			$this->assign('msg',$message);
			$this->assign('typelist',$rows);
			$this->display("store:admin:TypeRecovery");
		}	

		public function TypeReset(){
			$DelList = I('select');
			$TypeModel = M('store_type');
			$w['id'] = array('in',$DelList);
			$data['status'] = 1;
			$rs = $TypeModel->where($w)->save($data);
			$this->success('成功恢复选中分类');
		}		

		public function TypeDel(){
			$DelList = I('select');
			$TypeModel = M('store_type');
			$w['id'] = array('in',$DelList);
			$data['status'] = 0;
			$rs = $TypeModel->where($w)->save($data);
			$this->success('成功关闭选中分类');
		}

//添加分类
		public function TypeAdd(){

			if(IS_POST){
				$TypeModel = M('store_type');
				$type_name = trim(I('type_name'));
				//$type_pic = I("typepic");
				$type_status = I("type_status");
				$weight = I("weight");

//上传分类图标
				$name = time();
			    $upload = new \Think\Upload();// 实例化上传类
			    $upload->maxSize   =     204800 ;// 设置附件上传大小
			    $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
			    $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
			    //$upload->savePath  =     date("Ymd",time()); // 设置附件上传（子）目录
			    $upload->subName = array('date','Ymd');
			    $upload->saveName = date('YmdHis',time()).rand(1000,9999); 
			    // 上传文件 
			    $info   =   $upload->uploadOne($_FILES['typepic']);
			    if(!$info) {// 上传错误提示错误信息
			        $this->error($upload->getError());
			    }else{// 上传成功
			        $picurl = substr($upload->rootPath,1).$info['savepath'].$info['savename'];
			        $data['typename'] = $type_name;
			        $data['status'] = $type_status;
			        $data['picurl'] = $picurl;
			        $data['weight'] = $weight;
			       if($TypeModel->add($data)){
			       		$this->success('分类添加成功','',2);
			       		exit();
			       }
			    }
			}

			$this->display("store:admin:TypeAdd");
		}

//分类修改
		public function TypeEdit(){

			$TypeModel = M('store_type');

			$id = $_GET['id'];
			$w['id'] = $id;

			if(IS_POST){
				$id = $_POST['editid'];
				$ww['id'] = $id;
				$rs = $TypeModel->where($ww)->find();

				$type_name = trim(I('type_name'));
				$typeid = I("id");
				$type_status = I("type_status");
				$weight = I("weight");

				$data['typename'] = $type_name;
				$data['type_status'] = $type_status;
				$data['weight'] = $weight;

				if($_FILES['typepic']['error']==4){
			        $TypeModel->where($ww)->save($data);
		       		$this->success('分类保存成功','',2);
		       		exit();
				}else{
//上传分类图标
				    $upload = new \Think\Upload();// 实例化上传类
				    $upload->maxSize   =     204800 ;// 设置附件上传大小
				    $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
				    $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
				    //$upload->savePath  =     date("Ymd",time()); // 设置附件上传（子）目录
				    $upload->subName = array('date','Ymd');
				    $upload->saveName = date('YmdHis',time()).rand(1000,9999); 
				    // 上传文件 
				    $info   =   $upload->uploadOne($_FILES['typepic']);
				    if(!$info) {// 上传错误提示错误信息
				        $this->error($upload->getError());
				    }else{// 上传成功
				        $picurl = substr($upload->rootPath,1).$info['savepath'].$info['savename'];
				        $data['picurl'] = $picurl;
				       if($TypeModel->where($ww)->save($data)){
				       		$this->success('分类保存成功','',2);
				       		exit();
				       }
				    }
			    }
			}

			$row = $TypeModel->where($w)->find();

			$this->assign('tpe',$row);
			$this->display("store:admin:TypeEdit");
		}
	}

 ?>