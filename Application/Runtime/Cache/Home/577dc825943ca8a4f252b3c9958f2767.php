<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>钦州旅游网 - 惠民卡系统 - 商家信息修改</title>
<link rel="stylesheet" type="text/css" href="/Public/Css/base.css" />
<link rel="stylesheet" type="text/css" href="/Public/Css/fileinput.min.css" />
<script type="text/javascript" src="/Public/Js/jquery.min.js"></script>
<script type="text/javascript" src="/Public/Js/select.js"></script>

<style type="text/css">
.fonts {
	font-size: 12px;
}

.col-md-2 { padding: 0px !important; }
</style>

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

<link rel="stylesheet" type="text/css" href="/Public/BootstrapValidator/css/bootstrapValidator.min.css" />
<script type="text/javascript" src="/Public/BootstrapValidator/js/bootstrapValidator.min.js"></script>
<script type="text/javascript" src="/Public/Js/fileinput.min.js"></script>
<script type="text/javascript" src="/Public/Js/fileinput_locale_zh.js"></script>
<link href="/Public/bootstrap-dialog/bootstrap-dialog.min.css" rel="stylesheet">
<script src="/Public/bootstrap-dialog/bootstrap-dialog.min.js"></script>

        <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="background-color: #fff; ">
      <div class="container">
        <div class="row clearfix">
          <div class="col-md-9 column">
            <form class="form-horizonta product-add" name="form1" data-type='ajax' id="form1" method="post" action="<?php echo U('ShopEditAjax');?>" role="form">
              <div class="form-group">
                 <label for="spname">商家名称</label><input placeholder="三娘湾景区" name="shopname" class="form-control" value="<?php echo ($sa["shopname"]); ?>" id="shopname" type="text" />
                 <input name="aid" class="form-control" value="<?php echo ($sa["id"]); ?>" type="hidden" />
              </div>
              <div class="form-group">
                <label for="title">分类信息</label>
                <div class="form-inline">
                  <select name="typeid" id="typeid" class="form-control">
                    <?php if(is_array($tn)): $i = 0; $__LIST__ = $tn;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$tn): $mod = ($i % 2 );++$i;?><option <?php if($sa['typeid'] == $tn['id']): ?>selected<?php endif; ?> value="<?php echo ($tn["id"]); ?>"><?php echo ($tn["typename"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                  </select>

                </div>

              </div>

              <div class="form-group">
                <label for="status">状态</label><div class="form-inline">
                  <select name="status" id="status" class="form-control">
                    <option <?php if($sa["status"] == 1): ?>selected<?php endif; ?> value="1">启用</option>
                    <option <?php if($sa["status"] == 0): ?>selected<?php endif; ?> value="0">停用</option>
                  </select>
                </div>
              </div>

              <div class="form-group">
                 <label for="spname">商家地址</label><input placeholder="钦州市xxx街xx号" name="address" class="form-control" value="<?php echo ($sa['address']); ?>" id="address" type="text" />
              </div>

              <div class="form-group">
                <label for="pics">商家图片(最大2M/张，最多5张)</label><input data-preview-file-type="text" multiple="multiple" id="pics" name="pics[]" type="file" />
                <input type="hidden" name="picsimg" class="picsubmit" value="">
              </div>
              <div class="form-group"><label for="business_about">商家介绍</label><textarea style="min-height: 300px"  name="business_about" id="business_about"><?php echo ($sa["business_about"]); ?></textarea>

<!-- 配置文件 -->
<script type="text/javascript" src="/Public/bdUe/ueditor.config.js"></script>
<!-- 编辑器源码文件 -->
<script type="text/javascript" src="/Public/bdUe/ueditor.all.js"></script>
<!-- 实例化编辑器 -->
<script type="text/javascript"> 
    var editor = new UE.ui.Editor(); 
    editor.render("business_about"); //1.2.4以后可以使用一下代码实例化编辑器 
</script>
              </div>
              <div style="text-align: center;"><button type="button" name="submit" class="btn btn-primary btn-sub">保存信息</button></div>
              

            </form>
          </div>
        </div>
      </div>
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
<script type="text/javascript">
  
$(document).ready(function(){
  var id = '<?php echo ($sa["id"]); ?>';
    var str = '<?php echo ($sa["picsimg"]); ?>'.split(',');
    if('<?php echo ($sa["picsimg"]); ?>'!=''){
       var len = str.length;
    }else{
       var len = 0;
    }
   
    $(".picsubmit").val('<?php echo ($sa["picsimg"]); ?>');
    var imgs = [];
    var imgconfig =[];
    if(len>=1){
      for(var i=0; i<len;i++){
        var stri = str[i].replace(/\//g,"-");
        imgs.push("<img  style='width:auto;height:160px;' src='" + str[i] + "' class='file-preview-image' alt='图片"+ i +"' title='图片"+ i +"'/>");
        imgconfig.push({"url":'/index.php/Home/StoreShop/ShopPicDel/pathurl/'+stri+'/id/'+id+'/arrid/'+i,'key':i});
      }
    }else{
      imgs.push("");
    }

    var upconfig = {
      'showUpload':true,
      'previewFileType':'any',
      'maxFileCount':5,
      'allowedPreviewTypes':['image','text'],
      'uploadAsync':true,
      'uploadUrl':'/index.php/Home/StoreProduct/ProductPicUpload',
      'enctype': 'multipart/form-data',
      'msgFilesTooMany':'抱歉，您最多可以上传5张图片',
    }

    if(imgs!=''){
     upconfig.initialPreview = imgs;
     upconfig.initialPreviewConfig = imgconfig;
    }

//Ajax图片上传 - bootstrap-inputfile
  $("#pics").fileinput(upconfig).on("fileuploaded", function(event, outData) {
    //文件上传成功后返回的数据
    var result = outData.response.data;
    // 对应的input 赋值
    if($(".picsubmit").val()!=''){
      $(".picsubmit").val($(".picsubmit").val()+","+result);
    }else{
      $(".picsubmit").val(result);
    }
});



    //验证表单并以Ajax方式提交数据

$(".btn-sub").click(function(){
$('form').data('bootstrapValidator').validate(); 
 var sub = $("#form1").data('bootstrapValidator').isValid();
 if(sub){
    var url = $('form').attr('action');
    var data = $('form').serializeArray();
    $.ajax({
      type:'POST',
      datatype:'json',
      data:data,
      url:url,
      success:function(result){
        if(result=='Success'){

          BootstrapDialog.show({
            title:'提示',
            message:'恭喜，修改保存成功！',
            buttons:[{
              label:'知道了',
              action:function(dialog){
                dialog.close();
              }
            }]
          })
          $('.btn-sub').attr('disabled','disabled').html('已提交');
        }
      }
    });
 }
});
   

      $('#form1').bootstrapValidator({

　　　　　message: 'This value is not valid',
          feedbackIcons: {
              valid: 'glyphicon glyphicon-ok',
              invalid: 'glyphicon glyphicon-remove',
              validating: 'glyphicon glyphicon-refresh'
          },
          fields: {
              shopname: {
                validators: {
                    notEmpty: {
                        message: '请输入商家名称'
                    }
                }
              },
            typeid: {
            validators: {
                notEmpty: {
                    message: '请选择分类信息'
                }
              }
            },
            }
      }).on('error.field.bv', function(e, data) {
          $('.btn-sub').attr('disabled','disabled');
        
      }).on('status.field.bv', function(e, data) {
          $('.btn-sub').removeAttr('disabled').html('提交商家');
      });

})
</script>
</html>