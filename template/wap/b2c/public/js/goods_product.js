/**
 * 商品详情相关
 * 选择加入购物车，立即购买，商品限购等操作
 * 2017-01-07
 */

/**
 * 点击确定触发事件
 */
$(document).ready(function() {
	$("div[name='specvals']").each(function() {
		if (this.children.length === 1) {
			change(this.children[0]);
		}
	})
	// 点击确定触发事件
	$('#submit_ok').bind("click",function() {
		if($("#uid").val() == null || $("#uid").val() == ""){
			window.location.href = ""+ APPMAIN+ "/login";
		}else{
			if ($("#hiddStock").val() == 0) {
				showBox("商品已售罄");
			} else {
				var trueId = "";
				var count = "";
				var $uiskuprop = $(".s-buy-ul .right button");
				var $uiskupropCount = $(".s-buy-ul .s-buy-li").length - 1;
				var flag = 0;
				$($uiskuprop).each(function() {
					flag = $(this).attr("checked") == "checked" ? flag + 1: flag; // 判断所有规格是否都选完整了
				});
				if ($uiskupropCount === flag) {
					var purchaseSum = $("#max_buy").val() * 1;
					var currentNum = $("#hidden_current_num").val() * 1;
					var num = $("#num").val() * 1;
					var nummax = $("#num").attr("max") * 1;
					if(currentNum!=0 && currentNum == purchaseSum){
						showBox("此商品限购，您最多可购买"+ purchaseSum+ "件");
						return;
					}
					if (num >= 1) {
						if (num <= nummax) {
							if (num <= purchaseSum|| purchaseSum == 0) {
								var cart_detail = new Object();
								cart_detail.trueId = $("#hiddPDetailID").val();
								cart_detail.count = $("#num").val();
								cart_detail.goods_name = $("#itemName").text();
								cart_detail.select_skuid = $("#hiddSkuId").val();
								cart_detail.shop_id = $("#hidden_shop_id").val();
								cart_detail.shop_name = $("#hidden_shop_name").val();
	
								cart_detail.select_skuName = $("#hiddSkuName").val();
								cart_detail.price = $("#hiddSkuprice").val();
								//没有SKU商品，获取第一个
								if(cart_detail.select_skuid==null||cart_detail.select_skuid=="")
								{
									cart_detail.select_skuid = $("#goods_sku0").attr("skuid");
									cart_detail.select_skuName = $("#goods_sku0").attr("skuname");
									cart_detail.price = $("#goods_sku0").attr("price");
								}
								cart_detail.picture = $("#default_img").val();
								cart_detail.cost_price = $("#cost_price").text();
								var cart_tag = $("#submit_ok").attr("tag");
								if(cart_tag == "addCart"){
									$.ajax({
										url :  APPMAIN + "/Goods/addCart",
										async : true,
										type : "post",
										data : {
											"cart_detail" : cart_detail,
											"cart_tag" : cart_tag
										},
										success : function(data) {
											$('body').css("overflow", "auto");
											if (data == '-1') {
												showBox("只有会员登录之后才能购买，请进入会员中心注册或登录。");
												window.location.href = ""+ APPMAIN+ "/Member";
											}else if(data == 0){
												showBox("该商品限购"+purchaseSum+"，请您检查购物车");
												$("#s_buy").slideUp();
												$("#mask").hide();
												$("#addcart_way").show();
												$("#addcart_way").addClass("addcart-way");
												$("#loading").hide();
												$(".js-bottom-opts").show();
												$("#global-cart").addClass("buy-cart-msg");
											}else {
												$("#s_buy").slideUp();
												$("#mask").hide();
												$("#addcart_way").show();
												$("#addcart_way").addClass("addcart-way");
												if ($("#submit_ok").attr("tag") == "addCart") {
													var new_count = $("#countcart").text()* 1+ cart_detail.count* 1;
													$("#icon_tip_code").show();
													$("#countcart").show();
													$("#countcart").text(new_count);
												}
												$("#loading").hide();
												$(".js-bottom-opts").show();
												$("#global-cart").addClass("buy-cart-msg");
												// 添加购物车
												if ($("#submit_ok").attr("tag") == "addCart") {
													if (purchaseSum != 0) {
														var tempCoun = purchaseSum - count;
														if (tempCoun == 0) {
															$("#purchaseSum").val(-1);
														} else {
															$("#purchaseSum").val(purchaseSum- count);
														}
													}
	//												$("#s_buy").slideUp();
	//												$("#mask").hide();
	//												$("#addcart_way").show();
	//												$("#addcart_way").addClass("addcart-way");
//													setTimeout(function() {
//														$("#success_tip_line").fadeIn();
//													},1000);
//													setTimeout(function() {
//														$("#success_tip_line").fadeOut();
//													},3000);
													$('#submit_ok').show();
													showBox("加入购物车成功");
												}
												$("#loading").hide();
											}
										}
									});
								}else{
									var skuid = $("#hiddSkuId").val();
									var num = $("#num").val();
									//没有SKU商品，获取第一个
									if(skuid==null||skuid=="")
									{
										skuid = $("#goods_sku0").attr("skuid");
									}
									//立即购买
									$.ajax({
										url : APPMAIN + "/Order/orderCreateSession",
										type : "post",
										data : { "tag" : "buy_now", "sku_id" : skuid, "num" :num },
										success : function(res){
											window.location.href = APPMAIN+"/Order/PaymentOrder";
										}
									});
								}
							} else {
								if (purchaseSum <= 0) {
									purchaseSum = 0;
								}
								showBox("此商品限购，您最多可购买"+ purchaseSum+ "件");
							}
						} else {
							showBox("库存不足");
						}
					} else {
						showBox("商品的数量至少为1");
					}
				} else {
					showBox("请选择完整的商品规格");
				}
			}
		}
	});

/**
* 点击加入购物车，立即购买等触发
* 
*/
$(function() {
// 是否下架
	if ($("#is_sale").val() != 1) {
		$(".js-shelves").css("display","block");
//		$(".product-status").css("display", "block");
		$(".js-bottom-opts").css("display","none");
	}
	// shopping progress
	$("#addCart,#buyBtn1,#groupbuy").on("click",function(e) {
		if ($("#member_uid").val() == 0) {
			if (window.confirm("只有会员登录之后才能购买，是否会员中心注册或登录?")) {
				window.location.href = APPMAIN + "/MemberCenter/member";
			}
		} else if ($("#max_buy").val() == -1) {
			$(".product-status").css("display", "block");
			$(".product-status").find("span[name='state']").text("您的购买已达上限！");
			return false;
		} else {
			flag = $("#is_sale").val();
			activity_state = $("#activity_state").val();
			if (flag == '1') {
				if (activity_state == undefined || activity_state == "1") {
					$("body").css({ overflow : "hidden"});
					$(".bar_wrap").hide();
					$("#mask").show();
					$("#s_buy").show();
					$("#s_buy").animate({bottom : "0"}, "1200");
					$("#addcart_way").removeClass("addcart-way");
					$("#submit_ok").attr("tag",e.target.id);
					//库存等于0变成灰色
					if ($("#hiddStock").val() == 0) {
						$("#submit_ok").css("background","#969292");
					}
					// 加入购物车
					if (e.target.id == 'addCart') {
						$(".js-bottom-opts").hide();
						$("#submit_ok").text("加入购物车");
					} else {
						$(".js-bottom-opts").hide();
						$("#submit_ok").text("下一步");
					}
				} else {
					if (activity_state == "0") {
						$(".product-status").css("display","block");
						$(".product-status").find("span[name='state']").text("活动未开始");
					} else if (activity_state == "2") {
						$(".product-status").css("display","block");
						$(".product-status").find("span[name='state']").text("活动已结束");
					} else if (activity_state == "-1") {
						$(".product-status").css("display","block");
						$(".product-status").find("span[name='state']").text("活动已关闭");
					}
				}
			} else {
				showBox("该商品已下架");
			}
		}
	})
	
	$("#mask,#icon_close").on("click", function() {
		$("#s_buy").animate({ bottom : "-800px" }, "1200");
		$("#mask").hide();
		$('body').css("overflow", "auto");
		$(".js-bottom-opts").show();
	})

	$("#a-know").on("click", function() {
		$("#share-tip").fadeOut();
	})

})

function CheckInt(obj) {
	var pattern = /^[1-9]\d*|0$/; // 匹配非负整数
	if (!pattern.test(obj)) {
		return false;
	} else {
		return true;
	}
}

function preventNo(e) {
	e.preventDefault();
}

$('#btnShare').bind("click",function() {
	var topheight = document.body.scrollTop;
	var scrollHeight = document.body.scrollHeight;
	$("#mask-bg").attr("style","height:" + (scrollHeight + topheight) + "px");
	$("#mask-content").attr("style","padding-top:" + topheight + "px");
	$("#mask-bg").show();
	$("#mask-content").show();
	document.addEventListener('touchmove',preventNo, false);
});

$('#mask-bg').bind("click",function() {
	$("#mask-bg").hide();
	$("#mask-content").hide();
	document.removeEventListener('touchmove',preventNo, false);
});

$('#mask-content').bind("click",function() {
	$("#mask-bg").hide();
	$("#mask-content").hide();
	document.removeEventListener('touchmove',preventNo, false);
});

// huxl
$("#distribution-apply").click(function(event) {
	event.preventDefault();
	$("#distribution-tip").fadeIn();
	setTimeout(function() {
		$("#distribution-tip").fadeOut();
	}, 4000)
});

// close advertisement
$("#advertisement-close").click(function() {
	$("#advertisement-apptip").hide();
	$("#fromesb-wechat").animate({ top : 0 });
})

// contact float
$("#contFloat").click(function(event) {
	event.preventDefault();
	$("#contFloat-detail").show();
})

$("#contFloat-detail-close").click(function() {
	$("#contFloat-detail").hide();
})

$("#mask,#icon_close").click(function() {
	$("#s_buy").slideUp();
	$("#mask").hide();
	$('body').css("overflow", "auto");
})

// $("#submit_ok").click(function () {
	// $("#s_buy").slideUp();
	// $("#mask").hide();
	// $("#addcart_way").show();
	// $("#addcart_way").addClass("addcart-way");
	// setTimeout(function () {
		// $("#success_tip_line").fadeIn();
	// }, 1000);
	// setTimeout(function () {
		// $("#success_tip_line").fadeOut();
	// }, 3000);
// })

});

var specificationValueDatas = {};
var productDatas = {};
var obj = {
	Span0 : "",
	Span1 : "",
	Span2 : "",
	Span3 : "",
	Span4 : ""
};
// 样式选择事件
function change(span) {

	$('button[name=' + $(span).attr('name') + ']').each(function() {

		$(this).removeClass("current");
		$(this).attr("checked", false);

	});

	// obj[$(span).attr('name')] = span.innerHTML;

	$(span).addClass("current");

	$(span).attr("checked", true);


	var specificationValueSelecteds = '';
	var $specificationValueSelected = $(".s-buy-ul .right button");
	$specificationValueSelected.each(function(i) {
		var $this = $(this);
		if ($this.attr("checked") == "checked") {
			specificationValueSelecteds += $this.attr("id") + ";";
		}
	});

	for (i = 0; i < 200; i++) {
		sku_id = "#goods_sku" + i;
		goods_sku_name = $(sku_id).val();
		if (specificationValueSelecteds == goods_sku_name) {
			select_skuid = $(sku_id).attr("skuid");
			select_skuName = $(sku_id).attr("skuname");
			stock = $(sku_id).attr("stock");
			// price = $(sku_id).attr("price");
			if(stock==0){
				$("#submit_ok").css("background","#969292");
			}
			$("#Stock").text("剩余" + stock + "件");
			$("#num").attr("max", stock);
			// $("#price").text("¥"+price);
			$("#hiddSkuId").val(select_skuid);
			$("#hiddSkuName").val(select_skuName);
			// $("#hiddSkuprice").val(price);
			// alert(select_skuid);
			// alert(heima_module);
			active = $("#submit_ok").attr("tag");
			if (active == 'addCart' || active == 'buyBtn1') {
				/*
				 * $.ajax({ url: ""+heima_module+"/Weishop/sku_price_select/",
				 * type: "post", asysc: false, data: { "sku_id":select_skuid },
				 * success: function (res) { //alert(res);
				 * //alert(res['retval']); if (res != null) { var price = res;
				 * $("#price").text("¥"+price); $("#hiddSkuprice").val(price); }
				 * else { show("系统网络出现问题");
				 * window.location.href=""++"/Weishop/WeishopList/" } }
				 * });
				 */
				price = $(sku_id).attr("price");
				$("#price").text("¥" + price);
				$("#hiddSkuprice").val(price);
			} else if (active == "groupbuy") {
			}
		}
	}

	select();
}

function select() {
	var html = '';
	for ( var i in obj) {
		if (obj[i] != '') {
			html += '<font color=orange>"' + obj[i] + '"</font> 、';
		}
	}
	// html = '<b> 已选择:</b> ' + html.slice(0, html.length - 1);
	// $('#resultSpan').html(html);

}

function imgview() {
	var arr = $("#imgs").val();
	var c = arr.substring(0, arr.length - 1).split(',');
	var index = $("#imgpage").text().split('/') - 1;
	if (typeof window.WeixinJSBridge != 'undefined') {
		WeixinJSBridge.invoke("imagePreview", {
			current : c[index],
			urls : c
		});
	}
}
function showPic() {
	$("#content").html(hdata);
	$("#p-detailoff").hide();
	$("#p-detail").show();

};
window.onload = function() {
	if (typeof window.WeixinJSBridge != 'undefined') {
		document.addEventListener("WeixinJSBridgeReady", onWeixinReady, false);
	} else {
		$("#p-detailoff").show();
	}
}
function onWeixinReady() {
	WeixinJSBridge.invoke('getNetworkType', {}, function(e) {
		WeixinJSBridge.log(e.err_msg);
		var state = e.err_msg.split(':')[1];
		if (state == "wifi") {
			$("#content").html(hdata);
			$("#p-detail").show();
		} else {
			$("#p-detailoff").show();
		}
	});
}
$(function() {
	$(".add").click(function() {
		var num = $("#num").val() * 1;
		var max_buy = $("#max_buy").val() * 1;
		var nummax = $("#num").attr('max') * 1;
		if (num >= max_buy && max_buy != 0) {
			var buy_num = max_buy;
			if (max_buy == -1) {
				buy_num = 0;
			}
			$(this).addClass("quantity-minus-disabled");
			// alert("此商品限购，您最多可购买" + buy_num + "件");
			showBox("此商品限购，您最多可购买" + buy_num + "件");
		} else if (num < nummax) {
			num = num + 1;
			$(this).removeClass("quantity-minus-disabled");
		}
		$(".reduce").removeClass("quantity-minus-disabled");
		$("#num").val(num);
	})
	$(".reduce").click(function() {
		var num = $("#num").val() * 1;
		if (num > 1) {
			num = num - 1;
			if (num == 1) {
				$(this).addClass("quantity-minus-disabled");
			}
		} else {
			$(this).addClass("quantity-minus-disabled");
		}
		$(".add").removeClass("quantity-minus-disabled");
		$("#num").val(num);
	})
	$("#num").bind("input propertychange", function() {
		var num = $(this).val() * 1;
		var max_buy = $("#max_buy").val() * 1;
		var nummax = $(this).attr('max') * 1;
		if (num >= max_buy && max_buy != 0) {
			showBox("此商品限购，您最多可购买" + max_buy + "件");
			num = max_buy;
		} else if (num > nummax) {
			num = nummax;
		}
		if (isNaN(num)) {
			num = 1;
		}
		$(this).val(num);
	})
})