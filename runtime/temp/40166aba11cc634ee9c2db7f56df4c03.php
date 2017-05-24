<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:50:"template/admin\b2c\Wchat\weixinQrcodeTemplate.html";i:1495106538;s:28:"template/admin\b2c\base.html";i:1495424696;s:34:"template/admin\b2c\openDialog.html";i:1495424452;}*/ ?>
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
		
<style type="text/css">
.dislog-style {
	width: 80%;
	margin: 40px auto;
}

.modal.fade {
	top: 50%;
}

.dislog-style ul {
	width: 100%;
}

.dislog-style ul li span {
	display: inline-block;
	width: 60px;
	text-align: center;
	height: 40px;
	line-height: 31px;
}

.dislog-style ul li input {
	width: 200px;
}
#albumList{
	/* border-top:1px solid #E3E3E3; */
}

.input-file{
	position: absolute;
	top: -10px !important;
	right: 9px !important;
	height: 26px !important;
	width: 94px !important;
	filter: alpha(opacity : 0) !important; 
	opacity: 0 !important;
	line-height:auto;
}
.qrcode_button{
	background-color:#51a351;
	border:none;
	margin-top:15px;
	width:100%;
	color:#FFF;
	padding: 5px 10px;
}
.check{
	position: absolute;
	/* bottom: 45px; */
	bottom:0px;
	width: 188px;
	height: 330px;
	right: -1px;
	background-color: rgba(0,0,0,0.8);
	display:none;
}
.check div{
	width:60%;
	height:30px;
	margin-left:20%;
	border:1px solid #fff;
	margin-top:10%;
	text-align:center;
	/* background:#00C1FF; */
}
.check div:hover{
	background: #00C1FF;
	border:1px solid #00C1FF;
}
.check div span{
	font-size:15px;
	color:#fff;
	line-height:30px;
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
						
<li onclick="load_url();" ><a class="nscs-table-handle_green"><i class="fa fa-plus-circle"></i>&nbsp;添加自定义模板</a></li>


					</ul>
				</div>
			</div>
			<hr class="tabmenu_hr" style="border:1px solid #00C0FF;margin:0 0px 10px 20px;"  />
			<div class="main">
			

<div id="pictureIndex" class="ncsc-picture-folder">
	<div class="ncsc-album">
		<ul id="albumList" >
		<!-- <li  style="opacity: 1;width:19%;margin-right:7.5%;margin-top:10px;margin-bottom:10px;padding-bottom:45px;" onclick="load_url();">
			<div style="height:328.23px;background-color:#666;">
				<div style="height:150px;"></div>
				<img src="ADMIN_IMG/qrcode/qrcode_add.png" style="display:block;margin:0 auto 10px;"/> 
				<div style="text-align:center;color:#FFF;font-size:14px;"><span>自定义模板</span></div>
			
			</div>
			

		</li> -->
		<?php if(is_array($template_list) || $template_list instanceof \think\Collection || $template_list instanceof \think\Paginator): if( count($template_list)==0 ) : echo "" ;else: foreach($template_list as $key=>$info): if(($key+2)%4 ==0): ?> 
				<li  style="opacity: 1;height:auto;position:relative;width:19%;margin-right:1%;margin-top:10px;margin-bottom:10px;"  onmouseover="checkShowThis(this);"  onmouseout="checkHideThis(this);" >			
			<?php else: ?> 
				<li  style="opacity: 1;height:auto;position:relative;width:19%;margin-right:1%;margin-top:10px;margin-bottom:10px;" onmouseover="checkShowThis(this);"  onmouseout="checkHideThis(this);" >
			<?php endif; ?>
			<!-- <img src="__UPLOAD__/<?php echo $info['template_url']; ?>" onclick="checkShowThis(this);"/> --> 
			<?php if($info['is_check'] == 1): ?> 
				<!-- <p style="color: #000;">/NiuFrameWork/<?php echo $info['template_url']; ?></p> -->
					<?php if(file_exists("$info[template_url]")): ?>
					<img src="__UPLOAD__/<?php echo $info['template_url']; ?>" style="border:1px solid #00C0FF;"/>
					<?php endif; else: if(file_exists("$info[template_url]")): ?>
					<img src="__UPLOAD__/<?php echo $info['template_url']; ?>" style="border:1px solid #eee;"/>
					<?php endif; endif; ?>	
			<div class="check" >
			<?php if($info['is_check'] == 1): ?> 
			<div style="margin-top:60%;cursor:pointer;" onclick="deleteWeixinQrcodeTemplateValid(<?php echo $info['id']; ?>)">
					<span>删除</span>
				</div>
				<div onclick="modifyWeixinQrcode(<?php echo $info['id']; ?>)" style="cursor:pointer;">
					<span>编辑</span>
				</div>
				<?php else: ?> 
				<div style="margin-top:50%;cursor:pointer;" onclick="modifyWeixinQrcodeTemplateValid(<?php echo $info['id']; ?>)">
					<span >设为默认</span>
				</div>
				<div onclick="deleteWeixinQrcodeTemplateValid(<?php echo $info['id']; ?>)" style="cursor:pointer;">
					<span>删除</span>
				</div>
				<div onclick="modifyWeixinQrcode(<?php echo $info['id']; ?>)" style="cursor:pointer;">
					<span>编辑</span>
				</div>
				<?php endif; ?>	
				
			</div>
			<div>
				<?php if($info['is_check'] == 1): ?> 
					<img src="PLATFORM_IMG/qrcode/check_qrcode1.png"class="qrcode_img" style="position:absolute;top:0px;right:0px;"/>
				<?php else: ?> 
					<img src="PLATFORM_IMG/qrcode/check_qrcode1.png" class="qrcode_img"style="position:absolute;top:0px;right:0px;display:none;"/>
				<?php endif; ?>
			</div>
			
			<!--<div style="width:185px;height:328px;background:#181806;position:absolute;"></div> -->
			<input type="hidden" class="id"value="<?php echo $info['id']; ?>"/>
			<input type="hidden" class="background"value="<?php echo $info['background']; ?>"/>
			<input type="hidden" class="nick_font_color"value="<?php echo $info['nick_font_color']; ?>"/>
			<input type="hidden" class="nick_font_size"value="<?php echo $info['nick_font_size']; ?>"/>
			<input type="hidden" class="is_logo_show"value="<?php echo $info['is_logo_show']; ?>"/>
			<input type="hidden" class="header_left"value="<?php echo $info['header_left']; ?>"/>
			<input type="hidden" class="header_top"value="<?php echo $info['header_top']; ?>"/>
			<input type="hidden" class="name_left"value="<?php echo $info['name_left']; ?>"/>
			<input type="hidden" class="name_top"value="<?php echo $info['name_top']; ?>"/>
			<input type="hidden" class="logo_left"value="<?php echo $info['logo_left']; ?>"/>
			<input type="hidden" class="logo_top"value="<?php echo $info['logo_top']; ?>"/>
			<input type="hidden" class="code_left"value="<?php echo $info['code_left']; ?>"/>
			<input type="hidden" class="code_top"value="<?php echo $info['code_top']; ?>"/>
			<div>
				<?php if($info['is_check'] == 1): ?> 
					<img src="PLATFORM_IMG/qrcode/check_qrcode1.png"class="qrcode_img" style="position:absolute;top:0px;right:0px;"/>
				<?php else: ?> 
					<img src="PLATFORM_IMG/qrcode/check_qrcode1.png" class="qrcode_img"style="position:absolute;top:0px;right:0px;display:none;"/>
				<?php endif; ?>
			</div>
		    </li>
		<?php endforeach; endif; else: echo "" ;endif; ?>		
		</ul>
	</div>
</div>


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
<script type="text/javascript">
function checkShowThis(event){
	$(".qrcode_button").hide();
	$(".check").hide();
	$(event).find(".qrcode_button").show();
	$(event).find(".check").show();
}
function checkHideThis(event){
	$(event).find(".qrcode_button").hide();
	$(event).find(".check").hide();
}
/**
 * 上传配置
 */
function save(event){
	/* var id = $(event).parent().parent().children(".id").val(); */
	var background = $(event).parent().parent().children(".background").val();
	var nick_font_color = $(event).parent().parent().children(".nick_font_color").val();
	var nick_font_size = $(event).parent().parent().children(".nick_font_size").val();
	var is_logo_show = $(event).parent().parent().children(".is_logo_show").val();
	
	var header_left = $(event).parent().parent().children(".header_left").val();
	var header_top = $(event).parent().parent().children(".header_top").val();
	var name_left = $(event).parent().parent().children(".name_left").val();
	var name_top = $(event).parent().parent().children(".name_top").val();
	var logo_left =$(event).parent().parent().children(".logo_left").val();
	var logo_top = $(event).parent().parent().children(".logo_top").val();
	var code_left = $(event).parent().parent().children(".code_left").val();
	var code_top = $(event).parent().parent().children(".code_top").val();
	$.ajax({
		type : "post",
		url : "ADMIN_MAIN/Wchat/qrcode",
		data : {
			'background' : background,
			'nick_font_color' : nick_font_color,
			'nick_font_size' : nick_font_size,
			'is_logo_show' : is_logo_show,
			'header_left' : header_left,
			'header_top' : header_top,
			'name_left' : name_left,
			'name_top' : name_top,
			'logo_left' : logo_left,
			'logo_top' : logo_top,
			'code_left' : code_left,
			'code_top' : code_top
		},
		async : true,
		success : function(data) {
			 if(data['code'] > 0){
				 showMessage('success', data['message'], 'ADMIN_MAIN/Wchat/weixinQrcodeTemplate');
			 }else{
				 showMessage('error', data['message']);
			 }
		}
	})
	
}
/**
 * 设置店铺的模板为默认
 */
function modifyWeixinQrcodeTemplateValid(id){
	$.ajax({
		type : "post",
		url : "ADMIN_MAIN/Wchat/modifyWeixinQrcodeTemplateValid",
		data : {
			'id' : id
		},
		async : true,
		success : function(data) {
			location.reload();
			if(data['code'] > 0){
				 showMessage('success', data['message'], 'ADMIN_MAIN/Wchat/weixinQrcodeTemplate');				 
			 }else{
				 showMessage('error', data['message']);
			 } 
		}
	})
}

function deleteWeixinQrcodeTemplateValid(id){
	$.ajax({
		type : "post",
		url : "ADMIN_MAIN/Wchat/deleteWeixinQrcodeTemplateValid",
		data : {
			'id' : id
		},
		async : true,
		success : function(data) {
			if(data['code'] > 0){
				 showMessage('success', data['message'], 'ADMIN_MAIN/Wchat/weixinQrcodeTemplate');				 
			 }else{
				 showMessage('error', data['message']);
			 } 
		}
	})
}
function updateQrcodeCheck(id){
	
}

function load_url(){
	window.location.href="ADMIN_MAIN/Wchat/qrcode.html";
}

function modifyWeixinQrcode(id){
	window.location.href="ADMIN_MAIN/Wchat/qrcode.html?id="+id;
}
</script>


</body>
</html>