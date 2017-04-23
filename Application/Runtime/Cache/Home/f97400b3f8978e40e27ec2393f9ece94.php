<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>钦州旅游网 - 惠民卡系统 - 订单列表</title>
<link rel="stylesheet" type="text/css" href="/Public/Css/base.css" />
<script type="text/javascript" src="/Public/Js/jquery.min.js"></script>
<script type="text/javascript" src="/Public/Js/select.js"></script>
<style type="text/css">
.fonts {
	font-size: 12px;
}
</style>
<script type="text/javascript">
  $(document).ready(function(){
    $('#sub').click(function(){
      $('#form1').submit();
    });
  });
</script>
</head>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
    <script type="text/javascript" src="http://apps.bdimg.com/libs/jquery/2.1.1/jquery.min.js"></script>
<script type="text/javascript" src="/Public/bootstrap/js/bootstrap.min.js"></script>
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="/Public/adminlte/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="http://cdn.bootcss.com/font-awesome/4.6.3/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="http://cdn.bootcss.com/ionicons/2.0.1/css/ionicons.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/Public/adminlte/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="/Public/adminlte/dist/css/skins/_all-skins.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="/Public/adminlte/plugins/iCheck/flat/blue.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="/Public/adminlte/plugins/morris/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="/Public/adminlte/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="/Public/adminlte/plugins/datepicker/datepicker3.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="/Public/adminlte/plugins/daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="/Public/adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->



  <header class="main-header">
    <!-- Logo -->
    <a href="#" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>H</b>MK</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Qzly</b>HMK</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">HMK</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">

          <li class="dropdown user user-menu">
            <a href="<?php echo U('StoreOrder/OrderList');?>">商城管理</a>
          </li>
          <li class="dropdown user user-menu">
            <a href="<?php echo U('index/manage');?>">惠民卡</a>
          </li>
          <li class="dropdown user user-menu">
            <a href="#">
              <img src="/Public/adminlte/dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo ($_SESSION['admin']); ?></span>
            </a>
          </li>
          <!-- Control Sidebar Toggle Button -->

        </ul>
      </div>
    </nav>

  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="/Public/adminlte/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo ($_SESSION['admin']); ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <ul class="sidebar-menu">
      
      <?php if(is_array($adminmenu)): $i = 0; $__LIST__ = $adminmenu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$adminmenu): $mod = ($i % 2 );++$i;?><li class=<?php if($c["tid"] == $adminmenu["id"]): ?>active<?php endif; ?> treeview>
          <a href="#">
            <i class="<?php echo ((isset($adminmenu['classicon']) && ($adminmenu['classicon'] !== ""))?($adminmenu['classicon']):'glyphicon glyphicon-plus'); ?>"></i> <span><?php echo ($adminmenu['typename']); ?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
          <?php if(is_array($ttt)): $i = 0; $__LIST__ = $ttt;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$type22): $mod = ($i % 2 );++$i; if($type22["tid"] == $adminmenu["id"]): ?><li <?php if(($type22['action'] == $cc) OR ($cc == 'manage')): ?>class="active"<?php endif; ?>><a href="<?php echo ($type22['url']); ?>"><i class="<?php echo ((isset($type2["classicon"]) && ($type2["classicon"] !== ""))?($type2["classicon"]):'fa fa-circle-o'); ?>"></i> <?php echo ($type22['typename']); ?></a></li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
          </ul>
        </li><?php endforeach; endif; else: echo "" ;endif; ?>

        <li class="header">系统管理</li>
        <li><a href="/index.php/home/index/index"><i class="fa  fa-home text-red"></i> <span>前台首页</span></a></li>
        <li><a href="/index.php/home/index/loginout2"><i class="fa  fa-power-off text-yellow"></i> <span>注销登录</span></a></li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>




<!-- jQuery 2.2.3 -->

<!-- jQuery UI 1.11.4 -->
<script src="/Public/Js/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.6 -->

<!-- Sparkline -->
<script src="/Public/adminlte/plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="/Public/adminlte/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="/Public/adminlte/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="/Public/adminlte/plugins/knob/jquery.knob.js"></script>
<!-- daterangepicker -->
<script src="/Public/Js/moment.js"></script>
<script src="/Public/adminlte/plugins/daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="/Public/adminlte/plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="/Public/adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="/Public/adminlte/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="/Public/adminlte/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="/Public/adminlte/dist/js/app.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->

<!-- AdminLTE for demo purposes -->
</body>
</html>

      <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style="background-color: #fff; ">
    <!-- Content Header (Page header) -->
    <!-- Main content -->
<div class="search">
  <form id="form1" name="form1" class="form-inline" role="form" method="post" action="">
  <div class="form-group">
        <select name="t1" class="form-control">
            <option value="0">全部</option>
          <?php if(is_array($shop)): $i = 0; $__LIST__ = $shop;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sp): $mod = ($i % 2 );++$i;?><option <?php if($sp["id"] == $keysave['t1']): ?>selected<?php endif; ?> value="<?php echo ($sp["id"]); ?>"><?php echo ($sp["typename"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
        </select>
    <div class="input-group">
      <input class="form-control" type="text" name="search" id="search" value="<?php echo ($keysave["keyword"]); ?>" placeholder="三娘湾门票">
      <div class="input-group-addon" name="sub" id="sub" style="cursor: pointer;"><span class="glyphicon glyphicon-search"></span></div>
    </div>
  </div>
  </form>
  <br>
</div>

<div style="margin:0px 2%;">
  <ul style="margin:0px;">
    <form id="form2" name="form2" method="post" action="<?php echo U('StoreProduct/ProductDel');?>">
      <ul>
        <table class="table table-bordered" width="96%" style="background:#fff;"  cellpadding="0">
          <tr>
            <td width="50" height="35" align="center" ><input type="checkbox" name="all" id="all" />
              <label for="all"></label></td>
            <td align="center" >商品标题</td>
            <td align="center" >商品名称</td>
            <td align="center" >所属商家</td>
            <td align="center" >商品分类</td>
            <td align="center" >折扣点</td>
            <td align="center" >市场价</td>
            <td align="center" >优惠价</td>
            <td align="center" >限购数量</td>
            <td align="center" >状态</td>
            <td align="center" >库存</td>
            <td align="center" >添加时间</td>
            <td align="center" >操作</td>
          </tr>
          <?php if(is_array($ol)): $i = 0; $__LIST__ = $ol;if( count($__LIST__)==0 ) : echo "$msg" ;else: foreach($__LIST__ as $key=>$ol): $mod = ($i % 2 );++$i;?><tr>
              <td width="50" height="35" align="center" ><input type="checkbox" value="<?php echo ($ol["id"]); ?>" class="select" name="select[]" id="select[]" /></td>
              <td align="center" ><?php echo ($ol["seotitle"]); ?></td>
              <td align="center" ><?php echo ($ol["product_name"]); ?></td>
              <td align="center" ><?php echo ($ol["shopname"]); ?></td>
              <td align="center" ><?php echo ($ol["typename"]); ?></td>
              <td align="center" ><?php echo ($ol['product_point']); ?>%</td>
              <td align="center" ><?php echo ($ol["product_oprice"]); ?></td>
              <td align="center" ><?php echo ($ol["price"]); ?></td>
              <td align="center" ><?php echo ($ol["purchase"]); ?></td>
              <td align="center" ><?php if($ol["status"] == 0): ?>已下架<?php else: ?>已上架<?php endif; ?></td>
              <td align="center" ><?php echo ($ol["stock"]); ?></td>
              <td align="center" ><?php echo (date('Y-m-d H:i:s',$ol["time"])); ?></td>
              <td align="center" ><a href="<?php echo U('ProductEdit',array('id'=>$ol['id']));?>"><button type="button" class="btn btn-primary">编辑</button></a></td>
            </tr><?php endforeach; endif; else: echo "$msg" ;endif; ?>
        </table>
        <div style="text-align: center;"><?php echo ($page); ?></div>
        <div style="text-align: center;">
          <input  name="submitbtn" class="btn btn-primary" onclick="return confirm('您确定要删除选中的产品吗？')" value="删除选中" type="submit" />
          <span class="fonts">（请谨慎删除，删除后不可恢复）</span>
        </div>
      </ul>
    </form> 
   
</div>
    <!-- /.content -->
	</div>
  <!-- /.content-wrapper -->
     <footer class="main-footer">
    <div class="pull-right hidden-xs">
    </div>
    <strong>Copyright &copy; 钦州旅游网   By:技术部
  </footer>
  
  <div class="control-sidebar-bg"></div>
</div>
</body>
</html>