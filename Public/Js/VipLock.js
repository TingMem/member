// JavaScript Document


	$(document).ready(function(e) {
		$("#username").focus();
			$(".kuaijie ul li").click(function(){
			$("#about").val("通过["+$(this).html()+"]认证");	
		});



//提交表单		
		$(".manage_reg").click(function(){

			var pattern = /^[1-9]{1}[0-9]+$/;
			var	str = $("#username").val();
			var result = pattern.test(str);
			//alert(result);
			if(result != true){
				$(".nametips").html("<i class='glyphicon glyphicon-remove red'></i>必须以数字1到9开头,至少两位数以上。");
				$(".username").focus();
				//$(this).val("");
				return false;
			}else{
				if($("#username").val()==""){	
					$("#username").focus();	
					alert('请输入手机号');
					return false;
				}else if($("#card").val()=="" || $("#card").val().length!=18){
					//$(".font12").html("身份证号码不正确");
					alert("身份证号码不正确");
					$("#card").focus();	
					return false;
				}else if($("#sid").val() == ""){
					$(".cardsid").html("请输入会员卡号");
					$("#sid").focus();
					return false;
				}else if($("#usercname").val()==""){
					alert("请输入姓名");
					$("#usercname").focus();
					return false;
				}else{
					$("#form1").submit();	
				}
			}
		});


		
		$(".pwdtrue").change(function(){
			//alert($(".pwdtrue").is(":checked"));
			if($(".pwdtrue").is(":checked")){	
				$("#password").removeAttr("readonly");
			}else{
				$("#password").attr("readonly","readonly");
			}
		});

		$(".resetsid").change(function(){
			//alert($(".pwdtrue").is(":checked"));
			if($(".resetsid").is(":checked")){	
				$("#sid").removeAttr("readonly");
			}else{
				$("#sid").attr("readonly","readonly");
			}
		});


		$(".xuqi").change(function(){
			if($(".xuqi").is(':checked')){
				$(".sxuqi").css('display','block');	
			}else{
				$(".sxuqi").css('display','none');	
			}
		})		
        $("#username").change(function(){
			var pattern = /^[1-9]{1}[0-9]+$/;
			var	str = $(this).val();
			var result = pattern.test(str);
			//alert(result);
			if(result != true){
				$(".nametips").html("<i class='glyphicon glyphicon-remove red'></i>必须以数字1到9开头,至少两位数以上。");
				//$(this).val("");
				return false;
			}else{		

				if($("#username").val()!=""){
					$.ajax({
						url :"/index.php/home/vip/vipload",
						//Type:'POST',
						type:'POST',
						data:{username:$("#username").val()},
						dataType:"JSON",
						success: function(obj){
							if(obj!=0){
								//var obj = $.parseJSON(data);
								//alert(data);
								
								$("#password").val("********");
								$("#usercname").val(obj.usercname);
								$("#card").val(obj.card);
								$("#tel").val(obj.tel);
								$(".pwd").css("color","green").html("");
								//$("#sid").val(obj.sid);
								$(".qixian").css("color","blue").html("有效期："+obj.startime+"至"+obj.endtime);
								$("#form1").attr("action","/index.php/home/vip/viplock");
								$(".manage_reg").html('绑定会员卡');
								$("#about").text(obj.about);
								//$(".resetpwd").html('<input name="pwdtrue" class="pwdtrue"  type="checkbox" value="1" /> 修改密码，不勾选则不修改');
								$(".resetpwd").css('display','block');
								if(obj.sid!=null){
									$("#sid").val(obj.sid);	
									//$(".cidtips").html('<span style="color:green;fong-size:14px;"><input name="resetsid"  class="resetsid" type="checkbox" value="1" /> 更改卡号（挂失或录错）</span>');
									$(".resetsidspan").css('display','block');
									$(".resetsidspan").css('display','block');
									$(".reendtime").css('display','block');
									
									
									
									$("#sid").attr("readonly","readonly").addClass('form-control');
									$("#password").attr("readonly","readonly").addClass('form-control');
								}else{
									
									$("#sid").attr("placeholder","请输入会员卡号");
									$("#password").attr("readonly","readonly").addClass('form-control');
									$(".cidtips").html("请输入会员卡号。");
									$("#sid").val("519777000");
								}
								$(".nametips").html("<span style='color:blue' class='glyphicon glyphicon-info-sign'></span>该用户已经注册，已经为您拉取信息，请询问用户是否已经进行了注册。")
								
							}else{
								$("#form1").attr("action","/index.php/home/vip/vipaddlock");
								$(".nametips").html("<sapn style='color:green' class='glyphicon glyphicon-ok'></span>");
								$(".pwd").html("*手机号为密码");
								//$("#password").val("");
								//$("#tel").val("");
								$("#usercname").val("");
								$("#card").val("");
								$("#about").text("");
								$("#tel").val($("#username").val());
								$("#password").val($("#username").val());
							}
						},
						error : function(){
							alert('请求失败，服务器未响应！。');
						}
					});	
				}else {
								$(".nametips").html("<i style='color:green' class='glyphicon glyphicon-ok green'></i>尚未注册，请在下方填写密码。");
								$(".pwd").html("*手机号为密码");
								//$("#password").val("");
								//$("#tel").val("");
								$("#usercname").val("");
								$("#card").val("");
								$("#about").text("");
								$("#tel").val("");
								$("#password").val("");
								$("#sid").val("519777000");
				}	
			}
		});
    });