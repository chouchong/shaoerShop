<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:44:"template/wap\b2c\\Order\PaymentOrderNew.html";i:1495866256;s:26:"template/wap\b2c\base.html";i:1495866256;}*/ ?>
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

<link rel="stylesheet" type="text/css" href="__TEMP__/<?php echo $style; ?>/public/css/order.css">
<link rel="stylesheet" type="text/css" href="__TEMP__/<?php echo $style; ?>/public/css/pro-detail.css">
<link rel="stylesheet" type="text/css" href="__TEMP__/<?php echo $style; ?>/public/css/payment_order_new.css">
<link rel="stylesheet" type="text/css" href="__TEMP__/<?php echo $style; ?>/public/css/payment_order_popup.css">

</head>
<body class="body-gray">
	
<section class="head">
	<a class="head_back" href="APP_MAIN"><i class="icon-back"></i></a>
	<div class="head-title">订单结算</div>
</section>

	<div class="motify" style="display: none;"><div class="motify-inner">弹出框提示</div></div>
	
<input type="hidden" id="goodslist" value="<?php echo $goods_sku_list; ?>">
<div class="h50"></div>
<div>
	<?php if($address_default['id'] != ''): ?>
	<div id="addressok" onload="opener.location.reload()">
		<input type="hidden" id="addressid" value="<?php echo $address_default['id']; ?>">
		<div class="js-order-address express-panel js-edit-address express-panel-edit">
			<ul class="express-detail">
				<a href="APP_MAIN/Member/memberAddress.html?url=cart">
					<li class="clearfix">
						<span class="name">收货人：<?php echo $address_default['consigner']; ?></span>
						<span class="tel"><?php echo $address_default['mobile']; ?></span>
					</li>
					<li class="address-detail">收货地址：<?php echo $address_default['address_info']; ?>-<?php echo $address_default['address']; ?></li>
				</a>
			</ul>
		</div>
	</div>
	<?php else: ?>
	<div class="empty-address-tip">
		<div id="noaddress"><a href="APP_MAIN/Member/memberAddress.html">新增收货地址</a></div>
	</div>
	<?php endif; ?>
	<div class="block-item express" style="padding: 0;"></div>
	<section class="cart-prolist">
		<div class="header">
			<a href="#"><?php echo $shopname; ?></a>
		</div>
		<?php if(is_array($itemlist) || $itemlist instanceof \think\Collection || $itemlist instanceof \think\Paginator): if( count($itemlist)==0 ) : echo "" ;else: foreach($itemlist as $key=>$list): ?>
		<div class="order-goods-item clearfix">
			<div class="name-card block-item">
				<a href="APP_MAIN/goods/goodsDetail?id=<?php echo $list['goods_id']; ?>" class="thumb">
					<img src="__ROOT__/<?php echo $list['picture_info']['pic_cover_micro']; ?>" alt="<?php echo $list['goods_name']; ?>" />
				</a>
				<div class="detail">
					<div class="clearfix detail-row">
						<div class="right-col">
							<input type="hidden" name="goods_skuid" value="<?php echo $list['sku_id']; ?>">
							<input type="hidden" name="goods_point_exchange"/>
							￥<span><?php echo $list['price']; if($list['point_exchange_type']==1): if($list['point_exchange']>0): ?>
									+<?php echo $list['point_exchange']; ?>积分
								<?php endif; endif; ?>
							</span>
						</div>
						<div class="left-col">
							<h3>
								<a href="javascript:;"><?php echo $list['goods_name']; ?></a>
							</h3>
						</div>
					</div>
					<div class="clearfix detail-row">
						<div class="right-col">
							<div class=" c-gray-darker">
								×<span><?php echo $list['num']; ?></span>
							</div>
						</div>
						<div class="left-col">
							<p class="c-gray-darker"><?php if($list['sku_name'] != '0'): ?><?php echo $list['sku_name']; endif; ?></p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php endforeach; endif; else: echo "" ;endif; ?>
		<div>
			<div id="express_method">
				<div>配送方式</div>
				<div>
					<a class="active" href="javascript:void(0);" value="1">快递发货</a>
<!-- 					<i class="right-arrow"></i> -->
				</div>
			</div>
			<div class="remarks">
				<div>买家留言：</div>
				<textarea id="leavemessage" placeholder="给卖家留言"></textarea>
			</div>
		</div>
		<!-- 此处删除部分信息 -->
		<div class="total">
			<span class="float_left">商品合计：</span>
			<i style="color: red; font-size: 15px;">￥</i>
			<span id="orderprice" class="total-price"><?php echo $count_money; ?></span>
		</div>
		
		<?php if($count_point_exchange>0): ?>
			<div class="total">
				<span class="float_left">可用积分：<span style="color: gray;" ><?php echo $member_account['point']; ?></span></span>
				<span class="total-price" data-point="<?php echo $count_point_exchange; ?>" id="count_point_exchange"><?php echo $count_point_exchange; ?>积分</span>
			</div>
		<?php endif; ?>
	
		 <div class="total">
			<span class="float_left">可用余额：<span style="color: gray;" >￥<?php echo $member_account['balance']; ?></span></span>
			<span>
				使用<input type="text" id="member_balance" data-max="<?php echo $member_account['balance']; ?>" placeholder="0"  />元<!-- onchange="calculate_youhui()" -->
			</span>
		</div>
		<div class="total">
			<span class="float_left">优惠券：</span>
			<span id="use_coupon" val="-1" money="0">不使用优惠券</span>
		</div>
		<div class="remarks">
			<input type="hidden" id="favorable" value="0">
			<input type="hidden" id="input_discount_money" value="<?php echo $discount_money; ?>">
			<p>商品金额<span class="float_right" id="goods_total_money" money="<?php echo $count_money; ?>">￥<?php echo $count_money; ?></span></p>
			<p>
				运费<span id="feeprice" money="<?php echo $express; ?>" class="float_right">￥<?php echo $express; ?></span>
				<input type="hidden" id="is_calculate_express" value="<?php echo $is_calculate_express; ?>">
				<input type="hidden" id="res_message" value="<?php echo $res_message; ?>">
			</p>
			<p>
				总优惠<span class="float_right" id="discount_money">￥<?php echo $discount_money; ?></span>
			</p>
		</div>
	</section>
	<div style="height: 50px"></div>
	<div class="order-total-pay bottom-fix">
		<div class="pay-container clearfix">
			<span class="c-gray-darker font-size-16">合计：</span>
			<span class="font-size-16 theme-price-color" id="realprice">￥0.00</span>
<!-- 			<span class="font-size-12 theme-price-color" id="realprice-decimal">00</span> -->
			<?php if($count_point_exchange>0): ?>
			<span class="font-size-16 theme-price-color" id="count-point">+<?php echo $count_point_exchange; ?>积分</span>
			<?php endif; ?>
			<input type="hidden" value="<?php echo $count_point_exchange; ?>" id="hidden_use_integration" />
			<button class="commit-bill-btn" onclick="submitOrder(this)">提交订单</button>
		</div>
	</div>
	<!--需要微信支付，显示下面按钮 end-->
	<section class="s-btn" style="display: none;">
		<button onclick="window.open(&#39;product-order.html&#39;)">去结算</button>
		<!--按钮不可用加样式“disable”-->
	</section>

	<div id="mask-layer"></div>
	<div id="popup-preferential" class="coupon-popup">
		<div class="js-scene-coupon-list">
			<div class="header">
				选择优惠<span class="js-close close"></span>
			</div>
			<div class="block block-list border-0">
				<ul class="js-coupon-list coupon-list">
					<li class="block-item coupon-item active">
						<div class="label-check-img" style="top:9px;"></div>
						<div class="coupon-info" style="line-height: 30px;height: 30px;">
							<a href="javascript:;" onclick="useCoupon(this,-1)">不使用优惠卷</a>
						</div>
					</li>
					<?php if(is_array($coupon_list) || $coupon_list instanceof \think\Collection || $coupon_list instanceof \think\Paginator): $i = 0; $__LIST__ = $coupon_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$coupon): $mod = ($i % 2 );++$i;?>
					<li class="block-item coupon-item ">
						<div class="label-check-img"></div>
						<div class="coupon-info">
							<a href="javascript:;" onclick="useCoupon(this,<?php echo $coupon['coupon_id']; ?>,&#39;<?php echo $coupon['coupon_code']; ?>&#39;,<?php echo $coupon['money']; ?>)">
								<p class="font-size-12"><?php echo $coupon['coupon_code']; ?><em class="pull-right"><?php echo $coupon['money']; ?>元</em></p>
								<p class="font-size-12 c-gray-darker">下单立减<?php echo $coupon['money']; ?>元</p>
							</a>
						</div>
					</li>
					<?php endforeach; endif; else: echo "" ;endif; ?>
				</ul>
			</div>
		</div>
		<div class="coupon-action-container">
			<button class="btn-green" style="margin: 0px;">确定</button>
		</div>
	</div>
</div>

	
	
	<!-- 加载弹出层 -->
	<div class="mask-layer-loading">
		<img src="__TEMP__/<?php echo $style; ?>/public/images/mask_load.gif"/>
		<!-- <i class="fa fa-spinner fa-pulse"></i> -->
	</div>
	
<script type="text/javascript" src="__TEMP__/<?php echo $style; ?>/public/js/payment_order.js"></script>
<script type="text/javascript">
var __IMG__ = '__TEMP__/<?php echo $style; ?>/public/images';
</script>

</body>
</html>