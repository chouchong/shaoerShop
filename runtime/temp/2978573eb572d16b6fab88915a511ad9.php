<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:35:"template/admin\b2c\Index\index.html";i:1495424452;s:28:"template/admin\b2c\base.html";i:1495424696;}*/ ?>
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
		
<link rel="stylesheet" type="text/css" href="ADMIN_CSS/dashboard.css">
<link rel="stylesheet" type="text/css" href="ADMIN_CSS/index.css">
<script src="ADMIN_JS/highcharts.js"></script>
<script src="ADMIN_JS/exporting.js"></script>
<script>
var admin_main = "ADMIN_MAIN";
</script>
<script src="ADMIN_JS/index.js"></script>
<script src="ADMIN_JS/jquery.timers.js"></script>
<!-- ********************【脚本统一写在index.js中】******************** -->

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
			
<header class="home">
	<article>
		<div class="home-shop">
			<img src="__STATIC__/images/niushop_home.png" /> <span>店铺设置</span>
		</div>
		<div class="home-info">
			<p><span class="user_name">--</span></p>
			<p>管理权限：<span>管理员</span></p>
			<p>店铺名称：<span>niushop</span></p>
		</div>
	</article>
	<article>
		<p class="last-login-time">最后登录时间：<span>0000-00-00 00:00:00</span></p>
	</article>
</header>
<div class="goods-prompt">
	<h3>店铺及商品提示<span>您需要关注的店铺信息以及待处理事项</span></h3>
	<div class="subtitle">
		<img src="__STATIC__/images/green_giftbag.png" /> <label>店铺商品发布情况：<span class="goods_all_count">0/不限</span></label>
		<img src="__STATIC__/images/orange_picture.png" /><label>图片空间使用情况：<span>0/不限</span></label>
	</div>
	<div class="goods-state">
		<ul>
			<li><h4 class="goods_sale_count">0</h4>出售中</li>
			<li><h4 class="goods_audit_count">0</h4>仓库中已审核</li>
			<li><h4 class="goods_shelf_count">0</h4>违规下架</li>
			<li><h4 class="goods_consult_count">0</h4>待回复咨询</li>
		</ul>
	</div>
</div>

<div class="merchants-help">
	<h3>商家帮助及平台联系方式</h3>
	<div class="subtitle">
		<img src="__STATIC__/images/green_phone.png" /><label>电话：<span id="user_tel">--</span></label>
		<img src="__STATIC__/images/orange_email.png" /><label>邮箱：<span id="user_email">--</span></label>
	</div>
	<div class="merchants-use">
		<ul>
			<li><a href="ADMIN_MAIN/Goods/goodsList.html">商品管理</a></li>
			<li><a href="ADMIN_MAIN/Promotion/couponTypeList.html">促销方式</a></li>
			<li><a href="ADMIN_MAIN/Order/OrderList.html">订单及售后</a></li>
		</ul>
	</div>
</div>

<div class="goods-prompt">
	<h3>
		交易提示<span>您需要立即处理的交易订单</span>
	</h3>
	<div class="subtitle">
		<img src="__STATIC__/images/green_list.png" /><label>近期售出：<span>交易中的订单</span></label>
		<img src="__STATIC__/images/orange_shield.png" /><label>维权投诉：<span>收到维权投诉</span></label>
	</div>
	<div class="goods-state">
		<ul>
			<a href='ADMIN_MAIN/Order/orderList.html?status=0'><li><h4 class="daifukuan">0</h4>待付款</li></a>
			<a href='ADMIN_MAIN/Order/orderList.html?status=1'><li><h4 class="daifahuo">0</h4>待发货</li></a>
			<a href='ADMIN_MAIN/Order/orderList.html?status=2'><li><h4 class="yifahuo">0</h4>已发货</li></a>
			<a href='ADMIN_MAIN/Order/orderList.html?status=3'><li><h4 class="yishouhuo">0</h4>已收货</li></a>
			<a href='ADMIN_MAIN/Order/orderList.html?status=4'><li><h4 class="yiwancheng">0</h4>已完成</li></a>
			<a href='ADMIN_MAIN/Order/orderList.html?status=5'><li><h4 class="yiguanbi">0</h4>已关闭</li></a>
			<a href='ADMIN_MAIN/Order/orderList.html?status=-1'><li><h4 class="tuikuanzhong">0</h4>退款中</li></a>
			<a href='ADMIN_MAIN/Order/orderList.html?status=-2'><li><h4 class="yituikuan">0</h4>已退款</li></a>
		</ul>
	</div>
</div>

<div class="sales">
	<h3>
		销售情况统计<span>按周期统计商家店铺的订单量和订单金额</span>
	</h3>
	<table>
		<tr>
			<td>项目</td>
			<td>订单量（件）</td>
			<td>订单金额（元）</td>
		</tr>
		<tr>
			<td>昨日销量</td>
			<td><span class="yesterday_goods">0</span></td>
			<td><span class="month_goods">0</span></td>
		</tr>
		<tr>
			<td>本月销量</td>
			<td><span class="yesterday_money">0</span></td>
			<td><span class="month_money">0</span></td>
		</tr>
	</table>
</div>

<div class="operation-promote">
	<h3>
		店铺运营推广<span>合理参见促销活动可以有效提供商品销量</span>
	</h3>
	<div class="operation-promote-state">
		<ul>
			<li class="snapup"><img
				src="__STATIC__/images/promoote_snapup.png" class="promote-img" />
				<h5 class="promote-h5">
					抢购活动<span>已开通</span>
				</h5>
				<p class="promote-p">参与平台发起的抢购活动提搞商品成交量及店铺浏览量</p></li>
			<li class=time-limit><img
				src="__STATIC__/images/promoote_snapup.png" class="promote-img" />
				<h5 class="promote-h5">
					限时折扣<span>已开通</span>
				</h5>
				<p class="promote-p">在规定时间段内对店铺中所选商品进行打折促销活动</p></li>

			<li class=full_present><img
				src="__STATIC__/images/promoote_snapup.png" class="promote-img" />
				<h5 class="promote-h5">
					满即送<span>已开通</span>
				</h5>
				<p class="promote-p">商家自定义满即送标准与规则，促进购买转化率</p></li>
			<li class=preferential-suit><img
				src="__STATIC__/images/promoote_snapup.png" class="promote-img" />
				<h5 class="promote-h5">
					优惠套装<span>未开通</span>
				</h5>
				<p class="promote-p">商品优惠套装，多重搭配更多实惠、商家必备营销方式</p></li>
			<li class=recommended_booth><img
				src="__STATIC__/images/promoote_snapup.png" class="promote-img" />
				<h5 class="promote-h5">
					推荐展位<span>未开通</span>
				</h5>
				<p class="promote-p">选择商品参与平台发布的主题活动，审核后集中展示</p></li>
			<li class=kims_volume><img
				src="__STATIC__/images/promoote_snapup.png" class="promote-img" />
				<h5 class="promote-h5">
					代金券<span>已开通</span>
				</h5>
				<p class="promote-p">自定义代金卷使用规则并由平台统一展示供买家领取</p></li>
		</ul>
	</div>
</div>

<div class="sales-ranking">
	<h3>
		单品销售排名<span>按周期统计商家店铺的订单量和订单金额</span>
	</h3>
	<table>
		<tr>
			<td>排行</td>
			<td>商品信息</td>
			<td>销量</td>
		</tr>
		<?php if(is_array($goods_list) || $goods_list instanceof \think\Collection || $goods_list instanceof \think\Paginator): if( count($goods_list)==0 ) : echo "" ;else: foreach($goods_list as $key=>$goods_info): ?>
			
		    <tr>
				<td>
				<?php if($key == 0): ?>
					<span class="frist">
				<?php elseif($key == 1): ?>
					<span class="second">
				<?php elseif($key == 2): ?>
					<span class="third">
				<?php else: ?>
					<span>
				<?php endif; ?>
					
					<?php echo $key+1; ?></span></td>
				<td title="<?php echo $goods_info['goods_name']; ?>">
				<?php 
				
				echo strlen($goods_info["goods_name"])>20 ? mb_substr($goods_info["goods_name"],0,20,'utf-8')."...":$goods_info["goods_name"];
				?>
				</td>
				<td><?php echo $goods_info['real_sales']; ?></td>
			</tr>
		<?php endforeach; endif; else: echo "" ;endif; ?> 
		<!-- <tr>
			<td><span class="frist">1</span></td>
			<td>裤子</td>
			<td>3000</td>
		</tr>
		<tr>
			<td><span class="second">2</span></td>
			<td>上衣</td>
			<td>2600</td>
		</tr>
		<tr>
			<td><span class="third">3</span></td>
			<td>笔记本</td>
			<td>2600</td>
		</tr>
		<tr>
			<td><span>4</span></td>
			<td>服务器</td>
			<td>2500</td>
		</tr>
		<tr>
			<td><span>5</span></td>
			<td>手机</td>
			<td>2200</td>
		</tr>
		<tr>
			<td><span>6</span></td>
			<td>水杯</td>
			<td>100</td>
		</tr> -->
	</table>
</div>

<div class="charts">
	<h3>
		订单总数统计<span><i></i>订单数量</span>
	</h3>
	<div id="orderCharts"></div>
</div>
<div class="charts" style="border-right: 0;">
	<h3>
		关注人数统计<span><i></i>关注人数</span>
	</h3>
	<div id="focusCharts"></div>
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
	
</body>
</html>