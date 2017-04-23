<?php 
namespace Home\Model;
use Think\Model;
/**
* 商家模型
* By :冷眼看人心、
*/
class StoreProductTypeModel extends Model
{

	protected $_validate = array(
		array('shopname','require','商家名不能为空',0),
		array('typeid','require','没有选择分类',0)
	);

	protected $_auto = array(
		array('business_about','htmlspecialchars_decode',3,'function')
	);
}

 ?>