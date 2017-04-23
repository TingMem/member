<?php
namespace Home\Controller;
use Think\Controller;

class ExcelController extends Controller {

	public function Excel(){
        $xlsName  = "用户录入表".date('Y-m-d H:i:s',time()).".xls";
		$date = $_GET['date'];
		switch ($date){
			case 1:
				$date1 = strtotime(date('Y-m-d', time()));
				$date2 =  (strtotime(date('Y-m-d', time()))+3600*24)-1;
			break;
			case 2:
				$date1 = (strtotime(date('Y-m-d', time()))+3600*24)-(3600*24*7);
				
				$date2 = strtotime(date('Y-m-d', time()));
			break;
			case 3:
				$date1 = (strtotime(date('Y-m-d', time()))+3600*24)-(3600*24*30);
				$date2 = strtotime(date('Y-m-d', time()));
			break;
			case 4:
				$date1 = strtotime("2016-05-20");
				$date2 = strtotime(date('Y-m-d', time()));
			break;
			
		}
				
        $xlsCell  = array(
			array('username','用户帐号'),
			array('usercname','真实姓名'),
			array('sid','惠民卡编号'),
			array('tel','手机'),
			array('card','身份证号'),
			array('jihuotime','激活时间'),
        );
		
//查找当前登录用户分发范围内的指定日期数据
		$xls = M('user');
//取得当前用户分发权限范围
		$ww['username']=array('eq',$_SESSION['admin']);
		$rowf = $xls->where($ww)->field("fanwei")->find();
		
		//var_dump($rowf);
		//exit();
		$arr = explode("|",$rowf['fanwei']);
		$len = count($arr);
		
		//$w['c.jihuotime'] = array('between',array($date1,$date2));//指定日期范围，当天，近7天，近30天
		$w1 =" `lock` = 1 AND c.jihuotime between {$date1} AND {$date2} AND ";
//指定用户所有分发范围卡号
		$w2 ='';
		//var_dump($arr);
		for($i=1;$i<=$len;$i=$i+2){
			if($i+1<$len && $len>2){
				$w2 = $w2."c.sid BETWEEN '{$arr[$i-1]}' AND '{$arr[$i]}' OR ";
			}else{
				$w2 = $w2."c.sid BETWEEN '{$arr[$i-1]}' AND '{$arr[$i]}'";
			}
		}
		
		//$w['c.sid'] = array('between',array($arr[0],$arr[1]));
		$w3 = $w1.$w2;
		$xlsData = $xls->join("LEFT JOIN tp_cart as c ON c.uid = tp_user.id")->where($w3)->field("tp_user.username,tp_user.usercname,tp_user.tel,tp_user.card,c.sid,c.jihuotime")->select();
    	if(!$xlsData){
			$this->error('没有符合您要求的数据');
			exit();
		}
		

        $this->exportExcel($xlsName,$xlsCell,$xlsData);
	}


		
		public function exportExcel($expTitle,$expCellName,$expTableData){

				$xlsTitle = iconv('utf-8', 'gb2312', $expTitle);//文件名称
				//$fileName = $_SESSION['account'].date('_YmdHis');//or $xlsTitle 文件名称可根据自己情况设定
				$cellNum = count($expCellName);
				$dataNum = count($expTableData);
				import("Org.Util.PHPExcel");
			   
				$objPHPExcel = new \PHPExcel();
				$objPHPExcel->getProperties()->setCreator("JAMES")
				->setLastModifiedBy("JAMES")
				->setTitle($expTitle)
				->setSubject("Dorder")
				->setDescription("dorder list")
				->setKeywords('dorder')
				->setCategory('test');	
				function convertUTF8($str)
				{
				   if(empty($str)) return '';
				   return  iconv('gb2312', 'utf-8', $str);
				}
				
				function sub($str){
					if(empty($str)) return '';
					return substr($str,0,10)."****";
				}
				
				function sidmid($str){
					if(empty($str)) return '';
					return "********".substr($str,8);
				}
				
				$objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY);
				$objPHPExcel->getActiveSheet()->getStyle('E')->getNumberFormat()->setFormatCode('000000'); 
				//$objPHPExcel->getActiveSheet()->getStyle('C')->getNumberFormat()->setFormatCode(\PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				
				$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(24);
				$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(24);
				$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(24);
				$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(24);
				$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(24);
				$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(24);
				
				$count = count($expTableData);
				
				$objPHPExcel->getActiveSheet()->setCellValue('A1', "平台帐号");
				$objPHPExcel->getActiveSheet()->setCellValue('B1', "真实姓名");
				$objPHPExcel->getActiveSheet()->setCellValue('C1', "惠民卡号");
				$objPHPExcel->getActiveSheet()->setCellValue('D1', "手机号码");
				$objPHPExcel->getActiveSheet()->setCellValue('E1', "身份证号码");
				$objPHPExcel->getActiveSheet()->setCellValue('F1', "激活时间");

				for ($i = 2; $i <= $count+1; $i++) {
					 $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $expTableData[$i-2]['username']);
					 $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $expTableData[$i-2]['usercname']);
					 $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, sidmid($expTableData[$i-2]['sid']));
					 $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $expTableData[$i-2]['tel']);
					 $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, "-".$expTableData[$i-2]['card']."-");
					 $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, date("Y-m-d H:i:s", $expTableData[$i-2]['jihuotime']));

				}
				
				
				import("Org.Utile.PHPExcel.IOFactory");
				header('pragma:public');
				header('Content-type:application/vnd.ms-excel;charset=utf-8;name="'.date("Y-m-d",time()).'.xls"');
				header("Content-Disposition:attachment;filename=$expTitle.xls");//attachment新窗口打印inline本窗口打印
				$objWriter = \PHPExcel_IOFactory::createWriter( $objPHPExcel, 'Excel5');  
				$objWriter->save('php://output'); 
      			exit; 
		}

}
	
	