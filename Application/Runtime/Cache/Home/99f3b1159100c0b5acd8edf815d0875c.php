<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no">
<title>钦州旅游网 - 联系我们</title>
<link rel="stylesheet" type="text/css" href="/Public/Css/base.css" />
<script type="text/javascript" src="/Public/js/jquery.min.js"></script>
<script type="text/javascript" src="/Public/js/select.js"></script>
<script>
	$(document).ready(function(e) {
        $(".submitbtn").click(function(){
			if($("#cont").val()=='' || $("#title").val()==''){
				alert('请输入标题和内容！');
				return false;	
			}else{
				$("#form1").submit();	
			}
		})
    });
</script>
<style>
	.message { margin:10px; padding:10px; border:1px solid #ccc; border-radius:5px; background:#fafafa;}
	.dt_topf { height:40px; line-height:40px; background:rgb(0,153,255); padding:5px 3% 0rem 3%;}
</style>
</head>

<body style="background:#fff">
  <div class="dt_topf">
    <div style="width:25%; float:left;"><a href="/index.php/home/index/index/"><img src="/Public/images/shangjia/list_back.png" alt="" style="height:30px;"  /></a></div>
     <div class="fontsize fontcolor" style="width:50%; text-align:center; color:#fff;float:left; font-size:18px; font-weight:bold;">联系我们</div>
  </div>
  
  <div class="news_add" style="font-size:14px; color:#666; clear:both;"> <?php echo ($body["content"]); ?> </div>
<form id="form1" name="form1" method="post" action="/index.php/home/manage/message_add">

  <div class="message">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td style="padding:10px 0 ; text-align:center; font-size:20px;">问题反馈
          <div style="padding:1rem 1rem 0.5rem 1rem ; border-bottom:1px solid #ccc;"></div></td>
      </tr>
      <tr>
        <td style="padding:10px 0;"><input name="title" type="text" id="title" placeholder="请输入反馈主题" style=" width:94%; margin:0 auto;padding:10px; font-size:14px; color:#333; height:35px;" size="5" /></td>
      </tr>
      <tr>
        <td><label for="cont"></label>
        <textarea  name="cont" cols="5" id="cont" style=" height:150px; width:94%; margin:0 auto;padding:10px; font-size:14px; color:#333;" placeholder="请输入反馈内容"></textarea></td>
      </tr>
    </table>
  </div>
  <div class="submitbtn" style=" height:50px; line-height:50px; font-size:18px; text-align:center; background: #EE5B5F; color:#fff; cursor:pointer; width:96%; margin:0 auto;margin-bottom:20px; border-radius:5px; ">提交反馈</div>
</form>
</body>
</html>