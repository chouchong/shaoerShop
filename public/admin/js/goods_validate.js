function IsEmpty(obj) {
	var val = $.trim($(obj).val());
	if (val == "") {
		$(obj).focus();
		return false;
	}
	return true;
}

// 商品添加页面基础数据添加和编辑的验证
function ValidateUserInput() {
	var shop_type = $("#shop_type").val();
	// 商品分组
	if ($("#productcategory-selected span").length == 0
			&& (shop_type == 2 || shop_type == 4)) {
		$("#productcategory-selected").nextAll('span').show();
		$('html,body').animate({
			scrollTop : 0
		}, 200);
		return false;
	} else {
		$("#productcategory-selected").nextAll("span").hide();
	}

	var shopCategoryText = "";
	// 商品分组
	$("#productcategory-selected span").each(function() {
		shopCategoryText += $(this).attr("id") + ",";
	})
	if (shopCategoryText == null || shopCategoryText == '') {
		$("#productcategory-selected").nextAll("span:last").show();
		document.documentElement.scrollTop = document.body.scrollTop = 0;
		return false;
	} else {
		$("#productcategory-selected").nextAll("span:last").hide();
	}
	// 商品标题
	if (!IsEmpty("#txtProductTitle")||$("#txtProductTitle").val().length>40) {
		$("#txtProductTitle").next("span").show();
		$("#txtProductTitle").focus();
		return false;
	} else {
		$("#txtProductTitle").next("span").hide();
	}

	// 商品品牌
//	if ($("#brandSelect").val() == 0) {
//		$("#brandSelect").focus();
//		$("#brandSelect").next().addClass('error');
//		$("#brandSelect").next().show();
//		return false;
//	} else {
//		$("#brandSelect").next().css("display", "none");
//	}
	// 商品原价
	if (!IsNum("#txtProductSalePrice")) {
		$("#txtProductSalePrice").nextAll("span:last").text("商品原价不能为空且需是数字");
		$("#txtProductSalePrice").nextAll("span:last").show();
		$("#txtProductSalePrice").focus();
		return false;
	} else {
		var price_s = $("#txtProductSalePrice").val();
		var c_price = parseFloat(price_s);
		$("#txtProductSalePrice").nextAll("span:last").hide();
	}

	// 市场价
	if (!IsNum("#txtProductMarketPrice")) {
		$("#txtProductMarketPrice").nextAll("span:last").text("商品市场价不能为空且需是数字");
		$("#txtProductMarketPrice").nextAll("span:last").show();
		$("#txtProductMarketPrice").focus();
		return false;
	} else {
		var price_s = $("#txtProductMarketPrice").val();
		var c_price = parseFloat(price_s);
		$("#txtProductMarketPrice").nextAll("span:last").hide();
	}
	// 商品成本价
	if (!IsNum("#txtProductCostPrice")) {
		$("#txtProductCostPrice").nextAll("span:last").text("商品成本价不能为空且需是数字");
		$("#txtProductCostPrice").nextAll("span:last").show();
		$("#txtProductCostPrice").focus();
		return false;
	} else {
		var price_s = $("#txtProductCostPrice").val();
		var c_price = parseFloat(price_s);
		$("#txtProductCostPrice").nextAll("span:last").hide();
	}
	// 基础销量
	if (!IsNum("#BasicSales")) {
		$("#BasicSales").nextAll("span:last").show();
		$("#BasicSales").focus();
		return false;
	} else {
		$("#BasicSales").nextAll("span:last").hide();
	}
	// 基础点击数
	if (!IsNum("#BasicPraise")) {
		$("#BasicPraise").nextAll("span:last").show();
		$("#BasicPraise").focus();
		return false;
	} else {
		$("#BasicPraise").nextAll("span:last").hide();
	}
	// 基础分享数
	if (!IsNum("#BasicShare")) {
		$("#BasicShare").nextAll("span:last").show();
		$("#BasicShare").focus();
		return false;
	} else {
		$("#BasicShare").nextAll("span:last").hide();
	}
	// 商家编码
	if (!IsEmpty("#txtProductCodeA")) {
		$("#txtProductCodeA").next().show();
		$("#txtProductCodeA").focus();
		return false;
	} else {
		$("#txtProductCodeA").next().hide();
	}
	// 总库存
	if (!IsPositiveNum("#txtProductCount")) {
		$("#txtProductCount").nextAll("span:last").show();
		$("#txtMinStockLaram").focus();
		return false;
	} else {
		$("#txtProductCount").nextAll("span:last").hide();
	}
	// 库存预警
	if (!IsPositiveNum("#txtMinStockLaram")) {
		$("#txtMinStockLaram").nextAll("span:last").show();
		$("#txtMinStockLaram").focus();
		return false;
	} else {
		$("#txtMinStockLaram").nextAll("span:last").hide();
	}

	var isflag = 0;
	$.each($('input[name="sku_price"]'), function(i, item) {
		var $this = $(item);
		if ($this.val().replace(/(^\s*)|(\s*$)/g, "") == ""
				|| $this.val().replace(/(^\s*)|(\s*$)/g, "") == "0.00") {
			$this.css("border-color", "#b94a48");
			$this.parent().find(".help-inline").text("价格最小为 0.01");
			$this.parent().find(".help-inline").show();
			isflag = 1;
		} else {
			num = parseInt($this.val());
			$this.css("border-color", "");
			$this.parent().find(".help-inline").hide();
		}
	});

	// 库存
	$.each($('input[name="stock_num"]'), function(i, item) {
		var $this = $(item);
		// if($this.val().replace(/(^\s*)|(\s*$)/g,
		// "")==""||$this.val().replace(/(^\s*)|(\s*$)/g, "")=="0"){
		if ($this.val().replace(/(^\s*)|(\s*$)/g, "") == "") {
			$this.css("border-color", "#b94a48");
			$this.parent().find(".help-inline").show();
			isflag = 1;
		} else {
			num = parseInt($this.val());
			$this.css("border-color", "");
			$this.parent().find(".help-inline").hide();
		}
	});
	if (isflag == 1) {
		return false;
	}
	var trs = $('.js-goods-stock .table-sku-stock').show().find('tbody').find(
			'tr');
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
	if (vals == null || vals == "") {
		// /return false;
	}
	// return false;
	var imgflag = false;// 默认：false。
	var imgtop = 0;// 如果没有商品图片，就定位到这个位置
	for (var i = 0; i < 5; i++) {
		if ($("#file_upload_img_" + (i + 1)).attr("data-id") == null
				|| $("#file_upload_img_" + (i + 1)).attr("data-id") == "") {
			imgflag = true;
			imgtop = $("#file_upload_img_" + (i + 1)).offset().top - 200;
		} else {
			imgflag = false;
			break;
		}
	}
	// 商品图
	if (imgflag) {
		$(".example span").text('需要设置第一张图片为商品主图').show();
		$(".example span").addClass('error');
		$("#txtMinStockLaram").focus();
		return false;
	} else {
		$("#upImgDiv").nextAll("span:last").hide();
		$("#upImgDiv").parent().parent().removeClass('error');
	}
	var temp_arr = img_id_arr.split(",");
	for (var k = 0; k < temp_arr.length; k++) {
		// 取出每一个跟全部进行比较
		var id = temp_arr[k];
		for (var j = (k + 1); j < temp_arr.length; j++) {
			// console.log("id:"+id+",j:"+temp_arr[j]);
			if (id == temp_arr[j]) {
				$("#upImgDiv").nextAll("span:last").text('商品图片存在重复').show();
				$("#upImgDiv").parent().parent().addClass('error');
				$("#file_upload_1").focus();
				return false;
			}
		}
	}
	// 商品描述
	var description = UE.getEditor('editor').getContent();

	description = description.replace(/(\n)/g, "");
	description = description.replace(/(\t)/g, "");
	description = description.replace(/(\r)/g, "");
	// description = description.replace(/<\/?[^>]*>/g, "");
	description = description.replace(/\s*/g, "");
	if (description == "") {
		$("#tareaProductDiscrip").nextAll("span:last").text("商品描述不能为空");
		$("#tareaProductDiscrip").nextAll("span:last").show();
		return false;
	} else if (description.length < 5 || description.length > 25000) {
		$("#tareaProductDiscrip").nextAll("span:last").text(
				"商品描述字符数应在5～25000之间");
		$("#tareaProductDiscrip").nextAll("span:last").show();
		return false;
	} else {
		$("#tareaProductDiscrip").nextAll("span:last").hide();
	}
	
	//如果是积分商品，则必须设置积分
	if($("#integralSelect").val() == 1){
		if($("#integration_available_use").val()=="" ||$("#integration_available_use").val()==0){
			$("#integration_available_use").focus();
			$("#integration_available_use").next().show();
			return false;
		}else{
			$("#integration_available_use").next().hide();
		}
	}
	// 运费设置
	if ($("input[name='fare']:checked").val() == 0
			&& $("#deliverySelect").val() == 0) {
		$("#deliverySelect").nextAll("span:last").show();
		return false;
	} else {
		$("#deliverySelect").nextAll("span:last").hide();
	}
	return true;
}