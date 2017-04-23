<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no">
	<title>商城首页</title>
	<link rel="stylesheet" href="/Public/adminlte/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="/Public/Css/store.css" />
	<script type="text/javascript" src="/Public/Js/jquery.min.js"></script>
	<script type="text/javascript" src="/Public/bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
<!-- Search Start -->
	<div class="container-fulid">
		<div class="row search-bg" style="margin: 0px">
			<div class="col-xs-2 search-title">全部</div>
			<div class="col-xs-8">
			    <div class="input-group">
			      <input type="text" class="form-control">
			      <span class="input-group-addon search-btn">
			        <span class="glyphicon glyphicon-search" style="font-size: 16px"></span>
			      </span>
			    </div>
			</div>
			<div class="col-xs-2"><span class="glyphicon glyphicon-shopping-cart" style="font-size: 24px; color: #fff; cursor: pointer;"></span></div>
		</div>
	</div>
<!-- //Search Start -->

<!-- TypeList Start -->
	
<link rel="stylesheet" type="text/css" href="/Public/layui/css/layui.css" />
<script type="text/javascript" src="/Public/layui/lay/dest/layui.all.js"></script>
<script type="text/javascript">
//流加载
	layui.use('flow', function(){
	  var $ = layui.jquery; //不用额外加载jQuery，flow模块本身是有依赖jQuery的，直接用即可。
	  var flow = layui.flow;
	  flow.load({
	    elem: '.list-box' //指定列表容器
	    ,done: function(page, next){ //到达临界点（默认滚动触发），触发下一页
	      var lis = [];
	      
	      //以jQuery的Ajax请求为例，请求下一页数据（注意：page是从2开始返回）
	      $.getJSON("<?php echo U('StoreIndex/IndexAjax');?>?page="+page, function(res){
	        //假设你的列表返回在data集合中
	     
	        layui.each(res.data, function(index, item){
	        	var imgs = new Array();
	        	var str = item.picsimg;
	        	imgs = str.split(",");
	          lis.push('<div class="row shoplist" style="margin: 0px; margin-bottom: 5px; padding: 10px;"><div class="col-xs-4"><a href="<?php echo U('StoreShopIndex/ShopArticle');?>?id='+item.id+'"><img class="shoplistimg" src="'+imgs[0]+'"/></a></div><div class="col-xs-8" style="padding: 3px 30px;"><h4 style="margin: 0px; font-weight: bold;"><a href="<?php echo U('StoreShopIndex/ShopArticle');?>?id='+item.id+'">'+item.shopname+'</a></h4><p><a href="<?php echo U('StoreShopIndex/ShopArticle');?>?id='+item.id+'"></a></p></div></div>');
	        }); 

			 
	        //执行下一页渲染，第二参数为：满足“加载更多”的条件，即后面仍有分页
	        //pages为Ajax返回的总页数，只有当前页小于总页数的情况下，才会继续出现加载更多
	        next(lis.join(''), page < res.pages);    
	      });
	    }
	  });
	});
</script>
	<div class="bgcolor">
		<ul style="list-style: none; margin: 0px; padding: 0px;">
			<?php if(is_array($typelist)): $i = 0; $__LIST__ = $typelist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$tp): $mod = ($i % 2 );++$i;?><li class="type-icon-list">
					<div class="list-group" style="border:none; margin: 0px; padding: 0px;">
						<div><a href="<?php echo U('StoreTypeList/Index',array('typeid'=>$tp['id']));?>" style="text-align: center; margin: 0 auto"><img style="height: 64px" class="img-responsive img-circle center-block" src="<?php echo ($tp["picurl"]); ?>" alt="<?php echo ($tp["typename"]); ?>"></a></div>
						<div class="type-title"><a href="<?php echo U('StoreTypeList/Index',array('typeid'=>$tp['id']));?>"><?php echo ($tp["typename"]); ?></a></div>
					</div>
				</li><?php endforeach; endif; else: echo "" ;endif; ?>
		</ul>
		<div style="clear: both;" class="clear-fixed"></div>
	</div>

<!-- TypeList End -->

<!-- Index AD Start -->
	
		<div class="container-fulid" style="margin: 5px 0px; border-top:1px #ccc solid;border-bottom:1px #ccc solid;">
			<div class="index-ad">AD1</div>
			<div class="index-ad">AD2</div>
			<div style="clear: both;"></div>
		</div>
	
<!-- Index AD End -->

<!-- ShopList Start -->
	
	<div class="container-fulid">
		<div class="vipicon">
			<span ><img style="width: 46px; margin-right: 10px;" src="/Public/img/vipicon.png"></span>
			<span style="font-size: 18px; font-weight: 600; color: rgb(6,193,174);">推荐商家</span>
		</div>
	</div>
	<div class="list-box" style="padding-bottom: 50px;">
		<?php if(is_array($shoplist)): $i = 0; $__LIST__ = $shoplist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$slt): $mod = ($i % 2 );++$i;?><div class="row shoplist" style="margin: 0px; margin-bottom: 5px; padding: 10px;">
				<div class="col-xs-4"><a href="<?php echo U('StoreShopIndex/ShopArticle',array('id'=>$slt['id']));?>"><img class="shoplistimg" src="<?php $arr = explode(',',$slt['picsimg']);echo $arr[0]; ?>"/></a></div>
				<div class="col-xs-8" style="padding: 3px 30px;">
					<h4 style="margin: 0px; font-weight: bold;"><a href="<?php echo U('StoreShopIndex/ShopArticle',array('id'=>$slt['id']));?>"><?php echo ($slt['shopname']); ?></a></h4>
					<p><a href="<?php echo U('StoreShopIndex/ShopArticle',array('id'=>$slt['id']));?>"><?php echo substr($slt['business_about'],0,90);?></a></p>
				</div>
			</div><?php endforeach; endif; else: echo "" ;endif; ?>
	</div>

	
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
	
<!-- ShopList End -->
</body>
</html>