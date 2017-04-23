<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no">
<title>钦州旅游网 - 会员卡系统</title>
<link rel="stylesheet" type="text/css" href="/Public/Css/base.css" />
<script type="text/javascript" src="/Public/js/jquery.min.js"></script>
<script type="text/javascript" src="/Public/js/select.js"></script>
<style>
.xinxi ul li table tr td { font-size:14px; padding: 10px 0; color:#fff;}
input { width:80%; height:25px; border:1px solid #CCC; border-radius:3px; font-size:14px; padding:3px;}

</style>
</head>

<body class="userset_body">
<div class="dt_top">
	<div style="width:25%; float:left;"><a href="/index.php/home/index/index"><img class='tytop' src="/Public/images/back.png" /></a></div>
    <div class="fontsize" style="width:50%; text-align:center; color:#fff;float:left;  font-weight:bold;">资料更改</div>
</div>
<form id="oForm" name="oForms" action="/index.php/home/vip/vipCenterSave" method="post">
<div class="user_main">
<?php if(is_array($lists)): $i = 0; $__LIST__ = $lists;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$lists): $mod = ($i % 2 );++$i;?><div class="xinxi">
    	<ul>
        
        	<li>
        	  <table width="100%" border="0" cellspacing="0" cellpadding="0">
        	    <tr>
        	      <td style="width:130px;" valign="top"><img  class="imgavatar" src="<?php echo ((isset($lists["avatar"]) && ($lists["avatar"] !== ""))?($lists["avatar"]):'/Public/images/avatar/default.jpg'); ?>" /></td>
        	      <td align="left" style="color:#fff;"><?php echo ($lists["username"]); ?></td>
        	      <td align="right">
                  </td>
        	      <td><div onclick="location.href='/index.php/home/vip/vipAvater'" style="padding:5px; width:60px; color:#fff; background:#ccc;">更改头像</div></td>
      	        </tr>
      	    </table>
        	</li>
        
            <li style="clear:both;">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="25%">积分</td>
                    <td width="50%"><?php echo ($lists["jifen"]); ?></td>
                  </tr>
                </table>
		  </li>
            <li>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="25%">手机</td>
                    <td width="50%"><?php echo (substr($lists["tel"],0,7)); ?>**** <a style="color: #06C;" href="/index.php/home/vip/vipTelEdit">更改</a></td>
                  </tr>
                </table>
            </li>
            <li>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="25%">姓名</td>
                    <td width="50%"><input name="usercname" type="text" value="<?php echo ($lists["usercname"]); ?>" /></td>
                  </tr>
                </table>
            </li>
            <li>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="25%">帐号</td>
                    <td width="50%"><?php echo ($lists["username"]); ?></td>
                  </tr>
                </table>
            </li>
            <li>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="25%">原密码</td>
                    <td width="50%"><input placeholder="不改请留空" name="password" type="text" value="" /></td>
                  </tr>
                </table>
            </li>
            <li>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="25%">新密码</td>
                    <td width="50%"><input placeholder="不改请留空" name="npassword" type="text" value="" /></td>
                  </tr>
                </table>
            </li>
            <li>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="25%">身份证</td>
                    <td width="50%"><?php echo ((isset($lists["card"]) && ($lists["card"] !== ""))?($lists["card"]):'尚未填写身份证'); ?></td>
                  </tr>
                </table>
            </li>
            
            <?php if($lists["sid"] != null): ?><li>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
             
                              <tr style>
                                <td width="50%">有效期</td>
                                <td width="50%"><?php echo (date('Y-m-d',$lists["startime"])); ?> 至 <?php echo (date('Y-m-d',$lists["endtime"])); ?></td>
                              </tr>
            
            </table>
			</li><?php endif; ?>  
            <li>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">

                  <tr>
                    <td width="25%">编号</td>
                    <td width="50%"><?php echo ((isset($lists["sid"]) && ($lists["sid"] !== ""))?($lists["sid"]):'未购买惠民卡'); ?></td>
                  </tr>
                </table>
            </li>
            <li style="border:0px; ">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td valign="top" width="25%">二维码名片</td>
                    <td width="50%" align="right"><img style="width:150px" src="<?php echo ((isset($lists["erweima"]) && ($lists["erweima"] !== ""))?($lists["erweima"]):'/Public/images/default.jpg'); ?>" /></td>
                  </tr>
                </table>
            </li>

            <div style="clear:both;"></div>  
        </ul>

    </div><?php endforeach; endif; else: echo "" ;endif; ?>
</div>
</form>
<div class="vipSubbtn">保存更改</div>
<div style="clear:both;"></div>

<link rel="stylesheet" type="text/css" href="/Public/Css/base.css" />
<div class="down_menu">
    <ul>
        <li><a href="/index.php/home/Index/index"><img src="/Public/images/home.png" /></a></li>
        <!-- <li><a href="/index.php/home/User/dd_list"><img src="/Public/images/down_dd.png" /></a></li> -->
        <li><a href="<?php echo U('StoreProductOrder/UserOrderList');?>"><img src="/Public/images/down_dd.png" /></a></li>
        <li><a href="/index.php/home/Index/about"><img src="/Public/images/down_fuwu.png" /></a></li>
        <li><a href="/index.php/home/Index/UserSet/username/<?php echo ($_SESSION['admin']); ?>"><img src="/Public/images/down_myhome.png" /></a></li>
    </ul>
</div>

</body>
</html>