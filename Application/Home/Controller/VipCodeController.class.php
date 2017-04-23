<?php
namespace Home\Controller;
use Think\Controller;

class VipCodeController extends NavPublicController {
public function VipCode(){

		$cfg = M('cart');
		$cfg2 = M('user');
		$row = $cfg2->where("username = '{$_SESSION['admin']}'")->find();
		$fanwei = $row['fanwei'];


		$arr = explode("|",$fanwei);//取出用户售卡范围
			$sql='';
			$cou = count($arr);
			$wl = "`lock` = 1 and ";
			for($i=1;$i<=$cou;$i=$i+2){
				if($cou>2){
					if($i+1<$cou){
						if($i>2){
							$sql = $sql."`sid` between {$arr[$i-1]} and {$arr[$i]} or ";
						}else{
							$sql = $sql."(`sid` between {$arr[$i-1]} and {$arr[$i]} or ";
						}
					}else{
						$sql = $sql."`sid` between {$arr[$i-1]} and {$arr[$i]})";
					}
					
				}else{
					$sql = $sql."`sid` between {$arr[$i-1]} and {$arr[$i]}";//解决如果数组长度只有2时导致sql后面多一半)问题
				}
					
				
			}
			$query = $sql;
			$count = $cfg->where($query)->order('sid asc')->count();
			$locks = $cfg->where($wl.$query)->order('sid asc')->count();//当前已经绑定的惠民卡数
			
			$uinter = $cfg2->where("`username` = 'internet'")->find();
			$array = explode("|",$uinter['fanwei']);
			$lenght = count($array);
			//var_dump($lenght);
			$wd = "`lock` = 1 and ";
			$isql='';
			for($k = 0 ;$k<$lenght;$k+=2){
//拼接sql，由于数组长度不一样 ，拼接出来的sql也不一样  ，比如后面的or ，如果数组长度为2，那么它就不能够存在，或者前面和后面的(  ) 括弧，前面的括弧只能是在数组长度大于2且当前$k[0]的时候加进去...
				if($lenght>2){
					if($k+2<$lenght){
						if($k<1){
							$isql =$isql. "(`sid` between {$array[$k]} and {$array[$k+1]} or ";
						}else{
							$isql =$isql. "`sid` between {$array[$k]} and {$array[$k+1]} or ";
						}
					}else{
						$isql = $isql."`sid` between {$array[$k]} and {$array[$k+1]})";
					}
				}else{
					$isql = $isql."`sid` between {$array[$k]} and {$array[$k+1]}";	
				}
			}
	
			$internet = $cfg->where($wd.$isql)->count();//电子卡已发售数量
//统计该用户已发售卡数
		
			$ok = ($count)-($locks);//剩余卡数
			$stk = $locks - $internet;//实体卡已发售数量
					
		
		
		if($_SESSION['level']<10){
			$sqlv='';
			$cous = count($arr);
			$wk = "`lock` = 0 and ";
			for($i=1;$i<=$cous;$i=$i+2){
				if($cous>2){
					if($i+1<$cous){
						if($i>2){
							$sqlv = $sqlv."`sid` between {$arr[$i-1]} and {$arr[$i]} or ";
						}else{
							$sqlv = $sqlv."(`sid` between {$arr[$i-1]} and {$arr[$i]} or ";
						}
					}else{
						$sqlv = $sqlv."`sid` between {$arr[$i-1]} and {$arr[$i]})";
					}
				}else{
					$sqlv = $sqlv."`sid` between {$arr[$i-1]} and {$arr[$i]}";//解决如果数组长度只有2时导致sql后面多一半)问题
				}
			}
			$query = $wk.$sql;
			$rev = $cfg->where($query)->order('sid asc')->find();
			//$minsid =$rev['sid'];
			$minsid = '519777000';

		}else{
			$minsid = '519777000';
		}
		
			$sqlc='';
			$couc = count($arr);
			$wj = "`lock` = 1 and ";
			for($i=1;$i<=$couc;$i=$i+2){
				if($couc>2){
					if($i+1<$couc){
						if($i>2){
							$sqlc = $sqlc."`sid` between {$arr[$i-1]} and {$arr[$i]} or ";
						}else{
							$sqlc = $sqlc."(`sid` between {$arr[$i-1]} and {$arr[$i]} or ";
						}
					}else{
						$sqlc = $sqlc."`sid` between {$arr[$i-1]} and {$arr[$i]})";
					}
					
				}else{
					$sqlc = $sqlc."`sid` between {$arr[$i-1]} and {$arr[$i]}";
				}
			}
			$querys = $wj.$sql;
			$viplock = $cfg->where($querys)->order('jihuotime desc')->limit(0,15)->select();
			
			$vip = array("count"=>$count,"ok"=>$ok,"locks"=>$locks,"sid"=>$minsid,'stk'=>$stk,'internet'=>$internet);
			$n=1;
			$arrstr='';
		
//因为范围是两两成对的，所以必须要判断它的奇偶，然后在前面加上范围$i，依次循环拼接。（效果：范围1: 51977700003000 - 51977700003400   范围2: 51977700005001 - 51977700005500）
		foreach($arr  as $val => $key){
			$stn = "范围".($n).": ";	
			if($val % 2 ==0){
				$n++;	
			}
			
			if(($val) % 2 ==0){
				$arrstr = $arrstr.$stn.$arr[$val]." - ";
			}else{
				$arrstr = $arrstr.$arr[$val]."&nbsp;&nbsp;&nbsp;";
			}
			
		}
		
		//var_dump($arrstr);
		$this->assign("arr",$arrstr);
		$this->assign('vip',$vip);
		$this->assign('viplock',$viplock);
		//$this->display("manage:vipreg");
	}
}