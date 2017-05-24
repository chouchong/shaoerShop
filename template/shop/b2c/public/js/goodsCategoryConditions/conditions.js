/**
 * 商品分类筛选 2017年2月22日 09:51:18 wyj
 */

/**
 * 条件筛选查询 2017年2月22日 09:54:58
 */
function searchConditions() {
	var min_price = $("#min_price").val();
	var max_price = $("#max_price").val();
	var url_parameter = $("#hidden_url_parameter").val();
	if (min_price == "" || max_price == "") {
		if(min_price == '' && max_price != ''){
			$.msg("应搜索大于等于此价格的商品");
			return;
		}else if(min_price != '' && max_price == ''){
			$.msg("应搜索小于等于此价格的商品");
			return;
		}
		/*$("#min_price").focus();
		return;*/
	} else {
		if (parseFloat(min_price) > parseFloat(max_price) || min_price.length > 15
				|| max_price.length > 15) {
			$.msg("价格输入错误");
			return;
		}
		var url = shop_main + "/goods/goodslist.html?" + url_parameter;
		url += "&min_price=" + min_price + "&max_price=" + max_price;
		location.href = url;
	}
}
// 是否多选
var isMore = false;
// 同一类，多选条件进行筛选，显示
// ns_category.js会控制“确定”按钮的样式
function showDuoXuan(obj) {
	$(obj).find(".duoxuan-btnbox").css("text-align", "center");
	$(obj).find(".duoxuan-btnbox").show();
	isMore = true;
}
// 同一类，多选条件进行筛选 隐藏
function hiddenDuoXuan(obj) {
	$(obj).find(".duoxuan-btnbox").hide();
	$("#brand-abox").find("li").removeClass("brand-seled");
	$(".select-button-sumbit").addClass("disabled");
	$(".select-button-sumbit").removeClass("select-button-sumbit");
	isMore = false;
}
// 单个品牌查询
function selectBrand(obj, brand_id, brand_name) {
	var url_parameter = $("#hidden_url_parameter").val();
	if ($(obj).parent().hasClass("brand-seled")) {
		$(obj).parent().removeClass("brand-seled");
	} else {
		$(obj).parent().addClass("brand-seled");
	}
	// 单选
	if (!isMore) {
		$("#brand-abox").find("li").removeClass("brand-seled");
		var url = shop_main + "/goods/goodslist.html?" + url_parameter;
		url += "&brand_id=" + brand_id + "&brand_name=" + brand_name;
		location.href = url;
	}
}

// 多个品牌查询
function brandMoreSearch(obj) {
	if (!$(obj).hasClass("disabled")) {
		var url_parameter = $("#hidden_url_parameter").val();
		var arr_id = new Array();
		var arr_name = new Array();
		$("#brand-abox").find(".brand-seled").each(function() {
			arr_id.push($(this).attr("data-brand-id"));
			arr_name.push($(this).attr("data-brand-name"));
		})
		var brand_id = arr_id.join(",");
		var brand_name = arr_name.join(",");
		var url = shop_main + "/goods/goodslist.html?" + url_parameter;
		url += "&brand_id=" + brand_id + "&brand_name=" + brand_name;
		location.href = url;
	}
}