<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no">
<title>钦州旅游网惠民卡 - 商家订单管理列表</title>
<link rel="stylesheet" type="text/css" href="/Public/Css/base.css" />
<script type="text/javascript" src="/Public/js/jquery.min.js"></script>
<script type="text/javascript" src="/Public/js/select.js"></script>
</head>

<body>
<div class="dt_top">
	<div style="width:25%; float:left;"><a href="/index.php/home/index/shopadmin"><img style="height:30px" src="/Public/images/shangjia/list_back.png" /></a></div>
    <div style="width:50%; text-align:center; color:#fff;float:left; font-size:18px; font-weight:bold;">订单列表</div>

</div>
<div class="new_message">您有<?php echo ((isset($count) && ($count !== ""))?($count):'0'); ?>条订单待处理</div>
<div class="user_main">
	<?php if(is_array($lists)): $i = 0; $__LIST__ = $lists;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$lists): $mod = ($i % 2 );++$i;?><table width="100%" style="background:#ccc;" border="0" align="center" cellpadding="0" cellspacing="1">
      <tr >
        <td  style="height:40px" bgcolor="#FFFFFF">
        <div  style="margin-right:1%; width:45%; float:right; min-height:30px; line-height:30px;font-size:14px;">时间：<?php echo (date('Y-m-d',$lists["logtime"])); ?></div>
        <div style="margin-left:1%;  width:50%; float:left;min-height:30px; font-size:14px;">订单：<?php echo ($lists["shopname"]); echo ($lists["num"]); echo ($lists["danwei"]); ?></div></td>
      </tr>
      <tr>
        <td bgcolor="#FFFFFF"><table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td  style="float:left;min-height:40px; font-size:14px;">单号：<?php echo ($lists["sid"]); ?></td>
          </tr>
          <tr>
            <td style="float:left;min-height:40px; font-size:14px;">单价：<span style="font-size:14px;  color: #F90">￥<?php echo ($lists["price"]); ?></span></td>
          </tr>
          <tr>
            <td  style="float:left;min-height:40px; font-size:14px;">总金额：<span style="font-size:14px;  color: #F90">￥<?php echo ($lists["cprice"]); ?></span></td>
          </tr>
          <tr>
            <td style="min-height:30px; font-size:14px;"><div style="width:100px; font-size:14px; float:left;height:30px">付款：<?php echo ($lists["pay"]); ?></div>&nbsp;&nbsp;&nbsp;<?php if(($lists["paystatus"] == 1)): ?><div style="text-align:center; color:#fff; background:#F93; height:40px; line-height:40px; width:80px; float:left; font-size:14px;">已付款</div><?php else: ?><div style="text-align:center;width:80px; font-size:14px; color:#fff; background:red; height:40px;float:left;  line-height:40px;">未付款</div><?php endif; ?></td>
          </tr>
          <tr>
            <td style="font-size:14px; height:40px;">
            <?php if($lists["status"] == 0): ?><div  style="margin-right:1%; width:80px; float:right; height:40px; line-height:40px; border-radius:3px;font-size:14px;  background:red;text-align:center; color:#fff; ">待处理</div><?php else: ?><div  style="margin-right:1%; width:80px; float:right; height:40px; line-height:40px; border-radius:3px;font-size:14px;  background: #060;text-align:center; color:#fff;">已处理</div><?php endif; ?>
           <div style="margin-left:1%;  width:48%; float:left; height:40px; line-height:40px; font-size:14px;">用户：<?php echo ($lists["username"]); ?></div></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td style="background:rgb(238,239,242)">
        <?php if(($lists["tel"] != null)): ?><a href="tel://<?php echo ($lists["tel"]); ?>"><?php endif; ?><div class="fontsize" style="width:49%; float:right; height:40px; line-height:40px;text-align:center; color:#333;cursor:pointer; border-left:1px solid #ccc;">致电客户</div><?php if(($lists["tel"] != null)): ?></a><?php endif; ?>
      <?php if(($lists["status"] != 1)): ?><a onclick="return confirm('标记后不可恢复，您确定要将该订单标志为已消费吗？')" href="/index.php/home/index/shopheyan/id/<?php echo ($lists["aid"]); ?>"><?php endif; ?><div class="fontsize<?php if(($lists["status"] != 1)): ?>shopheyan<?php endif; ?>" rel="<?php echo ($lists["aid"]); ?>" style=" width:50%; float:left; height:40px; line-height:40px; text-align:center;color:#333; cursor:pointer ; font-size:18px;">订单核验</div><?php if(($lists["status"] != 1)): ?></a><?php endif; ?>
        
        </td>
      </tr>
    </table>
    <br /><?php endforeach; endif; else: echo "" ;endif; ?><br />

    <div class="pagelist"><?php echo ($page); ?></div>
	<div style="clear:both;"></div>
</div>
<div style="clear:both;"></div>
</body>
</html>