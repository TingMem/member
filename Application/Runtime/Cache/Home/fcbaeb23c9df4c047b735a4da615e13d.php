<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>钦州旅游网 - 惠民卡系统 - 规格编辑</title>
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

    $("#submit").click(function(){

      if($('#type_name').val()==''){
        alert('请输入分类名');
        $("#type_name").focus();
        return false;
      }
    })

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
            <a href="<?php echo U('storeProduct/index');?>">商城管理</a>
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

<div style="margin:0px 2%;">
  <div class="container">
    <div class="row clearfix">
      <div class="col-md-12 column">
        <form class="form-horizontal" enctype="multipart/form-data" role="form" id="form1" name="form1" method="post" action="<?php echo U('TypeEdit');?>">
          <div class="form-group">
            <label for="typename" class="col-sm-2 control-label">分类名</label>
            <div class="col-sm-3">
              <input name="editid" class="form-control" id="editid" value="<?php echo ($tpe["id"]); ?>" type="hidden" />
              <input name="type_name" class="form-control" id="type_name" value="<?php echo ($tpe["typename"]); ?>" type="text" />
            </div>
          </div>
          <div class="form-group">
            <label for="type" class="col-sm-2 control-label">分类图标</label>
            <div class="col-sm-2" style="border: 0px;">
              <input name="typepic"  id="typepic" type="file" />
            </div>
            <p class="col-sm-2 text-danger"><img width="64px" height="64px;" src="<?php echo ((isset($tpe["picurl"]) && ($tpe["picurl"] !== ""))?($tpe["picurl"]):'/PUBLIC/images/default.jpg'); ?>"/>最大200kb</p>
          </div>
          <div class="form-group">
             <label for="type_status" class="col-sm-2 control-label">立即启用</label>
            <div class="col-sm-2">
              <select name="type_status" id="type_status" class="form-control">
              <option <?php if($tpe["status"] == 1): ?>selected<?php endif; ?> value="1">是</option>
                <option <?php if($tpe["status"] == 0): ?>selected<?php endif; ?> value="0">否</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="weight" class="col-sm-2 control-label">权重（排序）</label>
            <div class="col-sm-1">
              <input name="weight" class="form-control" id="weight" value="<?php echo ($tpe["weight"]); ?>" type="text" />
            </div>
          </div>

          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
               <button type="submit" id="submit" class="btn btn-primary">保 存</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
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