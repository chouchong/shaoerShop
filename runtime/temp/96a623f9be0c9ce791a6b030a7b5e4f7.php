<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:44:"template/wap\b2c\\Member\memberIndexB2C.html";i:1495866256;s:26:"template/wap\b2c\base.html";i:1495866256;}*/ ?>
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

<link rel="stylesheet" type="text/css" href="__TEMP__/<?php echo $style; ?>/public/css/member_index.css">
<style>
.head{
	border-bottom:0;
}
.panel.memberhead{
	background:url(__TEMP__/<?php echo $style; ?>/public/images/shoptop.png);
	background-size:100% 100%; 
}
.member{
	    width: 64%;
    float: right;
    margin-top: 26px;
	color:#fff;
}
.img{
	width:100%;
    margin: 5px 0;
}
.code{
    background: #fff;
	overflow: hidden;
}
.rec{
	height: 17px;
    /* margin: 5px 10px; */
    padding: 10px 20px;
	border-bottom: 1px solid #E2E1E1;
	line-height:17px;
}

.module-icon.memberCoupon {
    background:url(__TEMP__/<?php echo $style; ?>/public/images/Coupon.png) no-repeat;
	width: 22px;
    height: 22px;
	float: left;
    margin-top: 9px;
	    margin-right: 10px;
    display: inline-block;
	background-size:100% 100%;
}
.member-info{
	background: rgba(255,79,79, 0.8);
	float:left;
	width:33%;
	color: #fff;
	text-align: center;
	line-height:41px;
}
.vertical-bar{
	border-left: 1px solid rgba(250,250,250,0.6);
	height: 32px;
	vertical-align: middle;
	display: inline-block;
	margin-top:5px;
}
.namer{
    position: absolute;
    left: 103px;
    top: 30px;
}
.signin{
	position: absolute;
    left: 100px;
    top: 55px;
    border-radius: 3px;
    font-size: 10px;
    line-height: 14px;
    padding: 1px 5px;
}
.no{
	color: yellow;
	border: 1px solid yellow;
}
.yes{
	color: #fff;
	border: 1px solid #fff;
}
</style>
  
</head>
<body class="body-gray">
	
	<div class="motify" style="display: none;"><div class="motify-inner">弹出框提示</div></div>
	
<!--  <section class="head" style="background:#222;">
		<a class="head_back" onclick="window.history.go(-1)" href="javascript:void(0)" style="width:60px;"><i class="icon-back" style="color:#fff;margin-right:10px;"></i><span style="font-size:15px;color:#fff;">返回</span></a>
		<div class="head-title" style="color:#fff;">店铺中心</div>
	</section> -->
<div class="panel memberhead">
	<div class="member_head">
		<a href="APP_MAIN/Member/personalData.html?shop_id=<?php echo $shop_id; ?>">
			<p style="float:left;margin: 20px 0 20px 20px;position:relative;">
				<i>
				<?php if($member_img == '0'): ?>
					<img src="__TEMP__/<?php echo $style; ?>/public/images/member_default.png"/>
				<?php else: ?>
					<img src="__UPLOAD__/<?php echo $member_img; ?>" />
				<?php endif; ?>
				</i>
			</p>
			<p class="member" style="text-align:left;margin-right: 20px;margin-top: 40px;">
				<img src="__TEMP__/<?php echo $style; ?>/public/images/edit.png" style="float:right;width:20px; margin: 0 10px 0 0;">
				<span class="namer" style="font-size:14px;"><!-- 会员名： --><?php echo $member_info["user_info"]['nick_name']; ?></span>
				
			</p>
		</a>
		<?php if($isSign == 0): ?>
		<span class="signin no" onclick="signIn();">签到</span>
		<?php else: ?>
		<span class="signin yes">已签到</span>
		<?php endif; ?>
		<div style="overflow: hidden;width: 100%;">
			<a href='APP_MAIN/member/balancewater.html?shop_id=<?php echo $shop_id; ?>' class="member-info" style="width:49.5%;">
				<span >余额&nbsp;</span><span ><?php echo $member_info['balance']; ?></span>
			</a>
			<!-- <a href='APP_MAIN/member/coinwater?shop_id=<?php echo $shop_id; ?>' class="member-info" >
				<span >购物币&nbsp;</span><span >{1$member_info['coin']}</span>
			</a> -->
			<i class="vertical-bar"></i>
			<a href='APP_MAIN/member/integralwater.html?shop_id=<?php echo $shop_id; ?>' class="member-info" style="float:right;width:49.5%;"><span >积分&nbsp;</span><span ><?php echo $member_info['point']; ?></span></a>
		 </div>
	</div>
</div>
<div class="control">
	<div class="control_l">
		<span class="control_l_content">全部订单</span>
	</div>
	<div class="control_r"><a href="APP_MAIN/Order/myOrderList.html?shop_id=<?php echo $shop_id; ?>" class="right_href">查看全部订单</a></div>
</div>

<div class="panel member-nav" >
	<ul class="fu clear" >
		<li class="last" >
			<a href="APP_MAIN/Order/myOrderList.html?status=0&shop_id=<?php echo $shop_id; ?>">
				<img src="__TEMP__/<?php echo $style; ?>/public/images/pay.png">
				<p>待付款</p>
			</a>
		</li>
		<li class="last">
			<a href="APP_MAIN/Order/myOrderList.html?status=1&shop_id=<?php echo $shop_id; ?>">
				<img src="__TEMP__/<?php echo $style; ?>/public/images/send.png">
				<p>待发货</p>
			</a>
		</li>
		<li class="last">
			<a href="APP_MAIN/Order/myOrderList.html?status=2&shop_id=<?php echo $shop_id; ?>">
				<img src="__TEMP__/<?php echo $style; ?>/public/images/recieve.png">
				<p>待收货</p>
			</a>
		</li>
		<li class="last">
			<a href="APP_MAIN/Order/myOrderList.html?status=3&shop_id=<?php echo $shop_id; ?>">
				<img src="__TEMP__/<?php echo $style; ?>/public/images/recieved.png">
				<p>已收货</p>
			</a>
		</li>
		<li class="last">
			<a href="APP_MAIN/Order/myOrderList.html?status=4&shop_id=<?php echo $shop_id; ?>">
				<img src="__TEMP__/<?php echo $style; ?>/public/images/reback.png"/>
				<p>退款/售后</p>
			</a>
		</li>
	</ul>
</div>

<div class='member_list'>
<?php if(is_array($menu_arr) || $menu_arr instanceof \think\Collection || $menu_arr instanceof \think\Paginator): $i = 0; $__LIST__ = $menu_arr;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$arr_item): $mod = ($i % 2 );++$i;?>
	<ul>
		<?php if(is_array($arr_item) || $arr_item instanceof \think\Collection || $arr_item instanceof \think\Paginator): $i = 0; $__LIST__ = $arr_item;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
		<li>
			<a href="APP_MAIN/<?php echo $vo['url']; ?>">
				<i class=" module-icon <?php echo $vo['class']; ?>" ></i>
				<span ><?php echo $vo['title']; ?></span>
				<span class='jiantou'></span>
			</a>
		</li>
		<?php endforeach; endif; else: echo "" ;endif; ?> 
	</ul>
<?php endforeach; endif; else: echo "" ;endif; ?>
</div>

<!--distribution contact us end-->
<script type="text/javascript">
$(function(){
	buttomActive('#bottom_member');
})	
function signIn(){
	$.ajax({
		type : "post",
		url : "APP_MAIN/member/signIn",
		data : {
			"sign" : true
		},
		success : function(data){
			if(data['code']>0){
				location.reload();
			}
		}
	})
}
</script>

	
	<div class="fixed bottom">
		<div class="distribution-tip" id="distribution-tip" style="display: none;"></div>
		<dl class="sub-nav nav-b5">
			<dd id="buttom_home">
				<a href="APP_MAIN">
					<div class="nav-b5-relative">
						<img src="__TEMP__/<?php echo $style; ?>/public/images/home_check.png"/>
						<span>首页</span>
						<!--<i class="fa fa-home fa-2x"></i> -->
					</div>
				</a>
			</dd>
			<dd id="buttom_classify">
				<a href="APP_MAIN/goods/goodsClassificationList.html">
					<div class="nav-b5-relative">
						<img src="__TEMP__/<?php echo $style; ?>/public/images/classify_uncheck.png"/>
						<span>分类</span>
<!-- 						<i class="fa fa-list-ul fa-2x"></i>分类 -->
					</div>
				</a>
			</dd>
			<!-- <dd id="buttom_stroe" >
				<a href="APP_MAIN/goods/brandlist">
					<div class="nav-b5-relative">
						<img src="__TEMP__/<?php echo $style; ?>/public/images/store_uncheck.png"/>
						<span>品牌街</span>
					</div>
				</a>
			</dd> -->
			<dd id="bottom_cart" >
				<a href="APP_MAIN/goods/cart.html">
					<div class="nav-b5-relative">
						<img src="__TEMP__/<?php echo $style; ?>/public/images/cart_uncheck.png"/>
						<span>购物车</span>
<!-- 						<i class="fa fa-shopping-cart fa-2x"></i>购物车 -->
					</div>
				</a>
			</dd>
			<dd id="bottom_member" >
				<a href="APP_MAIN/Member/index.html">
					<div class="nav-b5-relative">
						<img src="__TEMP__/<?php echo $style; ?>/public/images/user_uncheck.png"/>
						<span>会员中心</span>
<!-- 						<i class="fa fa-user-circle fa-2x"></i>会员中心 -->
					</div>
				</a>
			</dd>
		</dl>
	</div>
	
	
	<!-- 加载弹出层 -->
	<div class="mask-layer-loading">
		<img src="__TEMP__/<?php echo $style; ?>/public/images/mask_load.gif"/>
		<!-- <i class="fa fa-spinner fa-pulse"></i> -->
	</div>
	
</body>
</html>