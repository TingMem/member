<?php
namespace Home\Controller;
use Think\Controller;
use Think\Model;

class StoreTypeListController extends Controller {

//商家列表方法	
    public function index(){
		header("Content-Type:text/html; charset=utf-8");
		$typeid = $_GET['typeid'];
		$type = M("store_type");
		$typeabout = $type->where("id = $typeid")->find();
		$this->assign("tb",$typeabout);

		$model = D('store_product_type');
		$w['typeid'] = $typeid;
		$shoplist = $model->where($w)->limit(0,5)->select(); //商家列表
		foreach ($shoplist as $key => $value) {
			$shoplist[$key] =  $model->create($value,3);
		}

		$emp = '<div class="row shoplist" style="margin: 0px; margin-bottom: 5px; padding: 10px;">暂无商家</div>';
		$this->assign('emp',$emp);			
		$this->assign('shoplist',$shoplist);
		$this->display('index:store_list');

	}


//分页流加载
	public function PageSplit()
	{

		$typeid = $_GET['typeid'];
		$thispage = $_GET['page'];
		$model = D('store_product_type');
		$w['typeid'] = $typeid;
		$total = $model->where($w)->count(); //当前分类下的商家数量

		$pages = ceil($total/5);
		$page = $_GET['page']*5;
		$shoplist = $model->where($w)->limit(0,5)->select(); //商家列表
		foreach ($shoplist as $key => $value) {
			$shoplist[$key] =  $model->create($value,3);//通过模型过滤html标签
		}

		$result['pages'] = $pages;
		$result['data'] = $shoplist;
		$json_str = json_encode($result);
		echo $json_str;
	}
	
}