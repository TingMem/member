<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no">
<title>钦州旅游网 - 新消息</title>
<link rel="stylesheet" type="text/css" href="/Public/Css/base.css" />
<script type="text/javascript" src="/Public/js/jquery.min.js"></script>
<script>
	$(document).ready(function() {
        if($("#all").val()==1){
			$(".msg").removeClass("active");
			$(".msg").eq(0).addClass("active");
		}else if($("#all").val()==0){
			$(".msg").removeClass("active");
			$(".msg").eq(2).addClass("active");
		}else if($("#all").val()==-1){
			$(".msg").removeClass("active");
			$(".msg").eq(1).addClass("active");
		}
    });
</script>
<style>
.msg {cursor:pointer; height:30px; line-height:30px; text-align:center; width:33%; float:left;}
.active { color:#fff; background:#ccc;}
</style>
</head>

<body style="background:rgb(238,238,238)">
<div class="dt_top">
	<div style="width:25%; float:left;"><a href="/index.php/home/index/index"><img style="height:30px" src="/Public/images/shangjia/list_back.png" /></a></div>
    <div class="fontsize fontcolor" style="width:50%; text-align:center; color:#fff;float:left; font-size:18px; font-weight:bold;">新消息查看</div>
</div>

    <div style="background:#999; height:30px; margin-top:2px;">
        <ul>
        	<input name="all" type="hidden" id="all" value="<?php echo ($all); ?>" />
        	<a href="/index.php/home/index/message_list"><li class="msg active">全部消息</li></a>
            <a href="/index.php/home/index/message_list/mymsg/1"><li class="msg">我的消息</li></a>
            <a href="/index.php/home/index/message_list/system/1"><li class="msg">系统消息</li></a>
        </ul>
    </div>
    <div style="clear:both;"></div>
	<div class="main">

    <?php if(is_array($messageData)): $i = 0; $__LIST__ = $messageData;if( count($__LIST__)==0 ) : echo "暂无消息" ;else: foreach($__LIST__ as $key=>$lists): $mod = ($i % 2 );++$i;?><div class="news_list">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="40">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td style="padding: 2% 5%">
                            <h1><a href="/index.php/home/index/message_art/id/<?php echo ($lists["id"]); ?>"><?php echo ($lists["title"]); ?></a>
                            <?php if($lists["look"] == 1): ?><font style="color:red">[新]</font><?php endif; ?>
                            </h1>
                            </td>
                          </tr>
                        </table>
                </td>
              </tr>
              <tr>
                <td><div class="news_about"><a style="font-size:14px;" href="/index.php/home/index/message_art/id/<?php echo ($lists["id"]); ?>"><?php echo (mb_substr(strip_tags($lists["body"]),0,30,'utf-8')); ?></a></div>

                    	<div style="padding:5px; background:#999; margin:0 10px;">管理员回复：</div>
                        <div style=" margin:10px 20px;">
                        <?php if(is_array($retmsgData)): $i = 0; $__LIST__ = $retmsgData;if( count($__LIST__)==0 ) : echo "管理员尚未回复" ;else: foreach($__LIST__ as $key=>$vb): $mod = ($i % 2 );++$i; if($vb['msgid'] == $lists['id']): ?><!--huifu  start -->
                        <?php echo ($vb["retadmin"]); ?>回复：<a style="font-size:14px; color:#666;" href="/index.php/home/index/message_art/id/<?php echo ($lists["id"]); ?>"><?php echo (mb_substr(strip_tags($vb["retcont"]),0,20,'utf-8')); ?></a>
                        <!--huifu  end   --><?php endif; endforeach; endif; else: echo "暂无消息" ;endif; ?>  
                        </div>
                </td>
              </tr>
            </table>
	  </div><?php endforeach; endif; else: echo "管理员尚未回复" ;endif; ?>
</div>
    
<div style="clear:both;"></div>
</body>
</html>