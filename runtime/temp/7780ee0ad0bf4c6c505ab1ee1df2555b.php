<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:40:"template/wap\b2c\\Order\myOrderList.html";i:1495866256;s:26:"template/wap\b2c\base.html";i:1495866256;}*/ ?>
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

    <link rel="stylesheet" type="text/css" href="__TEMP__/<?php echo $style; ?>/public/css/foundation.css">
    
    <link rel="stylesheet" type="text/css" href="__TEMP__/<?php echo $style; ?>/public/css/common-v4.4.css">
	<link rel="stylesheet" type="text/css" href="__TEMP__/<?php echo $style; ?>/public/css/person-v4.4.css">
	<link rel="stylesheet" type="text/css" href="__TEMP__/<?php echo $style; ?>/public/css/my_order_list.css">
    <script src="__TEMP__/<?php echo $style; ?>/public/js/order.js"></script>
	<script type="text/javascript">window.onerror=function(){return true;}</script>
	<script type="text/javascript">
		var CONTROLLER = "APP_MAIN/Orders";
		var APP_MAIN = 'APP_MAIN';
		function backPage(){
			window.location.href="APP_MAIN/Member/";
		};
		
	</script>

</head>
<body class="body-gray">
	


	<div class="motify" style="display: none;"><div class="motify-inner">弹出框提示</div></div>
	

    <!--topbar end-->
    <div class="main myorder">
    <section class="head">
    <a class="head_back" onclick="window.history.go(-1)"
			href="javascript:void(0)"><i class="icon-back"></i></a>
		<div class="head-title">我的订单</div>
		<div class="cf-container" data-reactid="2">
    		<div class="cf-edge" data-reactid="3"></div>
			<ul class="cf-content" data-reactid="4">

	    			<li class="cf-tab-item" data-index="1" data-reactid="7" statusid="all"><a href="javascript:GetDataList('all');" >全部</a></li>
	    			<li class="cf-tab-item" data-index="1" data-reactid="7" statusid="0"><a href="javascript:GetDataList(0);" >待付款</a></li>
					<li class="cf-tab-item" data-index="1" data-reactid="7" statusid="1"><a href="javascript:GetDataList(1);" >待发货</a></li>
					<li class="cf-tab-item" data-index="1" data-reactid="7" statusid="2"><a href="javascript:GetDataList(2);" >待收货</a></li>
					<li class="cf-tab-item" data-index="1" data-reactid="7" statusid="3"><a href="javascript:GetDataList(3);" >已收货</a></li>
					<li class="cf-tab-item" data-index="1" data-reactid="7" statusid="4"><a href="javascript:GetDataList(4);" >退款/售后</a></li>
				
	    	</ul>
		</div>
	</section>
    	
    	

		<div class="tabs-content">
			<div class="content active" id="list_content">
			</div>
		</div>
        <div id="pay" style="display: none"></div>
        
        <input type="hidden" name="status_hidden" id="status_hidden" value="<?php echo $status; ?>"/>
        <input type="hidden" name="shop_id" id="shop_id" value="<?php echo $shop_id; ?>"/>
    </div>
    <script>
        $(function(){
        	$('.cf-container .cf-tab-item').click(function(){
        		$('.cf-container .cf-tab-item').removeClass('select');
        		$(this).addClass('select');
        	})
        	/* $('.cf-container .cf-tab-item.select').focus();
        	$(".cf-container .cf-content").animate({scrollLeft:$('.cf-container .cf-tab-item.select').offset().left},1000); */
        	var status_hidden=$('#status_hidden').val();
        	GetDataList(status_hidden);
        	$('.cf-container .cf-tab-item').each(function(){
        		if($(this).attr("statusid") == status_hidden)
        			{
        			$(this).addClass('select');
        			}
        	});
        })
        function GetDataList(status){
        	$.ajax({
        		type:'post',
        		async:true,
        		data:{'status':status,'shop_id':$('#shop_id').val()},
        		dataType:'json',
        		beforeSend:function(){
        			showLoadMaskLayer();
        		},
        		success:function(data){
        			var datahtml="";
        			if(data.length==0){
        				datahtml+='<div class="myorder-none" ><i class="icon-none"></i><span class="none_01">您还没有相关的订单</span><span class="none_02">去看看大家都在买什么吧</span><span class="none_03"><a href="APP_MAIN/Goods/goodsList.html">随便逛逛</a></span></div>';
        			
        			}else{
        				for(var i=0;i<data.length;i++){
	        				var ordersitem=data[i];
	        				datahtml+='<div class="list-myorder" style="margin-top:30px">';
	        				datahtml+='<div class="ordernumber" style="height:auto;overflow:hidden;line-height:22px;"><span class="order-num" style="font-size: 12px;">'+ordersitem['out_trade_no']+'</span><span class="order-date" style="font-size: 12px;">'+ordersitem['create_time']+'</span></div>';
	        				datahtml+='<ul class="ul-product">';
	        				
	        				for(var j=0;j<ordersitem['order_item_list'].length;j++){
	        					
	        					var goodsitem=ordersitem['order_item_list'][j];
	        					datahtml+='<li><a href="APP_MAIN/Order/orderDetail.html?orderId='+goodsitem['order_id']+'">';
	        					datahtml+='<span class="pic">';
	        					
	        					datahtml+='<img src="__ROOT__/'+goodsitem['picture']['pic_cover_micro']+'"></span>';
	        					datahtml+='<div class="text">';
	        					datahtml+='<span class="pro-name" style="font-size: 12px;">'+goodsitem['goods_name']+'</span>';
	        					
	        					datahtml+='<div class="pro-pric" style="margin-top: 5px;"><span style="font-size: 12px;">价&nbsp;&nbsp;&nbsp;格:</span><b style="font-size:12px;font-weight:normal;">￥'+goodsitem['price']+'</b></div>';
	        					
	        					datahtml+='<div class="pro-pric" style="margin-top: 0px;"><span style="font-size: 12px;">规&nbsp;&nbsp;&nbsp;格:</span><b style="font-size:12px;font-weight:normal;">'+goodsitem['sku_name']+'</b></div>';
	        					datahtml+='<div class="pro-pric" style="margin-top: 5px;"><span style="font-size: 12px;">数量:</span><b style="font-size:12px;font-weight:normal;">'+goodsitem['num']+'件</b></div>';
	        					datahtml+='</div></a>';
	        					datahtml+='<div class="div-return">';
	        					
	        					if(ordersitem['is_refund']==1 && goodsitem['refund_status']==0){
	        						datahtml+='<input type="button" onclick="window.location.href=\'APP_MAIN/Order/refundDetail.html?order_goods_id='+goodsitem['order_goods_id']+'\'" style="-webkit-border-radius:3px;-moz-border-radius:3px;-o-border-radius:3px;border-radius:3px;border:1px solid red;color:#F37872;background-color:white;font-size: 12px;padding:5px 10px 5px 10px;" value="退款/退货" />';
	        					}
	        					if(goodsitem['refund_status']!=0){
	        						datahtml+='<input type="button" onclick="window.location.href=\'APP_MAIN/Order/refundDetail.html?order_goods_id='+goodsitem['order_goods_id']+'\'" style="-webkit-border-radius:3px;-moz-border-radius:3px;-o-border-radius:3px;border-radius:3px;border:1px solid red;color:#F37872;background-color:white;font-size: 12px;padding:5px 10px 5px 10px;" value="'+goodsitem['status_name']+'" />';
	        					}
	        					
	        					datahtml+='</div>';
	        					if(goodsitem['shipping_status']!=0){
	        						datahtml+='<div style="width:100%;height:20px;color:#999999;margin-top: 5px;font-size: 12px;border-top: 1px dotted #ccc;padding-top:5px">';
	        						datahtml+='<div style="width:20%;float:left;">已发货</div></div>';
	        					}
	        					datahtml+='</li>';
	        				}
							datahtml+='</ul>';
							datahtml+='<div class="totle">';
							datahtml+='<span class="status">'+ordersitem['status_name']+'</span>';
							datahtml+='<span class="price">￥'+ordersitem['pay_money']+'</span>';
							datahtml+='<span class="pric-lable">总价</span>';
							datahtml+='<span class="prc-num"></span></div>';
							datahtml+='<div class="div-button">';
							if(ordersitem['member_operation']!=''){
								for(var x=0;x<ordersitem['member_operation'].length;x++){
									operationitem=ordersitem['member_operation'][x];
									datahtml+='<a href="javascript:void(0)" class="button [radius round] red" style="background-color: '+operationitem['color']+';border: 1px solid '+operationitem['color']+';" onclick="operation(\''+operationitem['no']+'\','+ordersitem['order_id']+')">'+operationitem['name']+'</a>';
								}
							}
							datahtml+='</div></div>';
	        			}
        			
        			}

        			$('#list_content').html(datahtml);
        			updateLoadMaskLayerHeight($(document).height());
        			hiddenLoadMaskLayer();
        		}
        	});
        }
    </script>

	
	
	<!-- 加载弹出层 -->
	<div class="mask-layer-loading">
		<img src="__TEMP__/<?php echo $style; ?>/public/images/mask_load.gif"/>
		<!-- <i class="fa fa-spinner fa-pulse"></i> -->
	</div>
	
</body>
</html>