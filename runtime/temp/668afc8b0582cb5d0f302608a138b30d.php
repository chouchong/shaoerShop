<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:39:"template/admin\b2c\Auth\userDetail.html";i:1495420006;s:28:"template/admin\b2c\base.html";i:1495424696;s:34:"template/admin\b2c\openDialog.html";i:1495424452;}*/ ?>
<!DOCTYPE html>
<html>
	<head>
	<?php if($frist_menu['module_name']=='首页'): ?>
	<title><?php echo $title_name; ?> - 商家管理</title>
	<?php else: ?>
		<title><?php echo $title_name; ?> - <?php echo $frist_menu['module_name']; ?>管理</title>
	<?php endif; ?>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="baidu-site-verification" content="phGGG7jWOJ" />
		<link rel="shortcut  icon" type="image/x-icon" href="ADMIN_IMG/admin_icon.ico" media="screen"/>
		<link rel="stylesheet" type="text/css" href="__STATIC__/bootstrap/css/bootstrap.css">
<!-- 		<link rel="stylesheet" type="text/css" href="__STATIC__/bootstrap/css/bootstrapSwitch.css"> -->
		<link rel="stylesheet" type="text/css" href="__STATIC__/bootstrap/css/bootstrap-responsive.css">
		<link rel="stylesheet" type="text/css" href="__STATIC__/css/common.css">
		<link rel="stylesheet" type="text/css" href="__STATIC__/css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="__STATIC__/css/seller_center.css">
		<link rel="stylesheet" type="text/css" href="__STATIC__/simple-switch/css/simple.switch.three.css">
		<script src="__STATIC__/js/jquery-1.8.1.min.js"></script>
		<script src="__STATIC__/bootstrap/js/bootstrap.js"></script>
<!-- 		<script src="__STATIC__/bootstrap/js/bootstrapSwitch.js"></script> -->
		<script src="__STATIC__/simple-switch/js/simple.switch.min.js"></script>
		<script src="__STATIC__/js/jquery.unobtrusive-ajax.min.js"></script>
		<script src="__STATIC__/js/common.js"></script>
		<script src="__STATIC__/js/seller.js"></script>
		<script>
			var PLATFORM_NAME="<?php echo $title_name; ?>";
			var ADMINIMG = "ADMIN_IMG";
			var ADMINMAIN = "ADMIN_MAIN";
			var UPLOAD = "__UPLOAD__";
		</script>
		<!-- <script src="__STATIC__/js/highcharts.js"></script> -->
		
<style>
.set-style dl dd{
	line-height: 32px;
}
</style>

	</head>
<body>
<style>
.wrapper{width:1268px;}
</style>
	<header class="ncsc-head-layout">
		<div class="wrapper">
			<div class="ncsc-admin">
<!-- 				<div class="ncsc-admin-info dropdown-toggle" data-toggle="dropdown"> -->
					<div class="ncsc-admin-headimg">
					<?php if($user_headimg != ''): ?>
						<img src="__ROOT__/<?php echo $user_headimg; ?>"/>
					<?php else: ?>
						<img src="__STATIC__/images/default_user_portrait.gif"/>
					<?php endif; ?>
					</div>
					<span class="user-name"><?php echo $username; ?></span>
					<a class="ncsc-admin-a ncsc-admin-info" data-toggle="dropdown"><i class="ncsc-admin-i ncsc-admin-down"></i></a>
					<a class="ncsc-admin-a h40"><i class="ncsc-admin-line"></i></a>
					<a class="ncsc-admin-a" href="SHOP_MAIN/Index/index" target="_blank" title="新窗口打开商城前台首页"><i class="ncsc-admin-i ncsc-admin-home"></i></a>
					<a class="ncsc-admin-a" href="ADMIN_MAIN/Login/logout.html" title="安全退出管理中心"><i class="ncsc-admin-i ncsc-admin-off"></i></a>
<!-- 						<img src="__STATIC__/images/topright_list.png"/> -->
<!-- 				</div> -->
				<div class="user-operation dropdown-menu">
<!-- 					<a href="ADMIN_MAIN" title="首页"> -->
<!-- 						<i class="fa fa-home"></i>首页 -->
<!-- 					</a>  -->
<!-- 					<a href="ADMIN_MAIN/Auth/userDetail.html" title="个人资料"> -->
<!-- 						<i class="fa fa-user"></i>个人资料 -->
<!-- 					</a>  -->
					<a href="javascript:;" title="修改密码" onclick="editpassword()">
						<i class="fa fa-wrench"></i>修改密码
					</a>
<!-- 					<a href="ADMIN_MAIN/Login/logout.html" title="安全退出"> -->
<!-- 						<i class="fa fa-sign-out"></i>安全退出 -->
<!-- 					</a> -->
				</div>
			</div>
			<div class="center-logo">
				<a href="ADMIN_MAIN"><img src="ADMIN_IMG/shop_logo.png"/></a>
<!-- 				<h1><a href="#" title="<?php echo $title_name; ?>"><span>NIU</span>SHOP&nbsp;<span>电商系统</span></a></h1> -->
			</div>
			<div class="index-search-container" style="position: relative;">
				<div class="index-sitemap" onclick="nav_open(this)">
					<a href="javascript:void(0);">导航管理<i class="icon-angle-down"></i></a>
					<div class="sitemap-menu" style="display: none; z-index: 1000;">
						<div class="title-bar" onclick="nav_close()">
							<h2>
								<i class="icon-sitemap"></i>管理导航<em></em>
							</h2>
							<span id="closeSitemap" class="close">X</span>
						</div>
						<div id="quicklink_list" class="content">
							<?php if(is_array($nav_list) || $nav_list instanceof \think\Collection || $nav_list instanceof \think\Paginator): if( count($nav_list)==0 ) : echo "" ;else: foreach($nav_list as $key=>$nav): ?>
							<dl>
								<dt><?php echo $nav['data']['module_name']; ?></dt>
								<?php if(is_array($nav['sub_menu']) || $nav['sub_menu'] instanceof \think\Collection || $nav['sub_menu'] instanceof \think\Paginator): if( count($nav['sub_menu'])==0 ) : echo "" ;else: foreach($nav['sub_menu'] as $key=>$nav_sub): ?>
								<dd>
									<a href="ADMIN_MAIN/<?php echo $nav_sub['url']; ?>"> <?php echo $nav_sub['module_name']; ?></a>
								</dd>
								<?php endforeach; endif; else: echo "" ;endif; ?>
							</dl>
							<?php endforeach; endif; else: echo "" ;endif; ?>
						</div>
					</div>
				</div>
				<div class="search-bar">
					<!-- <form method="get" target="_blank"> -->
						<input type="hidden" name="act" value="search"> 
						<input type="text" id="search_goods" name="keyword" placeholder="商品搜索" class="search-input-text" > 
						<input type="submit" class="search-input-btn pngFix" value="" onclick="search()">
					<!-- </form> -->
				</div>
			</div>
			<nav class="ncsc-nav">
				<?php if(is_array($headlist) || $headlist instanceof \think\Collection || $headlist instanceof \think\Paginator): if( count($headlist)==0 ) : echo "" ;else: foreach($headlist as $key=>$per): if(strtoupper($per['module_id']) == $headid): ?>
				<dl class="current_nav" onmouseover="add_nav_class(this)"
					onmouseout="remove_nav_class(this)">
					<dt>
						<a href="ADMIN_MAIN/<?php echo $per['url']; ?>"><?php echo $per['module_name']; ?></a>
					</dt>
					<dd class="arrow"></dd>
				</dl>
				<?php else: ?>
				<dl onmouseover="add_nav_class(this)" onmouseout="remove_nav_class(this)">
					<dt>
						<a href="ADMIN_MAIN/<?php echo $per['url']; ?>"><?php echo $per['module_name']; ?></a>
					</dt>
				</dl>
				<?php endif; endforeach; endif; else: echo "" ;endif; ?>
			</nav>
		</div>
	</header>
	<!-- 	左边菜单的加载 -->
	<div class="MAIN">
		
		<div class="LEFT">
			<div id="accordion2" class="accordion leftmenu">
				<div class="accordion-group">
					<div class="sidebarX">
						<?php if($frist_menu['module_picture'] != ''): ?>
						<img src="__UPLOAD__/<?php echo $frist_menu['module_picture']; ?>">
						<?php else: ?>
						<img src="__STATIC__/images/admin_left_logo.png">
						<?php endif; ?>
						<h2><?php echo $frist_menu['module_name']; ?></h2>
					</div>
					<div class="accordion-body collapse in" id="collapseOne">
						<ul class="nav nav-pills nav-stacked" id="left_menu-small">
							<?php if(is_array($leftlist) || $leftlist instanceof \think\Collection || $leftlist instanceof \think\Paginator): if( count($leftlist)==0 ) : echo "" ;else: foreach($leftlist as $key=>$leftItem): if(strtoupper($leftItem['module_id']) == $second_menu_id): ?>
							<li class="active"><h1></h1><a href="ADMIN_MAIN/<?php echo $leftItem['url']; ?>"><?php echo $leftItem['module_name']; ?></a></li>
							<?php else: ?>
							<li><a href="ADMIN_MAIN/<?php echo $leftItem['url']; ?>"><?php echo $leftItem['module_name']; ?></a></li>
							<?php endif; endforeach; endif; else: echo "" ;endif; ?>
						</ul>
					</div>
				</div>
			</div>
		</div>
		
		<!-- 	右边主要内容的加载 -->
		<div class="RIGHT">
			<div class="ncsc-path">
				<i class="icon-desktop"></i><?php echo $title_name; if($frist_menu['module_name'] != ''): ?>
				<i class="icon-angle-right"></i>
				<a href="ADMIN_MAIN/<?php echo $frist_menu['url']; ?>"><?php echo $frist_menu['module_name']; ?></a>
				<?php endif; if($secend_menu['module_name'] != ''): ?>
				<i class="icon-angle-right"></i>
				<a href="ADMIN_MAIN/<?php echo $secend_menu['url']; ?>"><?php echo $secend_menu['module_name']; ?></a>
				<?php endif; ?>
			</div>
			<!--顶部边框开始  -->
			<div class="tabmenu">
				<ul class="tab pngFix">
					<?php if(is_array($child_menu_list) || $child_menu_list instanceof \think\Collection || $child_menu_list instanceof \think\Paginator): if( count($child_menu_list)==0 ) : echo "" ;else: foreach($child_menu_list as $k=>$child_menu): if($child_menu['active'] == '1'): ?>
					<li class="active"><a href="ADMIN_MAIN/<?php echo $child_menu['url']; ?>"><?php echo $child_menu['menu_name']; ?></a></li>
					<?php else: ?>
					<li class="daohang_no"><a href="ADMIN_MAIN/<?php echo $child_menu['url']; ?>"><?php echo $child_menu['menu_name']; ?></a></li>
					<?php endif; endforeach; endif; else: echo "" ;endif; ?>
				</ul>
				<div class="right_side_operation">
					<ul>
						
						<li><a class="nscs-table-handle_green" href="ADMIN_MAIN/Auth/addUser" style="display: none;">右侧按钮测试</a></li>
						
					</ul>
				</div>
			</div>
			<hr class="tabmenu_hr" style="border:1px solid #00C0FF;margin:0 0px 10px 20px;"  />
			<div class="main">
			
<div class="set-style">
	<dl>
		<dt>用户名:</dt>
		<dd>
			<span class="user_name_span"><?php echo $info['user_name']; ?> &nbsp;&nbsp;&nbsp;<a href="javascript:;" onclick="updateUserName()">修改</a></span>
			<span class="user_name_input" style="display:none;">
				<input name="" id="user_name" type="text" value="<?php echo $info['user_name']; ?>"/>
				&nbsp;&nbsp;&nbsp;<a href="javascript:;" onclick="updateUserNameConfirm()">确定</a>
				&nbsp;&nbsp;&nbsp;<a href="javascript:;" onclick="updateUserNameCancel()">取消</a>
			</span>
		</dd>
	</dl>
	<dl>
		<dt>头像:</dt>
		<dd>
			<div class="class-logo"><p><img id="imgLogo"src="__UPLOAD__/<?php echo $info['user_headimg']; ?>" ></p></div>
			<div class="ncsc-upload-btn"> 
				<a href="javascript:void(0);">
					<span>
						<input hidefocus="true" size="1" class="input-file" name="file_upload" id="uploadImg" nc_type="change_store_label" type="file" onchange="imgUpload()">
						<input type="hidden" id="Logo" value="<?php echo $info['user_headimg']; ?>"/>
					</span>
					<p><!-- <i class="icon-upload-alt"></i> -->上传图片</p>
				</a> 
			</div>
			<p class="hint"><br><span style="color:orange;">建议使用宽100像素-高100像素内的GIF或PNG透明图片；点击下方"提交"按钮后生效。</span></p>
		</dd>
	</dl>
	<dl>
		<dt>手机:</dt>
		<dd>
			<span class="user_tel_span"><?php echo $info['user_tel']; ?> &nbsp;&nbsp;
				<a href="javascript:;" onclick="updateUserTel()" style='<?php if($info['user_tel_bind'] == 1): ?>display:none;<?php endif; ?>'>修改</a>&nbsp;&nbsp;
				<a class="user_tel_bind" href="javascript:;" onclick="userTelBind()" style='<?php if($info['user_tel_bind'] == 1): ?>display:none;<?php endif; ?>'>绑定</a>
				<a class="remove_user_tel_bind" href="javascript:;" onclick="removeUserTelBind()" style='<?php if($info['user_tel_bind'] == 0): ?>display:none;<?php endif; ?>'>解绑</a>
			</span>
			<span class="user_tel_input" style="display:none;">
				<input name="" id="user_tel" type="text" value="<?php echo $info['user_tel']; ?>"/>
				&nbsp;&nbsp;&nbsp;<a href="javascript:;" onclick="updateUserTelConfirm()">确定</a>
				&nbsp;&nbsp;&nbsp;<a href="javascript:;" onclick="updateUserTelCancel()">取消</a>
			</span>
		</dd>
	</dl>
	<dl>
		<dt>邮箱:</dt>
		<dd>
			<span class="user_email_span"><?php echo $info['user_email']; ?> &nbsp;&nbsp;
				<a href="javascript:;" onclick="updateUserEmail()" style='<?php if($info['user_email_bind'] == 1): ?>display:none;<?php endif; ?>'>修改</a>&nbsp;&nbsp;
				<a class="user_email_bind" href="javascript:;" onclick="userEmailBind()" style='<?php if($info['user_email_bind'] == 1): ?>display:none;<?php endif; ?>'>绑定</a>
				<a class="remove_user_email_bind" href="javascript:;" onclick="removeUserEmailBind()" style='<?php if($info['user_email_bind'] == 0): ?>display:none;<?php endif; ?>'>解绑</a>
			</span>
			<span class="user_email_input" style="display:none;">
				<input name="" id="user_email" type="text" value="<?php echo $info['user_email']; ?>"/>
				&nbsp;&nbsp;&nbsp;<a href="javascript:;" onclick="updateUserEmailConfirm()">确定</a>
				&nbsp;&nbsp;&nbsp;<a href="javascript:;" onclick="updateUserEmailCancel()">取消</a>
			</span>
		</dd>
	</dl>
	<dl>
		<dt>QQ:</dt>
		<dd>
			<input id="user_qq" type="text" value="<?php echo $info['user_qq']; ?>" style="width:200px;"/>
		</dd>
	</dl>
	<dl>
		<dt>社交账号:</dt>
		<dd>
<!-- 			<a class="" href="javascript:;"><i class="fa fa-weixin"></i> 绑定微信</a>&nbsp;&nbsp;&nbsp; -->
<!-- 			<a class="" href="javascript:;"><i class="fa fa-weibo"></i> 绑定微博</a>&nbsp;&nbsp;&nbsp; -->
			<span class="user_qq_a" style='<?php if(!(empty($info['qq_openid']) || (($info['qq_openid'] instanceof \think\Collection || $info['qq_openid'] instanceof \think\Paginator ) && $info['qq_openid']->isEmpty()))): ?>display:none;<?php endif; ?>'><a class="" href="APP_MAIN/login/oauthlogin?type=QQLOGIN"><i class="fa fa-qq"></i> 绑定qq</a></span>
			<span class="user_qq_span" style='<?php if(empty($info['qq_openid']) || (($info['qq_openid'] instanceof \think\Collection || $info['qq_openid'] instanceof \think\Paginator ) && $info['qq_openid']->isEmpty())): ?>display:none;<?php endif; ?>'>
				<?php if(!(empty($info['qq_openid']) || (($info['qq_openid'] instanceof \think\Collection || $info['qq_openid'] instanceof \think\Paginator ) && $info['qq_openid']->isEmpty()))): ?>
				<img alt="" src="<?php echo $info['qq_info_array']['figureurl_qq_1']; ?>">
				<?php endif; ?>
				<a class="" href="javascript:removeUserQQBind();"> 解绑</a></span>
		</dd>
	</dl>
	<button class="edit_button" onclick="setUserBasicAjax();">提交</button>
</div>
<script src="ADMIN_JS/ajax_file_upload.js" type="text/javascript"></script>
<script src="__STATIC__/js/file_upload.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css"
	href="ADMIN_CSS/jquery-ui-private.css">
<script>
var platform_shopname= 'NIUSHOP';
</script>
<script type="text/javascript" src="ADMIN_JS/jquery-ui-private.js" charset="utf-8"></script>
<script type="text/javascript" src="ADMIN_JS/jquery.timers.js"></script>
<div id="dialog"></div>
<script type="text/javascript">
		function showMessage(type, message,url,time)
		{
			if(url == undefined){
				url = '';
			}
			if(time == undefined){
				time = 2;
			}
			//成功之后的跳转
			if(type == 'success')
				{
				$( "#dialog" ).dialog({
		            buttons: {
		                "确定,#51A351": function() {
		                    $(this).dialog('close');
		                }
		            },
		            contentText:message,
		      		time:time,
		      		timeHref: url,
		        });
				}
			//失败之后的跳转
			if(type == 'error')
				{
				$( "#dialog" ).dialog({
		            buttons: {
		                "确定,#e57373": function() {
		                    $(this).dialog('close');
		                }
		            },
		            time:time,
		            contentText:message,
		            timeHref: url,
		        });
				}
			
		}
		function showConfirm(content)
		{
			$( "#dialog" ).dialog({
	            buttons: {
	                "确定,#e57373": function() {
	                    $(this).dialog('close');
	                    return 1;
	                },
	                "取消": function() {
	                    $(this).dialog('close');
	                    return 0;
	                }
	            },
	            contentText:content,
			});
			
		}
	</script>
<script>
function setUserBasicAjax(){
	var user_headimg = $("#Logo").val();
	var user_qq = $("#user_qq").val();
	$.ajax({
		type:"post",
		url:"ADMIN_MAIN/Auth/userDetail",
		data:{
			'user_headimg':user_headimg,
			'user_qq':user_qq,
		},
		async:true,
		success:function (data) {
			if (data["code"] > 0) {
				showMessage('success', data["message"],'ADMIN_MAIN/Auth/userDetail?type=basic');
			}else{
				showMessage('error', data["message"]);
			}
		}
	});
}
/**
 * 显示 修改邮箱
 */
function updateUserEmail(){
	$(".user_email_span").hide();
	$(".user_email_input").show();
}
//取消
function updateUserEmailCancel(){
	$(".user_email_span").show();
	$(".user_email_input").hide();
}
/**
 * 修改 用户 邮箱
 */
function updateUserEmailConfirm(){
	var user_email = $("#user_email").val();
	$.ajax({
		type:"post",
		url:"ADMIN_MAIN/Auth/modifyUserEmail",
		data:{'user_email':user_email},
		async:true,
		success:function (data) {
			if (data["code"] > 0) {
				showMessage('success', data["message"],'ADMIN_MAIN/Auth/userDetail');
			}else{
				showMessage('error', data["message"]);
			}	
		}
	});
}
/**
 * 解除 会员邮箱绑定
 */
function removeUserEmailBind(){
	$.ajax({
		type:"post",
		url:"ADMIN_MAIN/Auth/removeUserEmailBind",
		async:true,
		success:function (data) {
			if (data["code"] > 0) {
				showMessage('success', data["message"],'ADMIN_MAIN/Auth/userDetail');
			}else{
				showMessage('error', data["message"]);
			}	
		}
	});
}
/**
 * 会员邮箱 绑定
 */
function userEmailBind(){
	$.ajax({
		type:"post",
		url:"ADMIN_MAIN/Auth/userEmailBind",
		async:true,
		success:function (data) {
			if (data["code"] > 0) {
				showMessage('success', data["message"],'ADMIN_MAIN/Auth/userDetail');
			}else{
				showMessage('error', data["message"]);
			}	
		}
	});
}


/**
 * 显示手机号
 */
function updateUserTel(){
	$(".user_tel_span").hide();
	$(".user_tel_input").show();
}
//取消
function updateUserTelCancel(){
	$(".user_tel_span").show();
	$(".user_tel_input").hide();
}
/**
 * 修改 用户手机号
 */
function updateUserTelConfirm(){
	var user_tel = $("#user_tel").val();
	$.ajax({
		type:"post",
		url:"ADMIN_MAIN/Auth/modifyUserTel",
		data:{'user_tel':user_tel},
		async:true,
		success:function (data) {
			if (data["code"] > 0) {
				showMessage('success', data["message"],'ADMIN_MAIN/Auth/userDetail');
			}else{
				showMessage('error', data["message"]);
			}	
		}
	});
}
/**
 * 解除 会员手机绑定
 */
function removeUserTelBind(){
	$.ajax({
		type:"post",
		url:"ADMIN_MAIN/Auth/removeUserTelBind",
		async:true,
		success:function (data) {
			if (data["code"] > 0) {
				showMessage('success', data["message"],'ADMIN_MAIN/Auth/userDetail');
			}else{
				showMessage('error', data["message"]);
			}	
		}
	});
}
/**
 * 会员手机绑定
 */
function userTelBind(){
	$.ajax({
		type:"post",
		url:"ADMIN_MAIN/Auth/userTelBind",
		async:true,
		success:function (data) {
			if (data["code"] > 0) {
				showMessage('success', data["message"],'ADMIN_MAIN/Auth/userDetail');
			}else{
				showMessage('error', data["message"]);
			}	
		}
	});
}
/**
 * 解除 用户 qq 绑定
 */
function removeUserQQBind(){
	$( "#dialog" ).dialog({
		buttons: {
			"确定,#e57373": function() {
			$(this).dialog('close');
			$.ajax({
				type:"post",
				url:"ADMIN_MAIN/Auth/removeUserQQBind",
				async:true,
				success:function (data) {
					if (data["code"] > 0) {
						showMessage('success', data["message"],'ADMIN_MAIN/Auth/userDetail');
					}else{
						showMessage('error', data["message"]);
					}
				}
			});
		},
		"取消": function() {
			$(this).dialog('close');
		}
	},
	contentText:"确定解除绑定吗？"
	});
}
	/**
	*图片上传
	*/
	function imgUpload() {
		var fileid = "uploadImg";
		fileCommonUpload("UPLOAD_URL",fileid,"__UPLOAD__");	
	
	}
	/**
	 * 修改会员用户名显示
	 */
	function updateUserName(){
		$(".user_name_span").hide();
		$(".user_name_input").show();
	}
	/**
	 * 修改用户名提交
	 */
	function updateUserNameConfirm(){
		var user_name = $("#user_name").val();
		$.ajax({
			type:"post",
			url:"ADMIN_MAIN/Auth/modifyUserName",
			data:{
				'user_name':user_name,
			},
			async:true,
			success:function (data) {
				if (data["code"] > 0) {
					showMessage('success', data["message"],'ADMIN_MAIN/Auth/userDetail');
				}else{
					showMessage('error', data["message"]);
				}	
			}
		});
	}
	/**
	 * 修改用户名取消
	 */
	function updateUserNameCancel(){
		$(".user_name_span").show();
		$(".user_name_input").hide();
	}
</script>

			</div>
			<div class="page" id="turn-ul" style="display: none;">
				<div class="pagination pagination-right">
					<ul>
						<li><a id="beginPage" class="page-disable">首页</a></li>
						<li><a id="prevPage" class="page-disable">上一页</a></li>
						<li id="pageNumber"></li>
						<li><a id="nextPage">下一页</a></li>
						<li><a id="lastPage">末页</a></li>
					</ul>
				</div>
			</div>
			<input type="hidden" id="page_count" />
		</div>
	</div>
	<!--修改密码弹出框 -->
	<div id="edit-password" class="modal hide" tabindex="-1" role="dialog"
		aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel">修改密码</h3>
		</div>
		<div class="modal-body">
			<form class="form-horizontal">
				<div class="control-group">
					<label class="control-label" for="inputPassword"><span class="color-red">*</span>原密码</label>
					<div class="controls">
						<input type="password" id="pwd0" placeholder="请输入原密码">
						<span class="help-block"></span>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputPassword"><span class="color-red">*</span>新密码</label>
					<div class="controls">
						<input type="password" id="pwd1" placeholder="请输入新密码">
						<span class="help-block"></span>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputPassword"><span class="color-red">*</span>再次输入密码</label>
					<div class="controls">
						<input type="password" id="pwd2" placeholder="请输入确认密码">
						<span class="help-block"></span>
					</div>
				</div>
				<div style="text-align: center; height: 20px;" id="show"></div>
			</form>
		</div>
		<div class="modal-footer">
			<button class="btn btn-info" onclick="submitPassword()"  style="display:inline-block;">保存</button>
			<button class="btn" data-dismiss="modal" aria-hidden="true">关闭</button>
		</div>
	</div>
	<!--修改密码弹框结束  -->
	<div class="footer">
		<div id="faq" style="background: #eee; padding-top: 10px;">
			<div class="faq-wrapper"></div>
		</div>
		<div id="footer" class="wrapper">
			<p>
				<?php if(is_array($ShopNavigationData) || $ShopNavigationData instanceof \think\Collection || $ShopNavigationData instanceof \think\Paginator): if( count($ShopNavigationData)==0 ) : echo "" ;else: foreach($ShopNavigationData as $key=>$vo): if($key>0): ?> |<?php endif; ?> <a href="<?php echo $vo['nav_url']; ?>"><?php echo $vo['nav_title']; ?></a> 
				<?php endforeach; endif; else: echo "" ;endif; ?>
			</p>
			Copyright 2015-2025 <a href="" target="_blank"><?php echo $title_name; ?></a> All rights
			reserved.<br>
		</div>
	</div>
	<script>
	$(".checkbox").simpleSwitch({
		"theme": "FlatCircular"
	});
</script>
	<script>
		$(function() {
			//设置最小高度  2016年8月1日17:57:09
			var height = Number($(window).height()) - 173;
			$('.MAIN').css('minHeight', height);
			$('.index-sitemap > a').bind("click", function() {
				$(".sitemap-menu-arrow").slideDown("slow");
				$(".sitemap-menu").slideDown("slow");
			});
			$('.add-quickmenu > a').bind("click", function() {
				$(".sitemap-menu-arrow").slideDown("slow");
				$(".sitemap-menu").slideDown("slow");
			});
			$('#closeSitemap').bind("click", function() {
				$(".sitemap-menu-arrow").slideUp("fast");
				$(".sitemap-menu").slideUp("fast");
			});
		})
		// 系统注销菜单的控制
		var closetimer = 0;
		function exitSystemOver() {
			cancelColseMenu();
			$("#exit_System").css("display", "block");
		};

		function exitSystemOut() {
			closetimer = window.setTimeout(mclose, 600);
		};

		function cancelColseMenu() {
			window.clearTimeout(closetimer);
			closetimer = null;
		};

		function mclose() {
			$("#exit_System").css("display", "none");
		}
		$(document).ready(function() {
			//获取页面完整地址
			var url = window.location.host;
			if (url.indexOf('autoscript') != -1) {
				$("#hm_a").remove();
			}
		});
		//弹出修改密码的弹窗
		function editpassword() {
			$('#edit-password').modal('show');
		}
		//保存修改密码的按钮
		function submitPassword() {
			var pwd0 = $("#pwd0").val();
			var pwd1 = $("#pwd1").val();
			var pwd2 = $("#pwd2").val();
			if (pwd1 == '') {
				$("#pwd1").focus();
				$("#pwd1").siblings("span").html("密码不能为空");
				return;
			} else if ($("#pwd1").val().length < 6) {
				$("#pwd1").focus();
				$("#pwd1").siblings("span").html("密码不能少于6位数");
				return;
			}
			if (pwd2 == '') {
				$("#pwd2").focus();
				$("#pwd2").siblings("span").html("密码不能为空");
				return;
			} else if ($("#pwd2").val().length < 6) {
				$("#pwd2").focus();
				$("#pwd2").siblings("span").html("密码不能少于6位数");
				return;
			}
			if (pwd1 != pwd2) {
				$("#pwd2").focus();
				$("#pwd2").siblings("span").html("两次密码输入不一样，请重新输入");
				return;
			}
			$.ajax({
				url : "ADMIN_MAIN/Login/ModifyPassword",
				type : "post",
				data : {
					"old_pass" : $("#pwd0").val(),
					"new_pass" : $("#pwd1").val()
				},
				dataType : "json",
				success : function(data) {
					if (data['code'] > 0) {
						$("#show").html('<span style="color:green">密码修改成功</span>');
					} else {
						$("#show").html('<span style="color:red">'+data['message']+'</span>');
					}
				}
			});
		}

		function add_nav_class(doc) {
			$(doc).addClass("hover");
		}
		function remove_nav_class(doc) {
			$(doc).removeClass("hover");
		}
		function nav_open() {
			$(".sitemap-menu-arrow").show();
			$(".sitemap-menu").show();
		}
		function nav_close() {
			$(".sitemap-menu-arrow").hide();
			$(".sitemap-menu").hide();
		}
		//查询
		function search(){
			var search_info = $("#search_goods").val();
			window.location.href="ADMIN_MAIN/Goods/goodsList.html?search_info="+search_info;
		}
	</script>
	
</body>
</html>