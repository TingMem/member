<?php 
namespace Home\Model;
use Think\Model;

/**
* 规格验证
* Edit Time 2016.11.14 
* By:冷眼看人心、
*/
class StoreSpecModel extends Model
{
	
	protected $_validate = array(
		array('typeid','require','请选择分类',0),
		array('spec_name','require','规格名不能为空',0),
		array('spec_price','currency','价格必须为货币格式',0)
	);
}

 ?>