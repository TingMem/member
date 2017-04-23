<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>钦州旅游网 - 商家首页</title>
<link rel="stylesheet" type="text/css" href="/Public/Css/base.css" />
<script type="text/javascript" src="/Public/js/jquery.min.js"></script>
</head>

<body>
<div class="shop_top">

  <table  width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="60" height="50"><?php if($c != 0): ?><a href="/index.php/home/index/shoplist"><?php endif; ?><img class="goto" style="width:6rem;" src="/Public/images/shangjia/xiaoxi.png" /><?php if($c != 0): ?></a><?php endif; ?></td>
      <td style="color:#fff; font-size:3rem;"><?php if($c != 0): ?><a style="color:#fff;" href="/index.php/home/index/shoplist"><?php endif; ?>&nbsp;&nbsp;&nbsp;您有<?php echo ($c); ?>条未处理订单<?php if($c != 0): ?></a><?php endif; ?><input type="hidden" class="add" value="<?php echo ((isset($c) && ($c !== ""))?($c):'0'); ?>" /></td>
    </tr>
  </table>
</div>
<div class="user_main">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="50%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td>
            <div class="dd_list">	
            	<a onclick="alert('暂未开放'); return false;" href="/index.php/home/index/shoplist"><img style="width:95%; margin-bottom:2rem;" src="/Public/images/shangjia/index_dingdan.png" /></a>   
            </div>
            </td>
          </tr>
          <tr>
            <td><a href="/index.php/home/index/tongji"><img style="width:95%;" src="/Public/images/shangjia/index_yeji.png" /></a></td>
          </tr>
        </table></td>
        <td width="50%" valign="top">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><a href="/index.php/home/index/news_list"><img  width="100%" style="margin-bottom:2rem;" src="/Public/images/shangjia/index_zixun.png" /></a></td>
              </tr>
              <tr>
                <td><a href="/index.php/home/vip/user_shop_edit"><img  width="100%" style="margin-bottom:2rem" src="/Public/images/shangjia/index_guanli.png" /></a></td>
              </tr>
              <tr>
                <td>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td><a href="/index.php/home/index/loginout"></a></td>
                  </tr>
                  <tr>
                    <td><a href="/index.php/home/index/loginout"><img  width="100%" style="margin-bottom:1rem" src="/Public/images/shangjia/index_loginout.png" /></a></td>
                  </tr>
                </table>
			</td>
          </tr>
        </table></td>
      </tr>
    </table>

	<div style="clear:both;"></div>
</div>
<div style="clear:both;"></div>
</body>
</html>