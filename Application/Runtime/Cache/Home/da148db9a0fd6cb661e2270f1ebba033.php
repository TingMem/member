<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no">
<title>钦州旅游网 - 我的订单</title>
<link rel="stylesheet" type="text/css" href="/Public/Css/base.css" />
<script type="text/javascript" src="/Public/js/jquery.min.js"></script>
</head>

<body>
<div class="dt_top">
	<div style="width:25%; float:left;"><a href="/index.php/home/index/index"><img style="height:30px" src="/Public/images/shangjia/list_back.png" /></a></div>
    <div class="fontsize fontcolor" style="width:50%; text-align:center; color:#fff;float:left; font-size:18px; font-weight:bold;">我的订单</div>
</div>
<div class="main">
<div class="user_dd_list">
	<ul>
    	<li>
        	<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td class="fontsize3" width="50%" height="40" align="center">入会时间：<?php echo ($rs["c"]); ?></td>
                <td class="fontsize3"  width="50%" align="center">最近消费：<?php echo ($rs["u"]); ?></td>
              </tr>
            </table>

      </li>

<?php if(is_array($lists)): $i = 0; $__LIST__ = $lists;if( count($__LIST__)==0 ) : echo "$empty" ;else: foreach($__LIST__ as $key=>$lists): $mod = ($i % 2 );++$i;?><a href="/index.php/home/user/dd_art/aid/<?php echo ($lists["aid"]); ?>">
      <li>
      	<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="left" width="15%"><img width="90%" src="<?php echo ($lists["url"]); ?>" /></td>
            <td width="40%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="30"><span class="fontsize3" style="color:#333;">商家：<?php echo ($lists["usercname"]); ?></span></td>
              </tr>
              <tr>
                <td height="30"><span style="font-size:2rem; color:#666;">时间：<?php echo (date('Y-m-d',$lists["xftime"])); ?></span></td>
              </tr>
            </table></td>
            <td width="40%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="30"><span class="fontsize3" style="color:#333;">项目：<?php echo ($lists["product"]); ?> <font style="color:red; font-size:2rem; font-weight:100;">×<?php echo ($lists["num"]); ?></font></span></td>
              </tr>
              <tr>
                <td height="30"><?php if($lists["paystatus"] != 0): ?><span style="font-size:2rem; color:#666;">付款成功</span><?php else: ?><span style="font-size:2rem; color:red;">待付款</span><?php endif; ?></td>
              </tr>
            </table></td>
            <td width="5%"><img width="90%" src="/Public/images/xiangqing.png" /></td>
          </tr>
        </table>
      </li>
      </a><?php endforeach; endif; else: echo "$empty" ;endif; ?> 
      
    </ul>
</div>
    <div style="clear:both;"></div>
</div>

<link rel="stylesheet" type="text/css" href="/Public/Css/base.css" />
<div class="down_menu">
    <ul>
        <li><a href="/index.php/home/Index/index"><img src="/Public/images/home.png" /></a></li>
        <li><a href="/index.php/home/User/dd_list"><img src="/Public/images/down_dd.png" /></a></li>
        <li><a href="/index.php/home/Index/about"><img src="/Public/images/down_fuwu.png" /></a></li>
        <li><a href="/index.php/home/Index/UserSet/username/<?php echo ($_SESSION['admin']); ?>"><img src="/Public/images/down_myhome.png" /></a></li>
    </ul>
</div>

</body>
</html>