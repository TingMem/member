<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no">
	<title>商家详情</title>
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
      <?php echo ($cp["product_name"]); ?>
    </div>
    <div class="col-xs-2"><span class="glyphicon glyphicon-shopping-cart" style="font-size: 24px; color: #fff; cursor: pointer;"></span></div>
  </div>
</div>
<!-- //商城头部 -->	
    
  

  
	  <div id="carousel-example-generic" class="carousel slide both" data-ride="carousel">  
<!-- Indicators -->
    		<span  style="bottom: 5px !important; left: 5px; margin: 0px; float: left; position: absolute; z-index: 10">
    			<div style="background: rgb(255,153,0);  width: 60px; padding: 3px; border-radius: 15px;">
    				<span class="glyphicon glyphicon-chevron-down fontcolor"></span>
    				<span class="fontcolor"><?php echo ($sae["discount"]); ?>折</span>
    			</div>
    		</span>
        <ol class="carousel-indicators" style="bottom: 0px !important;">
        	<?php if(is_array($arrs)): foreach($arrs as $k=>$arrs2): ?><li data-target="#carousel-example-generic" data-slide-to="<?php echo ($k); ?>"></li><?php endforeach; endif; ?>
        </ol>  

<!-- Wrapper for slides -->  
        <div class="carousel-inner" role="listbox"> 
	        <?php if(is_array($arrs)): foreach($arrs as $i=>$arrs): ?><div class="item">  
	                <img src="<?php echo ($arrs); ?>" alt="<?php echo ($i); ?>">
	            </div><?php endforeach; endif; ?>
        </div>  
        <!-- Controls -->  
        <a id="carleft" style="display: none" class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">  
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>  
            <span class="sr-only">Previous</span>  
        </a>  
        <a id="carright" style="display: none" class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">  
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>  
            <span class="sr-only">Next</span>  
        </a>   
    </div> 
  
  
	
  <script src="/Public/fenxiang/nativeShare.js"></script>
  <script type="text/javascript" src="/Public/Js/toucher.js"></script>
  <link rel="stylesheet" href="/Public/fenxiang/nativeShare.css"/>
  <script>   
  //引入layui模块
  layui.use(['layer', 'form'], function(){
    var layer = layui.layer
    ,form = layui.form();
    
  });


</script> 
  <script type="text/javascript">
    $(document).ready(function(){

        //幻灯
      var myTouch = util.toucher(document.getElementById('carousel-example-generic'));  
      myTouch.on('swipeLeft',function(e){  
          $('#carright').click();  
      }).on('swipeRight',function(e){  
          $('#carleft').click();  
      }); 
      $(".carousel-inner div").eq(0).addClass("active");
      $(".carousel-indicators li").eq(0).addClass("active");

//分享层

      layui.use('layer',function(){
        var $ = layui.jquery, layer = layui.layer; //独立版的layer无需执行这一句
        $(".show").click(function(event) {
          var url = window.location.href;
          var config = {
              url:url,// 分享的网页链接
              title:'<?php echo ($cp["product_name"]); ?>',// 标题
              desc:'我的天，竟然是！震惊！沉默了！',// 描述
              img:'<?php echo ($arrs); ?>',// 图片
              img_title:'<?php echo ($cp["product_name"]); ?>',// 图片标题
              from:'钦州旅游惠民卡商城' // 来源
          };

    var share_obj = new nativeShare('nativeShare',config);
          layer.open({
            type: 1 //Page层类型
            ,area: ['100%', '100%'] //遮罩宽高
            ,title: '分享给好友'
            ,shade: 0.6 //遮罩透明度
            ,maxmin: false //允许全屏最小化
            ,anim: 1 //0-6的动画形式，-1不开启
            ,content: $('#nativeShare')
            ,cancel:function(){
              $("#nativeShare").hide();
            }
          });  
        });
      })
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
    })
  </script>
  	<div class="shop-article-tab">
  		<table name='tab' width="100%" style="text-align: center;">
  			<tr>
  				<td><div style="height: 30px;"><h4 class="h4" style="font-weight: 600; text-align: left; padding: 0 0 0 10%;"><?php echo ($cp["product_name"]); ?></h4></div></td>
  			</tr>
  		</table>
  	</div>
<div style="display: none" id="nativeShare"></div>
  <!--cont-box2-->
    <div class="cont-box" id="cont-box2">
      <div class="row" style="margin: 0px ; padding: 20px; border-bottom: 1px solid #ccc;">
        <?php if(is_array($attr)): $i = 0; $__LIST__ = $attr;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ar): $mod = ($i % 2 );++$i;?><div class="col-xs-6">
            <span style="font-weight: bold;"><?php echo ($ar["attr_name"]); ?></span>：<?php echo ($attrv[$i-1]['attr_value']); ?>
          </div><?php endforeach; endif; else: echo "" ;endif; ?>
      </div>

      <!-- 简介 -->
    <div class="shop-article-tab" style="border-top: 0px;">
      <table name='tab' width="100%" style="text-align: center;">
        <tr>
          <td><div style="height: 30px;"><h4 class="h4" style="font-weight: 600; text-align: left; padding: 0 0 0 10%;">商品详情</h4></div></td>
        </tr>
      </table>
    </div>

      <div style="margin: 20px; padding-left: 15px;">
        <?php echo (htmlspecialchars_decode($cp["product_about"])); ?>
      </div>
    </div>

      <div style="margin: 0 5%; border-top: 1px solid #ccc; padding: 10px;">
        <button type="button" name="fenxiang" class="layui-btn layui-btn-radius layui-btn-primary layui-btn-small show">分享</button>
      </div>

    <div class="row" style="margin: 0px;">
      <table class="table table-bordered">
        <tr>
          <td style="width: 50%; text-align: center;">
            <span style="color: rgb(255,51,0); font-size: 16px">￥</span><span data-tid='<?php echo ($cp["id"]); ?>' class="price" data-p="<?php echo ($cp["price"]); ?>" placeholder="<?php echo ($cp["price"]); ?>" style="color: rgb(255,51,0); font-size: 24px"><?php echo ($cp["price"]); ?></span>
            <span style="color: rgb(255,109,12); font-size: 14px">￥</span><span style="color: rgb(255,109,12); font-size: 16px"><del class="oprice" data-p="<?php echo ($cp["product_oprice"]); ?>" data-tid='<?php echo ($cp["id"]); ?>'><?php echo ($cp["product_oprice"]); ?></del></span>
            <span style="color: rgb(255,109,12); font-size: 14px">门市价</span>
          </td>
          <td style="text-align: center;">
          <a href="<?php echo U('StoreProductOrder/ProductOrder',array('id'=>$cp['id'],'tid'=>$sae['typeid']));?>">
            <button type="submit" class='layui-btn layui-btn-warm layui-btn-radius layui-btn-big'>立即预订</button></a></td>
        </tr>
      </table>
    </div>
  
</body>
</html>