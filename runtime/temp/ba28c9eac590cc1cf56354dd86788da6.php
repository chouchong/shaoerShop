<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:34:"template/wap\b2c\\Login\login.html";i:1495866256;}*/ ?>
<!DOCTYPE html>
<html>
<head>
<title>会员登录</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="Keywords" content="<?php echo $platform_shopname; ?>">
<meta name="Description" content="<?php echo $platform_shopname; ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<link rel="shortcut  icon" type="image/x-icon" href="__TEMP__/<?php echo $style; ?>/public/images/favicon.ico" media="screen"/>
<link rel="stylesheet" href="__TEMP__/<?php echo $style; ?>/public/css/login_base.css">
<link rel="stylesheet" href="__TEMP__/<?php echo $style; ?>/public/css/login_wap.css">
<link rel="stylesheet" type="text/css" href="__TEMP__/<?php echo $style; ?>/public/css/font-awesome.css">
<link rel="stylesheet" href="__TEMP__/<?php echo $style; ?>/public/css/layer.css" id="layuicss-skinlayercss">
<script src="__TEMP__/<?php echo $style; ?>/public/js/showBox.js"></script>
<script src="__TEMP__/<?php echo $style; ?>/public/js/jquery.js"></script>
<script type="text/javascript" src="__TEMP__/<?php echo $style; ?>/public/js/layer.js"></script>
<script type="text/javascript"
	src="__TEMP__/<?php echo $style; ?>/public/js/jquery.js"></script>
<script type="text/javascript">
	$(function() {
		$('.nk_cell').click(function() {
			if (!$(this).is('.active')) {
				$('.nk_cell').removeClass('active');
				$(this).addClass('active');
				var oDiv1 = $('#nk_text1');
				var oDiv2 = $('#nk_text2');
				if (oDiv1.css('display') == "block") {
					oDiv1.hide();
					oDiv2.show();
				} else {
					oDiv2.hide();
					oDiv1.show();
				}
			}
		});
		$('.right_login_user').click(function() {
			$("#username").val("");
		});
		$('.right_login_pass').click(function() {
			$("#password").val("");
			$("#password_mobile").val("");
		})
		$('.right_login_mobile').click(function() {
			$("#mobile").val("");
		})
	})
	function check(){
		
		var username = $("#username").val();
		var password = $("#password").val();
		if(username == ''){
			layer.msg('用户名不能为空');
			return false;
		}else if(password == ''){
			layer.msg('密码不能为空');
			return false;
		}
		
		$.ajax({
			type : "post",
			url : "index",
			async : true,
			data : {
				"username" : username,
				"password" : password
			},
			success : function(data) {
				 if(data["code"] > 0 ){
					 setTimeout(function(){location.href="APP_MAIN/member/index"},1000);
				}else{
					layer.msg(data["message"]);
				} 
			}
		});
		
		
	}
	
function check_mobile(){
		
		var mobile = $("#mobile").val();
		var password_mobile = $("#password_mobile").val();
		if(mobile == ''){
			layer.msg('手机号不能为空');
			return false;
		}else if(password_mobile == ''){
			layer.msg('密码不能为空');
			return false;
		}
		
		$.ajax({
			type : "post",
			url : "index",
			async : true,
			data : {
				"mobile" : mobile,
				"password" : password_mobile
			},
			success : function(data) {
				 if(data["code"] > 0 ){
					 setTimeout(function(){location.href="APP_MAIN/member/index"},1000);
				}else{
					layer.msg(data["message"]);
				} 
			}
		});
		
		
	}
</script>
<style>
.login_wei_three{
	margin: 1rem 42.5%;
}

</style>
</head>
<body>
	<!--      <section class="head">
		<a class="head_back" onclick="window.history.go(-1)" href="javascript:void(0)"><i class="icon-back"></i></a>
		<div class="head-title">会员登录</div>
	</section>  -->
	<div class="nk_logo">
		<img src="__TEMP__/<?php echo $style; ?>/public/images/login.png" />
	</div>
	<!-- <a href="APP_MAIN/login"><div class="banner_login">
		<span >登录</span>
	</div></a>
	<a href="APP_MAIN/login/register"><div class="banner_register">
		<span>注册</span>
	</div></a> -->
	<div class="nk_top">
		<div class="<?php if($loginConfig['mobile_config']['is_use'] == 1): ?>nk_cell<?php else: ?>nk_cell_one<?php endif; ?> active">
			账号密码登录
		</div>
		<?php if($loginConfig['mobile_config']['is_use'] == 1): ?>
		<div class="nk_cell">
			手机动态码登录
		</div>
		<?php endif; ?>
	</div>
	<div class="log-wp">
		<div class="log-box">
<!-- 			<form id="LoginForm" action="APP_MAIN/Login/" method="post" onsubmit="return check()"> -->
				<div id="nk_text1" style="display: block;">
					<div class="log-cont">
						<label class="log-txt" for="username">账号&nbsp;&nbsp;&nbsp;&nbsp;<input class="" type="text"
							name="username" id="username" placeholder="请输入手机号或账号"> <i
							class="right_login_user"> </i>
						</label>
					</div>
					<div class="log-cont">
						<label for="password">密码&nbsp;&nbsp;&nbsp;&nbsp;<input
							class="" type="password" name="password" id="password"
							placeholder="请输入密码"> <i class="right_login_pass"> </i>
						</label>
					</div>
					<!-- 	<div class="hide" id="verify">
					<div class="half pos">
						<div class="log-cont">
							<i class="icon-captcha"></i>
							<label class="half" for="code">
				                <input class="" type="text" name="code" placeholder="请输入验证码">
				            </label>
						</div>
					</div>
				</div> -->
					<button id="login-button" class="lang-btn" onclick="check()">登录</button>
					<div class="msg cl">
						<a style="color:#666;" href="APP_MAIN/login/reg.html">忘记密码？</a>
						<!-- <input type="checkbox" />记住密码  -->
						<a class="y"  href="APP_MAIN/login/register.html">立即注册</a>
					</div>
				</div>
<!-- 			</form> -->
<!-- 			<form id="LoginForm" action="APP_MAIN/Login/" method="post" onsubmit="return check_mobile()"> -->
				<div id="nk_text2" style="display: none;">
					<div class="nk-cont">
						<label> 手机号&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" id="mobile"
							name="mobile" placeholder="请输入手机号码"> <i class="right_login_mobile"> </i> <!-- <a
							href="javascript:;">获取验证码</a> -->
						</label>
					</div>
					<div class="nk-cont">
						<label>密&nbsp;&nbsp;&nbsp;码&nbsp;&nbsp;&nbsp;&nbsp;<input type="password"
							id="password_mobile" name="password" placeholder="请输入密码"> <i class="right_login_pass"> </i>
						</label>
					</div>
					<button id="login-button" class="lang-btn" onclick="check_mobile()">登录</button>
					<div class="msg cl">
						<a class="y" href="APP_MAIN/login/reg.html">忘记密码？</a>
					</div>
				</div>
<!-- 			</form> -->
			<!-- <div class="nk_regist">
				没有账号？<a href="APP_MAIN/login/register">立即注册</a>
			</div>  -->
		<!-- <div class="login-title pt-60 pb-50">
			<h5 class="t-c f-24">使用以下账号登录</h5>
		</div> -->
		<?php if($loginCount != 0): ?>
		<img src="__TEMP__/<?php echo $style; ?>/public/images/assistant_member.png" style="width: 80% !important;margin-left: 10%;margin-top: 25px;"/>
		<?php endif; ?>
		<div style="margin: 0 10%;">
		
		<?php if($loginConfig['qq_login_config']['is_use'] == 1): ?>
		<div class="<?php if($loginCount == 1): ?>login_wei<?php elseif($loginCount == 2): ?>login_wei_two<?php elseif($loginCount == 3): ?>login_wei_three<?php endif; ?>">
			<a href="APP_MAIN/login/oauthlogin.html?type=QQLOGIN">
			<img src="__TEMP__/<?php echo $style; ?>/public/images/qq.png"/>
			<span>QQ</span>
			</a>
		</div>
		<?php endif; ?>

		<div class="<?php if($loginCount == 1): ?>login_wei<?php elseif($loginCount == 2): ?>login_wei_two<?php else: ?>login_wei_three<?php endif; ?>">
			<a href="APP_MAIN/login/oauthlogin.html?type=WCHAT">
				<img src="__TEMP__/<?php echo $style; ?>/public/images/weixin.png" />
				<span>微信</span>
			</a>
		</div>

		<div class="<?php if($loginCount == 1): ?>login_wei<?php elseif($loginCount == 2): ?>login_wei_two<?php elseif($loginCount == 3): ?>login_wei_three<?php endif; ?>" style="display: none;">
			<a href="APP_MAIN/login/wchatOauth.html">
				<img src="__TEMP__/<?php echo $style; ?>/public/images/weibo.png"/>
				<span >微博</span>
			</a>
		</div>
		</div>
		
		</div>
	</div>
</body>
</html>