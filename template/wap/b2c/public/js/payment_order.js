/**
 * 待付款订单相关操作
 * 
 */
$(function() {
	//初始化合计
	var total_money = parseFloat($("#goods_total_money").attr("money"));//商品金额
	if($("#is_calculate_express").val() ==1){
		total_money += parseFloat($("#feeprice").attr("money"));//运费
	}
	$("#realprice").attr("data-old-total-money",total_money);//原合计（不包含优惠）
	
	calculateTotalAmount();
	
	/**
	 * 用户输入可用余额，进行验证，同时变化总优惠、合计
	 * 可用余额，不可超过订单总计,不可超过用户最大可用余额
	 */
	$("#member_balance").keyup(function(){
		if(validationOrder(true)){
			calculateTotalAmount();
		}
	})
	
})

/**
 * 使用优惠券
 * 2017年5月8日 12:29:19 wyj
 * @param obj 当前选中的优惠券
 * @param id 优惠券id
 * @param coupon_code 优惠卷编码
 * @param money 面额
 */
function useCoupon(obj, id, coupon_code, money) {
	if (id == -1) {
		$("#use_coupon").text("不使用优惠券");
		$("#use_coupon").attr("money", 0);
	} else {
		var str = "￥" + money;
		$("#use_coupon").text(str);
		$("#use_coupon").attr("money", money);
	}
	$("#use_coupon").attr("val", id);
	var count = $(".coupon-list li").length;
	for (var i = 0; i < count; i++) {
		$(".coupon-list li").removeClass("active");
	}
	$(obj).parent().parent().addClass("active");
	$(".cd-bouncy-nav-modal").removeClass("fade-in");
	$(".cd-bouncy-nav-modal").addClass("fade-out");
	calculateTotalAmount();
}


/**
 * 验证
 * @param is_show
 * @returns {Boolean}
 */
function validationOrder(is_show){
	var r = /^\d+(\.\d{1,2})?$/;
	var member_balance = $("#member_balance").val() == "" ? 0 : $("#member_balance").val();//可用余额
	var max_total = $("#realprice").attr("data-old-total-money");//总计
	if(!r.test(member_balance)){
		if(is_show){
			showBox("可用余额输入格式错误");
		}
		return false;
	}
	
	var user_money = $("#member_balance").attr("data-max");// 最大可用余额
	if (parseFloat(member_balance) > parseFloat(user_money)) {
		if(is_show){
			showBox("不能超过可用余额！");
			$("#member_balance").val($("#member_balance").attr("data-max"));
		}
		return false;
	}
	
	//可用余额不能超过订单总计
	if(parseFloat(member_balance)>parseFloat(max_total)){
		if(is_show){
			showBox("可用余额不能超过应付款金额！");
			$("#member_balance").val(max_total);
		}
		return false; 
	}
//	
//	// 无法计算运费
//	if($("#is_calculate_express").val() ==0){
//		showBox($("#res_message").val());
////		return false;
//	}

	if ($("#addressid").val() == undefined ||$("#addressid").val() == '' ) {
		showBox("请先选择收货地址");
		return false;
	}

	flag = false;//验证成功后，将防止重复提交的标识改完false
	return true;
}

/**
 * 计算总金额
 * 2017年5月8日 13:55:48
 */
function calculateTotalAmount(){
	// 商品总价
	var money = parseFloat($("#goods_total_money").attr("money"));
	var total_discount = 0;//总优惠

	// 运费
	if($("#is_calculate_express").val() ==1){
		money += parseFloat($("#feeprice").attr("money"));
	}else{
		showBox($("#res_message").val());
	}
	
	if(parseFloat($("#input_discount_money").val())>0){
		total_discount+= parseFloat($("#input_discount_money").val());//满减送
		money-= parseFloat($("#input_discount_money").val());
	}
	
	//可用余额
	var member_balance = $("#member_balance").val() == "" ? 0:parseFloat($("#member_balance").val());
	if(member_balance>0){
		money -= member_balance;
		total_discount += member_balance;
	}

	// 优惠券
	if ($("#use_coupon").attr("val") != -1) {
		// 价格
		money -= parseFloat($("#use_coupon").attr("money"));
		if(money>0){
			total_discount += parseFloat($("#use_coupon").attr("money"));
		}
	}
	if(money<0){
		money = 0;
	}
	$("#realprice").text("￥" + money.toFixed(2));//合计
	$("#realprice").attr("data-total-money",money.toFixed(2));//合计[实际付款金额]（包含优惠券、运费）
	$("#discount_money").text("￥"+total_discount.toFixed(2))//总优惠
}

$("#use_coupon").click(function() {
	$("#mask-layer").show();
	$("#popup-preferential").show();
});
$("#mask-layer").click(function() {
	$("#popup-preferential").hide();
	$(this).hide();
});
$(".btn-green").click(function() {
	$("#mask-layer").hide();
	$("#popup-preferential").hide();
})
$(".js-close").click(function() {
	$("#mask-layer").hide();
	$("#popup-preferential").hide();
})

/**
 * 提交订单
 * 2017年5月8日 18:59:40
 * @param event
 */
var flag = false;//防止重复提交
function submitOrder(event) {
	if(validationOrder(true)){
		// 无法计算运费
		if($("#is_calculate_express").val() ==0){
			showBox($("#res_message").val());
			return;
		}else{
			wechat();
		}
	}
}
// 点击微信支付触发事件
function wechat() {
	var express_method_id = $("#express_method a.active").attr("value");//配送方式
	var goodslist = $("#goodslist").val();//商品sku
	var leavemessage = $("#leavemessage").val();//买家留言
	var use_coupon = $("#use_coupon").attr("val");// 优惠券
	var use_integration = 0;//积分
	if($("#hidden_use_integration").val() != undefined && $("#hidden_use_integration").val() !=''){
		use_integration = $("#hidden_use_integration").val();
	}
	var member_balance = $("#member_balance").val()==""?0:$("#member_balance").val();
	if(flag){
		return;
	}
	flag = true;
	$.ajax({
		url : APPMAIN + "/Order/orderCreate/",
		type : "post",
		data : {
			"goodslist" : goodslist,
			"leavemessage" : leavemessage,
//			"express_method_id" : express_method_id,
			"use_coupon" : use_coupon,
			"use_integration" : use_integration,
			"member_balance" : member_balance
		},
		success : function(res) {
//			alert(JSON.stringify(res));
//			showBox(res.code+","+res.message);
			if (res.code > 0) {
				//如果实际付款的金额为0，则直接进入订单
				if($("#realprice").attr("data-total-money") == 0){
//					window.location.href = APPMAIN + '/order/myorderlist';
					window.location.href = APPMAIN + '/Pay/payCallback?msg=1&out_trade_no' + res.code;
				}else{
					window.location.href = APPMAIN + '/Pay/getPayValue?out_trade_no=' + res.code;
				}
			} else {
				showBox(res.message);
				flag = false;
			}
		}
	});
}

// 计算总优惠
function calculate_youhui() {
	var use_coupon = 0;
	var use_hongbao = 0;
	var use_integration = 0;
	var integrat_money = 0;
	var member_balance = $("#member_balance").val()>0 ? $("#member_balance").val() : 0;
	// if($("#use_coupon").val() != null){
	// use_coupon = parseFloat($("#coupon"+$("#use_coupon").val()).val());
	// }
	// if (parseInt($("#use_integrate").val()) > parseInt($("#use_integrate")
	// .attr("max"))) {
	// showBox("最多可用" + $("#use_integrate").attr("max") + "积分");
	// flag = false;
	// return;
	// } else {
	// flag = true;
	// }
	
	if (parseInt(member_balance) > parseInt($("#member_balance")
			.attr("max"))) {
		showBox("最多可用" + $("#member_balance").attr("max") + "元");
		$("#member_balance").val($("#member_balance").attr("max"));
		member_balance = $("#member_balance").attr("max");
	}
	$money = 0;
	// 优惠券
	if ($("#use_coupon").attr("val") != null
			&& typeof ($("#use_coupon").attr("val")) != "undefine"
			&& $("#use_coupon").attr("val") != -1) {
		// 价格
		$money += $("#use_coupon").attr("money") * 1.0;
	}
	// 积分
	// if ($("#use_integrate").val() != null
	// && typeof ($("#use_integrate").val()) != "undefine") {
	// // 换算价格
	// $money += $("#use_integrate").val()
	// * ($("#convert_rate").attr("rate") * 1.0);
	// }
	$("#favorable").val(
			parseFloat($money.toFixed(2))
					+ parseFloat($("#input_discount_money").val())
					+ parseFloat(member_balance));
	$("#discount_money").text("￥" + $("#favorable").val());
	alculate_total();
}

// 计算最终金额
function alculate_total() {
	if($("#goods_total_money").attr("money") == undefined){
		return;
	}
	$money = 0;
	// 商品总价
	if ($("#goods_total_money").attr("money") != null
			&& typeof ($("#goods_total_money").attr("money")) != "undefined") {
		$money += $("#goods_total_money").attr("money") * 1.0;
	}
	// 运费
	if($("#is_calculate_express").val() ==1)
		{
			if ($("#feeprice").attr("money") != null
					&& typeof ($("#feeprice").attr("money")) != "undefined") {
				$money += $("#feeprice").attr("money") * 1.0;
			}
		}else{
			showBox($("#res_message").val());
		}
	

	// 总优惠（基本优惠+积分+优惠券）
//	if ($("#favorable").val() != null
//			&& typeof ($("#favorable").val()) != "undefined") {
//		$money -= $("#favorable").val() * 1.0;
//	}

	// var real_price =
	// ($("#orderprice").text()*1.0+$("#feeprice").text()*1.0-$("#discount_money").val()*1.0).toFixed(2);
	// if(real_price < 0){
	// real_price = 0.00;
	// }
	$("#realprice").text("￥" + $money);
	$("#member_balance").attr("data-max-total",$money);
//	$("#realprice").text("￥" + $money.toFixed(2).split(".")[0]);
//	$("#realprice-decimal").text("." + $money.toFixed(2).split(".")[1]);
}