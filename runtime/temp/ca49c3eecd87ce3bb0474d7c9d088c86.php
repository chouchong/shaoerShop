<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:37:"template/wap\b2c\Goods\goodsList.html";i:1495866256;s:26:"template/wap\b2c\base.html";i:1495866256;s:41:"template/wap\b2c\Index\controlSearch.html";i:1495866256;}*/ ?>
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

<link rel="stylesheet" type="text/css" href="__TEMP__/<?php echo $style; ?>/public/css/common.css">
<link rel="stylesheet" type="text/css" href="__TEMP__/<?php echo $style; ?>/public/css/components.css">
<link rel="stylesheet" type="text/css" href="__TEMP__/<?php echo $style; ?>/public/css/category.css">
<link rel="stylesheet" type="text/css" href="__TEMP__/<?php echo $style; ?>/public/css/group_goods_list.css">
<script language="javascript" src="__TEMP__/<?php echo $style; ?>/public/js/goods_list.js" type="text/javascript"></script>
<style>

.openList li dd {
    width: 90%;
}
.openList li dl dt {
    font-size: 14px;
    width: 90%;
    height: 20px;
    overflow: hidden;
}
.openList .goods-sales {
    font-size: 12px;
}
.openList li dd i {
    font-size: 14px;
}
.custom-search{
	width:90%;
	margin-left:20px;	
}
.custom-search .custom-search-input{
	width:97%;
}
.custom-search-button{
	height:50px;
}
</style>

</head>
<body class="body-gray">
	
<section class="head">
	<a class="head_back" onclick="window.history.go(-1)" href="javascript:void(0)"><i class="icon-back"></i></a>
	<div class="head-title">
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
</div></div>
	
</section>

	<div class="motify" style="display: none;"><div class="motify-inner">弹出框提示</div></div>
	
<div id="index_content">
<!--列表页内容start-->
<section class="category-content-section">
	<section class="filtrate-term ">
		<ul>
			<li class="cur"><a href="javascript:void(0)">综合排序</a></li>
			<!--排序点击li标签增加样式cur；span标签增加样式active_down-->
			<li class="">
				<a href="javascript:void(0);" class="filtrate-sort">
					<em>排序</em>
					<span class="arrow_down arrow"></span>
				</a>
			</li>
		<!-- 	<li class="filtrate">
				<a href="javascript:void(0);">
					筛选
					<i class="iconfont"></i>
				</a>
			</li> -->
		</ul>
	</section>
	<div class="mask-div"></div>
	<div class="filtrate-more hide sale-num">
		<span><a href="javascript:void(0)" data-sort="1" data-name="销量" class=""> 销量 </a></span>
		<span><a href="javascript:void(0)" data-sort="2" data-name="新品" class=""> 新品 </a></span>
		<span><a href="javascript:void(0)" data-sort="3" data-name="价格" class=""> 价格 </a></span>
		<input type="hidden" id='order' name="order"  />
		<input type="hidden" id='category_id' name='category_id' value="<?php echo $category_id; ?>" />
	</div>
	<!--goods_grid布局start-->
	<div class="goods-list-grid openList">
		<div class="blank-div"></div>
		<div id="goods_list">
			<div class="tablelist-append clearfix"></div>
		</div>
	</div>
</section>
<!--底部菜单 start-->
</div>

	
	
	<!-- 加载弹出层 -->
	<div class="mask-layer-loading">
		<img src="__TEMP__/<?php echo $style; ?>/public/images/mask_load.gif"/>
		<!-- <i class="fa fa-spinner fa-pulse"></i> -->
	</div>
	
<script type="text/javascript">
$(function(){
	getgoodlist()
})
function getgoodlist(){
	$('#grouGoodsListmask').hide();
	$('.two-list-menu').hide();
	$('.two-list-menu li[pid]').hide();
	var order=$('.filtrate-more span a.current').attr('data-sort');
	var sort=$(".filtrate-more").find("input[name='order']").val();
	$.ajax({
		type:"post",
		url : "APP_MAIN/Goods/goodsList",
		async : true,
		data : {'category_id':'<?php echo $category_id; ?>','brand_id':'<?php echo $brand_id; ?>','order':order,'sort':sort },
		beforeSend:function(){
			showLoadMaskLayer();
		},
		success : function(data){
			var list_html="";
			for(var i=0;i<data['data'].length;i++){
				var item=data['data'][i];	
				list_html+='<div class="product single_item info">'
					+'<li>'
					+'<div class="item">'
					+'	<div class="item-tag-box">'
					+'	<!--热卖icon位置为：0px 0px，新品icon位置为：0px -35px，精品icon位置：0px -70px-->'
					+'</div>'
					+'<div class="item-pic">'
					+'	<a href="APP_MAIN/Goods/goodsDetail.html?id='+item.goods_id+'">'
					+'<img class="" src="__UPLOAD__/'+item.pic_cover_mid+'"  alt="'+item.goods_name+'" style="display: block;max-width:100%;max-height:100%;">'
					+'	</a>'	
					+'</div>'
					+'<dl>'
					+'	<dt>'
					+'		<a href="APP_MAIN/Goods/goodsDetail.html?id='+item.goods_id+'">'+item.goods_name+'</a>'
					+'	</dt>'
//					+'	<a class="shop-name" href="/shop/3.html">';
// 					+'		<i class="iconfont color"></i>';
// 					list_html+=(item.shop_type==1)?'自营':'普通';
					
//					list_html+='		</a>'
					+'		<dd>'
					+'			<i>￥'+item.promotion_price+'</i>'
					+'		</dd>'
					+'	</dl>'
					+'</div>'
					+'<div class="item-con-info">'
					+'<span class="goods-sales"> 销量：'+item.sales+'</span>'
					+'<div class="cart-box" id="number_575">'
					+'<a class="add-cart increase" data-goods_id="575" href="javascript:CartGoodsInfo('+item.goods_id+')"></a>'
					+'	<a class="decrease hide" data-goods_id="575" style="right: 60px;"></a>'
					+'</div></div></li></div>';
			}
			$('.tablelist-append').html(list_html);
			updateLoadMaskLayerHeight($(document).height());
			hiddenLoadMaskLayer();
		}
	});
}
</script>

</body>
</html>