<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:39:"template/admin\b2c\Goods\goodsList.html";i:1495442045;s:28:"template/admin\b2c\base.html";i:1495424696;s:34:"template/admin\b2c\pageCommon.html";i:1492765125;s:34:"template/admin\b2c\openDialog.html";i:1495424452;}*/ ?>
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
		
<link rel="stylesheet" type="text/css" href="ADMIN_CSS/product.css">
<script type="text/javascript" src="__STATIC__/My97DatePicker/WdatePicker.js"></script>
<style type="text/css">
.tr-title {
	height: 30px;
	background: #E3E3E3;
	border:1px solid rgba(234, 233, 233, 0.51);
}

.fun-a {
	margin-top: 0px;
	padding: 6px 15px 0 15px;
}

.a-pro-view-img {
	float: left;
}

.thumbnail-img {
	width: 60px;
	margin-right: 10px;
}

.cell i {
	display: block;
}
.remodal-bg.with-red-theme.remodal-is-opening,.remodal-bg.with-red-theme.remodal-is-opened {
      filter: none;
}

.remodal-overlay.with-red-theme {
      background-color: #f44336;
}

.remodal.with-red-theme {
      background: #fff;
}

input[type="radio"], input[type="checkbox"] {
    margin: -1px 5px 0;
	margin-left:0px;
}
.edit-group{
	border-bottom: 1px solid #ebebeb;
	margin-bottom:10px;
}
.edit-group label{	
	font-weight:normal;
}
.edit-group-title{
	height:15px;
	line-height:15px;
	width:140px;
	margin-top:3px;
	margin-bottom:3px;
}
.edit-group-button{	   
    border-color: #3283fa;
	border: 1px solid #bbb;
	height: 26px;
    line-height: 24px;
    padding: 0 5px;
}
.group-button-bg{
	 background: #3283fa;
	 color: #fff;
}
.div-pro-view-name{width:75%;}
i.hot,i.recommend,i.new{font-size:12px;margin-right:10px;font-style:normal;color:#fff;background-color:#E84C3D;border-radius:2px;padding:1px 2px;}

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
						
<li><a class="nscs-table-handle_green" href="ADMIN_MAIN/Goods/addGoods.html"><i class="fa fa-plus-circle"></i>&nbsp;发布商品</a></li>

					</ul>
				</div>
			</div>
			<hr class="tabmenu_hr" style="border:1px solid #00C0FF;margin:0 0px 10px 20px;"  />
			<div class="main">
			
<table class="mytable">
	<tr>
		<th style="line-height:33px;">
			创建时间：
			<input type="text" id="startDate" class="input-medium" placeholder="请选择开始日期" onclick="WdatePicker()" />
			&nbsp;-&nbsp;
			<input type="text" id="endDate" placeholder="请选择结束日期" class="input-medium" onclick="WdatePicker()" />
			商品名：<input id="goods_name" class="input-small" type="text" value="<?php echo $search_info; ?>">
			上下架
			<select id="state">
				<option value="">全部</option>
				<option value="1">上架</option>
				<option value="0">下架</option>
				<option value="10">违规禁售</option>
			</select>	
			<input type="button" onclick="searchData()" value="搜索" />
		</th>
	</tr>
</table>
<div id="myTabContent" class="tab-content">
	<div class="tab-pane active">
		<table class="table table-striped table-main" border="0">
			<colgroup>
				<col width="3%">
				<col width="25%">
				<col width="12%">
				<col width="9%">
				<col width="8%">
				<col width="7%">
				<col width="7%">
				<col width="15%">
			</colgroup>
			<tbody>
				<tr class="table-title" style="background: white;z-index: 10;border: 1px solid #E3E3E3;">
					<th></th>
					<th>商品名称</th>
					<th>价格（元）</th>
					<th>总库存</th>
					<th>销量</th>
					<th>上下架</th>
					<th>排序</th>
					<th>操作</th>
				</tr>
				<tr class="trcss">
					<td colspan="5">
						<label style="display: inline-block;vertical-align: middle;">
							<input onclick="CheckAll(this)" id="ckall" type="checkbox">
							<span style="display: inline-block; margin-left: 0px; margin-right: 10px;font-weight: 400;">全选</span>
						</label>
						<a class="btn btn-small fun-a" href="javascript:void(0)" onclick="deleteGoodsCount()">删除</a>
						<a class="btn btn-small fun-a upstore" href="javascript:void(0)" onclick="goodsIdCount('online')">上架</a>
						<a class="btn btn-small fun-a downstore" href="javascript:void(0)" onclick="goodsIdCount('offline')">下架</a>
						<a class="btn btn-small fun-a recommend" href="javascript:void(0)"
						onclick="ShowRecommend()" data-html="true" id="setRecommend" title="<h6 class='edit-group-title'>推荐</h6>"
						data-container="body" data-placement="bottom"  data-trigger="manual"
						data-content="<div class='edit-group' id='recommendType'>
 							  <label class='checkbox-inline'><input type='checkbox' value='1'>热销 </label>
							  <label class='checkbox-inline'><input type='checkbox' value='2'>推荐 </label>
							  <label class='checkbox-inline'><input type='checkbox' value='3'>新品 </label>
							</div>
							<button class='edit-group-button group-button-bg' onclick='setRecommend();'>保存</button>
							<button class='edit-group-button' onclick='hideSetRecommend()'>取消</button>"
						>推荐</a>
						<a onclick="goodsGroupIdCount();"data-html="true"class="btn btn-small fun-a category" href="javascript:void(0)" id="editGroup" title="<h6 class='edit-group-title'>修改分组</h6>"  
							data-container="body" data-placement="bottom"  data-trigger="manual"
							data-content="<div class='edit-group' id='goodsChecked' style='max-width:auto;'>
 							<?php foreach($goods_group as $vo): ?> 
 							<p>
 								<label class='checkbox-inline' style='display:inline-block;' >
								<input type='checkbox' value='<?php echo $vo['group_id']; ?>'><b><?php echo $vo['group_name']; ?></b>&nbsp;&nbsp;&nbsp;
								</label>
								<?php foreach($vo['sub_list']['data'] as $vs): ?>
								<label style='display:inline-block;'>
								<input type='checkbox' value='<?php echo $vs['group_id']; ?>'><?php echo $vs['group_name']; ?>
								</label>
								<?php endforeach; ?>
							</p>
							<?php endforeach; ?>
							</div>
							<button class='edit-group-button group-button-bg' onclick='goodsGroupUpdate();'>保存</button>
							<button class='edit-group-button' onclick='hideEditGroup()'>取消</button>">
							商品分组</a> 
							<input type='hidden'value='' id='goods_type_ids'/>
				</tr>
			</tbody>
			<tbody id="productTbody" style="border: 0px;">
				<tr class="table-title" style="display: none;">
					<th><label><input onclick="CheckAll(event)" id="ckall" name="" value="" type="checkbox"></label></th>
					<th>商品名称</th>
					<th>价格（元）</th>
					<th>总库存</th>
					<th>销量</th>
					<th>上下架</th>
					<th>排序</th>
					<th>操作</th>
				</tr>
			</tbody>
		</table>
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
	
<script src="__STATIC__/js/page.js"></script>
<div class="page" id="turn-ul" style="display: none">
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
<script>
	$(function() {
		$("#turn-ul").show();//显示分页z
		LoadingInfo(1);//通过此方法调用分页类
	});
	function JumpForPage(obj) {
		jumpNumber = $(obj).text();
		LoadingInfo($(obj).text());
		$(".currentPage").removeClass("currentPage");
		$(obj).addClass("currentPage");
		if (jumpNumber == 1) {
			changeClass("prev");
		} else if (jumpNumber < parseInt($("#page_count").val())) {
			changeClass();
		} else if (jumpNumber == parseInt($("#page_count").val())) {
			changeClass("next");
		}
	}
	$("#beginPage").click(function() {
		if(jumpNumber!=1){
			jumpNumber = 1;
			LoadingInfo(1);
			changeClass("begin");
		}
	});
	//上一页
	$("#prevPage").click(function() {
		var obj = $(".currentPage");
		var index = parseInt(obj.text()) - 1;
		if (index > 0) {
			obj.removeClass("currentPage");
			obj.prev().addClass("currentPage");
			jumpNumber = index;
			LoadingInfo(index);
			//判断是否是第一页
			if (index == 1) {
				changeClass("prev");
			} else {
				changeClass();
			}
		}
	});
	//下一页
	$("#nextPage").click(function() {
		var obj = $(".currentPage");
		//当前页加一（下一页）
		var index = parseInt(obj.text()) + 1;
		if (index <= $("#page_count").val()) {
			jumpNumber = index;
			LoadingInfo(index);
			obj.removeClass("currentPage");
			obj.next().addClass("currentPage");
			//判断是否是最后一页
			if (index == $("#page_count").val()) {
				changeClass("next");
			} else {
				changeClass();
			}
		}
	});
	//末页
	$("#lastPage").click(
			function() {
				jumpNumber = $("#page_count").val();
				if(jumpNumber>1){
					LoadingInfo(jumpNumber);
					$("#pageNumber a:eq("+ (parseInt($("#page_count").val()) - 1) + ")").text($("#page_count").val());
					changeClass("next");
				}
			});
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
	//查询
	function searchData(){
		LoadingInfo(1);
	}
	/**
	 * 隐藏商品分组
	 */
	function hideEditGroup(){
		$("#editGroup").popover("hide");
	}
	function hideSetRecommend(){
		$("#setRecommend").popover("hide");
	}
	//查询用户列表
	function LoadingInfo(pageIndex) {
		var start_date = $("#startDate").val();
		var end_date = $("#endDate").val();
		var state = $("#state").val();
		var goods_name =$("#goods_name").val();
		$.ajax({
			type : "post",
			url : "ADMIN_MAIN/Goods/goodsList",
			async : true,
			data : {
				"pageIndex" : pageIndex,
				"start_date":start_date,
				"end_date":end_date,
				"state":state,
				"goods_name":goods_name
			},
			success : function(data) {
				$("#page_count").val(data["page_count"]);
				$("#pageNumber a").remove();
				var html = '';
				if (data["data"].length > 0) {
					for (var i = 0; i < data["data"].length; i++) {
						html += '<tr class="tr-title" style=" width: 1502px;"><td class="td-'+ data["data"][i]["goods_id"]+'"><label><input value="'
								+ data["data"][i]["goods_id"]
								+ '" tj="" name="sub" data-state="'+data["data"][i]["state"]+'" type="checkbox"></label></td>';
						html += '<td colspan="7" style="width: 97%;"><div style="display: inline-block; width: 100%;" class="pro-code"><span>商家编码：'
								+ data["data"][i]["code"] + '</span>';
								/* if(data["data"][i]["state"] == 1){
									html += '<span class="pro-code" style="color: #f35252; float: right;"> <i class="fa fa-long-arrow-up" style="margin-right: 4px;"></i>已上架';
								}else{
										html += '<span class="pro-code" style="color: #27A9E3; float: right;"> <i class="fa fa-long-arrow-up" style="margin-right: 4px;"></i>已下架';
								} */
						html += '<span class="pro-code" style="margin-left:10px;"><i class="fa fa-long-arrow-up" style="margin-right: 4px;"></i>创建时间：'+data["data"][i]["create_time"];
						html += '</span></div></td></tr>';
						html += '<tr><td colspan="2" style="background: white;"><div><a class="a-pro-view-img" href="APP_MAIN/Goods/goodsDetail.html?id='+data["data"][i]["goods_id"]+'"target="_blank"><img class="thumbnail-img"src="__ROOT__/'+data["data"][i]["pic_cover_micro"]+'">';
						html += '<div class="div-pro-view-name"><span style="color: #13A5D5;" class="thumbnail-name title='+ data["data"][i]["goods_name"]+'"><a "target="_blank" href="APP_MAIN/Goods/goodsDetail.html?id='+data["data"][i]["goods_id"]+'">'
								+ data["data"][i]["goods_name"]
								+ '</a></span>';
						//html += '<div class="div-flag-style"><span class="" title=""><i class="icon-tablet"style="background: none; color: #555; font-size: 20px; margin-right: 0;"></i></span><span onmouseover="mouseover(this)" onmouseout="mouseout(this)"style="display: inline-block;"> <i class="icon-qrcode"style="background: none; color: #555; font-size: 20px; margin-right: 0;"></i></span>';
						//html += '<div class="QRcode" style="display: none; position: absolute;"id="qrcode"><p><img src=""></p></div></div>';
						html += '</div><div style="margin-top:10px;">';
						html += data["data"][i]["is_hot"] == 1 ? '<i class="hot">热</i>' : '';
						html += data["data"][i]["is_recommend"] == 1 ? '<i class="recommend">荐</i>' : '';
						html += data["data"][i]["is_new"] == 1 ? '<i class="new">新</i>' : '';
						html += '</div></div></td>';
						html += '<td style="background: white;"><div class="priceaddactive"><span class="price-lable">原&nbsp;&nbsp;&nbsp;&nbsp;价</span><spanclass="price-numble" style="color: #666;"id="moreChangePrice'+ data["data"][i]["goods_id"]+'"  >'
								+ data["data"][i]["price"]
								+ '</span></div>';
						html += '<div><span class="price-lable" >销售价:</span><span class="price-numble"id="moreChangePrice'+ data["data"][i]["goods_id"]+'" style="color:red;">'
								+ data["data"][i]["promotion_price"]
								+ '</span>';
						html += '</td>';
						html += '<td style="background: white;"><div class="cell"><span class="pro-stock" style="color: #666;"id="moreChangeStock'+ data["data"][i]["goods_id"] + '">'
								+ data["data"][i]["stock"]
								+ '</span></div></td>';
						html += '<td style="background: white;"><div class="cell"><span class="pro-stock" style="color: #666;"id="moreChangeStock'+ data["data"][i]["goods_id"]+'">'
								+ data["data"][i]["real_sales"]
								+ '</span></div></td>';
						if(data["data"][i]["state"] == 1){
							html += '<td style="background: white;">已上架</td>';
						}else{
							html += '<td style="background: white;">已下架</td>';
						}
						html += '<td style="background: white;"><div class="cell"><span class="price-numble" onclick="oneChangeSort(this)">'
								+ data["data"][i]["sort"]
								+ '</span><input class="input-mini" pid="'
								+ data["data"][i]["goods_id"]
								+ '" style="display: none"value="'
								+ data["data"][i]["sort"]
								+ '" onblur="changeSort(this)" oldsort="'
								+ data["data"][i]["sort"]
								+ '" type="number"></div></td>';
						html += '<td style="background: white;"><div class="cell"><div class="bs-docs-example tooltip-demo"style="text-align: center;">';
						html += '<a href="javascript:;" data-placement="bottom" data-original-title="编辑"><span class="edit" style="display: inline-block; width: 19%;" onclick="updateGoodsDetail('
								+ data["data"][i]["goods_id"]
								+ ')"><i class="icon-edit" style="width: initial;"></i>编辑</span></a>';
						html += '<a href="javascript:void(0)" data-placement="bottom"onclick="deleteGoods('
								+ data["data"][i]["goods_id"]
								+ ')" data-original-title="删除"><span class="del" style="display: inline-block; width: 19%;"><i class="icon-trash" style="width: initial;"></i>删除</span></a></div></div></td></tr>';
					}
				} else {
					html += '<tr align="center"><th colspan="8">暂无符合条件的数据记录</th></tr>';
				}
				$("#productTbody").html(html);
				var totalpage = $("#page_count").val();
				if (totalpage == 1) {
					changeClass("all");
				}
				var $html = pagenumShow(jumpNumber,totalpage,<?php echo $pageshow; ?>)
				$("#pageNumber").append($html);
			}
		});
	}
	//把值传过去即可
	function updateGoodsDetail(goods_id) {
		window.location = "ADMIN_MAIN/Goods/addGoods?step=2&goodsId="
				+ goods_id;
	}
	function deleteGoodsCount() {
		var goods_ids= "";
		$("#productTbody input[type='checkbox']:checked").each(function() {
			if (!isNaN($(this).val())) {
				goods_ids = $(this).val() + "," + goods_ids;
			}
		});
		goods_ids = goods_ids.substring(0, goods_ids.length - 1);
		if(goods_ids == ""){
			$( "#dialog" ).dialog({
	            buttons: {
	                "确定,#51A351": function() {
	                    $(this).dialog('close');
	                }
	            },
	            contentText:"请选择需要操作的记录",
	            title:"消息提醒",
	        });
			return false;
		}
		deleteGoods(goods_ids);
		/* var del = confirm("确定要删除吗？"); */
		
		/* if (del) {			
			alert("確定啊，id我都有了，你看" + id);
		} else {
			alert("不確定");
		} */
	}
	//全选
	function CheckAll(event){
		var checked = event.checked;
		$("#productTbody input[type = 'checkbox']").prop("checked",checked);
		
	}
	//商品上架id合计
	function goodsIdCount(line){
		var goods_ids= "";
		$("#productTbody input[type='checkbox']:checked").each(function() {
			if (!isNaN($(this).val())) {
				var state = $(this).data("state");
				if(line == "online"){
					if(state == 1){
						$( "#dialog" ).dialog({
				            buttons: {
				                "确定,#51A351": function() {
				                    $(this).dialog('close');
				                }
				            },
				            contentText:"记录中包含已上架记录",
				            title:"消息提醒",
				        });
						return false;
					}
				}else{
				if(state == 0){
					$( "#dialog" ).dialog({
			            buttons: {
			                "确定,#51A351": function() {
			                    $(this).dialog('close');
			                }
			            },
			            contentText:"记录中包含已下架记录",
			            title:"消息提醒",
			        });
					return false;
					}
				}
				goods_ids = $(this).val() + "," + goods_ids;
			}
		});
		goods_ids = goods_ids.substring(0, goods_ids.length - 1);
		if(goods_ids == ""){
			$( "#dialog" ).dialog({
	            buttons: {
	                "确定,#51A351": function() {
	                    $(this).dialog('close');
	                }
	            },
	            contentText:"请选择需要操作的记录",
	            title:"消息提醒",
	        });
			return false;
		}
		modifyGoodsOnline(goods_ids,line);
	}
	
	//商品上下架
	function modifyGoodsOnline(goods_ids,line){
		if(line == "online"){
			var url = "ModifyGoodsOnline";
			var lingStr = "上架";
		}else{
			var url = "ModifyGoodsOffline";
			var lingStr = "下架";
		}
		$.ajax({
			type : "post",
			url : "ADMIN_MAIN/Goods/"+url,
			async : true,
			data : {
				"goods_ids" : goods_ids
			},
			success : function(data) {
				if(data["code"] > 0 ){
					LoadingInfo(1);
					$( "#dialog" ).dialog({
			            buttons: {
			                "确定,#51A351": function() {
			                    $(this).dialog('close');
			                }
			            },
			            contentText:"商品"+lingStr+"成功",
			            title:"消息提醒",
			      		time:5
			        });
				}
			}
		})
	}
	
	function deleteGoods(goods_ids){
		$( "#dialog" ).dialog({
            buttons: {
                "确定,#51A351": function() {
                    $(this).dialog('close');
                    $.ajax({
            			type : "post",
            			url : "ADMIN_MAIN/Goods/deleteGoods",
            			async : true,
            			data : {
            				"goods_ids" : goods_ids
            			},
    					dataType : "json",
            			success : function(data) {
            				if(data["code"] > 0 ){
            					LoadingInfo(1);
            					$( "#dialog" ).dialog({
            			            buttons: {
            			                "确定,#51A351": function() {
            			                    $(this).dialog('close');
            			                }
            			            },
            			            modal: true,
            			            contentText:data["message"],
            			            title:"消息提醒",
            			      		time:5
            			        });
            				}
            			}
            		})
                }
            },
            contentText:"你确定删除吗？",
            title:"消息提醒"
        });
	}
	//商品修改分组id合计
	function goodsGroupIdCount(){
		var goods_ids= "";
		$("#productTbody input[type='checkbox']:checked").each(function() {
			if (!isNaN($(this).val())) {
				goods_ids = $(this).val() + "," + goods_ids;
			}
		});
		goods_ids = goods_ids.substring(0, goods_ids.length - 1);
		if(goods_ids == ""){
			$( "#dialog" ).dialog({
	            buttons: {
	                "确定,#51A351": function() {
	                    $(this).dialog('close');
	                }
	            },
	            contentText:"请选择需要操作的记录",
	            title:"消息提醒",
	        });
			return false;
		}
		$("#goods_type_ids").val(goods_ids);
		$("#editGroup").popover("show");
		$(".popover").css("max-width",'1000px');
	}
	//商品修改分组
	function goodsGroupUpdate(){
		var goods_type = "";
		var goods_ids = $("#goods_type_ids").val();
		$("#goodsChecked input[type='checkbox']:checked").each(function(){
			if (!isNaN($(this).val())) {
				goods_type = $(this).val() + "," + goods_type;
			}
		})
		if(goods_type == ""){
			$( "#dialog" ).dialog({
	            buttons: {
	                "确定,#51A351": function() {
	                    $(this).dialog('close');
	                }
	            },
	            contentText:"请选择需要操作的记录",
	            title:"消息提醒",
	        });
			return false;
		}
		goods_type = goods_type.substring(0, goods_type.length - 1);
		$.ajax({
			type : "post",
			url : "ADMIN_MAIN/Goods/ModifyGoodsGroup",
			async : true,
			data : {
				"goods_id" : goods_ids,
				"goods_type" : goods_type
			},
			success : function(data) {
				if(data["code"] > 0 ){
					$("#editGroup").popover("hide");
					LoadingInfo(1);
					$( "#dialog" ).dialog({
			            buttons: {
			                "确定,#51A351": function() {
			                    $(this).dialog('close');
			                }
			            },
			            contentText:data["message"],
			            title:"消息提醒",
			        });
				} 
			}
		})
	}
//显示 推荐选项
function ShowRecommend(){
	var goods_ids= "";
	$("#productTbody input[type='checkbox']:checked").each(function() {
		if (!isNaN($(this).val())) {
			goods_ids = $(this).val() + "," + goods_ids;
		}
	});
	goods_ids = goods_ids.substring(0, goods_ids.length - 1);
	if(goods_ids == ""){
		$( "#dialog" ).dialog({				
            buttons: {
                "确定,#51A351": function() {
                    $(this).dialog('close');
                }
            },
            contentText:"请选择需要操作的记录",
            title:"消息提醒",
        });
		return false;
	}
	$("#goods_type_ids").val(goods_ids);
	$("#setRecommend").popover("show");
} 
//修改为  推荐 商品
function setRecommend(){
	var recommend_type = '';
	var goods_ids = $("#goods_type_ids").val();
	$("#recommendType input[type='checkbox']").each(function(){
		if ($(this).attr("checked") == 'checked') {
			var recommend_type_new = 1;
		}else{
			var recommend_type_new = 0;
		}
		recommend_type = recommend_type_new + "," + recommend_type;
	})
	if(recommend_type == ""){
		$( "#dialog" ).dialog({
            buttons: {
                "确定,#51A351": function() {
                    $(this).dialog('close');
                }
            },
            contentText:"请选择需要操作的记录",
            title:"消息提醒",
        });
		return false;
	}
	recommend_type = recommend_type.substring(0, recommend_type.length - 1);
	$.ajax({
		type : "post",
		url : "ADMIN_MAIN/Goods/ModifyGoodsRecommend",
		async : true,
		data : {
			"goods_id" : goods_ids,
			"recommend_type" : recommend_type
		},
		success : function(data) {
			if(data["code"] > 0 ){
				$("#setRecommend").popover("hide");
				LoadingInfo(1);
				$( "#dialog" ).dialog({
		            buttons: {
		                "确定,#51A351": function() {
		                    $(this).dialog('close');
		                }
		            },
		            contentText:data["message"],
		            title:"消息提醒",
		        });
			} 
		}
	})
}
</script>

</body>
</html>