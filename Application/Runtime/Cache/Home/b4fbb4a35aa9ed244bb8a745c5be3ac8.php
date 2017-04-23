<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<!-- Tell the browser to be responsive to screen width -->
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<title>钦州旅游网 - 会员卡系统</title>
<link rel="stylesheet" type="text/css" href="/Public/Css/base.css" />
<script type="text/javascript" src="/Public/Js/jquery.min.js"></script>
<script type="text/javascript" src="/Public/Js/select.js"></script>
<script type="text/javascript" src="/Public/Js/Viplock.js"></script>
<style type="text/css">
.fonts {
	font-size: 12px;
	
}
table tr td { padding:0 15px;}
input.ipt { width:250px; height:30px; margin-right:20px; float:left}
.kuaijie ul li { list-style:none; float:left; padding:5px; border:1px solid #ccc; margin-right:20px; cursor:pointer;}
.font12 {
	font-size: 12px;
	color: #F00;
}


</style>
<script>
	$(document).ready(function(e) {
        $("#yanqi").keyup(function(){
			if(!$.isNumeric($(this).val())){
				$(this).val("");
				$(this).focus();
			}
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
    <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- Main content -->
  	  
<form id="form1" name="form1" method="post" action="/index.php/home/vip/vipAddLock">
  <table class="table-bordered" width="100%" style="background:#ccc;" border="0" align="center" cellpadding="0" cellspacing="1">
    <tr>
      <td height="50" colspan="3" align="center" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="60%">&nbsp;</td>
          <td><a href="/index.php/home/Excel/Excel/date/1">
            <div style="margin-left:30px; border:1px solid #ccc; padding:5px; background:#eee; cursor: pointer; text-align:center ; float:left;">导出今天</div>
          </a>
            <div style="margin-left:30px; border:1px solid #ccc; padding:5px; background:#eee; cursor: pointer; text-align:center ;  float:left;"><a href="/index.php/home/Excel/Excel/date/2">导出近7天</a></div>
            <a href="/index.php/home/Excel/Excel/date/3">
            <div style="margin-left:30px; border:1px solid #ccc; padding:5px; background:#eee; cursor: pointer; text-align:center ;float:left;">导出近一月</div>
            </a>
            
            <a href="/index.php/home/Excel/Excel/date/4">
            <div style="margin-left:30px; border:1px solid #ccc; padding:5px; background:#eee; cursor: pointer; text-align:center ;float:left;">导出全部</div>
            </a>
            
            
            </td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td height="50" colspan="3" align="center" bgcolor="#FFFFFF">
      <div style="float:left">卡号发售范围：
      	<span style="color:red;"><?php echo ($arr); ?></span>
        
          共[<span style="color:red;"><?php echo ($vip["count"]); ?></span>]张  当前已发售[<span style="color:red;"><?php echo ($vip["locks"]); ?></span>]张  剩余：[<span style="color:red;"><?php echo ((isset($vip["ok"]) && ($vip["ok"] !== ""))?($vip["ok"]):'0'); ?></span>]张</div> <?php if($_SESSION["level"] == 10): ?>实体卡:[<span style="color:red;"><?php echo ($vip["stk"]); ?></span>]张，电子卡[<span style="color:red;"><?php echo ($vip["internet"]); ?></span>]张<?php endif; ?></td>
    </tr>
    <tr>
      <td width="200" height="50" align="center" bgcolor="#FFFFFF">手机：</td>
      <td bgcolor="#FFFFFF"><label for="username"></label>
        <input class="ipt" name="username"  type="text" id="username" style="float:left;" maxlength="11" />

        &nbsp;<span class="font12 nametips">&nbsp;*数字，第一位必须是1-9之间</span></td>
      <td width="20%" rowspan="8" valign="top" bgcolor="#FFFFFF">
      <div style="padding:5px; border-bottom:1px dashed #ccc; color:#666; font-size:18px; ">您最近绑定</div>
      <?php if(is_array($viplock)): $i = 0; $__LIST__ = $viplock;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$viplock): $mod = ($i % 2 );++$i;?><div style="padding:5px;<?php switch($i): case "1": case "2": case "3": ?>color:red;"><?php break;?>
        <?php default: ?>color:#999"><?php endswitch; echo ($i); ?>. &nbsp;&nbsp;&nbsp;<?php echo ($viplock["sid"]); ?></div><?php endforeach; endif; else: echo "" ;endif; ?>
      </td>
    </tr>
    <tr>
      <td width="200" height="50" align="center" bgcolor="#FFFFFF">密码：</td>
      <td bgcolor="#FFFFFF"><input class="ipt" type="text" name="password" style="float:left" id="password" />
      &nbsp;<span class="font12 pwd"></span><span class="font12 resetpwd" style="display:none; float:left;"><input name="pwdtrue" class="pwdtrue"  type="checkbox" value="1" /> 修改密码，不勾选则不修改</span></td>
    </tr>
    <tr>
      <td height="50" align="center" bgcolor="#FFFFFF">姓名：</td>
      <td bgcolor="#FFFFFF"><input class="ipt" type="text" name="usercname" id="usercname" /></td>
    </tr>
    <tr>
      <td width="200" height="50" align="center" bgcolor="#FFFFFF">身份证：</td>
      <td bgcolor="#FFFFFF"><input class="ipt" name="card" type="text" id="card" maxlength="18" />
      &nbsp; <span class="font12">*</span><span class="font12">如配偶是钦州或以其它方式证明自己居住于钦州，请在备注处注明</span></td>
    </tr>
    <tr style="">
    
      <td width="200" height="50" align="center" bgcolor="#FFFFFF">手机(接收短信)：</td>
      <td bgcolor="#FFFFFF"><input class="ipt" name="tel" type="text" id="tel" maxlength="11"  /><span class="font12 qixian"></span></td>
    </tr>
    <tr>
      <td height="50" align="center" bgcolor="#FFFFFF">延期生效：</td>
      <td bgcolor="#FFFFFF"><input value="0" class="ipt" placeholder="3" style="width: 70px !important" name="yanqi" type="text" id="yanqi" maxlength="3" />
      天 <span class="font12">*</span><span class="font12">请填写正整数，不填则为不延期，只针对未绑定或正在绑定的用户，已绑定的不能延期。</span></td>
    </tr>
    <tr>
      <td height="50" align="center" bgcolor="#FFFFFF">会员卡号：</td>
      <td bgcolor="#FFFFFF"><input class="ipt" value="<?php echo ($vip["sid"]); ?>" name="sid" type="text" id="sid" maxlength="14" />
  &nbsp; &nbsp;<span class="font12 cidtips"><span class="resetsidspan" style="color:green;fong-size:14px; display:none; float:left;"><input name="resetsid"  class="resetsid" type="checkbox" value="1" /> 更改卡号（挂失或录错）</span> <span class="reendtime" style="color:green;fong-size:14px; display:none; float:left;"><input name="xuqi" style="float:left;"  class="xuqi" type="checkbox" value="1" /> <small style="float: left; font-size:13px; padding-top:3px;">&nbsp;续期</small> &nbsp;&nbsp;&nbsp;<select style="float:left; color:red; display:none;" class="sxuqi" name="sxuqi">
    <option value="1">1年</option>
    <option value="2">2年</option>
    <option value="3">3年</option>
    <option value="4">4年</option>
    <option value="5">5年</option>
    <option value="10">10年</option>
  </select></span></span></td>
    </tr>
    <tr>
      <td width="200" height="50" align="center" bgcolor="#FFFFFF">备注</td>
      <td bgcolor="#FFFFFF">
        <div class="kuaijie" style="margin:20px;">
          <ul>
            <li>身份证</li>
            <li>户口本</li>
            <li>学生证</li>
            <li>结婚证</li>
            <li>暂住证</li>
            <li>其它证件</li>
          </ul>
        </div>
        <div style="clear:both; padding-top:20px;">
          <textarea placeholder="请描述用户通过什么方式证明自己是钦州人，如身份证居住地址是钦州可不填写。" name="about" cols="50" rows="5" id="about"></textarea>
          <span class="font12"> *如配偶是钦州地区户籍时，可使用结婚证购买</span>
        </div>
      </td>
    </tr>
    <tr>
      <td colspan="3" align="center" bgcolor="#FFFFFF"><p>&nbsp;</p>
        <div style=" cursor:pointer; float:left; margin-left:400px; text-align:center; color:#fff;" class="manage_reg btn btn-primary">注册绑定</div>
        <p>&nbsp;</p>
        <p>&nbsp;</p></td>
    </tr>
  </table>
</form>
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