<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no">
<head>
<script src="http://apps.bdimg.com/libs/jquery/1.6.4/jquery.min.js"></script>
<script>
	$(document).ready(function() {	

		$(".regbtn").click(function(){
			if($("#call").val().length == 11){
				$.get('/index.php/home/User/verify',{call:$('#call').val(),callback:$('#call').val(),username:$("#username").val()},function(result){
					$("#username").val($("#call").val());
					if(result==1){
						var step = 60;//初始化读秒
						t = setInterval(function(){
							step-=1;
							$(".regbtn").attr("disabled","disabled").val("稍候"+step+"秒...").css("cursor",'wait');
							if(step<=0){
								$(".regbtn").removeAttr("disabled").val("获取验证码").css("cursor",'pointer');
								clearInterval(t);
								step = 60;
							}
						},1000);
					}else if(result==-1){
						alert('请耐心等待60秒...');
					}else{
						alert('该手机尚未注册!');	
					}
					
				});
			}else{
				alert('手机号长度不正确');
			}
			
		});
		
		$(".call").change(function(){
			$("#username").val($(".call").val());	
		})
		
		$(".subs").click(function(){
			if($("#password").val()==$("#password2").val() && $("#vcode").val()!=''){
				$("#form1").submit();	
			}else{
				alert('两次密码输入不一致，或验证码没有填写');
				return false;	
			}
		});
		
    });
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>钦州旅游——会员注册</title>
<link rel="stylesheet" type="text/css" href="/Public/Css/base.css" />
</head>


<body style="background:url(/Public/images/reg_bg.png) no-repeat; background-size:100%;">
<div class="dt_top">
	<div style="width:25%; float:left;"><a href="/index.php/home/index/index"><img style="height:30px;" src="/Public/images/shangjia/list_back.png" /></a></div>
    <div style="width:50%; text-align:center; color:#fff;float:left; font-size:18px; font-weight:bold;">找回密码</div>
</div>
<div class="reg">
  <form id="form1" name="form1" method="post" action="/index.php/home/user/returnpwd">
  <div class="fontsize fontcolor" style="text-align:center; margin-bottom:10%;">找回密码</div>

    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="center">
        <div style="margin:0 10%; background:rgb(209,211,211); border-radius:12px;">
        <div style="display:none;" class="uico"><img src="/Public/images/userico.png" /></div>
        <input class="input" placeholder="" type="hidden" name="username" id="username" /></div></td>
      </tr>
      <tr>
        <td height="50" align="center">
        <div style="margin:0 10%; background:rgb(209,211,211); border-radius:12px;">
        <div class="uico"><img src="/Public/images/shouji.png" /></div>
        <input class="input call" placeholder="您的手机" type="text"  name="call" id="call" /></div>
        </td>
      </tr>
      <tr>
        <td height="50" align="center">
        <div style="margin:0 10%;  border-radius:12px;">
        <div class="sizecolor" style="width:30%; float:left;">验证码：</div>
        <input style="height:30px; width:25%; float:left; border:1px solid #ccc;line-height:30px ; padding:3px; font-size:16px; border-radius:5px;" placeholder="验证码" type="text" name="vcode" id="vcode" />
        <input type="button" name="regbtn" value="获取验证码" class="regbtn" />
        </div>
        </td>
      </tr>
      <tr>
        <td height="50" align="center">
        <div style="margin:0 10%; background:rgb(209,211,211); border-radius:12px;">
        <div class="uico"><img src="/Public/images/pwdico.png" /></div>
        <input class="input" placeholder="输入新密码" type="password" name="password" id="password" /></div>
        </td>
      </tr>

      <tr>
        <td align="center">
        <div style="margin:0 10%; background:rgb(209,211,211); border-radius:12px;">
        <div class="uico"><img src="/Public/images/pwdico.png" /></div>
        <input class="input" placeholder="重复新密码" type="password" name="password2" id="password2" /></div>
        </td>
      </tr>
    </table>
    <div style="margin:0 10%;  color:#fff;"><img class="subs" width="100%" src="/Public/images/post.png" /></div>
  </form>
</div>

</body>
</html>