<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:39:"template/wap\b2c\Goods\goodsDetail.html";i:1495866256;s:26:"template/wap\b2c\base.html";i:1495866256;s:41:"template/wap\b2c\Goods\controlDetail.html";i:1495866256;s:27:"template/wap\b2c\share.html";i:1495866258;}*/ ?>
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

<link rel="stylesheet" type="text/css" href="__TEMP__/<?php echo $style; ?>/public/css/mall.css">
<link rel="stylesheet" type="text/css" href="__TEMP__/<?php echo $style; ?>/public/css/pre_foot.css">
<link rel="stylesheet" type="text/css" href="__TEMP__/<?php echo $style; ?>/public/css/goods_detail.css">
<script src="__TEMP__/<?php echo $style; ?>/public/js/goods_product.js"></script>
<script language="javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript" src="__TEMP__/<?php echo $style; ?>/public/js/jscommon.js" language="javascript" charset="gb2312"></script>
<script src="__TEMP__/<?php echo $style; ?>/public/js/jquery.lazyload.js" type="text/javascript"></script>
<style>
.js-shelves {
	display: none;
}
</style>

</head>
<body class="body-gray">
	
<section class="head">
	<a class="head_back" onclick="window.history.go(-1)" href="javascript:void(0)"><i class="icon-back"></i></a>
	<div class="head-title"><?php echo $shopname; ?></div>
</section>

	<div class="motify" style="display: none;"><div class="motify-inner">弹出框提示</div></div>
	
	
	<link rel="stylesheet" type="text/css" href="__TEMP__/<?php echo $style; ?>/public/css/scroll.css">
<link rel="stylesheet" type="text/css" href="__TEMP__/<?php echo $style; ?>/public/css/detail.css">
<link rel="stylesheet" type="text/css" href="__TEMP__/<?php echo $style; ?>/public/css/components.css">
<script src="__TEMP__/<?php echo $style; ?>/public/js/scroll.js" type="text/javascript"></script>
<script src="__TEMP__/<?php echo $style; ?>/public/js/countdown.js" type="text/javascript"></script>
<style type="text/css">
.productproperty-list{
	float: left;
    font-size: 14px;
    cursor: pointer;
    color: #656565;
	width:20%;
}
.tab-nav .icon{
    display: inline-block;
    width: 14px;
    height: 14px;
    background-position: -61px 0px;
    vertical-align: -2px;
    margin-right: 5px;
}
#comment_content{
	padding:10px;
}
.user_info{
	width:20%;
	text-align:center;
}
.face{
    height: 35px;
/*     width: 35px; */
/*     border-radius: 50%; */
/*     border: 1px solid #e5e5e5; */
/*     overflow: hidden; */
}
.tablelist:after{
	content:'';
	clear:both;
	display:block;
}
.tablelist .user_info{
	float:left;
}
.tablelist dl{
	float:right;
	width: 75%;
	line-height:25px;
}
.current{
	color:#f03737;
}
.comment-type ul{
	display: inline-block;
	width: 100%;
}
.comment-type ul li{
	width: 20%;
    text-align: center;
    padding: 10px 0;
    border-bottom: 1px solid #f0f0f0;
}

.shop_slider_auto .pic_list li div{
	text-align: center;
	width:100%;
/* 	height:360px; */
}
</style>
<!-- 商品详情 -->
<div class="h50" style="height:45px;"></div>
<section id="banner">
	<div class="shop_slider shop_slider_auto" data-tag="module-slider" data-height="320px">
		<div class="inner" data-tag="slider-warp" >
			<ul class="pic_list" data-tag="slider-list">
			<?php if(is_array($goods_detail['img_list']) || $goods_detail['img_list'] instanceof \think\Collection || $goods_detail['img_list'] instanceof \think\Paginator): if( count($goods_detail['img_list'])==0 ) : echo "" ;else: foreach($goods_detail['img_list'] as $key=>$img_list): ?>
				<li data-index="0" style="width: 640px; left: 0px;-webkit-transition: 300ms;transition: 300ms;-webkit-transform: translate(0px, 0px) translateZ(0px);<?php if($key!=0): ?>display:none;<?php endif; ?>">
					<!-- <a href="#" target="_blank" title="图片"> -->
					<div >
						<img alt="图片" class="pp_init_img" src="__ROOT__/<?php echo $img_list['pic_cover_big']; ?>">
					</div>
					<!-- </a> -->
				</li>
			<?php endforeach; endif; else: echo "" ;endif; ?>
			</ul>
		</div>
		<div class="bar_wrap">
			<ul class="bar" data-tag="slider-page">
				<li class="cur"></li>
				<li></li>
				<li></li>
			</ul>
		</div>
	</div>
</section>
<input type="hidden" id="is_sale" value="<?php echo $goods_detail['state']; ?>" />
<input type="hidden" id="goods_id" value="<?php echo $goods_detail['goods_id']; ?>" />
<input type="hidden" id="code" value="<?php echo $goods_detail['code']; ?>" />
<input type="hidden" id="max_buy" value="<?php echo $goods_detail['max_buy']; ?>" />
<input type="hidden" id="hidden_current_num" value="<?php echo $num; ?>" />
<?php if($goods_detail['promotion_info'] != ''): ?>
<div class="goods-header js-goods-header goods-activity clearfix">
	<input type="hidden" id="end_time"  value="<?php echo $goods_detail['promotion_detail']['end_time']; ?>"/>
	<div class="goods-price ">
		<div class="current-price activity-price">
			<span>￥</span><i class="js-goods-price price"><?php echo $goods_detail['promotion_price']; ?><!-- <i>.00</i> --></i>
			<span class="price-title js-price-title ">限时折扣</span>
		</div>
		<em class="original-price"><?php echo $goods_detail['price']; ?></em>
		<div class="font-size-12 overview-countdown js-activity-tips started " data-status="started">
			<div class="countdown-title">距结束仅剩</div>
			<div class="js-discount-time countdown" data-countdown="3542691">
			<span class="c-red js-day">00</span> 天 
			<span class="c-red js-hour">00</span> 时 
			<span class="c-red js-min">00</span> 分 
			<span class="c-red js-sec">00</span> 秒</div>
		</div>
	</div>
</div>
<?php endif; ?>
<div class="buy_area">
	<div class="fn_wrap">
		<h1 class="title" id="itemName"><?php echo $goods_detail['goods_name']; ?></h1>
	</div>
	<div class="price_wrap">
		<span class="tit" id="priceTitle"></span> 
		<span class="price" price="<?php if($goods_detail['promotion_info'] != ''): ?><?php echo $goods_detail['promotion_price']; else: ?><?php echo $goods_detail['price']; endif; ?>">
			<span style="font-size:14px;display: inline-block;vertical-align: middle;">￥</span>
			<?php echo $goods_detail['promotion_price']; if($goods_detail['point_exchange_type']==1 && $goods_detail['point_exchange']>0): ?>
			<span style="font-size:16px;display: inline-block;vertical-align: middle;">+<?php echo $goods_detail['point_exchange']; ?>积分</span>
			<?php endif; ?>
		</span>
		<del class="old_price"><em id="priceMarket" style="">¥<span id="cost_price"><?php echo $goods_detail['price']; ?></span></em></del>
		<span class="flag" id="priceDis" style="display: none"></span>
	</div>
	
	<?php if($goods_detail['max_buy']>0): ?>
	<hr class="with-margin-l" />
	<hr class="divider-line" />
	<div class="price_postage">
		<span class="price_postage_tit">
		<i style="color: #fff;font-size: 12px;padding: 3px;background: #f44;border-radius: 2px;">限购数量</i>&nbsp;<?php echo $goods_detail['max_buy']; ?>个</span>
	</div>
	<?php endif; ?>
	<hr class="with-margin-l" />
	<div class="stock-detail" >
		<span class="price_postage_tit">运费：<?php echo $goods_detail['shipping_fee_name']; ?></span>
	</div>
</div>
<hr class="with-margin-l" />
<hr class="divider-line" />
<?php if($goods_detail['mansong_name'] != ''): ?>
<div class="price_postage">
	<span class="price_postage_tit js-reduced-send single"><i style="color: #fff;font-size: 12px;padding: 3px;background: #f44;border-radius: 2px;">满减</i>&nbsp;<?php echo $goods_detail['mansong_name']; ?></span>
</div>
<hr class="with-margin-l" />
<hr class="divider-line" />
<?php endif; if($goods_detail['give_point'] != 0): ?>
<div class="price_postage">
	<span class="price_postage_tit"><i class="fa fa-database" style="color: #F44;margin-right: 5px;"></i>赠送积分<span style="color:#F44;padding:0;"><?php echo $goods_detail['give_point']; ?></span>分</span>
</div>
<hr class="with-margin-l" />
<?php endif; ?>
    
    <div class="likeshare" style="display:none;">
		<span class="span-like">
    		<i class="icon-good" id="clickGood" typeid="1" is_click = '0' style='background: url("__TEMP__/<?php echo $style; ?>/public/images/dianzan1.png") no-repeat 5px 5px;'></i>点赞
		</span>
		<span class="span-share">
			<i class="icon-share" id="clickShare" typeid="2" style='background: url("__TEMP__/<?php echo $style; ?>/public/images/fenxiang1.png") no-repeat 5px 5px;'></i>分享
		</span>
	</div>
	
	<div class="statistics" style="display:none;">
		<div class="cols">销量:<i><?php echo $goods_detail['sales']; ?></i></div>
			<div class="cols">
				点赞:<i id="goodNum"><?php echo $goods_detail['evaluates']; ?></i>
				<input type="hidden" id="hiddenGoodNum" value="<?php echo $goods_detail['evaluates']; ?>">
			</div>
			<div class="cols">
				分享:<i id="shareNum"><?php echo $goods_detail['shares']; ?></i>
				<input type="hidden" id="hiddenshareNum" value="<?php echo $goods_detail['shares']; ?>">
			</div>
	</div>
	
	<div class="mod_tab_wrap">
		<div class="mod_tab" id="detailTab">
			<span onclick="showProperty(this,1)" class="cur"><?php echo $goods_detail['introduction']; ?></span>
			<span onclick="showProperty(this,2)">商品评价</span>
		</div>
	</div>
	
<!-- 	<section class="p-a-c-list"> -->
<!-- 		<ul class="list-attribute" id="productproperty" style="display: none;"></ul> -->
<!-- 	</section> -->
	<!-- 商品详情 -->
	<div class="detail_info_wrap" id="p-detail">
		<div class="detail_list" id="content"><?php echo $goods_detail['description']; ?></div>
	</div>
	<!-- 商品评论 -->
	<div class="comment-type" id="productproperty" style="display:none;">
		<ul class="tab-nav">
			<li class="productproperty-list current" data-type="0" >全部<em>(<?php echo $evaluates_count['evaluate_count']; ?>)</em></li>
			<li class="productproperty-list" data-type="4"  >图片 <em>(<?php echo $evaluates_count['imgs_count']; ?>)</em></li>
			<li class="productproperty-list" data-type="1" >好评 <em>(<?php echo $evaluates_count['praise_count']; ?>)</em></li>
			<li class="productproperty-list" data-type="2" >中评 <em>(<?php echo $evaluates_count['center_count']; ?>)</em></li>
			<li class="productproperty-list" data-type="3" > 差评 <em>(<?php echo $evaluates_count['bad_count']; ?>)</em></li>
	    </ul>
	</div>
	
	
	
	
	<!-- 评论展示 -->
	<div id="comment_content">
		<div class="comment-con "></div>
	</div>
	<div class="footer">
		<!-- <div class="copyright">
			<a href="#" target="_blank">店铺主页</a>
			<a href="#" target="_blank">会员中心</a>
			<a href="#">关注我们</a>
			<a href="#" target="_blank">线下门店</a>
			<a href="#" target="_blank">店铺信息</a> -->
			<!-- 第三方app隐藏topbar时，需要在底部显示购物记录入口 -->
		<!-- </div> -->
		<!-- <div class="ft-copyright "><a href="http://www.niushop.com.cn" target="_blank"><?php echo $platform_shopname; ?>提供技术支持</a></div> -->
	</div>
	
	<div class="success-tip-line" id="success_tip_line" style="display: none;">成功加入购物车！</div>
	<div class="mask" id="mask" style="display: none;"></div>
	<span class="" id="addcart_way" style="display: none;"><i></i></span>
	<section class="s-buy" id="s_buy" style="bottom: -800px; display: none;">
		<div class="popup"  id="popup" style="-webkit-border-radius:3px;-moz-border-radius:3px;-o-border-radius:3px;border-radius:3px;display: none"></div>
		<ul class="s-buy-ul">
			<li class="s-buy-pro">
				<span class="pro-img">
					<input type="hidden" id="default_img" value="<?php echo $goods_detail['img_list'][0]['pic_id']; ?>" />
					<img src="__ROOT__/<?php echo $goods_detail['img_list'][0]['pic_cover_micro']; ?>" >
				</span>
				<div class="pro-info">
					<p class="name" ><?php echo $goods_detail['goods_name']; ?></p>
					<p class="pro-price" id="price">￥<?php echo $goods_detail['promotion_price']; ?></p>
				</div>
				<i class="icon-close" id="icon_close"></i>
			</li>
		</ul>
		<hr class="with-margin-l" />
		<ul class="s-buy-ul specification" id="specification">
			<?php if(is_array($goods_detail['attribute_list']) || $goods_detail['attribute_list'] instanceof \think\Collection || $goods_detail['attribute_list'] instanceof \think\Paginator): if( count($goods_detail['attribute_list'])==0 ) : echo "" ;else: foreach($goods_detail['attribute_list'] as $k=>$pro_prop): ?>
			<li class="s-buy-li" >
				<div class="left"><?php echo $pro_prop['attr_name']; ?>：</div>
				<div class="right" name="specvals" >
				<?php if(is_array($goods_detail['attribute_value_list']) || $goods_detail['attribute_value_list'] instanceof \think\Collection || $goods_detail['attribute_value_list'] instanceof \think\Paginator): if( count($goods_detail['attribute_value_list'])==0 ) : echo "" ;else: foreach($goods_detail['attribute_value_list'] as $key=>$pro_propvalue): if($pro_propvalue['attr_id'] == $pro_prop['attr_id']): ?>
						<button class="select" name="Span<?php echo $k; ?>" id="<?php echo $pro_prop['attr_id']; ?>:<?php echo $pro_propvalue['attr_value_id']; ?>" onclick="change(this);">
						<?php echo $pro_propvalue['attr_value']; ?>
						</button>
					<?php endif; endforeach; endif; else: echo "" ;endif; ?>
				</div>
			</li>
			<hr class="with-margin-l" />
			<?php endforeach; endif; else: echo "" ;endif; if(is_array($goods_detail['sku_list']) || $goods_detail['sku_list'] instanceof \think\Collection || $goods_detail['sku_list'] instanceof \think\Paginator): if( count($goods_detail['sku_list'])==0 ) : echo "" ;else: foreach($goods_detail['sku_list'] as $k=>$pro_skus): ?>
			<input type="hidden" id="goods_sku<?php echo $k; ?>" value="<?php echo $pro_skus['attr_value_items']; ?>;" stock="<?php echo $pro_skus['stock']; ?>" price="<?php echo $pro_skus['promote_price']; ?>" skuid="<?php echo $pro_skus['sku_id']; ?>" skuname="<?php echo $pro_skus['sku_name']; ?>">
			<?php endforeach; endif; else: echo "" ;endif; ?>
			<input type="hidden" id="goods_sku_num" value="100">
			<li class="s-buy-li">
				<div class="left" style="float:left;">购买数量：</div>
				<div class="right">
					<span class="reduce quantity-minus-disabled">-</span>
					<input class="number" name="quantity" autocomplete="off" value="1" min="1" max="<?php echo $goods_detail['stock']; ?>" id="num">
					<span class="add">+</span>
					<input id="hiddPDetailID" type="hidden" name="name" value="<?php echo $goods_detail['goods_id']; ?>">
					<input id="hiddSkuId" type="hidden" name="name" value="">
					<input id="hiddSkuName" type="hidden" name="name" value="">
					<input id="hiddSkuprice" type="hidden" name="name" value="">
					<input id="hiddStock" type="hidden" value="<?php echo $goods_detail['stock']; ?>"/>
				</div>
				<span style="display: inline-block;margin-top:5px;color:#333;" id="Stock">剩余<?php echo $goods_detail['stock']; ?>件</span>
				<?php if($goods_detail['max_buy'] != '0' AND $goods_detail['max_buy'] != -1): ?>
				<span style="display: inline-block;margin-top:5px;color:#333;">限购<?php echo $goods_detail['max_buy']; ?>件</span>
				<?php endif; ?>
			</li>
		</ul>
		<ul class="s-buy-ul">
			<li class="s-buy-btn">
				<a class="btn" id="submit_ok" tag="buyBtn1">确定</a>
				<input type="hidden" id="hidden_shop_name" value="<?php echo $goods_detail['shop_name']; ?>"/>
				<input type="hidden" id="hidden_shop_id" value="<?php echo $goods_detail['shop_id']; ?>"/>
			</li>
		</ul>
	</section>
	<script type="text/javascript">
	window.onload=function(){
		$('.pic_list li').show();
	}
	$(".comment-type li").click(function() {
		var type = $(this).data("type");
		//alert(type);
		var target = $(this);
		$(".comment-type").find("li").removeClass("current");
		$(".comment-type").find("i").removeClass("cur");
		$(target).addClass("current");
		$(target).children().addClass("cur");
		GetDataList();
	})
	
	
	function showProperty(sobj,type){
		$("#detailTab span").removeClass("cur");
		$(sobj).addClass("cur");
		if(type==1){
			$("#productproperty").hide();
			$("#p-detail").show(); 
		}else{
			$("#productproperty").show();
			$("#p-detail").hide(); 
			GetDataList();
		}
	}
	
	
	/**
	* 分页显示
	* @param {Object} pageindex
	*/
	function GetDataList(){
		var commentsType=$(".comment-type li.current").attr('data-type');
		$.ajax({
			type:"post",
			url:"APP_MAIN/Goods/getGoodsComments",
			data:{'comments_type' : commentsType, "goods_id" : $("#goods_id").val() },
			dataType:'json',
			
			success:function(data){
// 				alert(JSON.stringify(data));
				var listhtml='';
				if(data['data'].length==0){
					$('.comment-con').html('<div class="tip-box"><i class="tip-icon"></i><div class="tip-text">还没有任何评价哦</div></div>');
					$('#pagination').hide();
					return false;
				}
				for(var i=0;i<data['data'].length;i++){
					var dataitem=data['data'][i];
					var member_name=dataitem['member_name'];
					member_name=dataitem['is_anonymous']==1?member_name.replace(member_name.substring(1,member_name.length),'***')+'(匿名)':member_name;
					listhtml+=' <div class="tablelist" style="border-bottom: 1px solid #e5e5e5;margin-bottom: 10px;">'
						+'<div class="user_info" style="margin-right:10px;">'
						+'<div class="face"><img src="__TEMP__/<?php echo $style; ?>/public/images/default_user_portrait_0.png" style="width:35px;border-radius: 50%;"/></div>'
						+'<div class="name-box">'+member_name+'</div>'
						+'</div>'
						+'<dl>'
						+'<dd>'+dataitem['content']+'</dd>'
					if(dataitem['image']!=''){
						var imgs_arr=dataitem['image'].split(',');
						listhtml+='<dd style="margin:5px 0;">'
						for(var key in imgs_arr){
							listhtml+='<img src="__UPLOAD__/'+imgs_arr[key]+'" alt=""/>';	
						}
						listhtml+='</dd>';
						listhtml+='<dd class="photo-viewer"></dd>'
					}	
					listhtml+='<div class="date"><span>'+dataitem['addtime']+'</span> <span></span></div>';
					listhtml+='</dl>';
					if(dataitem['again_content']!=''){
						
						listhtml+='<div style="margin-left:-1px;float:right;margin-top: 9px;width:75%;">追加评价：</div>'
						+'<dl>'
						+'<div style="width: 26%;margin-right: 10px;height:auto;float: left;"></div>'
						+'<dd>'+dataitem['again_content']+'</dd>'
						if(dataitem['again_image']!=''){
							var imgs_arr=dataitem['again_image'].split(',');
							listhtml+='<dd>'
							for(var key in imgs_arr){
								listhtml+='<img src="__UPLOAD__/'+imgs_arr[key]+'" alt="" />';
							}
							listhtml+='</dd>';
						}
						listhtml+='<div class="date"><span>'+dataitem['again_addtime']+'</span> <span></span></div>';
						listhtml+='</dl>';
					}
					listhtml+='</div>';
				}
				$(".comment-con").html(listhtml);
				
			}
		});
	}
	
	
	
	
	$(function () {
		countDown();//计时器

		$.ajax({
			type:"post",
			data : {"shop_id" : "<?php echo $shop_id; ?>" , "flag" : "goods" , "goods_id" : "<?php echo $goods_id; ?>"},
			url : "APP_MAIN/goods/getShareContents",
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
//					                alert('用户点击发送给朋友');
					            },
					            success: function (res) {
//					                alert('已分享');
					           
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
					            
					            },
					            cancel: function (res) {
					                //alert('已取消');
					            },
					            fail: function (res) {
					           //     alert(JSON.stringify(res));
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
				});
		
		//点赞
		$("#clickGood").one('click',function(){
			var $tempThis= $(this);
			var typeID=1;
			var goods_id = $("#goods_id").val();
			$.ajax({
				url: "<?php echo \think\Config::get('HEIMA_MODULE'); ?>/Weishop/click_gs",
				type: "Post",
				asysc: false,
				data: { "goods_id":goods_id,"action":typeID },
				success: function (res) {
					if(res == 1){
						$("#goodNum").text(parseInt($("#hiddenGoodNum").val())+1+"次");  
					}
				},
				error: function () {
				}
			});
			$tempThis.css('background','url(__TEMP__/<?php echo $style; ?>/public/images/dianzan2.png) no-repeat 5px 5px');
			$tempThis.attr("is_click",'1');
			$("#collect-link").on("click", function () {
				$("#collect-tip").show();
			})
			$("#a-know").on("click", function () {
				$("#collect-tip").hide();
			})
		})
		
		//分享
		$("#clickShare").on('click',function(){
			$("#share-tip").show();
			var $tempThis= $(this);
			var typeID=2;
			var goods_id = $("#goods_id").val();
			$.ajax({
				url: "APP_MAIN/Weishop/click_gs",
				type: "Post",
				asysc: false,
				data: { "goods_id":goods_id,"action":typeID },
				success: function (res) {
					if(res == 1){
						$("#shareNum").text(parseInt($("#hiddenshareNum").val())+1+"次");
					}
				},
				error: function () {
				}
			});
			$tempThis.css('background','url(__TEMP__/<?php echo $style; ?>/public/images/fenxiang2.png) no-repeat 5px 5px');
		})
	})
</script>
	<script language="javascript" src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js"> </script>
<input type="hidden" id="appId" value="<?php echo $signPackage['appId']; ?>">
<input type="hidden" id="jsTimesTamp" value="<?php echo $signPackage['jsTimesTamp']; ?>">
<input type="hidden" id="jsNonceStr"  value="<?php echo $signPackage['jsNonceStr']; ?>">
<input type="hidden" id="jsSignature" value="<?php echo $signPackage['jsSignature']; ?>">

	
<div class="js-bottom-opts bottom-fix">
	<div class="responsive-wrapper">
		<a id="global-cart" href="APP_MAIN/Goods/cart.html?shop_id=<?php echo $shop_id; ?>" class="new-btn buy-cart <?php if($carcount>0): ?>buy-cart-msg<?php endif; ?> ">
		
			<i class="iconfont icon-shopping-cart"></i>
			<span class="desc">购物车</span>
		</a>
		<div class="big-btn-2-1">
			<a href="javascript:;" class="big-btn orange-btn" id="addCart">加入购物车</a>
			<a href="javascript:;" class="big-btn red-btn" id="buyBtn1">立即购买</a>
		</div>
	</div>
</div>
<div class="btn_wrap btn_wrap_static btn_wrap_nocart no-server js-shelves">
	<div class="product-status">该商品已下架</div>
</div>
	<input type="hidden" value="<?php echo $uid; ?>" id="uid"/>

	
	<!-- 加载弹出层 -->
	<div class="mask-layer-loading">
		<img src="__TEMP__/<?php echo $style; ?>/public/images/mask_load.gif"/>
		<!-- <i class="fa fa-spinner fa-pulse"></i> -->
	</div>
	
</body>
</html>