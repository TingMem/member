<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<meta charset="utf-8" />
<head>
<script src="http://apps.bdimg.com/libs/jquery/1.6.4/jquery.min.js"></script>
<script>
	$(document).ready(function() {
		
		//初始化页面
		$(".login").height($("body").height());
		
		
		$("#password").keydown(function(e){
			if(e.keyCode==13){
				if($.trim($("#username").val())!='' && $.trim($("#password").val())!=''){
					$("#form1").submit();
				}else{
					alert('帐号或密码没有输入哦');	
					return false;
				}
			}
		});
        $(".sub").click(function(){
			if($.trim($("#username").val())!='' && $.trim($("#password").val())!=''){
				$("#form1").submit();
			}else{
				alert('帐号或密码没有输入哦');	
				return false;
			}
		});
    });
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>钦州旅游——会员登录</title>
<link rel="stylesheet" type="text/css" href="/Public/Css/base.css" />
</head>

<body style="background:url(/Public/images/loginbg.png) no-repeat; background-size:100%;">
<div class="adminlogin">
  <form id="form1" name="form1" method="post" action="/index.php/home/index/logincheck">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td></td>
      </tr>
      <tr>
        <td height="50" align="center">
        <div style="margin:0 37%; background:rgb(209,211,211); border-radius:12px;">
        <div class="uico2"><img src="/Public/images/userico.png" /></div>
        <input class="input3" placeholder="请输入帐号" type="text" name="username" id="username" /></div></td>
      </tr>
      <tr>
        <td height="10" align="center">&nbsp;</td>
      </tr>
      <tr>
        <td height="50" align="center">
        <div style="margin:0 37%; background:rgb(209,211,211); border-radius:12px;">
        <div class="uico2"><img src="/Public/images/pwdico.png" /></div>
        <input class="input3" placeholder="请输入密码" type="password" name="password" id="password" /></div>
        </td>
      </tr>
      <tr>
        <td align="right">&nbsp;</td>
      </tr>
    </table>
    <div style="margin:0 37%;  color:#fff;"><img class="sub" width="100%" src="/Public/images/loginpic.png" /></div>
  </form>
</div>

</body>
</html>