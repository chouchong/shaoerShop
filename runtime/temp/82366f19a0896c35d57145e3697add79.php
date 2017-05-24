<?php if (!defined('THINK_PATH')) exit(); /*a:8:{s:33:"template/wap\b2c\Index\index.html";i:1495426982;s:26:"template/wap\b2c\base.html";i:1495427102;s:27:"template/wap\b2c\share.html";i:1494503663;s:41:"template/wap\b2c\Index\controlSearch.html";i:1493284251;s:40:"template/wap\b2c\Index\controlSlide.html";i:1495425994;s:41:"template/wap\b2c\Index\controlNotice.html";i:1495182036;s:38:"template/wap\b2c\Index\controlNav.html";i:1494985028;s:43:"template/wap\b2c\Index\controlDiscount.html";i:1494985017;}*/ ?>
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

<link rel="stylesheet" type="text/css" href="__TEMP__/<?php echo $style; ?>/public/css/control_type.css">
<link rel="stylesheet" type="text/css" href="__TEMP__/<?php echo $style; ?>/public/css/goods_list.css">
<link rel="stylesheet" type="text/css" href="__TEMP__/<?php echo $style; ?>/public/css/group_buy.css">
<style type="text/css">
.custom-search-button{top: 1px;}
.sliding {overflow-y: auto;background: #ffffff;}
.sliding::-webkit-scrollbar {display: none;}
.sliding ul {white-space: nowrap;text-align: center;}
.sliding ul li {padding: 10px 10px 0 10px;display: inline-block;background: #ffffff;border-right: 2px solid #f8f8f8;width:25%;}
.sliding ul li img{width:60px;height:60px;}
.members_goodspic{border-bottom:1px solid #f3f3f3;}
.info p.goods-title{padding-top:10px;}
.info p.goods-price{margin:0;margin-bottom:8px;}
.controltype{height:35px;margin:0;width:100%;line-height:32.5px;}
.controltype>.control_l_content{top:0;background: none;}
.info p.goods-price>em{font-size:12px;font-weight:bold;color:#f23030;}
.popup{
	    background: none;
		padding:0;
}
.code{
	
    width: 60%;
    margin: 0 auto;
    background: #fff;
    border-radius: 13px;
}
</style>

</head>
<body class="body-gray">
	
<!-- 标识：是否显示顶部关注  0：[隐藏]，1：[显示]-->
<?php if($is_subscribe == 1): ?>
<div class="fixed-focus-on">
	<i class="close" onclick="$('.fixed-focus-on').hide();">x</i>
	<div class="foucs-on-block">
		<?php if($source_img_url != ''): ?>
		<img class="user-bg" src="<?php echo $source_img_url; ?>">
		<?php else: ?>
		<img class="user-bg" src="__TEMP__/<?php echo $style; ?>/public/images/default/default_shop_avatar.png">
		<?php endif; if($source_user_name != ''): ?>
		<p>我是你的好友<span><?php echo $source_user_name; ?></span>,推荐给您让生意从此做好</p>
		<?php else: ?>
		<p>您当前还未关注微信公众账号，请点击关注</p>
		<?php endif; ?>
		<button id="subscribe">点击关注</button>
	</div>
</div>
<?php endif; ?>


<!-- 遮罩层 -->
	<div class="shade" style="position:fixed;top:0px;left:0px;width:100%;height:100%;margin-top:0;background: rgba(0, 0, 0, 0.7);z-index: 999;display:none;"><span style="float: right; padding: 15px;font-size: 22px;color: #fff;" id="close">X</span></div>
<!-- 弹出层 --> 
	<div class="popup" style="position:fixed;top: 36%;left: 0px;width: 100%;height: 100%;margin-left:0px;display:none;">
		
		<div class="code">
			<div style="overflow: hidden;">
			   <img src="__ROOT__/<?php echo $web_info['web_qrcode']; ?>"  style="max-width: 100%;margin-top: 10px;"/>
			   <div style="color:#666; margin-bottom: 10px;">长按二维码关注公众微信</div>
			</div>
		</div>
	</div>




	<div class="motify" style="display: none;"><div class="motify-inner">弹出框提示</div></div>
	
<script language="javascript" src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js"> </script>
<input type="hidden" id="appId" value="<?php echo $signPackage['appId']; ?>">
<input type="hidden" id="jsTimesTamp" value="<?php echo $signPackage['jsTimesTamp']; ?>">
<input type="hidden" id="jsNonceStr"  value="<?php echo $signPackage['jsNonceStr']; ?>">
<input type="hidden" id="jsSignature" value="<?php echo $signPackage['jsSignature']; ?>">

<div class="com-content">

<!-- 搜索 -->
<div style="width: 100%;background-color: #fff;padding: 10px 0px;">
	
<script src="__TEMP__/<?php echo $style; ?>/public/js/public_assembly.js"></script>
<div class="editing">
	<div class="control-group">
		<div class="custom-search" >
			<!-- <form action="" method="GET"> -->
				<input type="text" class="custom-search-input" placeholder="搜索商品" value='' style="background:#f4f4f4;border:none;border-radius:0;">
				<button type="button" class="custom-search-button">搜索</button>
				<input type="hidden" class="shopid" value="<?php echo $shop_id; ?>" name="shop_id"/>
			<!-- </form> -->
		</div>
		<div class="component-border"></div>
	</div>
	<div class="sort">
		<i class="sort-handler"></i>
	</div>
</div>
	<style>.custom-search-button{top:0;}</style>
</div>
<!-- 轮播图 -->
<link rel="stylesheet" type="text/css" href="__TEMP__/<?php echo $style; ?>/public/css/slick.css">
<link rel="stylesheet" type="text/css" href="__TEMP__/<?php echo $style; ?>/public/css/components.css">
<script src="__TEMP__/<?php echo $style; ?>/public/js/slick.js"></script>
<div class="slick">
<?php if(is_array($plat_adv_list['adv_list']) || $plat_adv_list['adv_list'] instanceof \think\Collection || $plat_adv_list['adv_list'] instanceof \think\Paginator): if( count($plat_adv_list['adv_list'])==0 ) : echo "" ;else: foreach($plat_adv_list['adv_list'] as $key=>$v): ?>
    <div style="display:block;text-align:center;width:100%;height:<?php echo $plat_adv_list['ap_height']; ?>px;line-height:<?php echo $plat_adv_list['ap_height']; ?>px;">
    	<a href="<?php echo $v['adv_url']; ?>">
    		<img src="__UPLOAD__/<?php echo $v['adv_image']; ?>" alt="" style="height:175px;max-width:100%/* ;height:auto; */display: inline-block !important;vertical-align: middle !important;">
    	</a>
	</div>
<?php endforeach; endif; else: echo "" ;endif; ?>
</div>
<script>
$('.slick').slick({
	slidesToShow: 1,
	slidesToScroll: 1,
	autoplay: true,
	arrows:false,
	autoplaySpeed: 2000,
});
</script>

<!-- 公告 -->
<script src="__TEMP__/<?php echo $style; ?>/public/js/rollSlide.js"></script>
<style>
.hot {
	width: 100%;
	height: 40px;
	background: #FFF;
	border-bottom: 1px solid #eee;
}

.hot .notice-img {
	float: left;
	width: 40px;
	height: 40px;
	margin: 2px 20px;
	position: relative;
}

.hot .notice-img img {
	display: block;
	height: 27px;
	width: 27px;
	margin:4px;
}

.hot .notice-img:after {
	content: '';
	display: block;
	width: 1px;
	height: 44px;
	background-color: #eee;
	position: absolute;
	right: -20px;
	top: 0;
}

.hot ul {
	position: absolute;
	left: 95px;
	top: 0px;
	overflow: hidden;
}

.hot ul li {
	width: 100%;
	height: 60px;
	float: left;
	line-height: 60px;
}

.hot ul li .hot-message {
	display: block;
	width: 80%;
	float: left;
	margin-left: 2%;
	height: 50px;
	margin-top: 10px;
}

.hot ul li .hot-message a {
	display: block;
	padding-left: 10px;
	height: 25px;
	overflow: hidden;
	/* font-size: 0.6rem; */
	font-size:14px;
	line-height: 25px;
	color: #666;
	-webkit-line-clamp: 1;
	-webkit-box-orient: vertical;
	display: -webkit-box;
	position: relative;
}
</style>

<script type="text/javascript">
$(function(){
	$('.hot').rollSlide({
		orientation: 'top',
		num: 1,
		v: 1500,
		//space: 500,
		isRoll: true
	});
});
</script>
<div class="hot" style="position: relative; overflow: hidden;">
	<div class="notice-img">
		<a href="javascript:;"><img src="__TEMP__/<?php echo $style; ?>/public/images/ad.png"></a>
	</div>
	
	<ul class="roll__list">
	<?php if(is_array($notice_arr) || $notice_arr instanceof \think\Collection || $notice_arr instanceof \think\Paginator): if( count($notice_arr)==0 ) : echo "" ;else: foreach($notice_arr as $k=>$notice): ?>
		<li>
			<div class="hot-message">
				<a href="javascript:;"><?php echo $notice; ?></a>
			</div>
		</li>
	<?php endforeach; endif; else: echo "" ;endif; ?>
	</ul>
</div>
<!-- 导航 -->
<link rel="stylesheet" type="text/css" href="__TEMP__/<?php echo $style; ?>/public/css/navi.css">
<div class="navi">
	<div class="navi-item">
		<nav class="navi-item_row">
			<a href="APP_MAIN">
				<span>
					<img src="__TEMP__/<?php echo $style; ?>/public/images/navimg/platform_nav_home1.png"><span>首页</span>
				</span>
			</a>
			<a href="APP_MAIN/goods/integralcenter.html">
				<span>
					<img src="__TEMP__/<?php echo $style; ?>/public/images/navimg/platform_nav_category1.png"><span>积分中心</span>
				</span>
			</a>
			<a href="APP_MAIN/index/discount.html">
				<span>
					<img src="__TEMP__/<?php echo $style; ?>/public/images/navimg/platform_nav_limit1.png"><span>限时折扣</span>
				</span>
			</a>
			<a href="APP_MAIN/goods/brandlist.html">
				<span>
					<img src="__TEMP__/<?php echo $style; ?>/public/images/navimg/platform_nav_joins1.png"><span>品牌专区</span>
				</span>
			</a>
			<a href="APP_MAIN/Member/index.html">
				<span>
					<img src="__TEMP__/<?php echo $style; ?>/public/images/navimg/platform_nav_member1.png"><span>会员中心</span>
				</span>
			</a>
			
		</nav>
	</div>
</div>




<!-- 品牌专区 -->


<!-- 限时折扣 -->


<!-- 促销模块 -->
<?php if(is_array($class_list) || $class_list instanceof \think\Collection || $class_list instanceof \think\Paginator): if( count($class_list)==0 ) : echo "" ;else: foreach($class_list as $key=>$class): if($class['class_name']=='新品上市'): ?>
	<div class="controltype">
		<!-- <img src="__TEMP__/<?php echo $style; ?>/public/images/newproduct.png"/> -->
		<!-- <span class="control_l_content" style="color:#FF4449;"><?php echo $class['class_name']; ?></span> -->
		<img src="__TEMP__/<?php echo $style; ?>/public/images/navimg/new_arrival.png">
	</div>
	<section class="members_goodspic">
		<ul>
			<?php if(is_array($class['goods_list']) || $class['goods_list'] instanceof \think\Collection || $class['goods_list'] instanceof \think\Paginator): if( count($class['goods_list'])==0 ) : echo "" ;else: foreach($class['goods_list'] as $k=>$goods): if($k<4): if($k%2==0): ?>
				<li class="gooditem" style="margin-bottom:1px;margin-left:0;margin-top:0;margin-right:0;border-right:1px solid #F3F3F3;width:49%;height:80px;padding:10px 0;" onclick='location.href="APP_MAIN/Goods/goodsDetail.html?id=<?php echo $goods['goods_info']['goods_id']; ?>"'>
				<?php else: ?>
				<li class="gooditem" style="margin-bottom:1px;margin-left:0;margin-top:0;margin-right:0;width:50%;height:80px;padding:10px 0;" onclick='location.href="APP_MAIN/Goods/goodsDetail.html?id=<?php echo $goods['goods_info']['goods_id']; ?>"'>
				<?php endif; ?>
				<div class="img" style="float:right;width:50%;height: initial;">
					<a href="APP_MAIN/Goods/goodsDetail.html?id=<?php echo $goods['goods_info']['goods_id']; ?>">
						<img class="lazy" src="__UPLOAD__/<?php echo $goods['picture_info']['pic_cover_small']; ?>" style="width: 80px;">
				</a>
				</div>
				<div class="info">
					<p class="goods-title"><a href="APP_MAIN/Goods/goodsDetail.html?id=<?php echo $goods['goods_info']['goods_id']; ?>"><?php echo $goods['goods_info']['goods_name']; ?></a></p>
					<p class="goods-price"><em>￥<?php echo $goods['goods_info']['promotion_price']; ?></em></p>
					
				</div>
			</li>
			<?php endif; endforeach; endif; else: echo "" ;endif; ?>
		</ul>
	</section>
	<div class="sliding">
		<ul id="slider">
			<?php if(is_array($class['goods_list']) || $class['goods_list'] instanceof \think\Collection || $class['goods_list'] instanceof \think\Paginator): if( count($class['goods_list'])==0 ) : echo "" ;else: foreach($class['goods_list'] as $k=>$goods): ?>
			<li>
				<a href="APP_MAIN/Goods/goodsDetail.html?id=<?php echo $goods['goods_info']['goods_id']; ?>">
					<img class="lazy" src="__UPLOAD__/<?php echo $goods['picture_info']['pic_cover_small']; ?>" >
				</a>
				<p class="goods-title" style="width:95px;overflow:hidden;"><a href="APP_MAIN/Goods/goodsDetail.html?id=<?php echo $goods['goods_info']['goods_id']; ?>"><?php echo $goods['goods_info']['goods_name']; ?></a></p>
				<p class="goods-price"><em style="color:red;font-size:12px;font-weight:bold;">￥<?php echo $goods['goods_info']['promotion_price']; ?></em></p>
			</li>
			<?php endforeach; endif; else: echo "" ;endif; ?>
		</ul>
	</div>
	<?php endif; endforeach; endif; else: echo "" ;endif; ?>
<!-- 限时折扣 -->
<?php if(count($discount_list) >0): ?>
<style type="text/css">
.group-list{overflow: hidden;}
.group-list-box .group-list li:nth-child(2n+1) {margin-left: 0px;}
.group-list-box{width:100%;margin:0 auto;float: none;overflow-y: hidden;}
.group-list-box .group-list li{width:49%;float:left;margin-left:1%;padding:0px;margin-bottom: 3px;}
.brand-info .brand-info-left .b-price p{
	color:#f23030;
	font-weight:bold;
	font-size:12px;
}
.buyer{
	font-size:12px;
}
</style>
<div class="slick">
	<a href="<?php echo $discount_adv['adv_list'][0]['adv_url']; ?>">
		<img src="__UPLOAD__/<?php echo $discount_adv['adv_list'][0]['adv_image']; ?>" >
		<!-- style="height:<?php echo $discount_adv['ap_height']; ?>px;" -->
	</a>
</div>

<div class="controltype" >
	<!-- <img src="__TEMP__/<?php echo $style; ?>/public/images/limit_top.png"/> -->
	<!-- <span class="control_l_content"><a href="APP_MAIN/index/discount" style="color:#6927FF;">限时折扣</a></span> -->
	<a href="APP_MAIN/index/discount.html" style="color:#6927FF;"><img src="__TEMP__/<?php echo $style; ?>/public/images/navimg/display_discount.png"></a>
</div>
<div class="group-list-box">
	<ul class="group-list">
	<?php if(is_array($discount_list) || $discount_list instanceof \think\Collection || $discount_list instanceof \think\Paginator): $i = 0; $__LIST__ = $discount_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
		<li>
			<!-- <span class="brand-name"><?php echo $vo['goods_name']; ?></span> -->
			<div class="p-img">
				<a href="APP_MAIN/goods/goodsDetail.html?id=<?php echo $vo['goods_id']; ?>" title="<?php echo $vo['goods_name']; ?>">
				    <img src="__UPLOAD__/<?php echo $vo['picture']['pic_cover']; ?>" style="height:170px;">
				<div class="brand-time" >
					<i></i>
					<span class="settime" starttime="<?php echo $vo['start_time']; ?>" endtime="<?php echo $vo['end_time']; ?>" ></span>
				</div>
				</a>
				 <!-- <div class="p_discount"><?php echo $vo['discount']; ?>折</div> -->
			</div>
			<a href="APP_MAIN/goods/goodsDetail.html?id=<?php echo $vo['goods_id']; ?>" title="<?php echo $vo['goods_name']; ?>"><div class="brand-name"><?php echo $vo['goods_name']; ?></div></a>
			<div class="brand-info" style="height:initial;">
				<div class="brand-info-left" style="float:none;">
					<span class="b-price" style="float:left;margin:5px 10px;">
					<p>￥<?php echo $vo['promotion_price']; ?></p>
					</span>
					<em></em>
					<span class="buyer"  style="float:right;line-height:31px;"><s style="margin-right: 10px;">￥<?php echo $vo['price']; ?></s></span>
				</div>
				<!-- <div class="brand-info-right" style="clear:both; margin-bottom: 8px;">
				<a class="main-btn" href="APP_MAIN/goods/goodsDetail?id=<?php echo $vo['goods_id']; ?>">马上抢</a>
				</div> -->
			</div>
		</li>
	<?php endforeach; endif; else: echo "" ;endif; ?>
	</ul>
</div>
<script type="text/javascript">
	$().ready(function() {
		updateEndTime();
	});
	//倒计时函数
	function updateEndTime() {
		var date = new Date();
		var time = date.getTime(); //当前时间距1970年1月1日之间的毫秒数

		$(".settime").each(function(i) {
			var endDate = this.getAttribute("endTime"); //结束时间字符串
			
			//转换为时间日期类型
			var endDate1 = eval('new Date(' + endDate.replace(/\d+(?=-[^-]+$)/, function(a) {
				return parseInt(a, 10) - 1;
			}).match(/\d+/g) + ')');
			
			var endTime = endDate1.getTime(); //结束时间毫秒数
	
			var lag = (endTime - time) / 1000; //当前时间和结束时间之间的秒数
			if (lag > 0) {
				var second = Math.floor(lag % 60);
				var minite = Math.floor((lag / 60) % 60);
				var hour = Math.floor((lag / 3600) % 24);
				var day = Math.floor((lag / 3600) / 24);
				$(this).html(day + "天" + hour + "时" + minite + "分" + second + "秒");
			} else{
				$(this).html("团购已经结束啦！");
			}
		});
		setTimeout("updateEndTime()", 1000);
	}
</script>
<?php endif; if(is_array($class_list) || $class_list instanceof \think\Collection || $class_list instanceof \think\Paginator): if( count($class_list)==0 ) : echo "" ;else: foreach($class_list as $key=>$class): if($class['class_name']=='热销排行'): ?>
	<div class="controltype">
		<!-- <img src="__TEMP__/<?php echo $style; ?>/public/images/hotsale.png"/> -->
		<!-- <span class="control_l_content" style="color:green;"><?php echo $class['class_name']; ?></span> -->
		<img src="__TEMP__/<?php echo $style; ?>/public/images/navimg/top_selling.png">
	</div>
	<section class="members_goodspic">
		<ul>
			<?php if(is_array($class['goods_list']) || $class['goods_list'] instanceof \think\Collection || $class['goods_list'] instanceof \think\Paginator): if( count($class['goods_list'])==0 ) : echo "" ;else: foreach($class['goods_list'] as $k=>$goods): if($k<4): ?>
			<li class="gooditem">
				<div class="img">
					<a href="APP_MAIN/Goods/goodsDetail.html?id=<?php echo $goods['goods_info']['goods_id']; ?>"><img class="lazy" src="__UPLOAD__/<?php echo $goods['picture_info']['pic_cover_small']; ?>" ></a>
				</div>
				<div class="info">
					<p class="goods-title"><a href="APP_MAIN/Goods/goodsDetail.html?id=<?php echo $goods['goods_info']['goods_id']; ?>"><?php echo $goods['goods_info']['goods_name']; ?></a></p>
					<p class="goods-price"><em>￥<?php echo $goods['goods_info']['promotion_price']; ?></em></p>
					<a href="APP_MAIN/Goods/goodsDetail.html?id=<?php echo $goods['goods_info']['goods_id']; ?>"></a>
				</div>
			</li>
			<?php endif; endforeach; endif; else: echo "" ;endif; ?>
		</ul>
	</section>
	<?php endif; endforeach; endif; else: echo "" ;endif; if(is_array($class_list) || $class_list instanceof \think\Collection || $class_list instanceof \think\Paginator): if( count($class_list)==0 ) : echo "" ;else: foreach($class_list as $key=>$class): if($class['class_name']=='商城热卖'): ?>
	
<!-- 	<div class="slick">
		<a href="APP_MAIN">
			<img src="__TEMP__/<?php echo $style; ?>/public/images/guanggao_cs_02.jpg" alt="">
		</a>
	</div> -->
	<div class="slick">
		<a href="<?php echo $hot_selling_adv['adv_list'][0]['adv_url']; ?>">
			<img src="__UPLOAD__/<?php echo $hot_selling_adv['adv_list'][0]['adv_image']; ?>" >
		<!-- style="height:<?php echo $discount_adv['ap_height']; ?>px;" -->
		</a>
	</div>
	
	
	<div class="controltype">
		<!-- <img src="__TEMP__/<?php echo $style; ?>/public/images/shophot.png"/> -->
		<!-- <span class="control_l_content" style="color:red;"><?php echo $class['class_name']; ?></span> -->
		<img src="__TEMP__/<?php echo $style; ?>/public/images/navimg/hot_commodity.png">
	</div>
	<section class="members_goodspic">
		<ul>
			<?php if(is_array($class['goods_list']) || $class['goods_list'] instanceof \think\Collection || $class['goods_list'] instanceof \think\Paginator): if( count($class['goods_list'])==0 ) : echo "" ;else: foreach($class['goods_list'] as $k=>$goods): if($k<4): ?>
			<li class="gooditem">
				<div class="img">
					<a href="APP_MAIN/Goods/goodsDetail.html?id=<?php echo $goods['goods_info']['goods_id']; ?>"><img class="lazy" src="__UPLOAD__/<?php echo $goods['picture_info']['pic_cover_small']; ?>"></a>
				</div>
				<div class="info">
					<p class="goods-title"><a href="APP_MAIN/Goods/goodsDetail.html?id=<?php echo $goods['goods_info']['goods_id']; ?>"><?php echo $goods['goods_info']['goods_name']; ?></a></p>
					<p class="goods-price"><em>￥<?php echo $goods['goods_info']['promotion_price']; ?></em></p>
					<a href="APP_MAIN/Goods/goodsDetail.html?id=<?php echo $goods['goods_info']['goods_id']; ?>"></a>
				</div>
			</li>
			<?php endif; endforeach; endif; else: echo "" ;endif; ?>
		</ul>
	</section>
	<?php endif; endforeach; endif; else: echo "" ;endif; if(is_array($class_list) || $class_list instanceof \think\Collection || $class_list instanceof \think\Paginator): if( count($class_list)==0 ) : echo "" ;else: foreach($class_list as $key=>$class): if($class['class_name']=='商城推荐'): ?>
	<div class="controltype">
	<!-- <img src="__TEMP__/<?php echo $style; ?>/public/images/shoprec.png"/> -->
	<!-- <span class="control_l_content" style="color:red;"><?php echo $class['class_name']; ?></span> -->
	<img src="__TEMP__/<?php echo $style; ?>/public/images/navimg/mall_recommend.png">
	</div>
	<section class="members_goodspic">
		<ul>
			<?php if(is_array($class['goods_list']) || $class['goods_list'] instanceof \think\Collection || $class['goods_list'] instanceof \think\Paginator): if( count($class['goods_list'])==0 ) : echo "" ;else: foreach($class['goods_list'] as $k=>$goods): if($k<4): ?>
			<li class="gooditem">
				<div class="img">
					<a href="APP_MAIN/Goods/goodsDetail.html?id=<?php echo $goods['goods_info']['goods_id']; ?>"><img class="lazy" src="__UPLOAD__/<?php echo $goods['picture_info']['pic_cover_small']; ?>"></a>
				</div>
				<div class="info"  style="margin-top:0;">
					<p class="goods-title"><a href="APP_MAIN/Goods/goodsDetail.html?id=<?php echo $goods['goods_info']['goods_id']; ?>"><?php echo $goods['goods_info']['goods_name']; ?></a></p>
					<p class="goods-price"><em>￥<?php echo $goods['goods_info']['promotion_price']; ?></em></p>
					<a href="APP_MAIN/Goods/goodsDetail.html?id=<?php echo $goods['goods_info']['goods_id']; ?>"></a>
				</div>
			</li>
			<?php endif; endforeach; endif; else: echo "" ;endif; ?>
		</ul>
	</section>
	<?php endif; endforeach; endif; else: echo "" ;endif; ?>
<!-- 促销模块 -->
<!-- <?php if(is_array($class_list) || $class_list instanceof \think\Collection || $class_list instanceof \think\Paginator): if( count($class_list)==0 ) : echo "" ;else: foreach($class_list as $key=>$class): ?>
	<div class="controltype" style="background-image:url(__TEMP__/<?php echo $style; ?>/public/images/newproduct.png);background-repeat:no-repeat;height:50px;margin:0;width:100%">
		<hr />
		<span class="control_l_content"><?php echo $class['class_name']; ?></span>
	</div>
	<div class="slick">
		<div><a href="APP_MAIN"><img src="__TEMP__/<?php echo $style; ?>/public/images/guanggao_cs_02.jpg" alt=""></a></div>
	</div>
	<section class="members_goodspic">
		<ul>
			<?php if(is_array($class['goods_list']) || $class['goods_list'] instanceof \think\Collection || $class['goods_list'] instanceof \think\Paginator): if( count($class['goods_list'])==0 ) : echo "" ;else: foreach($class['goods_list'] as $k=>$goods): if($k<4): ?>
			<li class="gooditem">
				<div class="img">
					<a href="APP_MAIN/Goods/goodsDetail?id=<?php echo $goods['goods_info']['goods_id']; ?>"><img class="lazy" src="__UPLOAD__/<?php echo $goods['picture_info']['pic_cover_small']; ?>"></a>
				</div>
				<div class="info">
					<p class="goods-title"><a href="APP_MAIN/Goods/goodsDetail?id=<?php echo $goods['goods_info']['goods_id']; ?>"><?php echo $goods['goods_info']['goods_name']; ?></a></p>
					<p class="goods-price"><em>￥<?php echo $goods['goods_info']['promotion_price']; ?></em></p>
					<a href="APP_MAIN/Goods/goodsDetail?id=<?php echo $goods['goods_info']['goods_id']; ?>"><div class="goods-buy"></div></a>
				</div>
			</li>
			<?php endif; endforeach; endif; else: echo "" ;endif; ?>
		</ul>
	</section>
<?php endforeach; endif; else: echo "" ;endif; ?> -->
	<div class="h60"></div>
</div>

	
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
	
 <script>
$(function(){
	//关注微信公众号弹出
	$("#subscribe").click(function(){
		
		$(".shade").show();
		$(".popup").show();
	})
	//关注微信公众号关闭
	$("#close").click(function(){
		$(".shade").hide();
		$(".popup").hide();
		
	})
	
	
	$.ajax({
		type:"post",
		url : "APP_MAIN/member/getShareContents",
		success : function(data){
			//alert(JSON.stringify(data));
			//document.write(data.share_img);
			/* $("#share_title").val(data['share_title']);
			$("#share_desc").val(data['share_contents']);
			$("#share_url").val(data['share_url']);
			$("#share_img_url").val(data['share_img']);\ */
			wx.config({
				debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
				appId: $("#appId").val(), // 必填，公众号的唯一标识
				timestamp: $("#jsTimesTamp").val(), // 必填，生成签名的时间戳
				nonceStr:  $("#jsNonceStr").val(), // 必填，生成签名的随机串
				signature: $("#jsSignature").val(),// 必填，签名，见附录1
				jsApiList: ['onMenuShareTimeline', 'onMenuShareAppMessage', 'onMenuShareQQ', 'onMenuShareWeibo'] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
			});
			wx.ready(function () {
				var title = data['share_title'];
				var share_contents = data['share_contents']+'\r\n';
				var share_nick_name = data['share_nick_name']+'\r\n';
				var desc2 = share_contents+ share_nick_name + "收藏热度：★★★★★";
				var url = data['share_url'];
				var img_url = data['share_img'];
				wx.onMenuShareAppMessage({
					title: title,
					desc: desc2,
					link: url,
					imgUrl: img_url,
					trigger: function (res) {
						//alert('用户点击发送给朋友');
					},
					success: function (res) {
						//alert('已分享');
						$.ajax({
							type : "post",
							url : "APP_MAIN/index/shareGivePoint",
							data : {
								"share" : true
							},
							success : function(data){
								
							}
						})
					},
					cancel: function (res) {
						//alert('已取消');
					},
					fail: function (res) {
						//alert(JSON.stringify(res));
					}
				});
				// 2.2 监听“分享到朋友圈”按钮点击、自定义分享内容及分享结果接口
				wx.onMenuShareTimeline({
					title: title,
					link: url,
					imgUrl: img_url,
					trigger: function (res) {
					  // alert('用户点击分享到朋友圈');
					},
					success: function (res) {
					//alert('已分享');
						$.ajax({
							type : "post",
							url : "APP_MAIN/index/shareGivePoint",
							data : {
								"share" : true
							},
							success : function(data){
								
							}
						})
					},
					cancel: function (res) {
					//alert('已取消');
					},
					fail: function (res) {
					   // alert(JSON.stringify(res));
					}
				});
	
				// 2.3 监听“分享到QQ”按钮点击、自定义分享内容及分享结果接口
				wx.onMenuShareQQ({
					title: title,
					desc: desc2,
					link: url,
					imgUrl: img_url,
					trigger: function (res) {
					//alert('用户点击分享到QQ');
					},
					complete: function (res) {
					//alert(JSON.stringify(res));
					},
					success: function (res) {
					//alert('已分享');
						$.ajax({
							type : "post",
							url : "APP_MAIN/index/shareGivePoint",
							data : {
								"share" : true
							},
							success : function(data){
								
							}
						})
					},
					cancel: function (res) {
					//alert('已取消');
					},
					fail: function (res) {
					//alert(JSON.stringify(res));
					}
				});
	
				// 2.4 监听“分享到微博”按钮点击、自定义分享内容及分享结果接口
				wx.onMenuShareWeibo({
					title: title,
					desc: desc2,
					link: url,
					imgUrl: img_url,
					trigger: function (res) {
					//alert('用户点击分享到微博');
					},
					complete: function (res) {
					//alert(JSON.stringify(res));
					},
					success: function (res) {
					//alert('已分享');
						$.ajax({
							type : "post",
							url : "APP_MAIN/index/shareGivePoint",
							data : {
								"share" : true
							},
							success : function(data){
								
							}
						})
					},
					cancel: function (res) {
					//alert('已取消');
					},
					fail: function (res) {
					//alert(JSON.stringify(res));
					}
				});
			})
		}
	})
})
</script>

</body>
</html>