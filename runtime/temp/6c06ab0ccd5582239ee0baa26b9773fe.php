<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:42:"template/wap\b2c\\Member\personalData.html";i:1495866256;s:26:"template/wap\b2c\base.html";i:1495866256;}*/ ?>
<!DOCTYPE html>
<html>
<head>
<meta content="text/html; charset=UTF-8">
<meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="format-detection" content="telephone=no">
<title><?php echo $platform_shopname; ?></title>
<link rel="shortcut  icon" type="image/x-icon" href="__TEMP__/<?php echo $style; ?>/public/images/favicon.ico" media="screen"/>
<link rel="stylesheet" type="text/css" href="__TEMP__/<?php echo $style; ?>/public/css/pre_foot.css">
<link rel="stylesheet" type="text/css" href="__TEMP__/<?php echo $style; ?>/public/css/pro-detail.css">
<link rel="stylesheet" type="text/css" href="__TEMP__/<?php echo $style; ?>/public/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="__TEMP__/<?php echo $style; ?>/public/css/showbox.css">
<link rel="stylesheet" href="__TEMP__/<?php echo $style; ?>/public/css/layer.css" id="layuicss-skinlayercss">
<script src="__TEMP__/<?php echo $style; ?>/public/js/showBox.js"></script>
<script src="__TEMP__/<?php echo $style; ?>/public/js/jquery.js"></script>
<script type="text/javascript" src="__TEMP__/<?php echo $style; ?>/public/js/layer.js"></script>
<script type="text/javascript">
	var CSS = "__TEMP__/<?php echo $style; ?>/public/css";
	var APPMAIN='APP_MAIN';
	//页面底部选中
	function buttomActive(event){
		clearButton();
		if(event == "#buttom_home"){
			$("#buttom_home").find("img").attr("src","__TEMP__/<?php echo $style; ?>/public/images/home_check.png");
		}else if(event == "#buttom_classify"){
			$("#buttom_classify").find("img").attr("src","__TEMP__/<?php echo $style; ?>/public/images/classify_check.png");
		}else if(event == "#buttom_stroe"){
			$("#buttom_stroe").find("img").attr("src","__TEMP__/<?php echo $style; ?>/public/images/store_check.png");
		}else if(event == "#bottom_cart"){
			$("#bottom_cart").find("img").attr("src","__TEMP__/<?php echo $style; ?>/public/images/cart_check.png");
		}else if(event == "#bottom_member"){
			$("#bottom_member").find("img").attr("src","__TEMP__/<?php echo $style; ?>/public/images/user_check.png");
		}
	}
	function clearButton(){
		$("#buttom_home").find("img").attr("src","__TEMP__/<?php echo $style; ?>/public/images/home_uncheck.png");
		$("#buttom_classify").find("img").attr("src","__TEMP__/<?php echo $style; ?>/public/images/classify_uncheck.png");
		$("#buttom_stroe").find("img").attr("src","__TEMP__/<?php echo $style; ?>/public/images/store_uncheck.png");
		$("#bottom_cart").find("img").attr("src","__TEMP__/<?php echo $style; ?>/public/images/cart_uncheck.png");
		$("#bottom_member").find("img").attr("src","__TEMP__/<?php echo $style; ?>/public/images/user_uncheck.png");
	}
	
	
	//显示加载遮罩层
	function showLoadMaskLayer(){
		$(".mask-layer-loading").fadeIn(300);
	}
	
	//隐藏加载遮罩层
	function hiddenLoadMaskLayer(){
		$(".mask-layer-loading").fadeOut(300);
	}
	
	//动态修改遮罩层高度
	function updateLoadMaskLayerHeight(height){
	//	$(".mask-layer-loading").css("height",height+"px");
	}
	$(function(){
		showLoadMaskLayer();
	})
	
	$(document).ready(function(){
		hiddenLoadMaskLayer();
		//编写代码
	})
</script>
<style>
body .sub-nav.nav-b5 dd i {
	margin: 3px auto 5px auto;
}

body .fixed.bottom {
	bottom: 0;
}
.mask-layer-loading{
	position: fixed;
    width: 100%;
    height: 100%;
    /* background: rgba(0,0,0,0.5); */
    z-index: 999999;
    top: 0;
    left: 0;
    text-align: center;
	display: none;
}
.mask-layer-loading i,.mask-layer-loading img{
	text-align: center;
	color:#000000;
	font-size:50px;
	position: relative;
	top:50%;
}
.sub-nav.nav-b5 dd{
	width:25%;
}
.bottom-img{
	vertical-align: middle; width: 26px; height: 26px; max-width: none;
}
</style>

    <link rel="stylesheet" type="text/css" href="__TEMP__/<?php echo $style; ?>/public/css/foundation.css">
    <link rel="stylesheet" type="text/css" href="__TEMP__/<?php echo $style; ?>/public/css/normalize.css">
<!--     <script src="__TEMP__/<?php echo $style; ?>/public/js/ClassFirst.js"></script> -->
<!--     <script src="__TEMP__/<?php echo $style; ?>/public/js/ClassSub.js"></script> -->
    <link rel="stylesheet" type="text/css" href="__TEMP__/<?php echo $style; ?>/public/css/common-v4.4.css">
<!--     <script src="__TEMP__/<?php echo $style; ?>/public/js/foundation.js"></script> -->
    <meta class="foundation-data-attribute-namespace">
    <meta class="foundation-mq-xxlarge">
    <meta class="foundation-mq-xlarge">
    <meta class="foundation-mq-large">
    <meta class="foundation-mq-medium">
    <meta class="foundation-mq-small">
<!--     <script src="__TEMP__/<?php echo $style; ?>/public/js/foundation.alert.js"></script> -->
<!--     <script src="__TEMP__/<?php echo $style; ?>/public/js/Common.js"></script> -->
    <style  type="text/css">
.button-submit{
	width:90%;
	margin:0 auto;
	margin-top:50px;
}
.button-submit button{
	color:#FFF;
	background-color:#E03115;
	font-size:15px;
	border:none;
	line-height:40px;
	height:40px;
}
.personal-center .side-nav{
	margin-top:68px;
}
#divInfo>.side-nav>li{
	margin-left: 5px;
    margin-right: 7px;
    padding-left: 5px;
    padding-right: 0px;
    height: 35px;
    line-height: 30px;
    min-height: 35px;
    border-bottom: 1px solid #f1f1f1;
}
#divInfo>.side-nav>li:first-child{
	padding-bottom: 8px;
    margin-top: 0px;
    padding-top: 0px;
    height: 44px;
}
.value.touxiang{
	float: left;
}
.personal-center .side-nav{
	margin-top:45px;
	padding-top:7px;
}
.personal-center .text{
	font-size: 13px;
}
#divInfo>.side-nav>li.border-bottom-none{border-bottom: none;}
#divInfo>.side-nav>li.border-bottom-none img{
    margin-right: 0px;
    border-radius: 0px;
    width: 32px;
    height: auto;
}
.body-gray{background:#f5f5f5;}
.mt-55.mlr-15 input{
	box-shadow: none;
    margin: 0;
    height: 35px;
    border: none;
    max-width: 72%;
	min-width: 60%;
    display: inline-block;
}
.mt-55.mlr-15>div
{
	line-height:50px;
	padding-left:15px;
	overflow: hidden;
	background: #fff;
}
.mt-55.mlr-15>div:first-child{
margin-top:45px;	
}
.mt-55.mlr-15>div>span{
	width: 28%;
	font-size: 14px;
	display: block;
	float:left;
}
.mt-55.mlr-15>div>span.left-img{
	width: 16%;
}
.mt-55.mlr-15>div>span>img{
	width: 26px;
	height:auto;
    float: left;
    margin-top: 16px;
}
.border_right{
	    border-right: 1px solid #ddd;
    height: 24px;
    width: 2px;
    float: left;
    margin-top: 16px;
    margin-left: 14px;
}
.mt-55.mlr-15 input:focus{
	background: #fff;
}
.personal-center .value{
	font-size: 12px;
    color: #999;
}
.personal-center .value img{
	height: 40px;
	width:40px;
    margin-right: 0px;
    border-radius: 50%;
    border: 1px solid #f5f5f5;
}
.personal-center .arrow, .personal-center .head-arrow{
	margin-top: 10px;
}
.personal-center .set_a{
	color: #29afe4;
}
.mt-55.mlr-15>div.threeBind{
	padding-left: 0px;
    border-bottom: 1px solid #ddd;
    border-top: 1px solid #ddd;
    margin-top: 54px;
}
.mt-55.mlr-15>div.threeBind ul{
	overflow: hidden;
	margin-left: 0.5rem;
	    margin-bottom: 0px;
}
.mt-55.mlr-15>div.threeBind ul li{
	overflow: hidden;
    line-height: 35px;
    margin-bottom: 0px;
}
.mt-55.mlr-15>div.threeBind ul li>img:first-child{
      float: left;
    margin-top: 9px;
    max-width: 26px;
    height: auto;
}
.mt-55.mlr-15>div.threeBind ul li>a{
	    display: block;
    float: left;
    border-bottom: 1px solid #ddd;
    width: 91%;
    color: #333;
    font-size: 14px;
    padding-left: 6px;
        height: 42px;
    line-height: 42px;
}
.mt-55.mlr-15>div.threeBind ul li>a:after{
	clear: both;
}
.mt-55.mlr-15>div.threeBind ul li:last-child>a{
	 border-bottom:0px;
}
.mt-55.mlr-15>div.threeBind ul li>a>div{
	float: right;
}
.mt-55.mlr-15>div.threeBind ul li>a>div>span:first-child{
	    color: #999;
}
.mt-55.mlr-15>div.threeBind ul li>a>div>span:first-child.wei_span{
	color: #00A0E9;
}
.mt-55.mlr-15>div.threeBind ul li>a>div>span:last-child{
	border-right: 1px solid #ddd;
    border-bottom: 1px solid #ddd;
    transform: rotate(-46deg);
    -ms-transform: rotate(-46deg);
    -moz-transform: rotate(-46deg);
    -webkit-transform: rotate(-46deg);
    -o-transform: rotate(-46deg);
    width: 12px;
    height: 12px;
    display: block;
    float: right;
    margin: 13px 8px 10px 0px;
}
</style>

</head>
<body class="body-gray">
	
<section class="head">
		<a class="head_back" onclick="backPage()"
			href="javascript:void(0)"><i class="icon-back"></i></a>
		<div class="head-title" id="title">个人资料</div>
		
	</section>

	<div class="motify" style="display: none;"><div class="motify-inner">弹出框提示</div></div>
	 <!--submit errow tip begin-->
<!--submit errow tip end-->
<div class="personal-complete">
	<div class="personal-complete-tip"  id="personaltip"></div>
	<!--side nav begin-->
	<div class="personal-center" id="divInfo" >
		<ul class="side-nav" id="list" >
			<li>
					<a href="javascript:void(0)">
					<div class="cont-value" style="padding:0px;">
						<?php if($member_img != '' and $member_img != '0'): ?>
							<span class="value touxiang"><img src="__UPLOAD__/<?php echo $member_img; ?>" /></span>
						<?php else: ?>
							<span class="value touxiang"><img src="__TEMP__/<?php echo $style; ?>/public/images/member_default.png" /></span>
						<?php endif; ?>
						
					</div>
					</a>
			</li>
			
			<li isnew="False" >
				<a href="javascript:void(0)">
					<div class="title">
						<i></i>
						<span class="text">账号</span>
					</div>
					<div class="cont-value">
						<span class="value"><?php echo $member_info['user_info']['user_name']; ?>&nbsp;</span>
					</div>
				</a>
			</li>
			
			<li isnew="False" >
				<a href="javascript:void(0)" >
					<div class="title">
						<i></i>
						<span class="text" tage="nickname">昵称</span>
					</div>
					<div class="cont-value">
						<i class="arrow"></i><span class="value"  id="nickname"><?php echo $member_info['user_info']['nick_name']; ?></span>
					</div>
				</a>
			</li>
			<li isnew="False" >
				<a href="javascript:void(0)" >
					<div class="title">
						<i></i>
						<span class="text" tage="password">密码</span>
					</div>
					<div class="cont-value">
						<i class="arrow"></i><span class="value set_a"  id="password">修改</span>
					</div>
				</a>
			</li>
			<li ><a href="javascript:void(0)">
					<div class="title">
						<i></i>
						<span class="text" tage="mobilephone">手机</span>
					</div>
					<div class="cont-value">
						<i class="arrow"></i>
						<?php if($member_info['user_info']['user_tel'] != ''): ?>
							<span class="value" id="mobilephone"><?php echo $member_info['user_info']['user_tel']; ?>&nbsp;</span>
						<?php else: ?>
							<span class="value set_a" id="mobilephone">绑定手机号</span>
						<?php endif; ?>
					</div>
			</a></li>
			<li><a href="javascript:void(0)">
					<div class="title">
						<i></i>
					<span class="text" tage="qqno">QQ号</span>
					</div>
					<div class="cont-value">
						<i class="arrow"></i><span class="value" id="qqno"><?php echo $member_info['user_info']['user_qq']; ?>&nbsp;</span>
					</div>
			</a></li>	
					
			<li><a href="javascript:void(0)">
					<div class="title">
						<i></i>
					<span class="text" tage="email">邮箱</span>
					</div>
					<div class="cont-value">
						<i class="arrow"></i><span class="value" id="emailno"><?php echo $member_info['user_info']['user_email']; ?>&nbsp;</span>
					</div>
			</a></li>	
			<li class="border-bottom-none"><a href="javascript:void(0)">
					<div class="title">
						<i></i>
					<span class="text" tage="threeBind">第三方账号绑定</span>
					</div>
					<div class="cont-value">
						<i class="arrow"></i><span class="value" id="threeBindno">
							<!--<img src="__TEMP__/<?php echo $style; ?>/public/images/personalData_weixin.png" alt="" />-->
							<img src="__TEMP__/<?php echo $style; ?>/public/images/personalData_qq.png" alt="" />
						</span>
					</div>
			</a></li>	
		</ul>
		
			<div  class="button-submit">
		<a href="APP_MAIN" >
					
				<button onclick="logout()" >
			退出登录
			</button>		
						
			</a>
			
		</div>
		
		
	</div>

</div>
<!--form begin-->
<!-- 第三方绑定 -->
<form class="mt-55 mlr-15" id="edit" style="display: none;margin:45px 0 0 0;width:100%;">
	<div class="threeBind">
		<ul>
			<!-- <li><img src="__TEMP__/<?php echo $style; ?>/public/images/personalData_weixin.png" alt="" /><a href="javascript:;"><span>微信</span> <div><span class="wei_span">未绑定</span><span class="right_border">&nbsp;</span></div></a> </li> -->
			
			<?php if($qq_openid != ''): ?>
			<li><img src="__TEMP__/<?php echo $style; ?>/public/images/personalData_qq.png" alt="" /><a href="APP_MAIN/Member/removeBindQQ.html"><span>QQ</span> <div><span class="">解除绑定</span><span class="right_border">&nbsp;</span></div></a> </li>
			<?php else: ?>
			<li><img src="__TEMP__/<?php echo $style; ?>/public/images/personalData_qq.png" alt="" /><a href="APP_MAIN/Login/oauthlogin.html?type=QQLOGIN"><span>QQ</span> <div><span class="wei_span">未绑定</span><span class="right_border">&nbsp;</span></div></a> </li>
				
			<?php endif; ?>
			
			<!-- <li><img src="__TEMP__/<?php echo $style; ?>/public/images/personalData_weibo.png" alt="" /><a href=""><span>微博</span> <div><span class="wei_span" >未绑定</span><span class="right_border">&nbsp;</span></div></a> </li> -->
		</ul>
	</div>
				
</form>

<!-- 密码修改 -->
<form class="mt-55 mlr-15" id="editpassword" style="display: none;background-color:#fff;margin:45px 0 0 0" >
		<div><span>当前密码：</span>
			<input type="text" id="oldpassword" style="margin:0;height:50px;border-bottom:none;"  placeholder="原始密码"   onfocus="$(this).attr('type','password')">
		</div>
		
		<div><span>新&nbsp;&nbsp;密&nbsp;码：</span>
			<input type="text" id="newpassword" style="box-shadow:none;margin:0;height:35px;border:none;width:auto;display:inline-block;"  placeholder="新密码"  onfocus="$(this).attr('type','password')"/>
			<span>确认新密码：</span><input type="text" id="newpassword2"   placeholder="确认新密码"  onfocus="$(this).attr('type','password')" >
		</div>
		<!--03 end-->	
</form>

<!-- 手机号绑定 -->
<form class="mt-55 mlr-15" id="edit_mobile" style="display: none;background-color:#fff;margin-top: 10px;margin:0;    margin-top: 8px;" >
		<div>
			<span>手机号</span>
			<input type="text" id="input_mobile"  placeholder="请输入手机号码"  value='<?php echo $member_info['user_info']['user_tel']; ?>'/>
		</div>
		
		<!-- <div>
			<span>验证码</span>
			<img id="verify_img" src="<?php echo captcha_src(); ?>" alt="captcha" onclick="this.src='<?php echo captcha_src(); ?>'"  />
			<input type="text" id="input_mobile"  placeholder="请输入验证码"  value=''/>
		</div> -->
		<!-- <div>验证码
		<input type="text" id="input_verify"   placeholder="请输入收到的验证码" /></div> -->
		<!--03 end-->	
</form>

<form class="mt-55 mlr-15" id="edit_nick_name" style="display: none;background-color:#fff;margin-top: 10px;margin:0;margin-top: 8px;">
		<div><span>昵称</span>
			<input type="text" id="input_nick_name"  placeholder="请输入昵称"  value='<?php echo $member_info['user_info']['nick_name']; ?>'/>
		</div>
</form>

<form class="mt-55 mlr-15" id="edit_email" style="display: none;background-color:#fff;margin-top: 10px;margin:0;margin-top: 8px;">
		<div><span>邮箱</span>
			<input type="text" id="input_user_email"  placeholder="请输入邮箱"  value='<?php echo $member_info['user_info']['user_email']; ?>'/>
		</div>
</form>

<div  id="saveBtn"class="button-submit" style="display: none;">
	<a href="javascript:void(0)" onclick="btnsave()">
		<button >保存</button>		
	</a>
</div>

	
	
	<!-- 加载弹出层 -->
	<div class="mask-layer-loading">
		<img src="__TEMP__/<?php echo $style; ?>/public/images/mask_load.gif"/>
		<!-- <i class="fa fa-spinner fa-pulse"></i> -->
	</div>
	
<script>
// 	$(document).foundation().foundation('joyride', 'start');
</script> 
<script type="text/javascript">
	var title = "";//
	var value = "";
	var type = "";
	$(function () {
		buttomActive('#bottom_member');
    	$("#list li").click(function () {
            var titleTag = this.children[0].children[0].children[1];
            if (titleTag == undefined) {
                titleTag = this.children[0].children[1].children[1];
            }
            title = titleTag.innerHTML;
			type = $(titleTag).attr("tage");
			value = this.children[0].children[1].children[1];
			if (value == undefined) {
				value = this.children[0].children[2].children[1]
			}
			value = value.innerHTML;

			value = value.replace("&nbsp;", "");
			$("#value").attr("placeholder", "");

			$("#personaltip").toggle()
			if (title == "账号") {
				if ($(this).attr("isnew") == "False") {
					return;
				} else {
					$("#value").attr("placeholder", "请输入会员名");
					$("#title").html(title);
					$("#saveBtn").toggle();
					$("#divInfo").toggle();
					$("#exit").toggle();
					$("#edit").toggle();
					return;
				}
			}
			if (title == "密码") {
				$("#title").html("修改密码");
				$("#saveBtn").toggle();
				$("#divInfo").toggle();
				$("#exit").toggle();
				$("#editpassword").toggle();
			}else if(title == "手机"){
				$("#value").attr("placeholder", "请输入手机号码!");
				$("#title").html("修改手机号码");
				$("#saveBtn").toggle();
				$("#divInfo").toggle();
				$("#exit").toggle();
				$("#edit_mobile").toggle();
			}else if(title == "昵称"){
				$("#value").attr("placeholder", "请输入昵称");
				$("#title").html("修改昵称");
				$("#saveBtn").toggle();
				$("#divInfo").toggle();
				$("#exit").toggle();
				$("#edit_nick_name").toggle();
			}else if(title == "邮箱"){
				$("#edit_email").toggle();
				$("#title").html(title);
				$("#saveBtn").toggle();
				$("#divInfo").toggle();
				$("#exit").toggle();
				$("#value").attr("placeholder", "请输入邮箱!");
				$("#input_ico").attr("src","__TEMP__/<?php echo $style; ?>/public/images/center_email.png");
			} else {
				$("#title").html(title);
				$("#value").val(value);
				$("#saveBtn").toggle();
				$("#divInfo").toggle();
				$("#exit").toggle();
				$("#edit").toggle();
				if(title=='第三方账号绑定'){
					$('.button-submit').hide();
				}
				if(title == "真实姓名"){
					$("#value").attr("placeholder", "请输入真实姓名!");
					$("#input_ico").attr("src","__TEMP__/<?php echo $style; ?>/public/images/center_user.png");
				}else if(title == "QQ号"){
					$("#value").attr("placeholder", "请输入QQ号!");
					$("#input_ico").attr("src","__TEMP__/<?php echo $style; ?>/public/images/center_qq.png");
				}else if(title == "微信号"){
					$("#value").attr("placeholder", "请输入微信号!");
					$("#input_ico").attr("src","__TEMP__/<?php echo $style; ?>/public/images/center_weixn.png");
				}
			}
		});
	});
	//点击返回
	function backPage(){
		var title=$("#title").html();
		if(title=="个人资料"){
			var shop_id = "<?php echo $shop_id; ?>";
			if(shop_id == 0)
				{
				window.location.href="APP_MAIN/member/index";	
				}
			else{
				window.location.href="APP_MAIN/member/index?shop_id="+shop_id;	
			}
		}else{
			window.location.href=window.location.href;	
		}
	}
	function logout(){
		  $.ajax({
              url: "APP_MAIN/Member/logOut",
              type: "post",
              success: function (res) {
                  if (res['code'] > 0) {
                	  window.location.href="APP_MAIN/login/index";
                  } else {
	            	  if(res["message"]!=null){
	            		  showBox(res["message"]);
	            	  }
                  }
              }
          })
	}
	function btnsave() {
        var url = "APP_MAIN";
        var value = "";
        switch (type) {
            case "password":
                //密码(6-16)位
                var oldpassword = $("#oldpassword").val();
                var newpassword = $("#newpassword").val();
                var newpassword2 = $("#newpassword2").val();
                var reg = /^[\@A-Za-z0-9\!\#\$\%\^\&\*\.\~]{6,16}$/;
                if (!reg.test(newpassword)) {
                	showBox("新密码不符合规则", {
        				time: 2000
        			});
                    return false;
                }
                if(newpassword2!=newpassword){
                	showBox("两次密码不一致请重新输入", {
        				time: 2000
        			});
                	 return false;
                }
                $.ajax({
                    url: "APP_MAIN/Member/modifyPassword",
                    data: { "new_password":newpassword,"old_password":oldpassword },
                    type: "post",
                    success: function (res) {
                    	//alert(JSON.stringify(res));
                        if (res['code']> 0) {
                            backPage();
                        } else {
                        	showBox(res["message"]);
                        }
                    }
                })
                break;
            case "truename":
                var truename = $("#truename").text().trim();
                value = $("#value").val().trim();
                if (value == "") {
                	showBox("真实姓名不能为空");
                	 return false;
                }
                if (truename == value) {
                	showBox("与原真实姓名一致,无需修改");
                	 return false;
                }
                $.ajax({
                    url: "APP_MIAN/Member/updateRealName",
                    data: { "truename": value },
                    type: "post",
                    success: function (res) {
                        if (res["retval"]  == 1) {
                             $("#truename").text(value);
                             backPage();
                        } else {
                        	showBox("修改失败");
                        }
                    }
                })
                break;
            case "mobilephone":
                var mobilephone = $("#mobilephone").text().trim();
                value = $("#input_mobile").val().trim();
                if (value == "") {
                	showBox("手机不能为空");
                	 return false;
                }
                //手机11位
                var reg = /^\d{11}$/;
                if (!reg.test(value)) {
                	showBox("手机号码格式不正确");
                	 return false;
                }
                if (mobilephone == value) {
                	showBox("与原手机号码一致,无需修改");
                	 return false;
                }
                $.ajax({
                    url: "APP_MAIN/Member/modifyMobile",
                    data: { "mobilephone": value },
                    type: "post",
                    success: function (res) {
                        if (res["code"] > 0) {
                            $("#mobilephone").text(value);
                            backPage();
                        } else {
                        	showBox(res["message"]);
                        }
                    }
                })
                break;
            case "qqno":
                value = $("#value").val().trim();
                if (value == "") {
                	showBox("QQ号不能为空");
                	 return false;
                }
                $.ajax({
                    url: "APP_MAIN/Member/modifyQQ",
                    data: {"qqno": value },
                    type: "post",
                    success: function (res) {
                        if (res["code"] > 0) {
                            backPage();
                            $("#qqno").text(value);
                        } else {
                        	showBox(res["message"]);
                        }
                    }
                })
                break;
            case "wxno":
                value = $("#value").val().trim();
                if (value == "") {
                	showBox("微信号不能为空");
                	 return false;
                }
                $.ajax({
                    url: "APP_MAIN/Member/modifyQQ",
                    data: { "wxno": value },
                    type: "post",
                    success: function (res) {
                        if (res["retval"]== 1) {
                            backPage();
                            $("#wxno").text(value);
                        } else {
                        	showBox("修改失败");
                        }
                    }
                })
                break;
            case 'email':
            	   value = $("#input_user_email").val().trim();
                   if (value == "") {
                	   showBox("邮箱不能为空");
                	   return false;
                   }
                   $.ajax({
                       url: "APP_MAIN/Member/modifyEmail",
                       data: { "email": value },
                       type: "post",
                       success: function (res) {
                           if (res["code"]== 1) {
                               backPage();
                               $("#emailno").text(value);
                           } else {
                        	   showBox("修改失败");
                           }
                       }
                   })
                   break;
            case "nickname":
            	var nickname = $("#nickname").text();
            	value = $("#input_nick_name").val().trim();
            	if(nickname == value){
    				showBox("与原昵称一致,无需修改");
    				return false;
            	}
            	if(value == ""){
            		showBox("昵称不能为空");
            		return false;
            	}
                $.ajax({
                    url: "APP_MAIN/Member/modifyNickName",
                    data: { "nickname": value },
                    type: "post",
                    success: function (res) {
                    	if(res.code >0){
                            $("#emailno").text(value);
                        	backPage();
                    	}else{
                        	showBox(res.message);
                    	}
                    }
                })
            	break;
        }
    }
</script> 

</body>
</html>