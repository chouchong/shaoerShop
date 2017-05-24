$(function() {
	$("input[name='fare']").change(function() {
		if ($("input[name='fare']:checked").val() == 1) {
			$("#deliveryDiv").show();
		} else {
			$("#deliveryDiv").hide();
		}
	});
});

function integrationChange(event) {
	$integration_val = $(event).val();
	if ($integration_val < 0) {
		$(event).val(0);
	}
}
/**
 * 上传图片，可以多图一起，也可以单图 sample.js 调用
 */
function UploadImage(event, ADMIN_MAIN, flag) {
	shopImageFlag = flag;
	speciFicationsFlag = 0;
	OpenPricureDialog("PopPicure", ADMIN_MAIN, 1);
}

var flag = false;//防止重复提交
// 基础数据页面的提交按钮点击事件
function SubmitProductInfo(type, ADMIN_MAIN,SHOP_MAIN) {
	img_id_arr = "";// 商品主图（5张）
	var leftCss = new Array();
	// 第一个循环对商品图片进行排序
	for (var j = 0; j < 5; j++) {
		var left = $("#file_upload_img_" + (j + 1)).parent().css("left")
				.replace("px", "");// 获取每个图片对应的坐标位置
		var imgid = $("#file_upload_img_" + (j + 1)).parent().attr("js-img");
		leftCss.push(left + ":" + imgid);
	}
	leftCss.sort();// 对数据进行排序
	for (var i = 0; i < leftCss.length; i++) {
		var index = leftCss[i].split(":")[1];
		if ($("#file_upload_img_" + (index)).attr("data-id") != null
				&& $("#file_upload_img_" + (index)).attr("data-id") != '') {
			img_id_arr += $("#file_upload_img_" + (index)).attr("data-id")
					+ ",";
		}
	}
	// ue.setContent(leftCss.toString(), true);//测试用
	// ue.setContent("排序后：" + leftCss.toString(), true);//测试用
	img_id_arr = img_id_arr.substr(0, img_id_arr.length - 1);
	// ue.setContent("排序后的图片Id：" + img_id_arr, true);//测试用
	// alert(img_id_arr+", [0]:"+);
	// return;//测试用
	// 禁用按钮
	var validateResult = ValidateUserInput(); // 验证用户输
	if (validateResult == true) {
		$("#lastPage,#btnSave,#btnSave2").attr("disabled", "disabled");
		var productViewObj = PackageProductInfo();
		var $code = 1;
		var $qrcode = $("#hidQRcode").val();
		if ($qrcode == "") {
			$code = 1;
		} else {
			$code = 0;
		}
		if(flag){
			return;
		}
		flag = true;
//		 var asd = JSON.stringify(productViewObj);
//		 alert(asd);
//		 return;
		$.ajax({
			url : "GoodsCreateOrUpdate",
			type : "post",
			// async : false,
			data : { "product" : productViewObj , "is_qrcode" : $code},
			dateType : "json",
			success : function(res) {
//				 alert("res:" + JSON.stringify(res));
//				 return;
				var url = ADMIN_MAIN + "/goods/goodslist";
				var goodsid = parseInt($("#goodsId").val());
				var text = "";
				if (res == 1) {
					if (type == 1) {
						url = SHOP_MAIN + "/goods/goodsinfo?goodsid="+goodsid;// 跳转到前台
					}
					showMessage('success', "商品发布成功", url);
				} else {
					showMessage('error', "商品发布失败", url);
				}
				flag = false;
			}
		});
	}
}

/**
 * 创建时间：2015年6月11日18:07:10 创建人：高伟 功能说明：获取数据已对象方式存储
 */
function PackageProductInfo() {
	// 初始化一个实体 将页面所需的数据存放到对象中
	var shop_type = $("#shop_type").val();
	var productViewObj = new Object();
	productViewObj.goodsId = $("#goodsId").val();// 商品id 11号目前为死值 0
	productViewObj.title = $("#txtProductTitle").val().replace(/^\s*/g, "")
			.replace(/\s*$/g, "");// 商品标题
	productViewObj.categoryId = $("#tbcName").attr("cid");// 商品类目 
	// 12号 商品类目；
	productViewObj.cost_price = $("#txtProductCostPrice").val().replace(/^\s*/g, "").replace(/\s*$/g, "") == "" ? 0 : $("#txtProductCostPrice").val().replace(/^\s*/g, "").replace(/\s*$/g,"");// 商品成本价
	productViewObj.price = $("#txtProductSalePrice").val().replace(/^\s*/g, "").replace(/\s*$/g, "");// 商品现价
	productViewObj.market_price = $("#txtProductMarketPrice").val().replace(/^\s*/g, "").replace(/\s*$/g, "");// 商品现价
	productViewObj.libiary_goodsid = $("#libiary_goodsid").val(); // 商品库id
	productViewObj.base_sales = $("#BasicSales").val() == '' ? 0 : $("#BasicSales").val();// 基础销量
	productViewObj.base_good = $("#BasicPraise").val() == '' ? 0 : $("#BasicPraise").val();// 基础点赞数
	productViewObj.base_share = $("#BasicShare").val() == '' ? 0 : $("#BasicShare").val();// 基础分享数
	productViewObj.code = $("#txtProductCodeA").val();// 商品编码
	productViewObj.type = 0;// 商品类别 11号目前为死值
	var skuIsChange = $("#skuIsChange").val();// sku是否发生过改变
	productViewObj.sku_is_changed = skuIsChange;
	productViewObj.is_sale = $("input[name='shelves']:checked").val();// 上下架标记
	productViewObj.display_stock = $('.controls input[name="stock"]:checked ').val();// 是否显示库存
	productViewObj.stock = $("#txtProductCount").val();// 总库存
	productViewObj.minstock = $("#txtMinStockLaram").val();// 库存预警数
	productViewObj.max_buy = $("#PurchaseSum").val().replace(/^\s*/g, "").replace(/\s*$/g, "") == "" ? 0 : $("#PurchaseSum").val().replace(/^\s*/g, "").replace(/\s*$/g, "");// 每人限购
	productViewObj.introduction = "商品简介";// 商品简介
	productViewObj.description = UE.getEditor('editor').getContent();// 商品描述
	productViewObj.shipping_fee = $("input[name='fare']:checked").val();// 运费方式
	productViewObj.express_config = 1;// 统一使用模板
	productViewObj.express_price = 0;// 统一邮费价格
	productViewObj.shipping_fee_id = $("input[name='fare']:checked").val() != 1 ? 0 : $("#deliverySelect").val();// 运费模板编号
	var shopCategoryText = "";
	$("#productcategory-selected span").each(function() {
		shopCategoryText += $(this).attr("id") + ",";
	})
	if (shopCategoryText != "") {
		shopCategoryText = shopCategoryText.substring(0,
				shopCategoryText.length - 1);
	}
	productViewObj.groupArray = shopCategoryText;
	productViewObj.thumbId = $("#hidthumbnail").val();
	productViewObj.brandId = $("#brandSelect").val();
	productViewObj.mainSrc = "";
	productViewObj.picture = img_id_arr.split(",")[0];
	var imageVals = img_id_arr;// 在页面中获取的
	productViewObj.imageArray = imageVals;// 商品图片分组
	var imgIdArray = "";
	for (var i = 0; i < speciFlcationsImgIdList.length; i++) {
		if (speciFlcationsImgIdList[i] != '') {
			imgIdArray += FirstImgId + "," + atomIdArr[i] + ","
					+ speciFlcationsImgIdList[i] + ";";
		}
	}
	productViewObj.sku_img_array = imgIdArray;// 商品规格图片
	var trs = $('.js-goods-stock .table-sku-stock').show().find('tbody').find('tr');
	var vals = "";
	for (var i = 0; i < trs.length; i++) {
		var tr = $(trs[i]);
		var pvs = tr.attr("sku-ids");
		var skuId = tr.attr("id");
		if (skuId == "") {
			skuId = 0;
		}
		var values = skuId + "¦";
		var tds = tr.find('td');
		for (var y = tds.length - 6; y < tds.length - 1; y++) {
			var $td = $(tds[y]);
			var $input = $td.find('input');
			values += $input.val() + "¦";
		}
		values += "0¦" + pvs + "§";
		vals += values;
	}
	vals = vals.substring(0, vals.length - 1);
	productViewObj.skuArray = vals;
	if (vals == "")
		productViewObj.is_sku = 0;// 是否是sku商品 11号目前为死值
	else
		productViewObj.is_sku = 1;// 是否是sku商品 11号目前为死值
	// 积分购买设置
	productViewObj.integration_available_use = $("#integration_available_use").val() == '' ? 0 : $("#integration_available_use").val();
	productViewObj.integration_available_give = $("#integration_available_give").val() == '' ? 0 : $("#integration_available_give").val();
	productViewObj.goods_class = $("#class_tbname").attr("cid") == '' ? 0 : $("#class_tbname").attr("cid");
	productViewObj.goods_returnRate = $("#txtGoodsReturnRate").val() == '' ? 0 : $("#txtGoodsReturnRate").val();
	if (shop_type == 1) {
		productViewObj.sup_shopid = $("#sup_shopidselect").val();
		productViewObj.sale_area = $("#txtGoodsAreasid").val();
		productViewObj.sup_price = $("#txtProductSupplyPrice").val();
		productViewObj.cb_cost_price = $("#txtProductCBCostPrice").val();
	} else {
		productViewObj.sup_shopid = 0;
		productViewObj.sale_area = "";
		productViewObj.sup_price = 0;
		productViewObj.cb_cost_price = 0;
	}
	productViewObj.point_exchange_type = $("#integralSelect").val();
	productViewObj.province_id = $("#provinceSelect").val();// 商品所在地：省
	productViewObj.city_id = $("#citySelect").val();// 商品所在地：市
	return productViewObj;
}