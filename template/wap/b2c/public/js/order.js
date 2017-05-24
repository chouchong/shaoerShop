/**
 * 订单操作js
 * 作用：订单流程相关操作
 * 2017-01-07
 */
/**
 * 订单操作中转
 * @param no
 * @param order_id
 */
function operation(no,order_id)
{
	switch(no){
	case 'pay'://支付
		pay(order_id);
		break;
	case 'close'://订单关闭
		orderClose(order_id);
		break;
	case 'getdelivery'://订单收货
		getdelivery(order_id);
		break;
	case 'refund'://申请退款
		orderRefund(order_id);
		break;
	default:
		break;
			
	}
}
/**
 * 微信支付
 * @param order_id
 */
function pay(order_id)
{
	window.location.href = "orderPay?id="+order_id;
}

/**
 * 订单交易关闭
 * @param order_id
 */
function orderClose(order_id)
{
	   $.ajax({
			type : "post",
			url : "orderClose",
			async : true,
			data : {
				"order_id" : order_id
			},
			success : function(data) {
				if(data["code"] > 0 ){
					showBox("关闭成功");
					window.location.reload();
				}
			}
		})
}
/**
 * 订单收货
 * @param order_id
 */
function getdelivery(order_id)
{
	$.ajax({
		type : "post",
		url : "orderTakeDelivery",
		async : true,
		data : {
			"order_id" : order_id
		},
		success : function(data) {
			if(data["code"] > 0 ){
				showBox("收货成功");
			}
		}
	})
}
/*****************************************************************************************************订单退款项目*************************************************************************/

