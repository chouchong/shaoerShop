<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:35:"template/admin\b2c\Login\login.html";i:1494580328;}*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="renderer" content="webkit" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<title><?php echo $title_name; ?></title>
	<meta name="keywords" content="<?php echo $title_name; ?>" />
	<meta name="description" content="<?php echo $title_name; ?>" />
	<meta name="author" content="<?php echo $title_name; ?>网站" />
	<link rel="shortcut  icon" type="image/x-icon" href="ADMIN_IMG/admin_icon.ico" media="screen"/>
	<script src="__STATIC__/js/jquery-1.8.1.min.js"></script>
	<script src="__STATIC__/bootstrap/js/bootstrap.js"></script>
	<link href="ADMIN_CSS/member_login.css" rel="stylesheet" type="text/css" />
	<style>
	.verification-code{
		position:relative;
	}
	.verification-code img{
		position: absolute;
		top: 5px;
		right: 32px;
		z-index:101;
		width:100px;
		height:30px;
	}
	</style>
</head>
<body>
	<div class="header_min" id="header">
	<div class="header_min_top">
		<div id="J_header" class="itopl font_gray6 link_gray6"><span class="link_yellow">欢迎登录<?php echo $title_name; ?>系统！请 <a href="#">登录</a>&nbsp;|&nbsp;<a href="SHOP_MAIN/login/register.html">注册</a></span></div>
		<div class="itopr font_gray9 link_gray6 substring">
			<a href="SHOP_MAIN" class="home">网站首页</a><!-- |
			<a href="APP_MAIN" class="m">手机访问</a>| 
 			<a href="#" class="help">帮助中心</a>| 
 			<a href="#" class="shop">积分商城</a>| 
			 <a href="#" class="stat">薪酬统计</a>|
 			<a href="#" class="last">保存到桌面</a> -->
		</div>
		<div class="clear"></div>
	</div>
</div>
<div class="user_head_bg">
	<div class="user_head">
		<div class="logobox"><a href="SHOP_MAIN"><img src="__ROOT__/<?php echo $logo; ?>" border="0"></a></div>
		<div class="logotxt">|&nbsp;&nbsp;商家登录</div>
		<div class="reg"><!--此处原来有注册--></div>
		<div class="clear"></div>
	</div>
</div>
<div class="ban_box">
	<div class="banner_list banner_list2" style="opacity: 0; z-index: 0;"></div>
	<div class="banner_list banner_list3" style="opacity: 0; z-index: 0;"></div>
	<div class="banner_list banner_list1" style="opacity: 0; z-index: 0;"></div>
	<div class="banner_list banner_list4" style="opacity: 4; z-index: 0;"></div>
	<div class="maind">
		<div class="login">
			<!--用户名密码登录 -->
			<div class="mob j_mob_show">
<!-- 				<div class="righttab J_hoverbut J_mob" title="微信扫码登录"></div> -->
				<div class="tit">
					<span class="switch_txt active">商家登录</span>
					<div id="forAccountLogin" class="switch_account link_blue" data-index="0"><a href="javascript:;">切换为账号登录</a></div>
				</div>
				<div class="type_box active">
					<div class="err J_errbox" id="hint" style="display:none;"></div>
					<div class="inputbox J_focus">
						<div class="imgbg"></div>
						<input type="text" class="input_login" name="txtName" id="txtName" onchange="javascript:;" placeholder="手机号/会员名/邮箱" />
					</div>
					<div class="inputbox J_focus">
						<div class="imgbg pwd"></div>
							<input type="password" class="input_login pwd J_loginword" name="txtPWD" id="txtPWD" placeholder="请输入密码" />
					</div>
					<?php if($login_verify_code['admin'] == 1): ?>
					<div class="inputbox J_focus verification-code">
						<div class="imgbg" style="background: none;"></div>
						<input type="text" id="vertification" class="input_login vertification" name="vertification" placeholder="请输入验证码 " /> 
						<img  id="verify_img" src="<?php echo captcha_src(); ?>" alt="captcha" onclick="this.src='<?php echo captcha_src(); ?>'"/>
					</div>
					<?php endif; ?>
<!-- 					<div class="txtbox link_gray6"> -->
<!-- 						<div class="td1"><label><input name="expire" class="J_expire" checked="checked" type="checkbox" value="1"> 7天内自动登录</label></div> -->
<!-- 						<div class="td2"><a href="SHOP_MAIN/login/findpasswd">忘记密码?</a></div> -->
<!-- 					</div> -->
		 			<div class="btnbox">
		 				<input class="btn_login J_hoverbut" type="button" id="btnLogin" onclick="btnlogin();" value="登录" />
		 			</div>
		 			<?php if($qq_info['is_use'] != 0 || $Wchat_info['is_use'] != 0): ?>
					<div class="qqbox">
						<div class="qtit" style="margin-bottom:10px;">
							<div class="qtit_left">使用合作账号登录</div>
							<div class="clear"></div>
						</div>
						<div class="appsparent" style="display: inline-block; float: right;margin-top: -55px;margin-right: 18px;">
							<div class="apps">
								<?php if($qq_info['is_use'] == 1): ?><a class="ali qq" href="APP_MAIN/login/oauthlogin.html?type=QQLOGIN" title="腾讯QQ账号登录"></a><?php endif; if($Wchat_info['is_use'] == 1): ?><a class="ali taobao" href="APP_MAIN/login/oauthlogin.html?type=WCHAT" title="微信登录"></a><?php endif; ?>
							</div>
						</div>
						<div class="clear"></div>
					</div>
					<?php endif; ?>
				</div>
			</div>
			<!--二维码的登录 -->
			<div class="qr_code J_qr_code_show">
				<div class="righttab J_hoverbut J_qr_code" title="账号密码登录"></div>
				<div class="tit">微信扫码，安全登录</div>
				<div id="J_weixinQrCode" class="code"><img width="140" height="140" src="ADMIN_IMG/icon-code.png"></div>
				<div class="txt">打开 手机微信 <br> 扫一扫登录</div>
			</div>
		</div>
	</div>
</div>
<input type="hidden" id="J_loginType" value="0" />
<input type="hidden" id="verify_userlogin" value="0" />
<input type="button" id="origin_btnCheck" style="display:none;"/>
<input type="button" id="btnCheck" style="display:none;"/>
<input type="hidden" id="J_sendVerifyType" value="0"/>
<div id="popup-captcha">
	<div class="gt_input">
		<input class="geetest_challenge" type="hidden" name="geetest_challenge"/>
		<input class="geetest_validate" type="hidden" name="geetest_validate"/>
		<input class="geetest_seccode" type="hidden" name="geetest_seccode"/>
	</div>
</div>
<div class="footer_min" id="footer">
	<div class="links link_gray6">
		<a target="_blank" href="#">网站首页</a>|
		<a target="_blank" href="#">招贤纳士</a>|
		<a target="_blank" href="#">联系我们</a>|
		<a target="_blank" href="#">推广合作</a>|
		<a target="_blank" href="#">法律申明</a>|
		<a target="_blank" href="#">产品服务</a>|
		<a target="_blank" href="#">网站介绍</a>|
		<a target="_blank" href="#">意见建议</a> 
	</div>
	<div class="txt">
		<p>联系地址：山西省太原市小店区并州南路6号1幢（鼎太风华）A座2单元21层2102号&nbsp;联系电话：400-886-7993<br>Copyright&nbsp;©&nbsp;2015-2017&nbsp;niushop.com.cn &nbsp;All&nbsp;Right&nbsp;Reserved&nbsp;晋ICP备16001360号-2</p>
	</div>
</div>
<div class="disappear_tooltip pie_about" style="left: 634.5px; top: 286.5px;">
	<div class="icon"></div>
	<div class="content"></div>
</div>
<script type="text/javascript">
var global = {
	h:$(window).height(),
	st: $(window).scrollTop(),
	backTop:function(){
		global.st > (global.h*0.5) ? $("#backtop").show() : $("#backtop").hide();
	}
}

$('#backtop').on('click',function(){
	$("html,body").animate({"scrollTop":0},500);
});

global.backTop();
$(window).scroll(function(){
	global.h = $(window).height();
	global.st = $(window).scrollTop();
	global.backTop();
});

$(window).resize(function(){
	global.h = $(window).height();
	global.st = $(window).scrollTop();
	global.backTop();
})
$(function() {
	$.pie = function(name, v){
		// 如果没有加载 PIE 则直接终止
		if (! PIE) return false;
		// 是否 jQuery 对象或者选择器名称
		var obj = typeof name == 'object' ? name : $(name);
		// 指定运行插件的 IE 浏览器版本
		var version = 9;
		// 未指定则默认使用 ie10 以下全兼容模式
		if (typeof v != 'number' && v < 9) {
			version = v;
		}
		// 可对指定的多个 jQuery 对象进行样式兼容
		if ($.browser.msie && obj.size() > 0) {
			if ($.browser.version*1 <= version*1) {
				obj.each(function(){
					PIE.attach(this);
				});
			}
		}
	}
	
	var url = window.location.host;
	if (url.indexOf('autoscript') != -1) {
		$("#hm_img").remove();
	}
	// 显示隐藏 请输入密码、请输入帐号
// 	innitEvent();
	var Sys = {};
	var ua = navigator.userAgent.toLowerCase();
	var s;
	(s = ua.match(/(msie |trident\/)([\d.]+)/)) ? Sys.ie = s[1]: (s = ua.match(/firefox\/([\d.]+)/)) ? Sys.firefox = s[1]: (s = ua.match(/chrome\/([\d.]+)/)) ? Sys.chrome = s[1]: (s = ua.match(/opera.([\d.]+)/)) ? Sys.opera = s[1]: (s = ua.match(/version\/([\d.]+).*safari/)) ? Sys.safari = s[1]: 0;
	if (Sys.chrome) {
		//$("#chromealert").hide();
		$("#chromealert").css("display", "none");
	} else {
		//$("#chromealert").show();
		$("#chromealert").css("display", "block");
	}
	if (Sys.ie) {
		$("#explorer").text("Internet Explorer");
	} else if (Sys.firefox) {
		$("#explorer").text("Firefox");
	} else if (Sys.opera) {
		$("#explorer").text("Opera");
	} else if (Sys.safari) {
		$("#explorer").text("Safari");
	} else {
		$("#explorer").text("其他");
	}
});
		// 显示隐藏 请输入密码、请输入帐号 
// 	function innitEvent() {
// 		$("#btnLogin").removeAttr("disabled");
// 		var $hidpwd = $("#hidpwd");
// 		var $pwd = $("#txtPWD");
// 		var $txtName = $("#txtName");
// 		var $hidpwd = $("#hidpwd");
// 		var $vertification = $("#vertification");
		
// 		$txtName.focus(function() {
// 			$("#namedel").css("display", "block");
// 			$("#pwddel").css("display", "none");
// 		})
// 		$hidpwd.focus(function() {
// 			$("#namedel").css("display", "none");
// 			$("#pwddel").css("display", "block");
// 		})
// 		$pwd.focus(function() {
// 			$("#pwddel").css("display", "block");
// 			$("#namedel").css("display", "none");
// 		})
// 		$("#namedel").click(function() {
// 			$(this).siblings("input").val("");
// 		});
// 		$("#pwddel").click(function() {
// 			$(this).siblings("input").val("");
// 		});
// 		$("#hidpwd").focus(function() {
// 			$("#hidpwd").css("display", "none");
// 			$("#txtPWD").css("display", "block");
// 			$("#txtPWD").focus();
// 		});
// 	};

	// enter 键登录
	document.onkeypress = function() {
		var iKeyCode = -1;
		if (arguments[0]) {
			iKeyCode = arguments[0].which;
		} else {
			iKeyCode = event.keyCode;
		}
		if (iKeyCode == 13) {
			// 登录
			$("#btnLogin").click();
		}
	}


	// 登陆 登录时 登录按钮"变暗"
	function btnlogin() {
		ClearCookie(); //登录时清除之前的cookie
		if ($("#txtName").val() == "请输入账号" || $("#txtName").val() == "") {
			$("#hint").css("display", "block");
			$("#hint").text("请输入账号");
			$("#txtName").focus();
			return false;
		} else if ($("#txtPWD").val() == "") {
			$("#hint").css("display", "block");
			$("#hint").text("请输入密码");
			$("#hidpwd").focus();
			return false;
		}
		var userName = $('#txtName').val();
		var password = $('#txtPWD').val();
		var vertification = $("#vertification").val(); 
		if("<?php echo $login_verify_code['admin']; ?>" == 1){
			if($("#vertification").val() == undefined || $("#vertification").val() == ""){
				$("#hint").css("display", "block");
				$("#hint").text("请输入验证码");
				$("#vertification").focus();
				return false;
			}
		}
		// 后台验证
		$.post("ADMIN_MAIN/Login/login", {
			"userName" : userName,
			"password" : password,
			"vertification" : vertification
		}, function(data) {
			if (data['code'] > 0) {
				$("#hint").css("display", "none");
				$("#btnLogin").attr("disabled", "disabled");
				window.location.href = "ADMIN_MAIN";
			} else {
				//$("#txtPWD").val("");//清空密码
				$("#verify_img").attr("src",'<?php echo captcha_src(); ?>');
				$("#txtValidate").val("");
				$("#hint").show();
				$("#hint").text(data['message']); //  用户名密码提示
				$("#verify_img").attr("src",'<?php echo captcha_src(); ?>');
			}
		});
	};

	// 设置时间 登录的按钮变色
	function locationHref() {
		//$("#btnLogin").addClass("btn-submit");
		var href = "";
		$.ajax({
			url : "/Login/JumpFirstMenu",
			type : "post",
			data : {},
			async : false,
			success : function(succData) {
				if (succData != null) {
					href = succData;
				}
			}
		});
		window.location.href = href;
	}
	function ClearCookie() {
		var expires = new Date();
		expires.setTime(expires.getTime() - 1000);
		document.cookie = "appCode='';path=/;expires=" + expires.toGMTString() + "";
		document.cookie = "roleID='';path=/;expires=" + expires.toGMTString() + "";
		document.cookie = "parentMenuID='';path=/;expires=" + expires.toGMTString() + "";
		document.cookie = "currentMenuName='';path=/;expires=" + expires.toGMTString() + "";
	}

	//生成快捷方式
	function shortcut() {
		$.ajax({
			url : "/Login/Shortcut",
			type : "post",
			success : function(data) {
			}
		});
	}
	//加入收藏
	function AddFavorite(sURL, sTitle) {
		try {
			window.external.addFavorite(sURL, sTitle);
		} catch (e) {
			try {
				window.sidebar.addPanel(sTitle, sURL, "");
			} catch (e) {
				alert("加入收藏失败，请使用Ctrl+D进行添加");
			}
		}
	}
	//生成快捷方式
	function toDesktop(sUrl, sName) {
		try {
			var WshShell = new ActiveXObject("WScript.Shell");
			var oUrlLink = WshShell.CreateShortcut(WshShell.SpecialFolders("Desktop") + "\\" + sName + ".url");
				oUrlLink.TargetPath = sUrl;
				oUrlLink.Save();
		} catch (e) {
			alert("当前IE安全级别不允许操作！");
		}
	}
	<!--微信扫码登录-->
	//给所有J_hoverbut的元素增加hover样式
	$(".J_hoverbut").hover(function(){
			$(this).addClass("hover");
		},function(){
			$(this).removeClass("hover");
		}
	);
	
	//会员登录手机登录和二维码的路切换
	$(".J_mob,.J_qr_code").click( function () {
		$(".j_mob_show").toggle();
		$(".J_qr_code_show").toggle();
	});
	$('.J_mob,#J_weixinQrCode').click(function(){
		get_weixin_qrcode();
	});
	var qrcode_time,
	waiting_weixin_scan = function(){
		$.getJSON(qscms.root + '?m=Home&c=Members&a=waiting_weixin_login',function(result){
			if(result.status == 1){
				window.location.href = result.data;
			}
		});
	},
	
	get_weixin_qrcode = function(){
		clearInterval(qrcode_time);
		$.getJSON(qscms.root + '?m=Home&c=Qrcode&a=get_weixin_qrcode',{type:'login'},function(result){
			if(result.status == 1){
				$('#J_weixinQrCode').empty().append(result.data);
				qrcode_time=setInterval(waiting_weixin_scan,5000);
			}else{
				$('#J_weixinQrCode').empty().html(result.msg);
			}
		});
	};
	//个人注册方式选项卡切换
	$(".regtab .tabli").click( function () {
		$(this).addClass("select").siblings(".tabli").removeClass("select");
		var index = $(".regtab .tabli").index(this);
		$('.tabshow').eq(index).show().siblings(".tabshow").hide();
		$('.tabshow').eq(index).find('input').eq(0).focus().addClass('input_focus');
	});
	//给符合条件的的文本框增加获取焦点的边框和背景变化	
	$(".J_focus input[type='text'][dir!='no_focus'],.J_focus textarea[dir!='no_focus'],.J_focus input[type='password']").focus(function(){
	$(this).addClass("input_focus")
	});
	$(".J_focus input[type='text'][dir!='no_focus'],.J_focus textarea[dir!='no_focus'],.J_focus input[type='password']").blur(function(){
	$(this).removeClass("input_focus")	
	});
</script>
</body>
</html>