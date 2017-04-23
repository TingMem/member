<?php
namespace Home\Controller;
use Think\Controller;
use Think\Model;

class StoreShopIndexController extends Controller {

    public function ShopArticle(){
		header("Content-Type:text/html; charset=utf-8");

		$ShopModel = M("store_product_type");
		$attrModel = M('store_attr');
		$attrvModel = M('store_attr_value');
		$Product = M("store_product");
		$id = $_GET['id'];
		$w['id'] = $id;
		$rows = $ShopModel->where($w)->find();//当前商家分类

		$ww['shop_id'] = $id;
		$rs = $Product->where($ww)->select(); //当前商家的所有产品

		$specModel = M('store_spec');
		$spw['typeid'] = $rows['typeid'];
		$spec = $specModel->where($spw)->select();

		//提取每个产品的所有附加属性，并保存到 $rs['str']中拼接起来。
		foreach ($rs as $key => $val) {
			$rs[$key]['str']='';
			$aw['id'] = array('in',$val['attr_id']);
			$attr = $attrModel->where($aw)->limit(0,3)->select();  //附加项
			$avw['id'] = array('in',$val['attr_value_id']);
			$attrv = $attrvModel->where($avw)->select(); //附加属性的值
			foreach ($attr as $ke => $va) {
				$rs[$key]['str'] = $rs[$key]['str'].$va['attr_name']."-".$attrv[$ke]['attr_value']."，";//开始拼接
			}

			$rs[$key]['str'] = substr($rs[$key]['str'],0,-3);//去掉每个产品附加属性拼接后，最后面的逗号。
		}

		$arrimg = explode(",",$rows['picsimg']);//切割图片组
		$this->assign('spec',$spec);
		$this->assign('sae',$rows);
		$this->assign('productlist',$rs);  //映射产品列表给模版
		$this->assign('arrs',$arrimg);
		$this->display('index:store_shop_article2');
	}

	public function ProductArticle(){
		$id = $_GET['id'];
		$pm = M('store_product');
		$attrModel = M('store_attr');
		$attrvModel = M('store_attr_value');

		$ShopModel = M("store_product_type");
		$w['id'] = $id;

		$row = $pm->where($w)->find();

		$aw['id'] = array('in',$row['attr_id']);
		$avw['id'] = array('in',$row['attr_value_id']);
		$attr = $attrModel->where($aw)->select();
		$attrv = $attrvModel->where($avw)->select();

		$ww['id'] = $row['shop_id'];
		$rows = $ShopModel->where($ww)->find();//当前商家分类
		$arrimg = explode(",",$row['product_pics']);//切割图片组
		$this->assign('arrs',$arrimg);
		$this->assign('attr',$attr);
		$this->assign('attrv',$attrv);
		$this->assign('sae',$rows);
		$this->assign('cp',$row);

		$this->display('index:store_product_article');
	}
}