<?php 
namespace Home\Controller;
use Think\Controller;

	/**
	* 产品管理
	*/

//产品列表
	class StoreProductController extends StoreNavPublicController
	{
		public function index()
		{
			$this->display("store:admin:order_list");
		}

	//产品管理
		public function ProductList()
		{
			import("@.ORG.Page"); //导入分页类

			//搜索菜单分类
			$modelData = M('store_type');
			$w2['status'] = 1;
			$rows = $modelData->where($w2)->select();

			$ProductModel = M("store_product");
			if(IS_POST){
				$t1 = trim(I('t1'));
				$keyword = trim(I('search'));

				//查询条件一=>分类查询
				if($t1 != 0){
					$w['type_id']=$t1;
				}

				$w['seotitle|product_name'] = array('like','%'.$keyword.'%');

				$count = $ProductModel->where($w)->count();
				$pagecount = 25;
				$page = new \Bootstrap\Page($count , $pagecount);

				$row = array('t1'=>$t1,'keyword'=>$keyword);
				$page->parameter = $row; //此处的row是数组，为了传递查询条件
				$page->setConfig('first','首页');
				$page->setConfig('prev','上一页');
				$page->setConfig('next','下一页');
				$page->setConfig('last','尾页');
				$page->setConfig('theme',''.'%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% <li><a aria-label="Next"><span aria-hidden="true">第'.I('p',1).' 页/共 %TOTAL_PAGE% 页 ( '.$pagecount.' 条/页 共 %TOTAL_ROW% 条)</span></a></li>');
				$show = $page->show();
				$ProductList = $ProductModel
				
				->alias('a')
				->join("left join tp_store_product_type b on b.id=a.shop_id")
				->join("left join tp_store_type c on c.id=a.type_id")
				->order('time desc')
				->field("a.*,b.shopname,c.typename")
				->where($w)
				->limit($page->firstRow.','.$page->listRows)
				->select();
				
			}else{
				$t1='';
				$keyword='';
				$count = $ProductModel->count();
				$pagecount = 25;
				$page = new \Bootstrap\Page($count , $pagecount);

				//$row = array('t1'=>$t1,'keyword'=>$keyword);
				//$page->parameter = $row; //此处的row是数组，为了传递查询条件
				$page->setConfig('first','首页');
				$page->setConfig('prev','上一页');
				$page->setConfig('next','下一页');
				$page->setConfig('last','尾页');
				$page->setConfig('theme',''.'%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% <li><a aria-label="Next"><span aria-hidden="true">第'.I('p',1).' 页/共 %TOTAL_PAGE% 页 ( '.$pagecount.' 条/页 共 %TOTAL_ROW% 条)</span></a></li>');
				$show = $page->show();
				$ProductList = $ProductModel
				->alias('a')
				->join("left join tp_store_product_type b on b.id=a.shop_id")
				->join("left join tp_store_type c on c.id=a.type_id")
				->order('time desc')
				->field("a.*,b.shopname,c.typename")
				->limit($page->firstRow.','.$page->listRows)
				->select();
			}
			if(!$ProductList){
				$message = "<tr><td colspan='12'>没有找到符合条件的订单</td></tr>";
			}else{
				$message = '';
			}

			$keysave = array('t1'=>$t1,'keyword'=>$keyword);
			$this->assign('keysave',$keysave);
			$this->assign('msg',$message);
			$this->assign('ol',$ProductList);
			$this->assign('page',$show);
			$this->assign('shop',$rows);
			$this->display("store:admin:Product");
		}

		//产品删除
		public function ProductDel()
		{
			$DelList = I('select');
			$OrderModel = M('store_product');
			$w['id'] = array('in',$DelList);
			$rs = $OrderModel->where($w)->delete();

			$this->success('产品删除成功','',1);
		}

		public function ProductPicUpload(){
			//产品图片上传
			    $upload = new \Think\Upload();// 实例化上传类
			    $upload->maxSize   =     204800 ;// 设置附件上传大小
			    $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
			    $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
			    //$upload->savePath  =     date("Ymd",time()); // 设置附件上传（子）目录
			    $upload->subName = array('date','Ymd');
		    	$upload->saveName = ['getRandFileName'];

		    	// 循环上传文件 
		   		$info   =   $upload->upload($_FILES);
			    if(!$info) {// 上传错误提示错误信息
			        $this->error($upload->getError());
			        exit();
			    }else{// 上传成功
			    	$pics = array();
			    	foreach ($info as $k => $v) {
			    		$picurl = substr($upload->rootPath,1).$info[$k]['savepath'].$info[$k]['savename'];
			        	$pics['data'] = $picurl;

			        	echo json_encode($pics);
			    	}
			        
			    }
		}


//产品添加Html
		public function ProductAdd()
		{
			//加载一级菜单
			$modelData = M('store_type');
			$ProductModel = M('store_product');
			$w['status'] = 1;
			$rows = $modelData->where($w)->select();

			$this->assign('tn',$rows);
			$this->display('store:admin:ProductAdd');
		}

//产品添加Ajax提交
		public function ProductAddAjax(){
				$modelData = M('store_type');
				$ProductModel = M('store_product');
				$w['status'] = 1;
				$rows = $modelData->where($w)->select();

				$seotitle = I('seotitle');
				$pname = I('productname');
				$typeid = I('typeid');
				$shopid = I('shopid');
				$point = I('point');
				$oprice = I('oprice');
				$price = I('price');
				$purchase = I('purchase');
				$status = I('status');
				$stock = I('stock');
				$product_about = I('product_about');


				//所选规格处理
				$attrs = $_POST['attrs'];
				$c = count($_POST['attrs']);//所选规格个数
				
				$attr_val_id = array();
				foreach ($attrs as $key => $value){
					$attr_val_id[$key] = $_POST['attrs'.$value];
				}

				$attr_id = implode(",",$_POST['attrs']);
				$attr_val_id = implode(",",$attr_val_id);

			   $pic = trim($_POST['picsubmit']);
		       $data['product_pics'] = $pic;
		       $data['seotitle'] = $seotitle;
		       $data['product_name'] = $pname;
		       $data['type_id'] = $typeid;
		       $data['shop_id'] = $shopid;
		       $data['attr_id'] = $attr_id;
		       $data['attr_value_id'] = $attr_val_id;
		       $data['product_point'] = $point;
		       $data['product_oprice'] = $oprice;
		       $data['price'] = $price;
		       $data['purchase'] = $purchase;
		       $data['status'] = $status;
		       $data['stock'] = $stock;
		       $data['product_about'] = $product_about;
		       $data['time'] = time();

		       if($ProductModel->add($data)){
		       		echo 'Success';
		       		exit();
		       }

		}

//被修改的产品信息加载
		public function ProductEdit()
		{
			$id = $_GET['id'];
			//加载一级菜单
			$modelData = M('store_type');
			$ProductModel = M('store_product');
			$w['status'] = 1;
			$rows = $modelData->where($w)->select();

			//加载修改信息
			$editdata = $ProductModel->where("`id` = $id")->find();
			$this->assign('sa',$editdata);
			$this->assign('tn',$rows);
			$this->display('store:admin:ProductEdit');
		}

//Ajax修改产品信息
		public function ProductEditAjax(){
				$modelData = M('store_type');
				$ProductModel = M('store_product');
				$w['status'] = 1;
				$rows = $modelData->where($w)->select();//产品分类

				//产品信息
				$ws['id'] = I('pid');
				$rs = $ProductModel->where($ws)->find();


				$seotitle = I('seotitle');
				$pname = I('productname');
				$typeid = I('typeid');
				$shopid = I('shopid');
				$point = I('point');
				$oprice = I('oprice');
				$price = I('price');
				$purchase = I('purchase');
				$status = I('status');
				$stock = I('stock');
				$product_about = I('product_about');


				//所选规格处理
				$attrs = $_POST['attrs'];
				$c = count($_POST['attrs']);//所选规格个数
				
				$attr_val_id = array();
				foreach ($attrs as $key => $value){
					$attr_val_id[$key] = $_POST['attrs'.$value];
				}

				$attr_id = implode(",",$_POST['attrs']);
				$attr_val_id = implode(",",$attr_val_id);

			   $pic = explode(',',$rs['product_pics']);

			   $picnow = trim($_POST['picsubmit']);

			   if(count($pic)>0 && $picnow!=''){
			   	  $pic = implode(",",$pic).",".$picnow;
			   }else{
			   	  if($picnow==''){
			   	  	$pic = implode(",",$pic);
			   	  }else{
			   	  	$pic = $picnow;
			   	  }
			   }

			   
		       $data['product_pics'] = $pic;
		       $data['seotitle'] = $seotitle;
		       $data['product_name'] = $pname;
		       $data['type_id'] = $typeid;
		       $data['shop_id'] = $shopid;
		       $data['attr_id'] = $attr_id;
		       $data['attr_value_id'] = $attr_val_id;
		       $data['product_point'] = $point;
		       $data['product_oprice'] = $oprice;
		       $data['price'] = $price;
		       $data['purchase'] = $purchase;
		       $data['status'] = $status;
		       $data['stock'] = $stock;
		       $data['product_about'] = $product_about;
		       $data['time'] = time();

		       if($ProductModel->where($ws)->save($data)){
		       		echo 'Success';
		       		exit();
		       }

		}



		//二级联动下拉菜单Ajax处理
		public function ProductLD()
		{
			$typeid = $_POST['id'];
			$ShopModel = M("store_product_type");
			$w['typeid']=$typeid;
			$ShopData = $ShopModel->where($w)->select();

			$str = '<option value="">请选择</option>';
			if($ShopData){
				foreach ($ShopData as $key => $val) {
					$s = '';
					if($val['id']==$_POST['sid']) $s = 'selected';
					$str.="<option $s value='{$val['id']}'>{$val['shopname']}</option>";
				}
			}else{
				$str = "<option value=''>暂无商家</option>";
			}

			echo $str;
		}

//联动菜单附加属性载入Ajax处理
		public function ProductAttrLD()
		{
			$shopid = $_POST['sid'];
			$ShopModel = M("store_attr");
			$w['typeid']=$shopid;
			$ShopData = $ShopModel->where($w)->select();
			$ShopAttrVal = M("store_attr_value");

			$totalstr = '';	

			$attrid = explode(",",$_POST['attrid']);
			$attrvid = explode(",",$_POST['attrvid']);

			//var_dump($attrid);
			if($ShopData){
				foreach ($ShopData as $key => $val) {
					$str = '<div class="form-group row clearfix">';
					$s = '';
					foreach ($attrid as $ke => $va) {
						if($val['id']==$va){
							$s = 'checked';
							break 1;
						}
					}

					$valstr = '';

					$AttrVal = $ShopAttrVal->where("attr_id = {$val['id']}")->select();
					$str.='<div class="col-md-2"><div class="checkbox"><input '.$s.' class="attrss" name="attrs[]" value="'.$val['id'].'" type="checkbox" /></div><label for="attrs">'.$val['attr_name'].'</label></div><div class="col-md-10">';
					foreach ($AttrVal as $k => $v) {
						
						foreach ($attrvid as $keys => $values) {
							$ss = '';
							if($v['id']==$values){
								$ss = 'checked';
								break 1;
							}else{
								$ss = '';
							}
						}
						$valstr .='<p><div class="radio"><input '.$ss.' name="attrs'.$val['id'].'" value="'.$v['id'].'" type="radio" /></div>'.$v['attr_value'].'</p>';
					}
					$totalstr.=$str.$valstr."</div></div>";
				}
			}else{
				$totalstr = "该分类暂无规格";
			}

			echo $totalstr;
		}


//图片删除处理逻辑

		public function ProductPicDel(){
			$ProductModel = M('store_product');
			$pid = I('id');
			$arrid = I('arrid');

			$pathurl = str_replace("-","/",I('pathurl'));

			$row = $ProductModel->where("`id`=$pid")->find();

			$arr = explode(",",$row['product_pics']);
			if($arr[$arrid] == str_replace("","-",$pathurl)){
				unset($arr[$arrid]);
				unlink($pathurl);
				$msg = 1;
				$arrstr = implode(",",$arr);
				$data['product_pics'] = $arrstr;
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