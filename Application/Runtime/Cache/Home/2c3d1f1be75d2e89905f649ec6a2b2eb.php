<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no">
<title>钦州旅游网 - 惠民卡主页</title>
<link rel="stylesheet" type="text/css" href="/member/member/Public/Css/base.css" />
<link rel="stylesheet" type="text/css" href="/member/member/Public/css/lrtk.css" />
<script type="text/javascript" src="/member/member/Public/js/jquery.min.js"></script>
<script type="text/javascript" src="/member/member/Public/js/responsiveslides.min.js"></script>
<script type="text/javascript" src="/member/member/Public/js/slide.js"></script>
</head>

<body>
<div class="tp_top">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="10%" align="left"><table width="60" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td>
          <a href="/index.php/home/index/message_list/"><img class="imgsize" src="/member/member/Public/images/message.png" /></a>
          <?php if($message != 0): ?><div class="xiaoxibox"><?php if($message > 99): ?>99+<?php else: echo ($message); endif; ?></div><?php endif; ?>
          </td>
        </tr>
      </table></td>
      <td align="center"><h1 style="color:#fff;padding:0px;">玩转钦州</h1></td>
      <td width="10%" align="right"><table width="48" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><img onclick="location.href='/index.php/home/vip/vipCenter'" class="imgsize" src="/member/member/Public/images/set.png" /></td>
        </tr>
      </table></td>
    </tr>
  </table>
</div>
<div class="main">
	<div class="banner">
        <!-- 代码 开始 -->
            <div class="slide_container">
              <ul class="rslides" id="slider">
                <li>
                  <img src="/member/member/Public/images/1.jpg" alt="">
                </li>
                <li>
                  <img src="/member/member/Public/images/2.jpg" alt="">
                </li>
              </ul>
            </div>
        <!-- 代码 结束 -->
    </div>
    <!-- 分类菜单 -->
    <div class="tp_main_menu">
    	<ul>
        	<li><a href="/index.php/home/Index/UserSet"><img src="/member/member/Public/images/gk.png" /></a><!--<a href="/index.php/home/User/spadmin_list.html"><img src="/member/member/Public/images/yd.png" /></a>--></li>
            <li>
            <a href="/index.php/home/User/xuzhi"><img src="/member/member/Public/images/xuzhi.png" /></a>
            <!--<a href="/index.php/home/User/dd_list"><img src="/member/member/Public/images/dd.png" /></a>--></li>
            <li><a href="/index.php/home/index/UserSet"><img src="/member/member/Public/images/hy.png" /></a></li>
            <li><a href="<?php echo U('StoreIndex/index');?>"><img src="/member/member/Public/images/yd.png" /></a><!-- <a href="/index.php/home/index/help_list"><img src="/member/member/Public/images/zn.png" /></a> --></li>
            <li><a href="/index.php/home/vip/vip_news_list"><img src="/member/member/Public/images/zx.png" /></a></li>
            <li><a href="/index.php/home/index/about"><img src="/member/member/Public/images/lxwm.png" /></a></li>
        </ul>
    </div>
    <div style="clear:both;"></div>
</div>
<div style="clear:both;"></div>
<link rel="stylesheet" type="text/css" href="/member/member/Public/Css/base.css" />
<div class="down_menu">
    <ul>
        <li><a href="<?php echo U('Index/index');?>"><img src="/member/member/Public/images/home.png" /></a></li>
        <!-- <li><a href="/index.php/home/User/dd_list"><img src="/member/member/Public/images/down_dd.png" /></a></li> -->
        <li><a href="<?php echo U('StoreProductOrder/UserOrderList');?>"><img src="/member/member/Public/images/down_dd.png" /></a></li>
        <li><a href="<?php echo U('Index/about');?>"><img src="/member/member/Public/images/down_fuwu.png" /></a></li>
        <li><a href="<?php echo U('Index/UserSet',array('username'=>$_SESSION['admin']));?>"><img src="/member/member/Public/images/down_myhome.png" /></a></li>
    </ul>
</div>

</body>
</html>