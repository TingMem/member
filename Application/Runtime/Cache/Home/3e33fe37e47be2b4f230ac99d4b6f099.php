<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no">
	<title>订单填写</title>
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
      订单填写
    </div>
    <div class="col-xs-2"><span class="glyphicon glyphicon-shopping-cart" style="font-size: 24px; color: #fff; cursor: pointer;"></span></div>
  </div>
</div>
<!-- //商城头部 -->	
    
  

  
  
	
  <script>  


    jQuery(document).ready(function($) {
       $(".arec").click(function(){

        var spec = $(".spec-price");
        var len = $("div").find('.layui-form-checked').length;
        var n = Number(0);
        var price = $(".price");
        var prices = $(".prices");

          if($(this).attr("data-type")==0){
            if(Number($(this).next(".num").val()) > 1){
               $('.num').val(Number($('.num').val())-1);
               var num = Number($('.num').val());
                if(len > 0){
                  for(var i=0;i<len;i++){
                    var n = n + Number($('.layui-form-checked').eq(i).prev("input").attr("placeholder"));
                  }

                  var n = n*$('.num').val();
                }
               prices.html(Number(price.attr('data-price')) + n/num + " * " + num);
               $(".price").html($(".price").eq(0).attr('data-price') * Number($('.num').val()) + n);
            }
          }else{
            if(Number($(this).prev(".num").val()) < Number($(this).attr("data-kucun"))){
              $('.num').val(Number($('.num').val())+1);
              var num = Number($('.num').val());
              if(len > 0){
                for(var i=0;i<len;i++){
                  var n = n + Number($('.layui-form-checked').eq(i).prev("input").attr("placeholder"));
                }

                var n = n*$('.num').val();
              }

              prices.html(Number(price.attr('data-price')) + n/num + " * " + num);
              $(".price").html($(".price").eq(0).attr('data-price') * Number($('.num').val()) + n);
            }else{
              alert('库存不足');
            }
          }
      });
    });
    //引入layui模块
    layui.use(['layer', 'form'], function(){
      var layer = layui.layer
      ,form = layui.form();
    });


    layui.use('layer',function(){
        var $ = layui.jquery
        , layer = layui.layer; 
        var $ = layui.jquery();
    });

    var form = layui.form();
    form.on('checkbox',function(data){

      var spec = $(".spec-price");
      var len = $("div").find('.layui-form-checked').length;
      var n = Number(0);

      if(len > 0){
        for(var i=0;i<len;i++){
          var n = n + Number($('.layui-form-checked').eq(i).prev("input").attr("placeholder"));
        }

        var n = n*$('.num').val();
      }

      var price = $(".price");
      var prices = $(".prices");
      var num = Number($('.num').val());
      var place = Number(data.elem.placeholder);
      if(data.elem.checked==true){
          price.html(Number(price.attr('data-price')) * num + n);
          prices.html(Number(price.attr('data-price')) + n/num + " * " + num);
      }else{
          price.html(Number(price.attr('data-price')) * num + n);
          prices.html(Number(price.attr('data-price')) + n/num + " * " + num);
      }
    });
  </script>
    <form name="form" class="layui-form form" action="<?php echo U('StoreProductOrder/OrderPost');?>" method="post">
    <input class="productid"  type="hidden" value="<?php echo ($odr["id"]); ?>"  name="pid"/>
    	<div class="">
    		<table name='tab' width="100%" style="text-align: center;">
    			<tr>
    				<td><div style="height: 30px;">
              <div class="row" style="margin: 0px;">
                <div class="col-xs-6">
                  <h4 class="h4" style="font-weight: 600; text-align: left; padding: 0 0 0 10%;"><?php echo ($odr["product_name"]); ?></h4>
                </div>
                <div class="col-xs-6" style="padding: 10px">
                <span style="color: rgb(255,51,0); font-size: 16px">￥</span><span data-price="<?php echo ($odr["price"]); ?>" class="prices"  placeholder="<?php echo ($odr["price"]); ?>" style="color: rgb(255,51,0); font-size: 16px"><?php if($odr["stock"] > 0): echo ($odr["price"]); else: ?>0<?php endif; ?></span>
                </div>
              </div>
            </div></td>
    			</tr>
    		</table>
    	</div>

  
      <div class="row" style="margin: 0px;padding: 15px 5%;">
        <div class="col-xs-6">购买数量</div>
        <div class="col-xs-6">
          <div class="input-group input-group-sm" style="padding: 5px 15px;">
            <span data-tid='<?php echo ($odr["id"]); ?>' class="input-group-addon arec" data-kucun="<?php echo ($odr["stock"]); ?>" data-type='0'>-</span>
            <input class="form-control num" readonly value="<?php if($odr["stock"] > 0): ?>1<?php else: ?>0<?php endif; ?>" type="text" name="num">
            <span data-tid='<?php echo ($odr["id"]); ?>' style="background: rgb(27,169,186); color: #fff" class="input-group-addon arec active" data-kucun='<?php echo ($odr["stock"]); ?>' data-type='1'>+</span>
          </div>
        </div>
      </div>

    <h4 class="h4" style="font-weight: 600; text-align: left; padding: 0 0 0 10%;">规格</h4>
  <!-- 规格选择 -->
      <div class="col-xs-4" style="padding:0  10% 3%; z-index: 10; width: 100%">
        <div class="layui-form-item"  style="margin: 0px !important">
        <?php if(is_array($spec)): $i = 0; $__LIST__ = $spec;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sc): $mod = ($i % 2 );++$i;?><input class="spec-price" placeholder="<?php echo ($sc["spec_price"]); ?>"  type="checkbox" value="<?php echo ($sc["id"]); ?>"  name="spec[]" title="<?php echo ($sc["spec_name"]); ?>"><?php endforeach; endif; else: echo "" ;endif; ?>
        </div>
      </div>
  <!-- //规格选择 -->
    
      <h4 class="h4" style="font-weight: 600; text-align: left; padding: 0 0 0 10%; clear: both;">属性</h4>

    <!--cont-box2-->
      <div class="cont-box" id="cont-box2">
        <div class="row" style="margin: 0px ; padding: 5px 5%; border-bottom: 1px solid #ccc;">
          <?php if(is_array($attr)): $i = 0; $__LIST__ = $attr;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ar): $mod = ($i % 2 );++$i;?><div class="col-xs-6">
              <span style="font-weight: bold;"><?php echo ($ar["attr_name"]); ?></span>：<?php echo ($attrv[$i-1]['attr_value']); ?>
              <input type="hidden" name="attrvalue[]" value="<?php echo ($ar["attr_name"]); ?>:<?php echo ($attrv[$i-1]['attr_value']); ?>">
            </div><?php endforeach; endif; else: echo "" ;endif; ?>
        </div>

      <div class="layui-form-item row" style="padding: 15px 0 0 5%;">
      <div class="col-xs-4"> <label class="layui-form-label h4" style="padding: 0 0 0 10% ; width:auto;  font-weight: bold;">支付方式</label></div>
       
        <div class="layui-input-block col-xs-6" style="margin-left:0px ">
          <select name="pay" lay-verify="required">
            <option value="wxpay">微信支付</option>
            <option value="alipay">支付宝支付</option>
            <option value="unionpay">银联</option>
          </select>
        </div>
      </div>

      <!-- 简介 -->

      <div class="shop-article-tab" style="border-top: 0px;padding: 10px">
        <table name='tab' width="100%" style="text-align: left">
          <tr>
            <td><div style="height: 30px;"><span class="h4" style="font-weight: 600; text-align: left; padding: 0 0px 0  7%;">预订须知：</span><span style="color: red">注：规格数量同商品数量一致</span>
            </div></td>
          </tr>
        </table>
      </div>

        <div style="margin: 20px; padding-left: 15px;">

          <?php echo (htmlspecialchars_decode($odr["product_about"])); ?>
        </div>
      </div>

      <div class="row" style="margin: 0px;">
     
        <table class="table table-bordered">
          <tr>
            <td style="width: 50%; text-align: center;">
              <span style="color: rgb(255,51,0); font-size: 16px">总价 ￥</span><span class="price" placeholder="<?php echo ($odr["price"]); ?>" data-price="<?php echo ($odr["price"]); ?>" style="color: rgb(255,51,0); font-size: 24px"><?php if($odr["stock"] > 0): echo ($odr["price"]); else: ?>0<?php endif; ?></span>
            </td>
            <td style="text-align: center;"><button type="submit" class='layui-btn layui-btn-warm layui-btn-radius layui-btn-big'>提交订单</button></td>
          </tr>
        </table>
      
      </div>
    </form>
  
</body>
</html>