<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no">
<title>钦州旅游网 - 会员卡系统</title>
<link rel="stylesheet" type="text/css" href="/Public/Css/base.css" />
<script type="text/javascript" src="/Public/js/jquery.min.js"></script>
<script type="text/javascript" src="http://apps.bdimg.com/libs/crypto-js/3.1.2/rollups/md5.js"></script>
<style>
.xinxi ul li table tr td { font-size:14px; padding: 10px 0; color:#fff;}
.goumais {
	background: #09c none repeat scroll 0 0;
    color: #fff;
    display: block;
    font-size: 14px;
    padding: 5px 10px;
    text-align: center;
}
</style>
<script>
$(document).ready(function(e) {
	//var d = new Date();
	var t = Date.parse(new Date());
	//var t = d.getTime();
//	var st = t.substring(0,10);
	//alert(t);
	if(t>1464796800000|| t<1464685200000){
		$(".goumais").remove();
	}
	$("#subs").click(function(){
		var code = $.trim($(".code").val());
		//alert(CryptoJS.MD5(code));
		if(CryptoJS.MD5(code) == '998363049539cb1dc6cc946c36b801ec' && $.trim($(".xh").val())!=''){
			window.location.href='/index.php/home/Vip/VipGouMains/xh/'+$(".xh").val();
		}else{
			alert('验证码不正确或您没有输入学号');
			return false;
		}
	})
	
	$("#close").click(function(){
		$(".xuehao").css("display","none");
		$(".code").val("");
		$(".xh").val("");
	})
	
	$("#goumais").click(function(){
		$(".xuehao").css("opacity","0.9");
		$(".xuehao").css("background","#000");
		$(".xuehao").css("display","block");
		$(".xuehao").height($(document.body).height());
	});
	
	$("#goumai").click(function(){
		
		//alert('正在进行系统升级！');
		//return false;
		if(confirm('如果您不是钦州户籍，请勿继续购买，否则将可能出现无法进入景区情况！')){
		$.ajax({
			url:"/index.php/home/Vip/VipGouMainCheck",
			type:'GET',
			success:function(ret){
				if(ret==1){
					window.location.href='/index.php/home/Vip/VipGouMains';
				}else if(ret==0){
					alert('抱歉，会员卡已售完！');
					return false;	
				}else if(ret == 2){
					alert('此卡尚未开始发售！发售时间2016-05-21 11:00:00');
					//window.location.href='/index.php/home/Vip/VipGouMain';
					return false;					
				}
			},	
		})	
		}else{
			return false;	
		}
		
	});
	
});
</script>
</head>

<body class="userset_body">
<div class="dt_top">
	<div style="width:25%; float:left;"><a href="/index.php/home/index/index"><img class='tytop' src="/Public/images/back.png" /></a></div>
    <div class="fontsize" style="width:50%; text-align:center; color:#fff;float:left;  font-weight:bold;">个人核验</div>
</div>
<div class="user_main">
<?php if(is_array($lists)): $i = 0; $__LIST__ = $lists;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$lists): $mod = ($i % 2 );++$i;?><div class="xinxi">
    	<ul>
        	<li>
        	  <table width="100%" border="0" cellspacing="0" cellpadding="0">
        	    <tr>
        	      <td style="width:130px;" valign="top"><img  class="imgavatar" src="<?php echo ((isset($lists["avatar"]) && ($lists["avatar"] !== ""))?($lists["avatar"]):'/Public/images/avatar/default.jpg'); ?>" /></td>
        	      <td align="left" style="color:#fff;"><?php echo ($lists["username"]); ?></td>
        	      <td align="right">
                        <table width="48" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td align="center"><a href="/index.php/home/vip/vipCenter"><img class="imgsize" src="/Public/images/set.png" /></a></td>
                          </tr>
                          <tr>
                            <td height="30" align="center" class="sizecolor">设置</td>
                          </tr>
                        </table>
                  </td>
        	      <td>&nbsp;</td>
      	        </tr>
      	    </table>
        	</li>
            <li style="clear:both;">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="50%">积分</td>
                    <td width="50%"><?php echo ($lists["jifen"]); ?></td>
                  </tr>
                </table>
		  </li>
            <li>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="50%">手机</td>
                    <td width="50%"><?php echo (substr($lists["tel"],0,7)); ?>****</td>
                  </tr>
                </table>
            </li>
            <li>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="50%">姓名</td>
                    <td width="50%"><?php echo ($lists["usercname"]); ?></td>
                  </tr>
                </table>
            </li>
            <li>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="50%">帐号</td>
                    <td width="50%"><?php echo ($lists["username"]); ?></td>
                  </tr>
                </table>
            </li>
            <li>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="50%">身份证</td>
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
                    <td width="50%">编号</td>
                    <td width="50%">
                    <div class="xuehao" style="width:80%;top:0; padding:20% 10%; left:0; position:fixed; display:none; z-index:10;">请输入活动现场验证码：<br /><input name="code" class="code" style="margin-top:20px; width:100%; height:25px;  " type="text" /><br /><br /><br />请输入您的学生证号：<br /><input name="xh" class="xh" style="margin-top:20px; width:100%; height:25px;  " type="text" /><br /><br /><br />
                    <a id="subs" class="goumais"  href="#">提交验证</a><br /><br />
                    <a id="close" class="goumais"  href="#">关闭</a>
                    </div>
                    
                    <?php if($lists["sid"] == null): ?><a id="goumai"  href="#">未购买,去购买</a><br />
                        <a id="goumais"  class="goumais" href="#">学生证购买</a>
                    <?php else: ?> <span style="color:#fff;"><?php echo ((isset($lists["sid"]) && ($lists["sid"] !== ""))?($lists["sid"]):'未购买惠民卡'); ?></span><?php endif; ?></td>
                  </tr>
                </table>
            </li>
            <li style="border:0px; margin-bottom:50px;">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td valign="top" width="50%">二维码名片</td>
                    <td width="50%" align="right"><img style="width:150px" src="<?php echo ((isset($lists["erweima"]) && ($lists["erweima"] !== ""))?($lists["erweima"]):'/Public/images/default.jpg'); ?>" /></td>
                  </tr>
                </table>
            </li>
        </ul>
    </div><?php endforeach; endif; else: echo "" ;endif; ?><div style="clear:both;"></div>

</div>
<div style="clear:both;"></div>
<a href="/index.php/home/index/loginout"><div class="vipSubbtns">注销登录</div></a>
<link rel="stylesheet" type="text/css" href="/Public/Css/base.css" />
<div class="down_menu">
    <ul>
        <li><a href="<?php echo U('Index/index');?>"><img src="/Public/images/home.png" /></a></li>
        <!-- <li><a href="/index.php/home/User/dd_list"><img src="/Public/images/down_dd.png" /></a></li> -->
        <li><a href="<?php echo U('StoreProductOrder/UserOrderList');?>"><img src="/Public/images/down_dd.png" /></a></li>
        <li><a href="<?php echo U('Index/about');?>"><img src="/Public/images/down_fuwu.png" /></a></li>
        <li><a href="<?php echo U('Index/UserSet',array('username'=>$_SESSION['admin']));?>"><img src="/Public/images/down_myhome.png" /></a></li>
    </ul>
</div>

</body>
</html>