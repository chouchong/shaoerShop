<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:47:"template/admin\b2c\Promotion\addCouponType.html";i:1495192291;s:28:"template/admin\b2c\base.html";i:1495424696;s:45:"template/admin\b2c\Promotion\selectGoods.html";i:1495414728;s:34:"template/admin\b2c\pageCommon.html";i:1492765125;s:34:"template/admin\b2c\openDialog.html";i:1495424452;}*/ ?>
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
		
<script src="ADMIN_JS/My97DatePicker/WdatePicker.js" type="text/javascript"></script>
<style  type="text/css">
.set-style{
	width:100%;
}
.set-style dl{
	width:100%;
	font-size: 0;
	/* line-height: 20px; */
	clear: both;
	padding: 0;
	margin: 0;
	border-bottom: dotted 1px #E6E6E6;
	overflow: hidden;
}
.set-style dl dt{
	font-size: 12px;
	line-height: 32px;
	vertical-align: top;
	letter-spacing: normal;
	word-spacing: normal;
	text-align: right;
	display: inline-block;
	width: 19%;
	padding: 10px 1% 10px 0;
	margin: 0;
	font-weight:normal;
}
.set-style dl dd{
	
	font-size: 12px;
	line-height: 32px;
	vertical-align: top;
	letter-spacing: normal;
	word-spacing: normal;
	display: inline-block;
	width: 78%;
	padding: 10px 0 10px 0;
}
.set-style dl dd input[type="text"]{
	font: 12px/20px Arial;
	color: #777;
	background-color: #FFF;
	vertical-align: top;
	display: inline-block;
	height:24px;
	line-height:24px;
	padding: 4px;
	border: 1px solid #CCC;
	outline: 0 none;
	width: 400px;
	margin:0;
}
.set-style dl dd input[type="text"].w70{
	width:70px;
}
.set-style dl dd textarea{
    font: 12px/20px Arial;
    color: #777;
    background-color: #FFF;
    vertical-align: top;
    display: inline-block;
    height: 60px;
    padding: 4px;
    border: solid 1px #CCC;
    outline: 0 none;
	width: 400px;
	margin:0;
}
.hint{
    font-size: 12px;
    line-height: 16px;
    color: #BBB;
    margin-top: 10px;
}
.set-style dl dd p img{
	border: medium none;
	vertical-align: middle;
}
.class-logo{
	background-color: #FFF;
	position: relative;
	z-index: 1;
}
.class-logo p{
	width: 120px;
	height: 100px;
	line-height: 0;
	background-color: #FFF;
	text-align: center;
	vertical-align: middle;
	display: table-cell;
	*display: block;
	overflow: hidden;
	margin: 0 0 10px;
	border: dashed 1px #E6E6E6;
}
.class-logo p img{
	max-width: 120px;
	max-height: 100px;
	border: medium none;
	vertical-align: middle;
	margin-top: expression(60-this.height/2);
	*margin-top: expression(30-this.height/2);
}

.set-style dl dd p{
	margin-bottom:0;
}

.table-div  table tr td{
	    border: 1px solid #e6e6e6;
    padding: 10px;
}
.goodlist-table tr td{
	    border: 1px solid #e6e6e6;
    padding: 10px;
}
.form-horizontal .control-group {
    margin-bottom: 0px;
}
.form-horizontal .controls {
    margin-left: 20px; 
}
.help-inline{
	    height: 30px;
    	line-height: 30px;
}
input[type="radio"]{
	margin-top:6px;
}
.controls table tr td input[type="radio"]{
	margin:0px;
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
		<dt>名称:</dt>
		<dd>
			<input type="text" id="coupon_name" maxlength="10">
			<p class="error">请输入优惠券名称</p>
			<p class="hint">10个字以内</p>
		</dd>
	</dl>
	<dl>
		<dt>面额:</dt>
		<dd><input class="input-mini w70" onkeyup="value=value.replace(/[^\d+(\.\d+)?]/g,'')" type="text" id="money"><span class="help-inline">元</span>
			<p class="error">请输入面额</p>
		</dd>
	</dl>
	<dl>
		<dt>发放数量:</dt>
		<dd><input class="input-mini w70" onkeyup='this.value=this.value.replace(/\D/gi,"")' type="text" id="count"><span class="help-inline">份</span>
			<p class="error">请输入发放数量</p>
		</dd>
	</dl>
	<dl>
		<dt>每人最大领取数:<br/>(0无限制)</dt>
		<dd><input class="input-mini w70" onkeyup='this.value=this.value.replace(/\D/gi,"")' type="text" id="max_fetch"><span class="help-inline">份</span>
			<p class="error">请输入没人最大领取数</p>
		</dd>
	</dl>
	<dl>
		<dt>满多少元使用:</dt>
		<dd><input class="input-mini w70" onkeyup="value=value.replace(/[^\d+(\.\d+)?]/g,'')" type="text" id="at_least"><span class="help-inline">元</span>
			<p class="error">请输入满足金额</p>
		</dd>
	</dl>
	<dl style="display:none;">
		<dt>领取人等级:</dt>
		<dd><input class="input-mini w70" onkeyup='this.value=this.value.replace(/\D/gi,"")' type="text" id="need_user_level"><span class="help-inline">级</span></dd>
	</dl>
	<dl>
		<dt>有效时间:</dt>
		<dd>
			<input class="input-medium" type="text" id="start_time" style="width:250px;"onclick="WdatePicker({skin:'twoer',dateFmt:'yyyy-MM-dd HH:mm:ss'})">
			<span class="mlr5">-</span> 
			<input class="input-medium" size="15"type="text" id="end_time" style="width:250px;"onclick="WdatePicker({skin:'twoer',dateFmt:'yyyy-MM-dd HH:mm:ss'})">
			<p class="error">请输入有效时间</p>
			<p class="hint">生效前买家可以领取但不能使用</p>
		</dd>
	</dl>
	<style>
.table-div  table tr td {
	border: 1px solid #e6e6e6;
	padding: 10px;
}

.goodlist-table tr td {
	border: 1px solid #e6e6e6;
	padding: 10px;
}

.form-horizontal .control-group {
	margin-bottom: 0px;
}

.form-horizontal .controls {
	margin-left: 20px;
}

.help-inline {
	height: 30px;
	line-height: 30px;
}

input[type="radio"] {
	vertical-align: middle;
	margin-top: -2px;
}

.controls table tr td input[type="radio"] {
	margin: 0px;
}

.ump-select-search select {
	margin-bottom: 0px
}

.btn-dange {
	color: #fff;
	background-color: #d00;
	border-color: #c50000;
}

.btn-dange:hover {
	color: #fff;
	background-color: #d00;
	border-color: #c50000;
}

.ump-select-tab {
	min-width: 750px;
	margin-bottom: -1px;
	background: #f2f2f2;
	border: 1px solid #ddd;
}

.ui-nav-tab {
	margin: 0;
}

.ui-nav-tab>li {
	position: relative;
	display: block;
	float: left;
	text-align: center;
	margin-bottom: -1px;
}

.ui-nav-tab:after {
	content: "";
	display: table;
	clear: both;
}

.ump-select-tab .ui-nav-tab li.active a, .ump-select-tab .ui-nav-tab li.active a:hover
	{
	height: 24px;
	line-height: 24px;
	border-bottom: 2px solid #f60;
}

.ump-select-tab .ui-nav-tab li:first-child a {
	border-left: 0;
}

.ump-select-tab .ui-nav-tab li a {
	width: 120px;
	border-top: 0;
	height: 25px;
	line-height: 25px;
	padding: 8px 20px;
}

.ui-nav-tab>li.active>a, .ui-nav-tab>li.active>a:hover, .ui-nav-tab>li.active>a:focus
	{
	color: #333;
	background-color: #fff;
	border-bottom-color: transparent;
	cursor: default;
}

.ui-nav-tab>li>a {
	position: relative;
	display: block;
	padding: 9px 15px;
	margin-right: -1px;
	line-height: 1.42857143;
	border: 1px solid #ddd;
	background-color: #f8f8f8;
	color: #333;
}

.ump-select-box {
	min-width: 750px;
	border: 1px solid #ddd;
	overflow: hidden;
}

.ump-select-search {
	padding: 10px 20px 10px;
	border-bottom: 1px solid #ddd;
	position: relative;
}

.ump-select-goods .ui-table {
	background: #fff;
}

.ui-table.ui-table-list {
	border: none;
}

.ui-table {
	width: 100%;
	font-size: 12px;
	text-align: left;
	margin-bottom: 0;
	border: 1px solid #e5e5e5;
}

.ui-table th.checkbox, .ui-table td.checkbox {
	width: 18px;
	padding: 10px 0 10px 10px;
}

.ui-table th, .ui-table td {
	padding: 10px;
	border-bottom: 1px solid #e5e5e5;
	vertical-align: top;
	-webkit-box-sizing: border-box;
	-moz-box-sizing: border-box;
	box-sizing: border-box;
}

.ui-table th {
	background: #f8f8f8;
}

.ui-table .cell-20 {
	width: 20%;
}

.center, .text-center {
	text-align: center;
}

.ump-select-goods .ui-table tr td {
	padding: 6px 4px;
	border-bottom: 1px dashed #ddd;
	vertical-align: middle;
}

.ump-select-goods .goods-image-td, .ump-select-goods .goods-image-td .goods-image,
	.ump-select-goods .goods-image-td img {
	width: 30px;
}

.ui-box {
	margin-bottom: 15px;
}

.ump-select-footer {
	padding: 0 20px 0 10px;
}

.ump-select-footer .pull-left {
	padding-bottom: 20px;
}

.pull-left {
	float: left;
}

.pagenavi {
	font-size: 12px;
	line-height: 16px;
	text-align: right;
}

.ui-btn {
	display: inline-block;
	border-radius: 2px;
	height: 26px;
	line-height: 26px;
	padding: 0 12px;
	cursor: pointer;
	color: #333;
	background: #f8f8f8;
	border: 1px solid #ddd;
	text-align: center;
	font-size: 12px;
	-webkit-box-sizing: content-box;
	-moz-box-sizing: content-box;
	box-sizing: content-box;
}

.ui-toolt {
	position: relative;
}

.ui-btn-primary {
	color: #fff;
	background: #07d;
	border-color: #006cc9;
}

.ui-btn-primary:hover {
	color: #fff;
	background: #07d;
	border-color: #006cc9;
}

.pagenavi .total, .pagenavi .prev, .pagenavi .next, .pagenavi .num,
	.pagenavi .goto-input, .pagenavi .goto-btn {
	display: inline-block;
	color: #333;
}

.pagenavi .total {
	padding: 6px 0;
	font-weight: normal !important;
}

.ui-table tr td {
	line-height: normal;
}
</style>
<dl class="type_dl">
	<dt>选择商品:</dt>
	<dd>
		<label
			style="vertical-align: middle; font-weight: normal; display: inline-block;">
			<input type="radio" value="1" name="range_type"
			onclick="ShopRadio(1)" checked="checked"> <span
			onclick="ShopRadio(1)" style="font-size: 15px; cursor: pointer;">所有商品</span>
		</td>
		</label> <label
			style="vertical-align: middle; font-weight: normal; display: inline-block;">
			<input type="radio" name="range_type" value="0"
			onclick="ShopRadio(0)"> <span onclick="ShopRadio(0)"
			style="cursor: pointer; font-size: 15px;">部分商品</span>
		</label>
	</dd>
</dl>
<dl>
	<dd id="some_pro" style="width: 99%; display: none;">
		<div class="js-goods-box" style="">
			<div class="ump-select-tab">
				<ul class="ui-nav-tab">
					<li class="js-tab active"><a href="javascript:void(0);"
						onclick="select_goods(this)">选择商品</a></li>
					<li class="js-tab"><a href="javascript:void(0);"
						onclick="selected_goods(this)">已选商品</a></li>
				</ul>
			</div>
			<div class="goods-list-wrap">
				<div class="js-goods-list-region js-goods-list-tab select-one"
					style="display: block;">
					<div class="widget-list">
						<div class="ump-select-box js-select-goods-list">
							<div class="ump-goods-wrap">
								<div class="ump-waitting-select ump-goods-list">
									<div class="js-list-filter-region clearfix">
										<div class="widget-list-filter">
											<div class="ump-select-search" style="display:none;">
												<select name="tag" id="group_id" class="js-goods-group">
													<option value="0">所有分组</option>
												</select> <select name="keyword_type" class="js-search-type">
													<option value="goods_title">商品标题</option>
													<option value="goods_no">商品编码</option>
												</select> <input class="js-input" type="text" name="keyword"
													placeholder="请输入商品名称" data-goods-title="请输入商品名称"
													data-goods-no="请输入商品编码" value="" style="width: 200px;">
												<a href="javascript:;" onclick="LoadingInfo(1)"
													class="ui-btn ui-btn-primary js-search"
													style="display: inline-block;">搜索</a>
											</div>
										</div>
									</div>
									<div class="ump-select-goods">
										<table class="ui-table ui-table-list" style="padding: 0px;">
											<thead
												class="js-list-header-region tableFloatingHeaderOriginal">
												<tr class="widget-list-header">
													<th class=""></th>
													<th colspan="2">商品信息</th>
													<th class="text-center cell-20">库存</th>
													<th class="text-center cell-20">操作</th>
												</tr>
											</thead>
											<tbody class="js-list-body-region goods-list"></tbody>
										</table>
										<div class="js-list-empty-region"></div>
									</div>
									<div class="js-list-footer-region ui-box">
										<div class="widget-list-footer">
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
<!-- 											<div class="ump-select-footer"> -->
<!-- 												<div class="pull-left" style="display: none;"> -->
<!-- 													<label class="checkbox inline"> <input -->
<!-- 														type="checkbox" class="js-select-all" -->
<!-- 														onclick="select_all(this)" style="margin-left: 0px;">全选 -->
<!-- 													</label> <a href="javascript:;" class="ui-btn js-batch-add">批量参加</a> -->

<!-- 												</div> -->
<!-- 												<div class="pagenavi"></div> -->
<!-- 											</div> -->
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div
					class="js-selected-goods-list-region js-goods-list-tab select-two"
					style="display: none;">
					<div>
						<div class="widget-list-item">
							<div class="ump-select-box js-select-goods-list">
								<div class="ump-goods-wrap">
									<div class="ump-already-select ump-goods-list">
										<div class="ump-select-goods">
											<table class="ui-table ui-table-list js-table"
												style="display:;">
												<thead class="js-list-header-region">
													<tr>
														<th class=""></th>
														<th colspan="2">商品信息</th>
														<th class="cell-20 text-center">库存</th>
														<th class="cell-20 text-center">操作</th>
													</tr>
												</thead>
												<tbody class="js-list-body-region"></tbody>
											</table>
											<!--                     <div class="js-list-empty-region hide" style="display: block;"> -->
											<!--                         <div class="no-result">还没有选择活动商品</div> -->
											<!--                     </div> -->
										</div>
										<div class="js-list-footer-region ui-box"
											style="display: none;">
											<div class="ump-select-footer ump-selected-footer">
												<div class="pull-left">
													<label class="checkbox inline"> <input
														type="checkbox" class="js-select-all"
														onclick="select_all(this)" style="margin-left: 0px;">全选
													</label> <a href="javascript:;" class="ui-btn js-batch-remove">批量取消</a>
												</div>
												<div class="js-pagination">
													<div class="ui-pagination"></div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</dd>
</dl>
<input type="hidden" id="goods_id_array" value="">
<script>
var $goods_selected_array = new Array();
var $goods_id_selected_array = new Array();
var $data_array;
$(function(){
	loadGoodsGroup();
});
$(".js-batch-add").click(function(){
	var obj = $(".select-one").find("input[name='sub']:checked");
	var html = '';
	obj.each(function(i){
		
		html += '<tr>'+$(".select-one table tbody tr").eq(i).html()+'</tr>';
	});
	$(".select-two tbody").append(html);
});
function join(goods_id,e){
	if($("#selected_"+goods_id).length > 0){
		return false;
	}else{
		for(var i=0; i<$data_array.length; i++){
			if($data_array[i]['goods_id'] == goods_id){
				$goods_selected_array[$goods_selected_array.length] = $data_array[i];
				$goods_id_selected_array[$goods_id_selected_array.length] = goods_id;
				refresh_data();
				break;
			}
	}
		var a = '<a href="javascript:;" class="btn btn-dange js-remove-reward" onclick="cancel_join('+goods_id+',this)">取消参加</a>';
		$(e).parent("td").html(a);
		$("#selected_"+goods_id+" .goods-opt").html(a);
	}
}
function cancel_join(goods_id,e){
	if($("#selected_"+goods_id).length > 0){
		for(var i=0; i<$goods_selected_array.length; i++){
			if($goods_selected_array[i]['goods_id'] == goods_id){
				$goods_selected_array.splice(i,1);
				$goods_id_selected_array.splice(i,1);
				refresh_data();
				break;
			}
		}
		var a = '<a href="javascript:;" class="btn ui-btn-primary js-add-reward" onclick="join('+goods_id+',this)">参加活动</a>';
		$(e).parent("td").html(a);
		$("#select_"+goods_id+" .goods-opt").html(a);
	}
}
function select_all(e){
	if(e.checked == true){
		$(e).parents("div.ump-goods-list").find("input[name='sub']").attr("checked","checked");
	}else{
		$(e).parents("div.ump-goods-list").find("input[name='sub']").attr("checked",false);
	}
}
function select_goods(e){
	$(e).parents("ul.ui-nav-tab").find(".js-tab").removeClass("active");
	$(e).parent("li").addClass("active");
	$(".select-one").show();
	$(".select-two").hide();
}
/**
 * 刷新 已选商品
 */
function refresh_data(){
	var data = $goods_selected_array;
	var html = "";
	for (var i = 0; i < data.length; i++) {
		html +='<tr class="widget-list-item" id="selected_'+data[i]["goods_id"]+'"><td class="checkbox text-center">';
		html +='<label><input type="checkbox" value="'+data[i]["goods_id"]+'" name="sub" style="margin-left:0px;"></label></td>';
		html +='<td class="goods-image-td text-center"><div class="goods-image js-goods-image">';
		html +='<img src="__ROOT__/'+data[i]["picture_info"]['pic_cover_micro']+'"></div></td>';
		html +='<td class="goods-meta"><p class="goods-title">';		
		html +='<a href="" target="_blank" class="new-window" title="'+data[i]["goods_name"]+'">'+data[i]["goods_name"]+'</a></p>';
		html +='<p class="goods-price">'+data[i]["price"]+'</p></td>';
		html +='<td class="text-center">'+data[i]["stock"]+'</td>';
		html +='<td class="text-center goods-opt"><a href="javascript:;" class="btn btn-dange js-remove-reward" onclick="cancel_join('+data[i]["goods_id"]+',this)">取消参加</a></td></tr>';
	}
	$(".select-two tbody tr").remove();
	$(".select-two tbody").append(html);
	
}
function selected_goods(e){
	$(e).parents("ul.ui-nav-tab").find(".js-tab").removeClass("active");
	$(e).parents("li").addClass("active");
	$(".select-two").show();
	$(".select-one").hide();
}
function LoadingInfo(pageIndex) {
	var $goodsArr = new Array();
	var group_id = $("#group_id").val();
	var search_text = $("#search_text").val();
	$.ajax({
				type : "post",
				url : "ADMIN_MAIN/Goods/getSerchGoodsList",
				async : true,
				data : {
					 "search_text" : search_text, "group_id":group_id, "pageIndex":pageIndex
				},
				success : function(data) {
					$("#page_count").val(data["page_count"]);
					$("#pageNumber a").remove();
					data = data['data'];
					$data_array = data;
					var html = '';				
					if (data.length > 0) {
						$("#DiscountList").show();
						for (var i = 0; i < data.length; i++) {
							if(jQuery.inArray(data[i]["goods_id"], $goodsArr) == "-1")
							{
								$goodsArr.push(data[i]["goods_id"]);
							}else{
								continue;
							}
							html +='<tr class="widget-list-item" id="select_'+data[i]["goods_id"]+'"><td class="checkbox text-center">';
							html +='<label><input type="checkbox" value="'+data[i]["goods_id"]+'" name="sub" style="margin-left:0px;"></label></td>';
							html +='<td class="goods-image-td text-center"><div class="goods-image js-goods-image">';
							html +='<img src="__ROOT__/'+data[i]["picture_info"]['pic_cover_micro']+'"></div></td>';
							html +='<td class="goods-meta"><p class="goods-title">';		
							html +='<a href="" target="_blank" class="new-window" title="'+data[i]["goods_name"]+'">'+data[i]["goods_name"]+'</a></p>';
							html +='<p class="goods-price">'+data[i]["price"]+'</p></td>';
							html +='<td class="text-center">'+data[i]["stock"]+'</td>';
							if($goods_id_selected_array.length > 0){
								if(jQuery.inArray(data[i]["goods_id"], $goods_id_selected_array) == "-1"){
									html +='<td class="text-center goods-opt"><a href="javascript:;" class="btn ui-btn-primary js-add-reward" onclick="join('+data[i]["goods_id"]+',this)" >参加活动</a></td></tr>';	
								}else{
									html +='<td class="text-center goods-opt"><a href="javascript:;" class="btn btn-dange js-remove-reward" onclick="cancel_join('+data[i]["goods_id"]+',this)">取消参加</a></td></tr>';
								}
							}else{
								html +='<td class="text-center goods-opt"><a href="javascript:;" class="btn ui-btn-primary js-add-reward" onclick="join('+data[i]["goods_id"]+',this)">参加活动</a></td></tr>';	
							}
						}
					} else {
						html += '<tr align="center"><th colspan="4">暂无符合条件的数据记录</th></tr>';
					}
					$("tbody.goods-list tr").remove();
					$("tbody.goods-list").append(html);
					var totalpage = $("#page_count").val();
					if (totalpage == 1) {
							changeClass("all");
					}
					var $html = pagenumShow(jumpNumber,totalpage,<?php echo $pageshow; ?>)
					$("#pageNumber").append($html);
				}
			});
}
function loadGoodsGroup(){
	$.ajax({
		type : "post",
		url : "ADMIN_MAIN/Goods/getGoodsGroupFristLevel",
		async : true,
		success : function(data) {
			var html = '';
			if(data.length > 0){
				for(var i=0; i < data.length; i++){
					html += '<option value="'+data[i]['group_id']+'">'+data[i]['group_name']+'</option>';
				}
			}
			$("#group_id").append(html);
		}
	});
}
//控制商品列表显示数据
function ShopRadio(num){
	if(num == 0){
		$("#some_pro").show();
		$("ul.ui-nav-tab li.js-tab").eq(1).click();
	}else{
		$("#some_pro").hide();
	}
}
</script>	
	<button class="edit_button" onclick="addCouponType();">提交</button>
</div>
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
	//保存
	function addCouponType(){       
		var coupon_name = $("#coupon_name").val();
		var money = $("#money").val();
		var count = $("#count").val();
		var max_fetch = $("#max_fetch").val();
		var at_least = $("#at_least").val();
		var need_user_level = $("#need_user_level").val();
		var range_type = $("input[name='range_type']:checked").val();
		var start_time = $("#start_time").val();
		var end_time = $("#end_time").val();
		var obj = $(".select-two table input[type=checkbox][name='sub']");
		var goods_id_array = '';
		obj.each(function(i){
			goods_id_array += ','+obj.eq(i).val();
		});
		goods_id_array = goods_id_array.substring(1);
		if(verify(coupon_name, money, count, max_fetch, at_least, start_time, end_time)){
			if(flag){
				return;
			}
			flag = true;
			$.ajax({
				type : "post",
				url : "ADMIN_MAIN/Promotion/addCouponType",
				data : {
					'coupon_name' : coupon_name,
					'money' : money,
					'count' : count,
					'at_least' : at_least,
					'max_fetch' : max_fetch,
					'need_user_level' : need_user_level,
					'range_type' : range_type,
					'start_time' : start_time,
					'end_time' : end_time,
					'goods_list' : goods_id_array
				},
				async : true,
				success : function(data) {
					if (data["code"] > 0) {
						showMessage('success', data["message"],'ADMIN_MAIN/Promotion/couponTypeList');
					}else{
						showMessage('error', data["message"]);
					}	
					flag = false;
				}
			});
		}
	}
	/**
	*模块输入信息验证
	*/
	function verify(coupon_name, money, count, max_fetch, at_least, start_time, end_time){
		if(coupon_name == ''){
			$("#coupon_name").parent().find('.error').show();
			return false;
		}else{
			$(".error").hide();
		}
		if(money == ''){
			$("#money").parent().find('.error').show();
			return false;
		}else{
			$(".error").hide();
		}
		if(count == ''){
			$("#count").parent().find('.error').show();
			return false;
		}else{
			$(".error").hide();
		}
		if(max_fetch == ''){
			$("#max_fetch").parent().find('.error').show();
			return false;
		}else{
			$(".error").hide();
		}
		if(start_time == '' || end_time == ''){
			$("#start_time").parent().find('.error').show();
			return false;
		}else{
			$(".error").hide();
		}
		return true;
	}
	var flag = false;//防止重复提交
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