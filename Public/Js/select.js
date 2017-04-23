// JavaScript Document


$(document).ready(function() {
    $("#all").change(function(){
		 //alert($(this).prop("checked"));
		 $("input[class='select']").prop("checked",$(this).prop("checked"));
	});
	
	
	//删除商户
	$(".delsub").click(function(){
		if(confirm('删除后不可恢复,您是否要继续删除？')){
			//return true;
			$("#form2").attr('action','/index.php/home/index/listdel');
			$("#form2").submit();
		}else{
			return false;	
		}
	});


	//删除商户
	$(".deluser").click(function(){
		if(confirm('删除后不可恢复,您是否要继续删除？')){
			//return true;
			$("#form2").attr('action',$(this).attr('type-url'));
			$("#form2").submit();
		}else{
			return false;	
		}
	});

	$(".updateuser").click(function(){
			//return true;
			$("#form2").attr('action',$(this).attr('type-url'));
			$("#form2").submit();
	});

	//删除商户
	$(".logdelsub").click(function(){
		if(confirm('删除后不可恢复,您是否要继续删除？')){
			//return true;
			$("#form2").attr('action','/index.php/home/vip/logdel');
			$("#form2").submit();
		}else{
			return false;	
		}
	});

	//删除会员卡
	$(".vipdel").click(function(){
		if(confirm('删除后不可恢复,您是否要继续删除？')){
			
			$("#form2").attr('action','/index.php/home/vip/cartdel');
			$("#form2").submit();
		}else{
			return false;	
		}
	});

	//删除新闻
	$(".news_del").click(function(){
		if(confirm('删除后不可恢复,您是否要继续删除？')){
			//return true;
			$("#form2").attr('action','/index.php/home/manage/news_del');
			$("#form2").submit();
		}else{
			return false;	
		}
	});

	//删除用户留言
	$(".Message_del").click(function(){
		if(confirm('删除后不可恢复,您是否要继续删除？')){
			//return true;
			$("#form1").attr('action','/index.php/home/manage/Message_del');
			$("#form1").submit();
		}else{
			return false;	
		}
	});


	//删除帮助新闻
	$(".help_del").click(function(){
		if(confirm('删除后不可恢复,您是否要继续删除？')){
			//return true;
			$("#form2").attr('action','/index.php/home/manage/help_del');
			$("#form2").submit();
		}else{
			return false;	
		}
	});

	//更新合作
	$(".edit").click(function(){
		if($(".select").is(":checked")){
			$("#form2").attr('action','/index.php/home/index/updatestatus');
			$("#form2").submit();	
		}else{
			alert('请选择要操作的数据');	
		}
	});

//新闻审核
	$(".news_edit").click(function(){
		if($(".select").is(":checked")){
			$("#form2").attr('action','/index.php/home/manage/updatenews');
			$("#form2").submit();	
		}else{
			alert('请选择要操作的数据');	
		}
	});


	$(".shopheyan").click(function(){
		//alert('Success');
		if(!confirm('是否将该订单标记为已消费？')){
			return false;
		}
	})
	
	$("#upbtn").click(function(){
		//alert('Success');
		$(".uptext").click();
	});
	
	$("#upbtn2").click(function(){
		//alert('Success');
		$(".uptext2").click();
	});
	
	$(".uptext").change(function(){
		$(".Fmpic").text($(".uptext").val());
	});
	
	$(".uptext2").change(function(){
		$.ajax({
			url: '/index.php/home/index/ajax_upload',
			type: 'POST',
			cache: false,
			data: new FormData($('#uploadForm')[0]),
			processData: false,
			contentType: false
		}).done(function(res) {;
			$(".test").val($(".test").val()+res);
			//$(".test").text($(".test").text()+res);
		}).fail(function(res) {$(".test").val('Error')});
	});
	
	$("#yulan").click(function(){
		$(".show").html($(".test").val()).css("display","block");
		$(".test").css("display","none");
		$("#yulan").css("display","none");
		$("#edit").css("display","block");
	});
	
	$("#edit").click(function(){
		$("#edit").css("display","none");
		$("#yulan").css("display","block");
		$(".show").css("display","none");
		$(".test").css("display","block");
	});
	
	$("#fabu").click(function(){
		$("#form").submit();
	});
	
	$(".dd_jisuan").click(function(){
		//alert('Success');
		$(".cprice").text("总金额："+$(".user_dd_price").val() * $("#user_dd_num").val());
		
		$(".user_dd_cprice").val($("#user_dd_price").val()*$("#user_dd_num").val());
	});
	
	$("#user_dd_num").change(function(){
		//alert('Success');
		$(".cprice").text("总金额："+$(".user_dd_price").val() * $("#user_dd_num").val());
		
		$(".user_dd_cprice").val($("#user_dd_price").val()*$("#user_dd_num").val());
	});
	
	$(".shop_btndiv img").click(function(){
		if(parseInt($(".goNum").val())>parseInt($(".goNum").attr("rel"))){
			alert('超出限购数量，每人限购'+parseInt($(".goNum").attr("rel"))+$(".goNum").attr("att"));
			return false;
		}else if($(".goNum").val()==''){
			alert('请输入购买数量');	
		}else{
			$("#myform").submit();	
		}
		
	});
	
	
	$(".vipSubbtnsk").click(function(){
		$("#Form11").submit();
	})
	
	
	$(".vipSubbtn").click(function(){
		$("#oForm").submit();
	})

	
});