<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no">
	<title>商家详情</title>
	<link rel="stylesheet" href="/Public/adminlte/bootstrap/css/bootstrap.min.css">


  
  <link rel="stylesheet" type="text/css" href="/Public/Css/store.css" />
	<script type="text/javascript" src="/Public/Js/jquery.min.js"></script>
	<script type="text/javascript" src="/Public/bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="/Public/Js/toucher.js"></script>
  <link rel="stylesheet" type="text/css" href="/Public/layui/css/layui.css" />
  <script type="text/javascript" src="/Public/layui/lay/dest/layui.all.js"></script>
  
<script>
//引入layui模块
layui.use(['layer', 'form'], function(){
  var layer = layui.layer
  ,form = layui.form();
  
});


</script> 
	<script type="text/javascript">
		$(document).ready(function(){
			var myTouch = util.toucher(document.getElementById('carousel-example-generic'));  
			myTouch.on('swipeLeft',function(e){  
			    $('#carright').click();  
			}).on('swipeRight',function(e){  
			    $('#carleft').click();  
			});  


			//幻灯
			$(".carousel-inner div").eq(0).addClass("active");
			$(".carousel-indicators li").eq(0).addClass("active");

      $(".cont-box").eq(0).css("display",'block');
			$("div.hov").click(function(){
				$("div.hov").removeClass("tab-active");
				$(this).addClass("tab-active");
        $(".cont-box").css('display','none');
        $("#"+$(this).attr('data-id')).css('display','block');
			});
      var form = layui.form();
      form.on('checkbox',function(data){

        var price = jQuery(".price[data-tid="+data.elem.alt+"]");
        var oprice = jQuery(".oprice[data-tid="+data.elem.alt+"]");
        if(data.elem.checked==true){

            price.text(Number(price['0'].outerText)+Number(data.elem.placeholder));
            oprice.text(Number(oprice.html())+Number(data.elem.placeholder));
        }else{
            price.text(Number(price['0'].outerText)-Number(data.elem.placeholder));
            oprice.text(Number(oprice.html())-Number(data.elem.placeholder));
        }
      })
		})
	</script>
	
</head>
<body>

<!-- 商城头部 -->
<div class="container-fulid">
  <div class="row search-bg" style="margin: 0px">
    <div class="col-xs-2 search-title"><a href="<?php echo U('StoreIndex/index');?>"><img style="height: 27px;" src="/Public/images/back.png"></a></div>
    <div class="col-xs-8 search-title">
      订单列表
    </div>
    <div class="col-xs-2"><span class="glyphicon glyphicon-shopping-cart" style="font-size: 24px; color: #fff; cursor: pointer;"></span></div>
  </div>
</div>
<!-- //商城头部 -->	
    
  

  
  
  
	
    <?php if(is_array($order)): $i = 0; $__LIST__ = $order;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$od): $mod = ($i % 2 );++$i;?><div class="row" style="margin: 0px; padding:10px 0px; border-bottom: 1px dashed #ccc;">
      <div class="col-xs-2" style="margin: 10px 0px; padding: 5px;"><img style="margin-top: 5px" width="100%" class="img-circle" src="<?php $img = explode(',',$od['product_pics']);echo $img[0]; ?>" /></div>
        <div class="col-xs-8" style="padding: 0px;">
          <div class="row" style="margin: 0;">
            <div class="col-xs-6 h5 ">商家：<?php echo ($od["shopname"]); ?></div>
            <div class="col-xs-6 h5 ">宝贝：<?php echo ($od["product_name"]); ?></div>
            <div class="col-xs-12 h5 ">有效期：</div>
          </div>
        </div>
        <div class="col-xs-2"><span style="font-size: 30px; text-align: center; margin-top: 20px; color: #666" class="glyphicon glyphicon-chevron-right"></span></div>
      </div><?php endforeach; endif; else: echo "" ;endif; ?>
  
</body>
</html>