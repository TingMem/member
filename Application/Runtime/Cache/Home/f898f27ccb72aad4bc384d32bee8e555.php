<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no">
	<title>订单确认</title>
	<link rel="stylesheet" href="/Public/adminlte/bootstrap/css/bootstrap.min.css">

	<link rel="stylesheet" type="text/css" href="/Public/layui/css/layui.css" />
  <link rel="stylesheet" type="text/css" href="/Public/Css/store.css" />
	<script type="text/javascript" src="/Public/Js/jquery.min.js"></script>
	<script type="text/javascript" src="/Public/bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="/Public/layui/lay/dest/layui.all.js"></script>
  
	<script type="text/javascript">
		$(document).ready(function(){

      $(".cont-box").eq(0).css("display",'block');
			$("div.hov").click(function(){
				$("div.hov").removeClass("tab-active");
				$(this).addClass("tab-active");
        $(".cont-box").css('display','none');
        $("#"+$(this).attr('data-id')).css('display','block');
			});
		})
	</script>
	
</head>
<body>

<!-- 商城头部 -->
<div class="container-fulid">
  <div class="row search-bg" style="margin: 0px">
  <div class="col-xs-2 search-title"><a onclick="history.back();" href="#"><img style="height: 27px;" src="/Public/images/back.png"></a></div>
    <div class="col-xs-8 search-title">
      订单确认
    </div>
    <div class="col-xs-2"><span class="glyphicon glyphicon-shopping-cart" style="font-size: 24px; color: #fff; cursor: pointer;"></span></div>
  </div>
</div>
<!-- //商城头部 -->	
    
  

  
  
	

    <form name="form" class="layui-form form" action="#" method="post">
    	<div class="">
    		<table name='tab' width="100%" style="text-align: center;">
    			<tr>
    				<td><div style="height: 30px;">
              <div class="row" style="margin: 0px;">
                <div class="col-xs-12">
                  <h4 class="h4" style="font-weight: 600; text-align: left; padding: 0 0 0 5%;"><?php echo ($order["product_name"]); ?> *<?php echo ($order['num']); ?></h4>
                </div>
              </div>
            </div></td>
    			</tr>
    		</table>
    	</div>

  
      <div class="row" style="margin: 0px;padding: 15px 5%;">
        <div class="col-xs-12">购买数量 <?php echo ($order['num']); ?></div>
      </div>

    <h4 class="h4" style="font-weight: 600; text-align: left; padding: 0 0 0 10%;">规格(已选购)</h4>
  <!-- 规格选择 -->
      <div class="col-xs-12" style="padding:0  10% 3%; z-index: 10; width: 100%">
        <?php echo ($order["spec"]); ?>
      </div>
  <!-- //规格选择 -->
    
      <h4 class="h4" style="font-weight: 600; text-align: left; padding: 0 0 0 10%; clear: both;">说明(含)</h4>

    <!--cont-box2-->
      <div class="cont-box" id="cont-box2">
        <div class="row" style="margin: 0px ; padding: 5px 5%; border-bottom: 1px solid #ccc;">
            <div class="col-xs-6">
              <?php echo ($order["attr_value"]); ?>
            </div>
        </div>


        <div style="margin: 20px; padding-left: 15px;">

        </div>
      </div>

      <div class="row" style="margin: 0px;">
     
        <table class="table table-bordered">
          <tr>
            <td style="width: 50%; text-align: center;">
              <span style="color: rgb(255,51,0); font-size: 16px">付款金额 ￥</span><span class="price" style="color: rgb(255,51,0); font-size: 24px"><?php echo ($order["total_price"]); ?></span>
            </td>
            <td style="text-align: center;"><button type="submit" class='layui-btn layui-btn-warm layui-btn-radius layui-btn-big'>确认并付款</button></td>
          </tr>
        </table>
      
      </div>
    </form>
  
</body>
</html>