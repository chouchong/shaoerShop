/**
 * 待付款订单相关操作
 * 
 */
$(function() {
	//初始化合计
	var total_money = parseFloat($("#hidden_count_money").val());//商品金额
	if($("#is_calculate_express").val() ==1){
		total_money += parseFloat($("#hidden_express").val());//运费
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
			$.msg("可用余额输入格式错误",{time:1000});
		}
		return false;
	}
	
	var user_money = $("#member_balance").attr("data-max");// 最大可用余额
	if (parseFloat(member_balance) > parseFloat(user_money)) {
		if(is_show){
			$.msg("不能超过可用余额！",{time:1000});
			$("#member_balance").val($("#member_balance").attr("data-max"));
		}
		return false;
	}
	
	//可用余额不能超过订单总计
	if(parseFloat(member_balance)>parseFloat(max_total)){
		if(is_show){
			$.msg("可用余额不能超过应付款金额！",{time:1000});
			$("#member_balance").val(max_total);
		}
		return false;
	}
	
//	// 无法计算运费
//	if($("#is_calculate_express").val() ==0){
//		$.msg($("#res_message").val(),{time:1000});
//		return false;
//	}

	if ($("#addressid").val() == undefined ||$("#addressid").val() == '' ) {
		$.msg("请先选择收货地址",{time:1000});
		return false;
	}

	//$(".js-order-use_coupon").parent().addClass("checkout_other2");
	//$(".js-order-use_coupon").find("span").text("-");
	//if (leavemessage == "") {
	//$(".js-order-leave-message").parent().addClass("checkout_other2");
	//$(".js-order-leave-message").find("span").text("-");
		// $("#leavemessage").focus();
		// $.msg("请填写订单留言");
		// return;
	// }

	flag = false;//验证成功后，将防止重复提交的标识改完false
	return true;
}

/**
 * 计算总金额
 * 2017年5月8日 13:55:48
 */
function calculateTotalAmount(){
	// 商品总价
	var money = parseFloat($("#hidden_count_money").val());
	var total_discount = 0;//总优惠

	// 运费
	if($("#is_calculate_express").val() ==1){
		money += parseFloat($("#hidden_express").val());
	}else{
		$.msg($("#res_message").val(),{time:1000});
	}

	if(parseFloat($("#hidden_discount_money").val())>0){
		total_discount+= parseFloat($("#hidden_discount_money").val());//满减送
		money-= parseFloat($("#hidden_discount_money").val());
	}
	
	total_discount+= parseFloat($("#hidden_discount_money").val());//满减送
	
	//可用余额
	var member_balance = $("#member_balance").val() == "" ? 0:parseFloat($("#member_balance").val());
	if(member_balance>0){
		money -= member_balance;
		total_discount += member_balance;
	}

	// 优惠券
	if ($("#use_coupon").attr("data-money") != 0) {
		// 价格
		money -= parseFloat($("#use_coupon").attr("data-money"));
		if(money>0){
			total_discount += parseFloat($("#use_coupon").attr("data-money"));
		}
	}
	if(money<0){
		money = 0;
	}
	$("#realprice").text("￥" + money.toFixed(2));//合计
	$("#realprice").attr("data-total-money",money.toFixed(2));//合计[实际付款金额]（包含优惠券、运费）
	$("#discount_money").text("￥"+total_discount.toFixed(2))//总优惠
}

// 选择优惠卷
function changeUseCoupon(obj) {
	$("#use_coupon").val($(obj).val());// 优惠券
	$("#use_coupon").attr("data-money",$(obj).find("option:selected").attr("data-money"));
	calculateTotalAmount();
}

var flag = false;//防止重复提交
// 创建订单
function submitOrder() {
	if(validationOrder(true)){
		// 无法计算运费
		if($("#is_calculate_express").val() ==0){
			$.msg($("#res_message").val(),{time:1000});
			return;
		}else{
			if(flag){
				return;
			}
			flag = true;
			var goods_sku_list = $("#goods_sku_list").val();// 商品Skulist
			var leavemessage = $("#leavemessage").val();// 订单留言
			var use_coupon = $("#use_coupon").val();//优惠券id
			var account_balance = $("#member_balance").val() == "" ? 0 : $("#member_balance").val();//可用余额
			var integral = $("#count_point_exchange").val() == ""?0 : $("#count_point_exchange").val();//积分
			$.ajax({
				url : shop_main + "/Order/orderCreate/",
				type : "post",
				data : {
					"goods_sku_list" : goods_sku_list,
					"leavemessage" : leavemessage,
					"use_coupon" : use_coupon,
					"integral" : integral,
					"account_balance" : account_balance
				},
				success : function(res) {
					if (res.code > 0) {
						//如果实际付款金额为0，跳转到个人中心的订单界面中
						if(parseInt($("#realprice").attr("data-total-money")) == 0){
//							window.location.href = shop_main + '/member/orderlist';
							window.location.href = app_main + '/Pay/payCallback?msg=1&out_trade_no' + res.code;
						}else{
							window.location.href = app_main + '/pay/getpayvalue?out_trade_no=' + res.code;
						}
					}else{
						$.msg(res.message);
						flag = false;
					}
				}
			});
		}
	}
}