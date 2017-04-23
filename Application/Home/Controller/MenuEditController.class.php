<?php
namespace Home\Controller;
use Think\Controller;

class MenuEditController extends NavPublicController {

	public function Menu_Lists(){
		$cfg = M('type');
		$w['tid'] = 0;
		$w['level'] = array('elt',I('session.level'));
		$typetop = $cfg->where($w)->select(); //一级菜单
		
		$ww['tid'] = array('neq',0);
		$ww['level'] = array('elt',I('session.level'));
		$type222 = $cfg->where($ww)->select();  //二级菜单
		
		$this->assign('type111',$typetop);
		$this->assign('type222',$type222);
		$this->display('manage:Menu_Lists');
	}
	
	
	public function Menu_add(){
		$cfg = M('type');
		$w['tid'] = 0;
		$w['level'] = array('elt',I('session.level'));
		$typetop = $cfg->where($w)->select(); //一级菜单
		$this->assign('top',$typetop);
		
		if(IS_POST){
			$typename = trim(I('post.typename'));
			$tid = trim(I('post.tid'));
			$px = trim(I('post.px'));
			$url = trim(I('post.url'));
			$level = trim(I('post.level'));
			$controller = trim(I('post.controller'));
			$action = trim(I('post.action'));
			$icon = trim(I('post.icon'));
			$data['typename']=$typename;
			$data['tid']=$tid;
			$data['px']=$px;
			$data['url']=$url;
			$data['level']=$level;
			$data['controller'] = $controller;
			$data['action'] = $action;
			$data['classicon'] = $icon;
			
			if($cfg->add($data)){
				$this->success('菜单添加成功！');
				exit();
			}else{
				$this->error('添加失败！');
				exit();	
			}
			
		}
		
		
		
		$this->display('manage:Menu_Add');
	}
	
	public function Menu_Edit(){
		$cfg = M('type');
		
		$w['tid'] = 0;
		$w['level'] = array('elt',I('session.level'));
		$typetop = $cfg->where($w)->select(); //一级菜单
		$this->assign('top',$typetop);
		
		
		$id = trim(I('get.id'));
		if(IS_POST){
			$typename = trim(I('post.typename'));
			$tid = trim(I('post.tid'));
			$px = trim(I('post.px'));
			$url = trim(I('post.url'));
			$level = trim(I('post.level'));
			$controller = trim(I('post.controller'));
			$action = trim(I('post.action'));
			$icon = trim(I('post.icon'));
			
			$data['typename']=$typename;
			$data['tid']=$tid;
			$data['px']=$px;
			$data['url']=$url;
			$data['level']=$level;
			$data['controller'] = $controller;
			$data['action'] = $action;
			$data['classicon'] = $icon;
			
			$where['id'] = I('post.id');

			
			if($cfg->where($where)->save($data)){
				$this->success('保存成功！');
				exit();
			}else{
				$this->error('保存失败！');
				exit();	
			}
			
		}
		
		$row = $cfg->where("`id`={$id}")->find();
		$this->assign('body',$row);
		
		$this->display('manage:Menu_Edit');
	}
	
	
	public function Menu_Delete(){
		$cfg = M('type');
		$id = I('get.id');
		if($id!='' || $id!=null){
			if($cfg->where("`id`={$id}")->delete()){
				$this->success('保存成功！');
				exit();
			}else{
				die('error');	
			}
			
		}	
	}
	
}