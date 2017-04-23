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

			$("div.hov").click(function(){
				$("div.hov").removeClass("tab-active");
				$(this).addClass("tab-active");
			});

			$(".arec").click(function(){
				if($(this).attr("data-type")==0){
					if(Number($(this).next(".purchase").val()) > 1){
						$(this).next('.purchase').val(Number($(this).next(".purchase").val())-1);
						var price = $(".price[data-tid="+$(this).attr('data-tid')+"]");
						var oprice = $(".oprice[data-tid="+$(this).attr('data-tid')+"]");

						price.text(Number(price.html())-Number(price.attr('data-p')));
						oprice.text(Number(oprice.html())-Number(oprice.attr('data-p')));
					}
				}else{
					if(Number($(this).prev(".purchase").val()) < Number($(this).attr("data-max")) && Number($(this).prev(".purchase").val())<= Number($(this).attr("data-kucun"))){
						$(this).prev('.purchase').val(Number($(this).prev(".purchase").val())+1);

						var price = $(".price[data-tid="+$(this).attr('data-tid')+"]");
						var oprice = $(".oprice[data-tid="+$(this).attr('data-tid')+"]");

						price.text(Number(price.html())+Number(price.attr('data-p')));
						oprice.text(Number(oprice.html())+Number(oprice.attr('data-p')));
					}else{
						alert('库存不足或已达限购数量');
					}
				}
			});
		})
	</script>
	
</head>
<body>
	<div class="container-fulid">
	<div class="row search-bg" style="margin: 0px">
		<div class="col-xs-2 search-title"><a href="<?php echo U('StoreIndex/index');?>"><img style="height: 27px;" src="/Public/images/back.png"></a></div>
		<div class="col-xs-8 search-title">
			<?php echo ($sae["shopname"]); ?>
		</div>
		<div class="col-xs-2"><span class="glyphicon glyphicon-shopping-cart" style="font-size: 24px; color: #fff; cursor: pointer;"></span></div>
	</div>
</div>

	<div id="carousel-example-generic" class="carousel slide both" data-ride="carousel">  
<!-- Indicators -->
		<span  style="bottom: 5px !important; left: 5px; margin: 0px; float: left; position: absolute; z-index: 10">
			<div style="background: rgb(255,153,0);  width: 60px; padding: 3px; border-radius: 15px;">
				<span class="glyphicon glyphicon-chevron-down fontcolor"></span>
				<span class="fontcolor">7折</span>
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
	
	<div class="shop-article-tab">
		<table name='tab' width="100%" style="text-align: center;">
			<tr>
				<td><div class="tab-active hov" style="height: 30px;"><h4 style="font-weight: 600;">预订</h4></div></td>
				<td style="width: 1px; color: rgb(50,184,173)">|</td>
				<td><div class="hov" style="height: 30px;"><h4 style="font-weight: bold;">详情</h4></div></td>
			</tr>
		</table>
	</div>
	<div class="cont-box1">
		<?php if(is_array($productlist)): $i = 0; $__LIST__ = $productlist;if( count($__LIST__)==0 ) : echo "暂无商品" ;else: foreach($__LIST__ as $key=>$plt): $mod = ($i % 2 );++$i;?><div class='bt-bot'>		
				<table name="cont-box1" style="width: 100%;">
					<tr>
						<td>
						<div class="row">
							<div class="col-xs-4">
							<h4 class="font-big"><?php echo ($plt["product_name"]); ?></h4>
							</div>
							<div class="col-xs-4" style="padding: 0px;">
								<div class="input-group input-group-sm" style="padding: 5px 15px;">
									<span data-tid='<?php echo ($plt["id"]); ?>' class="input-group-addon arec" data-max='<?php echo ($plt["purchase"]); ?>' data-type='0'>-</span>
									<input class="form-control purchase" readonly value="1" type="text" name="purchase">
									<span data-tid='<?php echo ($plt["id"]); ?>' class="input-group-addon arec" data-kucun='<?php echo ($plt["stock"]); ?>' data-max='<?php echo ($plt["purchase"]); ?>' data-type='1'>+</span>
								</div>
							</div>
							<div class="col-xs-4" style="border-left: 2px solid #ccc; height: 40px; line-height: 40px;">
								<span style="color: rgb(255,51,0); font-size: 24px">￥</span><span data-tid='<?php echo ($plt["id"]); ?>' class="price" data-p="<?php echo ($plt["price"]); ?>" style="color: rgb(255,51,0); font-size: 32px"><?php echo ($plt["price"]); ?></span>
							</div>
							<div style="height: 15px;" class="col-xs-12"></div>
							<div class="col-xs-8"><span style="color: rgb(255,51,0);"><?php echo ($plt["str"]); ?></span></div>
							<div class="col-xs-4">
								<span style="color: rgb(255,109,12); font-size: 14px">￥</span><span style="color: rgb(255,109,12); font-size: 16px"><del class="oprice" data-p="<?php echo ($plt["product_oprice"]); ?>" data-tid='<?php echo ($plt["id"]); ?>'><?php echo ($plt["product_oprice"]); ?></del></span>
								<span style="color: rgb(255,109,12); font-size: 14px">门市价</span>
							</div>
							<div style="height: 15px;" class="col-xs-12"> </div>
							<div class="col-xs-8"><button type="button" class="btn btn-info btn-sm" style="width:70%; font-size: 16px">商品详情</button></div>
							<div class="col-xs-4"><button type="button" class="btn btn-warning btn-sm" style="font-size: 16px">立即预订</button></div>
						</div>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
				</table>
			</div><?php endforeach; endif; else: echo "暂无商品" ;endif; ?>
	</div>

</body>
</html>