<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:48:"template/admin\b2c\Goods\selectCategoryNext.html";i:1495425048;s:28:"template/admin\b2c\base.html";i:1495424696;s:34:"template/admin\b2c\openDialog.html";i:1495424452;}*/ ?>
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
<!-- 选择商品图，弹出框的样式 -->
<link rel="stylesheet" type="text/css" href="ADMIN_CSS/defau.css">
<link href="__STATIC__/sku/jquery.ui.css" type="text/css" rel="stylesheet">
<link href="__STATIC__/sku/goods_create.css" type="text/css" rel="stylesheet">
<!-- <link href="__STATIC__/sku/base.css" type="text/css" rel="stylesheet"> -->
<link href='ADMIN_CSS/drag_haul/jquery.gridly.css' rel='stylesheet' type='text/css'>
<link href='ADMIN_CSS/drag_haul/sample.css' rel='stylesheet' type='text/css'>
<link href='ADMIN_CSS/select_category_next.css' rel='stylesheet' type='text/css'>
<script src="ADMIN_JS/fun.js"></script> 
<!-- <script src="ADMIN_JS/NewGetProperty.js"></script> -->
<script type="text/javascript" charset="utf-8" src="ADMIN_JS/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="ADMIN_JS/ueditor/ueditor.all.js"></script>
<!--建议手动加在语言，避免在ie下有时因为加载语言失败导致编辑器加载失败-->
<!--这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文-->
<script type="text/javascript" charset="utf-8" src="ADMIN_JS/ueditor/zh-cn.js"></script>
<script src="ADMIN_JS/ajax_file_upload.js" type="text/javascript"></script>
<script src="ADMIN_JS/image_common.js" type="text/javascript"></script>
<script src="ADMIN_JS/kindeditor-min.js" type="text/javascript"></script>
<!--  用  验证商品输入信息-->
<script type="text/javascript" src="ADMIN_JS/goods_validate.js"></script>
<script src="ADMIN_JS/jscommon.js" type="text/javascript"></script>
<!-- 用 -->
<script src="ADMIN_JS/goods_create.js" type="text/javascript"></script>
<!-- 用 ，加载数据-->
<script type="text/javascript" src="__STATIC__/sku/goods_create.js"></script>
<script type="text/javascript" src="__STATIC__/sku/base.js"></script>
<script type="text/javascript" src="__STATIC__/sku/jquery-ui.js"></script>
<script src="ADMIN_JS/art_dialog.source.js"></script>
<script src="ADMIN_JS/iframe_tools.source.js"></script>
<script src="ADMIN_JS/material_managedialog.js"></script>
<script src='ADMIN_JS/drag_haul/jquery.gridly.js' type='text/javascript'></script>
<script src='ADMIN_JS/drag_haul/sample.js' type='text/javascript'></script>
<script src='ADMIN_JS/init_address.js'></script>

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
			
<input type="hidden" id="goodsId" value="<?php echo $goods_id; ?>" />
<input type="hidden" id="skuIsChange" value="0" />
<input type="hidden" id="shop_type" value="<?php echo $shop_type; ?>" />
<input type="hidden" id="hidQRcode" value="" />
<input type="hidden" id="hidthumbnail" value="" />
<div class="pro-form">
	<div class="content">
		<form class="form-horizontal">
			<input type="hidden" value="0" id="hiddenProductID">
			<div class="c-box">
				<h3>基本信息</h3>
				<div class="control-group text">
					<label class="control-label">商品类目：</label>
					<div class="controls" cid="<?php echo $goods_category_id; ?>"
						cname="<?php echo $goods_category_name; ?>" id="tbcName"><?php echo $goods_category_name; ?></div>
				</div>
				<div class="control-group text">
					<label class="control-label">商品分组：</label>
					<div class="controls product-category-position">
						<div class="productcategory-selected" id="productcategory-selected"></div>
						<a class="area-select" id="area-select" href="javascript:void(0)">选择</a>
						<span class="help-inline" style="display: none; color: red;">请选择商品分类</span>
						<div class="procategory" id="procategory" style="color:#666;">
								<ul class="clear">
									<?php if(is_array($group_list) || $group_list instanceof \think\Collection || $group_list instanceof \think\Paginator): if( count($group_list)==0 ) : echo "" ;else: foreach($group_list as $key=>$gp): ?>
									<li>
										<input class="input-checked" id="<?php echo $gp['group_id']; ?>" type="checkbox" value="<?php echo $gp['group_name']; ?>">
										<label for="<?php echo $gp['group_id']; ?>"><?php echo $gp['group_name']; ?></label>
									</li>
									<?php endforeach; endif; else: echo "" ;endif; ?>
								</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="c-box">
				<h3>商品信息</h3>
				<div class="control-group">
					<label class="control-label" for="txtProductTitle"><span class="color-red">*</span>商品标题：</label>
					<div class="controls">
						<input class="productname" type="text" id="txtProductTitle">
						<span class="help-inline" style="display: none; color: red;">请输入商品标题，不能超过40个字</span>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="brandSelect">商品品牌：</label>
					<div class="controls">
						<select id="brandSelect">
							<option value="0">请选择商品品牌</option>
							<?php if(is_array($goodsbrand_list) || $goodsbrand_list instanceof \think\Collection || $goodsbrand_list instanceof \think\Paginator): if( count($goodsbrand_list)==0 ) : echo "" ;else: foreach($goodsbrand_list as $key=>$brand): ?>
							<option value="<?php echo $brand['brand_id']; ?>"><?php echo $brand['brand_name']; ?></option>
							<?php endforeach; endif; else: echo "" ;endif; ?>
						</select>
						<span class="help-inline" style="display: none; color: red;">请选择商品品牌</span>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="provinceSelect">所在地：</label>
					<div class="controls">
						<select id="provinceSelect" class="auto-width" onchange="getProvince(this,'#citySelect',-1)">
							<option value="0">请选择省</option>
						</select>
						<select id="citySelect" class="auto-width">
							<option value="0">请选择市</option>
						</select>
						<!-- <span class="help-inline" style="display: none;color:red;">请选择商品区域</span> -->
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="txtProductSalePrice"><span class="color-red">*</span>原价：</label>
					<div class="controls">
						<input type="number" id="txtProductSalePrice" min="0" placeholder="0">
						<span class="help-inline">元</span>
						<span class="help-inline" style="display: none; color: red;">商品现价不能为空且需是数字</span>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="txtProductMarketPrice"> <span class="color-red">*</span>市场价：</label>
					<div class="controls">
						<input type="number" id="txtProductMarketPrice" min="0" placeholder="0">
						<span class="help-inline">元</span>
						<span class="help-inline" style="display: none; color: red;">商品市场不能为空且需是数字</span>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="txtProductCostPrice"><span class="color-red">*</span>成本价：</label>
					<div class="controls">
						<input type="number" id="txtProductCostPrice" min="0" placeholder="0">
						<span class="help-inline">元</span>
						<span class="help-inline" style="display: none; color: red;">商品成本不能为空且需是数字</span>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="BasicSales"><span class="color-red"></span>基础销量：</label>
					<div class="controls">
						<input type="number" class="span1" id="BasicSales" value="0" min="0" placeholder="0">
						<span class="help-inline">件</span>
						<span class="help-inline" style="display: none; color: red;">基础销量需是数字</span>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="BasicPraise"> <span class="color-red"></span>基础点击数：</label>
					<div class="controls">
						<input type="number" class="span1" id="BasicPraise" value="0" min="0" placeholder="0">
						<span class="help-inline">次</span>
						<span class="help-inline" style="display: none; color: red;">基础点击数需是数字</span>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="BasicShare"> <span class="color-red"></span>基础分享数：</label>
					<div class="controls">
						<input type="number" class="span1" id="BasicShare" value="0" min="0" placeholder="0">
						<span class="help-inline">次</span>
						<span class="help-inline" style="display: none; color: red;">基础分享数需是数字</span>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="txtProductCodeA"><span class="color-red"></span>商家编码：</label>
					<div class="controls">
						<input type="text" id="txtProductCodeA">
						<span class="help-inline" style="display: none; color: red;">请输入商家编码</span>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label"><span class="color-red"></span>商品规格：</label>
					<div class="controls">
						<div class="sku-group">
							<div class="js-sku-list-container"></div>
							<div class="js-sku-group-opts sku-sub-group">
								<h3 class="sku-group-title">
									<button type="button" class="js-add-sku-group btn">添加规格项目</button>
								</h3>
							</div>
						</div>
					</div>
				</div>

				<div class="control-group" name="skuTable" style="display: none;">
					<label class="control-label"><span class="color-red"></span>商品库存：</label>
					<div class="controls">
						<div class="js-goods-stock control-group"
							style="font-size: 14px; margin-top: 10px;">
							<div id="stock-region" class="sku-group">
								<table class="table-sku-stock"></table>
							</div>
						</div>
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label"><span class="color-red">*</span>总库存：</label>
					<div class="controls">
						<!--  disabled="disabled" -->
						<input type="number" class="span1" id="txtProductCount" min="0" value="0">
						<span class="help-inline">件</span>
						<span class="help-inline" style="display: none; color: red;">请输入总库存数量</span>
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" for="txtMinStockLaram"> <spanclass="color-red">*</span>库存预警：</label>
					<div class="controls">
						<input type="number" class="span1" id="txtMinStockLaram" min="0">
						<span class="help-inline">件</span>
						<span class="help-inline" style="display: none; color: red;">请输入库存预警数</span>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label"><span class="color-red">*</span>商品图：</label>
					<div class="controls">
						<section class="example">
							<div class="gridly">
								<div class="brick small" js-img="1">
									<img id="file_upload_img_1" src="ADMIN_IMG/Default.png" alt="商品图片" />
									<a href="javascript:;" class="close-modal small" title="删除" style="display: none;">×</a>
								</div>
								<div class="brick small" js-img="2">
									<img id="file_upload_img_2" src="ADMIN_IMG/Default.png" alt="商品图片" />
									<a href="javascript:;" class="close-modal small" title="删除" style="display: none;">×</a>
								</div>
								<div class="brick small" js-img="3">
									<img id="file_upload_img_3" src="ADMIN_IMG/Default.png" alt="商品图片" />
									<a href="javascript:;" class="close-modal small" title="删除" style="display: none;">×</a>
								</div>
								<div class="brick small" js-img="4">
									<img id="file_upload_img_4" src="ADMIN_IMG/Default.png" alt="商品图片" />
									<a href="javascript:;" class="close-modal small" title="删除" style="display: none;">×</a>
								</div>
								<div class="brick small" js-img="5">
									<img id="file_upload_img_5" src="ADMIN_IMG/Default.png" alt="商品图片" />
									<a href="javascript:;" class="close-modal small" title="删除" style="display: none;">×</a>
								</div>
							</div>
							<span
								style="display: block; padding: 10px; margin-top: 30px; background: #eee;">必须为商品上传一张图片</span>
						</section>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label"><span class="color-red">*</span>商品描述：</label>
					<div class="controls" id="discripContainer">
						<textarea id="tareaProductDiscrip" name="discripArea" style="height: 500px; width: 800px; display: none;"></textarea>
						<script id="editor" type="text/plain" style="width: 800px; height: 500px;"></script>
						<span class="help-inline" style="display: none; color: red;">请输入商品描述</span>
					</div>
				</div>
			</div>
			<div class="c-box">
				<h3>物流及其他</h3>
				<div class="control-group">
					<label class="control-label"><span class="color-red">*</span>运费：</label>
					<div class="controls">
						<label class="radio inline normal"><input type="radio" name="fare" value="0" checked="checked"> 卖家承担运费</label>
						<label class="radio inline normal"><input type="radio" name="fare" value="1"> 买家承担运费</label>
						<span class="help-inline" style="display: none; color: red;">请选择运费类型</span>
					</div>
				</div>
				<div class="control-group" id="deliveryDiv" style="display: none">
					<label class="control-label"><span class="color-red">*</span>运费设置：</label>
					<div class="controls">
						<select id="deliverySelect">
							<?php if(is_array($shipping_list) || $shipping_list instanceof \think\Collection || $shipping_list instanceof \think\Paginator): if( count($shipping_list)==0 ) : echo "" ;else: foreach($shipping_list as $key=>$shipping): ?>
							<option value="<?php echo $shipping['shipping_fee_id']; ?>"><?php echo $shipping['shipping_fee_name']; ?></option>
							<?php endforeach; endif; else: echo "" ;endif; ?>
						</select>
						<!--  <a target="_blank"
							href="__MODULE__/Dispatching/Transportation?HeadCode=7000&MenuCode=7040">立即添加</a> -->
						<div id="deliveryFeeContainer" style="font-size: 14px;"></div>
						<span class="help-inline" style="display: none; color: red;">请选择运费模板</span>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label"><span class="color-red">*</span>库存显示：</label>
					<div class="controls">
						<label class="radio inline normal"><input type="radio" name="stock" checked="checked" value="1"> 是</label>
						<label class="radio inline normal"><input type="radio" name="stock" value="0"> 否</label>
						<span class="help-inline" style="display: none; color: red;">请选择库存是否显示</span>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="PurchaseSum"><span class="color-red"></span>每人限购：</label>
					<div class="controls">
						<input type="number" class="input-mini" min="0" placeholder="0" id="PurchaseSum" name="PurchaseSum">
						<span class="help-inline">件</span>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label"><span class="color-red">*</span>是否上架：</label>
					<div class="controls">
						<label class="radio inline normal"><input type="radio" name="shelves" value="1" checked="checked"> 立刻上架</label>
						<label class="radio inline normal"><input type="radio" name="shelves" value="0"> 放入仓库</label>
					</div>
				</div>
			</div>
			<div class="c-box">
				<h3>积分购买设置</h3>
				<div class="control-group">
					<label class="control-label"><span class="color-red">*</span>积分设置：</label>
					<div class="controls">
						<select id="integralSelect">
							<option value="0">非积分兑换</option>
							<option value="1">积分兑换</option>
						</select>
						<span class="help-inline" style="display: none; color: red;">请设置积分</span>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="integration_available_use">积分兑换：</label>
					<div class="controls">
						<input id="integration_available_use" name="integration_available_use" class="input-mini" placeholder="0" min="0" type="number" onchange="integrationChange(this);">&nbsp;积分
						<span class="help-inline" style="display: none; color: red;">请设置积分</span>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="integration_available_give">购买可赠送：</label>
					<div class="controls">
						<input id="integration_available_give" name="integration_available_give" class="input-mini" placeholder="0" min="0" type="number" onchange="integrationChange(this);">&nbsp;积分
					</div>
				</div>
			</div>
			<div class="btn-submit">
				<button class="btn btn-info" id="lastPage" onclick="location.href='__MODULE__/goods/selectcategory.html';">上一步</button>
				<button class="btn btn-info" id="btnSave" type="button" onClick="SubmitProductInfo(0,'ADMIN_MAIN','SHOP_MAIN')">保存</button>
				<input type="hidden" id="hidappurl" value="APP_MAIN" />
				<button class="btn btn-info" id="btnSave2" type="button" onClick="SubmitProductInfo(1,'ADMIN_MAIN','SHOP_MAIN')">保存并预览</button>
			</div>
		</form>
	</div>
</div>
<!-- 选择sku时的弹出框 -->
<div class="select2-drop select2-display-none select2-with-searchbox select2-drop-active" id="select2-drop" style="top: 403px; left: 421.875px; width: 180px; display: none;">
	<div class="select2-search">
		<input type="text" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" class="select2-input" maxlength="4">
	</div>
	<ul class="select2-results"></ul>
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
<script type="text/javascript">
	var root = '__ROOT__';
	var img_id_arr = "";//图片标识ID
	var speciFicationsFlag = 0;// 0：商品图的选择，1：规格的图片选择,2:商品详情的图片
	var speciFicationsImgCid = -1;//规格图片Id，动态控制规格图片的变化
	var speciFicationsLength = 0;// 保存图片数量
	var speciFlcationsImgSrc = new Array();//保存图片路径
	var speciFlcationsImgIdList = new Array();//图片Id
	var IsShowImg = false;// 是否添加规格图片，checkbox
	var atomIdArr = new Array();//第一个规格的图片ID
	var FirstImgId = -1;//第一个规格的ID
	var obj = null;//图片对象，用于加载图片
	var shopImageFlag = -1;//所点击的商品图片标识
	var goodsFigure = null;//商品图对象
	// 实例化编辑器，建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
	var ue = UE.getEditor('editor');
	$('.gridly').gridly({
		base : 60, // px 
		gutter : -20, // px
		columns : 12
	});
	initProvince("#provinceSelect");
	function PopUpCallBack(idlist, srclist) {
		var idArr, srcArr;
		if (idlist.indexOf(",")) {
			idArr = idlist.split(',');
			srcArr = srclist.split(',');
		} else {
			idArr = idlist;
			srcArr = srclist;
		}
		if (speciFicationsFlag == 0) {
			$("#file_upload_img_" + shopImageFlag).attr("src", srcArr);
			$("#file_upload_img_" + shopImageFlag).attr("data-id", idArr);
			$(goodsFigure).children("a").show();
		} else if (speciFicationsFlag == 1) {
			//判断当前下标是否存在，不存在进行添加，否则进行修改
			var str = '<a href="javascript:;" class="close-modal small "title="删除">×</a> ';
			str += '<img src="' + srcArr
					+ '" cid="spec_img_'
					+ speciFicationsImgCid
					+ '" style="width:84px;height:84px;" index="'+speciFicationsImgCid+'" />';
			str += '<span>替换</span>';
			$(obj).html(str);
			//alert(speciFlcationsImgSrc[speciFicationsImgCid]);
			if (speciFlcationsImgSrc[speciFicationsImgCid] == null) {
				speciFlcationsImgSrc.push(srcArr);
				speciFlcationsImgIdList.push(idlist);
			} else {
				speciFlcationsImgSrc[speciFicationsImgCid] = srcArr;
				speciFlcationsImgIdList[speciFicationsImgCid] = idlist;
			}
		} else if (speciFicationsFlag == 2) {
			for (var i = 0; i < srcArr.length; i++) {
				var description = "<img src='"+srcArr[i]+"' />";
				ue.setContent(description, true);
			}
		}
	}
	function setGoodsFigure(goodsFigure) {
		this.goodsFigure = goodsFigure;
	}

	//设置当前图片（SKU图片，商品规格）
	function setObject(obj) {
		this.obj = obj;
	}
	//设置商品详情的图片
	function setUeditorImg() {
		speciFicationsFlag = 2;
		OpenPricureDialog("PopPicure", ADMINMAIN, 5);
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