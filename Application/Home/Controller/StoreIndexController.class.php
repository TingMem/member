<?php
namespace Home\Controller;
use Think\Controller;
use Think\Model;

class StoreIndexController extends Controller {

//商城首页方法	
    public function index(){
		header("Content-Type:text/html; charset=utf-8");
		$model = M('store_type');
		$rows = $model->where('status = 1')->select(); //一级分类

		//推荐商家
		$shopModel = D('StoreProductType');
		$w['falg']='c';
		$w['status'] = 1 ;
		

		$shopdata = $shopModel->where($w)->limit(0,5)->select();
		foreach ($shopdata as $key => $value) {
			$shopdata[$key] =  $shopModel->create($value,3);
		}

		$this->assign('shoplist',$shopdata);
		$this->assign('typelist',$rows);
		$this->display('index:store_index');
	}

	
	public function IndexAjax(){
		$model = M('store_type');
		$rows = $model->where('status = 1')->select(); //一级分类

		//推荐商家
		$shopModel = D('StoreProductType');
		$w['falg']='c';
		$w['status'] = 1 ;
		$count = $shopModel->where($w)->count();
		$pages = ceil($count /5);
		$arr = array();
		$shopdata = $shopModel->where($w)->limit(($_GET['page']*5)-5,5)->select();
		foreach ($shopdata as $key => $value) {
			$shopdata[$key] =  $shopModel->create($value,3);
		}

		$arr['pages'] = $pages;
		$arr['data'] =$shopdata;

		$json_str =json_encode($arr);
		echo $json_str;

	}
}