$(function() {
	// $.ajax({
	// url : "getGoodsGroupList",
	// type : "post",
	// async : true,
	// success : function(res) {
	// $("#procategory ul").html("");
	// for (var i = 0; i < res.length; i++) {
	// var count = 0;
	// var str = "";
	// str += '<li><input class="input-checked" id="'
	// + res[i]["group_id"]
	// + '" type="checkbox" value="'
	// + res[i]["group_name"] + '" >';
	// str += '<label for="' + res[i]["group_id"] + '">'
	// + res[i]["group_name"] + '</label></li>';
	// for (var j = 1; j < res.length; j++) {
	// if (res[i]["group_id"] == res[j]["pid"]) {
	// count++;// 记录下标索引，计算有多少个子类。
	// str += '<li style="padding-left: 15px;"><input class="input-checked"
	// id="'
	// + res[j]["group_id"]
	// + '" type="checkbox" value="'
	// + res[j]["group_name"] + '" >';
	// str += '<label for="' + res[j]["group_id"]
	// + '">' + res[j]["group_name"]
	// + '</label></li>';
	// }
	//
	// }
	// i += count;// 跳过子类分类
	// $("#procategory ul").append(str);
	// }
	//
	// }
	// });
})

window.onload = function() {

	$("#area-select").on("mouseover", function() {
		$("#procategory").show();
	})

	$("#area-select").on("mouseout", function() {
		$("#procategory").hide();
	})
	/**
	 * 商品规格属性结构
	 */
	var prop = {
		propId : 1,
		c_pId : 1,
		name : '规格名称',
		is_sku : 1,
		orders : 1,
		propvalues : 11,
		proDelValues : 22
	};
	var selectProp = {
		propId : 1,
		c_pId : 1,
		name : '规格名称'
	};
	/**
	 * 商品规格属性值得结构
	 */
	var propValue = {
		propValueId : 1,
		c_vId : 1,
		propId : 1,
		name : "属性值得名称",
		orders : 0,
	};
	/**
	 * sku组合后的集合
	 */
	var skuList = {

	};
	var sku = {
		pvs : 11,
		price : '五十',
		Stock : '库存',
		code : '编号'
	};
	var delVals = new Array();
	/**
	 * 存放商品规格的集合
	 */
	var propArray = new Array();
	var skuArray = new Array();
	var selectArray = new Array();
	var obj = new Object();
	obj.props = propArray;
	obj.skus = skuArray;
	obj.selProps = selectArray;

	var goodsid = $("#goodsId").val();
	var shop_type = $("#shop_type").val();
	/**
	 * 控制控件显示不显示
	 */
	if (shop_type == 2) {
		$("#goods_classifyid").css('display', 'none');
		$("#goods_supply_list").css('display', 'none');
		$("#goods_sales_area").css('display', 'none');
		$("#goods_groupid").css('display', '');
		$("#tr_minprice_show").css('display', 'none');// 限价
		$("#tr_supplyPrice_show").css('display', 'none');// 限价
		$("#tr_costPrice_show").css('display', 'none');// 限价
	} else {
		$("#goods_classifyid").css('display', '');
		$("#goods_supply_list").css('display', '');
		$("#goods_sales_area").css('display', '');
		$("#goods_groupid").css('display', 'none');
		$("#tr_minprice_show").css('display', '');// 限价
		$("#tr_supplyPrice_show").css('display', '');// 供货价
		$("#tr_costPrice_show").css('display', '');// 成本价

	}
	$("#hidQRcode").val("");
	if (goodsid == 0)
		$("#lastPage").attr("disabled", false);
	else
		$("#lastPage").attr("disabled", true);
	$("#lastPage").attr("href", "javascript:;");

	/**
	 * 通过商品ID来查询这个商品的所有信息
	 */
	if (goodsid != 0) {
		$
				.ajax({
					url : "GoodsSelect",
					type : "get",
					asysc : true,
					data : {
						"goodsId" : goodsid
					},
					success : function(res) {
//						document.write(JSON.stringify(res));
//						 alert(JSON.stringify(res));
						var attr_sku_img_list = res["attr_sku_img_list"];
						if (null != attr_sku_img_list) {
							for (var j = 0; j < attr_sku_img_list.length; j++) {
								if (attr_sku_img_list[j]['img'] != null) {
									speciFlcationsImgSrc[j] = root
											+ "/"
											+ attr_sku_img_list[j]['img']['pic_cover'];
									speciFlcationsImgIdList[j] = attr_sku_img_list[j]['img']['pic_id'];
								}
							}
							$("#js-tip-instruction").css("display", "block");
							IsShowImg = true;
						}
						/**
						 * 商品信息表
						 */
						var goods = res;
						$("#txtProductTitle").val(goods["goods_name"]);
						$("#txtProductCostPrice").val(goods["cost_price"]);
						$("#txtProductSalePrice").val(goods["price"]);
						$("#txtProductMarketPrice").val(goods["market_price"]);
						$("#txtProductCodeA").val(goods["code"]);
						$("#txtProductCount").val(goods["stock"]);
						$("#txtMinStockLaram").val(goods["min_stock_alarm"]);
						$("#hidthumbnail").val(goods["thumbnail"]);
						$("#txtProductMinPrice").val(goods["sup_min_price"]);
						$("#libiary_goodsid").val(goods["library_goodsid"]);
						$("#PurchaseSum").val(goods["max_buy"]);
						$("#hidQRcode").val(goods["QRcode"]);
						$("#integration_available_use").val(
								goods["point_exchange"]);
						$("#integration_available_give").val(
								goods["give_point"]);
						$("#txtGoodsReturnRate")
								.val(goods["goods_profit_rate"]);
						$("#sup_shopidselect").val(goods["sup_shopid"]);
						$("#txtGoodsAreasid").val(goods["sale_area"]);
						$("#txtProductSupplyPrice").val(goods["supply_price"]);
						$("#txtProductCBCostPrice").val(goods["cb_cost_price"]);
						$("input[name='stock']").each(function() {
							$this = $(this);
							if (goods["display_stock"] == $this.val()) {
								this.checked = true;
							} else {
								this.checked = false;
							}
						});
						$("input[name='shelves']").each(function() {
							$this = $(this);
							if (goods["state"] == $this.val()) {
								this.checked = true;
							} else {
								this.checked = false;
							}
						});

						// 商品品牌
						$("#brandSelect").find(
								"option[value='" + goods['brand_id'] + "']")
								.attr("selected", true);
						
						//商品所在地，区域
						$("#provinceSelect").find("option[value='"+goods["province_id"]+"']").attr("selected",true);
						getProvince("#provinceSelect",'#citySelect',goods["city_id"]);

						// 运费模板选择
						$(
								"input[name='fare'][value='"
										+ parseInt(goods["shipping_fee"])
										+ "']").attr("checked", "checked");
						if (parseInt(goods["shipping_fee"]) == 1) {
							$("#deliveryDiv").show();
							$("#deliverySelect").find(
									"option[value='" + goods['shipping_fee_id']
											+ "']").attr("selected", true);
						}
						// 积分设置选择 //point_exchange_type
						$("#integralSelect").find(
								"option[value='" + goods["point_exchange_type"]
										+ "']").attr("selected", true);
						/**
						 * 商品附加表
						 */
						$("#BasicSales").val(goods["sales"]);
						$("#BasicPraise").val(goods["clicks"]);
						$("#BasicShare").val(goods["shares"]);
						/**
						 * 商品类目表
						 */
						// alert("cid:" + $("#tbcName").attr("cid"));
						// alert(goods["category_id"]);
						// alert(goods["category_name"]);
						$("#tbcName").attr("cname", goods["category_name"]);
						$("#tbcName").attr("cid", goods["category_id"]);
						$("#tbcName").html(goods['category_name']);
						/**
						 * 商品分类表
						 */
						var groupIdArray = res['goods_group_list'];
						var $selDiv = $("#productcategory-selected");
						var $lis = $("#procategory li");
						var html = "";
						for (var $i = 0; $i < groupIdArray.length; $i++) {
							var groupId = groupIdArray[$i]["group_id"];
							// alert(groupId);
							var name = groupIdArray[$i]["group_name"];
							html += "<span class='label' id='" + groupId + "'>"
									+ name
									+ "<i class='categoryclose'></i></span>";
							for (var $y = 0; $y < $lis.length; $y++) {
								var $li = $lis[$y];
								var $id = $($li).find("input").attr("id");
								if (groupId == $id) {
									$($li).find("input").attr("checked",
											"checked");
									break;
								}
							}
						}
						$selDiv.append(html);
						/**
						 * 图片表
						 */
						var imageList = res['img_list'];
						// alert(imageList.length);
						// alert(JSON.stringify(imageList));
						// alert(imageList.length);
						// /attachment/
						// 页面不显示库存 0 不显示 ，1显示
						$('.controls input[name="stock"]')
								.each(
										function() {
											if (goods['is_stock_visible'] == 1) {
												$(
														'.controls input[name="stock"][value="1"]')
														.attr("checked", true);
											} else {
												$(
														'.controls input[name="stock"][value="0"]')
														.attr("checked", true);
											}
										});
						var $divs = $(".previewContainer");
						// alert(imageList.length);
						for (var $i = 0; $i < imageList.length; $i++) {
							var $imges = imageList[$i];
							var order = 0;// $imges["orders"];
							var path = root + "/" + $imges["pic_cover"];
							var imageId = $imges["pic_id"];
							$("#file_upload_img_" + ($i + 1)).attr("src", path);
							$("#file_upload_img_" + ($i + 1)).attr("data-id",
									imageId);
							img_id_arr += imageId + ",";
						}
						// alert($("input[name='shelves']:checked").val());
						img_id_arr = img_id_arr
								.substr(0, img_id_arr.length - 1);
						// alert(img_id_arr);
						/**
						 * 佣金表
						 */
						// var commission = res[5][0];
						// $("#NextCommissionRate").val(commission["level_0"]);
						// $("#CommissionRate").val(commission["level_1"]);
						// $("#LastCommissionRate").val(commission["level_2"]);
						// /**
						// * 物流信息表
						// */
						// var express = res[6][0];
						// $("#txtStere").val(express["volume"]);
						// $("#txtKilogram").val(express["weight"]);
						// var express_type = express["express_type"];
						// if (express_type == 1) {
						// $("input[name='fare'][value=1]").attr('checked',
						// true);
						// } else {
						// $("input[name='fare'][value=0]").attr('checked',
						// true);
						// $("#deliveryDiv").show();
						// }
						// var template_id = express["express_template_id"];
						// if (template_id != 0) {
						// $("#deliverySelect").find(
						// "option[value=" + template_id + "]").attr(
						// "selected", true);
						// $
						// .ajax({
						// url : 'express_templequery',
						// type : "post",
						// data : {
						// "tempId" : template_id
						// },
						// success : function(res) {
						// if (res.length > 0) {
						// $("#deliveryFeeContainer")
						// .text("");
						// var expreeInfo = res[0];
						// var divItem = $("<div><strong>默认运费：</strong>"
						// + expreeInfo["first_amount"]
						// + "件内"
						// + expreeInfo["first_money"]
						// + "元,每增加"
						// + expreeInfo["continued_amount"]
						// + "件,加"
						// + expreeInfo["continued_money"]
						// + "元</div>"); // " +
						// // jsonRes[i].ServiceType
						// // + "
						// $("#deliveryFeeContainer")
						// .append(divItem);
						// if (res[1] != null) {
						// for (var i = 0; i < res[1].length; i++) {
						// var divItem = $("<div><strong>指定区域运费：</strong>"
						// + res[1][i]
						// + "</div>");
						// $(
						// "#deliveryFeeContainer")
						// .append(divItem);
						// }
						// }
						// }
						//
						// },
						// error : function() {
						// }
						// });
						// }
						/**
						 * 商品属性表
						 */
						var propList = res['attribute_list'];
						if(propList.length>0){
							//商品如果有sku的话，将总库存禁止输入
							$("#txtProductCount").attr("disabled",true);
							for (var $i = 0; $i < propList.length; $i++) {
								var provp = propList[$i];
								addProvPArray(provp["attr_id"], 0,provp["attr_name"], provp["is_visible"], "");
							}
						}else{
							//没有SKU属性，则将总库存开启输入
							$("#txtProductCount").attr("disabled",false);
						}
						/**
						 * 商品 属性值表
						 */
						var propValueList = res['attribute_value_list'];
						for (var $i = 0; $i < propValueList.length; $i++) {
							var provpVal = propValueList[$i];
							addProvPValueArray(provpVal["attr_value_id"], 0,
									provpVal["attr_id"], provpVal["attr_value"]);
						}
						/**
						 * 商品sku表
						 */
						var skuList = res['sku_list'];
						// alert(JSON.stringify(skuList));
						for (var $i = 0; $i < skuList.length; $i++) {
							var sku = skuList[$i];
							save_Sku(sku["sku_id"], sku["attr_value_items"],
									sku["price"], sku["stock"], sku["code"], 0,
									sku["market_price"], sku["cost_price"]);// 0
							// 是销售数量
							// sku["sales"]
							// 销量
						}
						// var editor_a = new
						// baidu.editor.ui.Editor(editorOption);
						// editor_a.render('myEditor');
						ue.ready(function() {
							ue.setContent(goods["description"], false);
						});

						refProvHtml(1);
						$("#skuIsChange").val(0);
					}
				});
	}
	$.ajax({
		url : "CateGoryPropSelect",
		type : "post",
		asysc : false,
		data : {
			"proId" : 1
		},
		success : function(res) {
			for (var $i = 0; $i < res.length; $i++) {
				var selectProp = new Object();
				selectProp.propId = res[$i]["propId"];
				selectProp.c_pId = res[$i]["c_pId"];
				selectProp.name = res[$i]["name"];
				$count = obj.selProps.length;
				obj.selProps[$count] = selectProp;
			}
			putSelectProvHtml();
		}
	});

	/**
	 * 创建时间：2015年6月10日17:57:28 创建人：高伟 功能说明：摆放要选择的下拉菜单的数据
	 */
	function putSelectProvHtml() {
		$(".select2-results").children().remove();
		var html = "";
		for (var $i = 0; $i < obj.selProps.length; $i++) {
			var $sel = obj.selProps[$i];
			var propId = $sel["propId"];
			var name = $sel["name"];
			var c_pId = $sel["c_pId"];
			html += "<li class='select2-results-dept-0 select2-result select2-result-selectable' id='"
					+ c_pId
					+ "' data-id='"
					+ propId
					+ "' ><div class='select2-result-label' >"
					+ name
					+ "</div></li>";
		}
		$(".select2-results").append(html);
	}

	/**
	 * 判断 商品规格 是否已经存在
	 */
	function is_ProvPExists($name) {
		for (var $i = 0; $i < obj.props.length; $i++) {
			if (obj.props[$i]["name"] == $name) {
				alert("已存在相同的规格属性!");
				$('#select2-drop .select2-input').focus();
				return false;
			}
		}
		return true;
	}
	/**
	 * 判断 商品规格属性值 是否已经存在
	 */
	function is_ProvpValueExists($provpId, $value) {
		var ValArray = new Array();
		for (var $i = 0; $i < obj.props.length; $i++) {
			if (obj.props[$i]["propId"] == $provpId) {
				ValArray = obj.props[$i]["propvalues"];
				break;
			}
		}
		for (var $i = 0; $i < ValArray.length; $i++) {
			if (ValArray[$i]["name"] == $value) {
				alert("已经存在相同的规格");
				return false;
			}
		}
		return true;
	}
	/**
	 * 添加商品规格是 给数组中添加数据 $provpId 规格id $c_pId 模板的id $name 规格名称 $is_sku 是否是sku属性
	 * $selName 是判断在这个节点上 是否已经添加过数据
	 */
	function addProvPArray($provpId, $c_pId, $name, $is_sku, $selName) {
		$("div[name='skuTable']").css("display", "block");
		var provp = new Object();
		provp.propId = $provpId;
		provp.c_pId = $c_pId;
		provp.name = $name;
		provp.is_sku = $is_sku;
		provp.propvalues = new Array();
		provp.proDelValues = new Array();
		if ($selName == '') {
			var $count = propArray.length;
			propArray[$count] = provp;
		} else {
			for (var $i = 0; $i < obj.props.length; $i++) {
				if (obj.props[$i]["name"] == $selName) {
					var propId = obj.props[$i]["propId"];
					deleteProvp(propId, 0);
					obj.props[$i] = provp;
					break;
				}
			}
		}
		refProvHtml(0);
	}
	/**
	 * 添加商品规格属性表
	 */
	function addProvPValueArray($propValueId, $c_vId, $propId, $name) {
		var $provpIndex = 0;
		for (var $i = 0; $i < obj.props.length; $i++) {
			if (obj.props[$i]["propId"] == $propId) {
				$provpIndex = $i;
				break;
			}
		}
		var provpValue = new Object();
		provpValue.propValueId = $propValueId;
		provpValue.c_vId = $c_vId;
		provpValue.propId = $propId;
		provpValue.name = $name;
		$count = obj.props[$i].propvalues.length;
		obj.props[$i].propvalues[$count] = provpValue;
		if (obj.props.length == 0) {
			$("#txtProductSalePrice").removeAttr("disabled");
		} else {
			// $("#txtProductSalePrice").attr("disabled", "disabled");//禁用三个价格
			// $("#txtProductMarketPrice").attr("disabled", "disabled");
			// $("#txtProductCostPrice").attr("disabled", "disabled");
		}
	}
	/**
	 * 删除 数组中的属性值 $provPValueId 属性值得ID $is_Del 0代表 从数组中彻底删除并且也删除数据库的数据 1 代表 移动到
	 * 删除数组中 $imme_ref 0代表 不用立即刷新 1 代表 立即刷新
	 */
	function deleteProvpValue($provPValueId, $is_Del, $imme_ref) {
		var $propIndex = 0;
		var $valIndex = 0;
		for (var $i = 0; $i < obj.props.length; $i++) {
			var $provpList = obj.props[$i]["propvalues"];
			for (var $y = 0; $y < $provpList.length; $y++) {
				if ($provpList[$y]["propValueId"] == $provPValueId) {
					$propIndex = $i;
					$valIndex = $y;
					break;
				}
			}
			if ($valIndex != 0) {
				break;
			}
		}
		if ($is_Del == 0) {
			// $.ajax({
			// url : "CateGoryPropvaluesDelete",
			// type : "post",
			// asysc : false,
			// data : {
			// "proId" : $provPValueId
			// },
			// success : function(res) {
			// if (res != 0) {
			// obj.props[$propIndex]["propvalues"]
			// .splice($valIndex, 1);
			// if ($imme_ref == 1)
			// refProvHtml(1);
			// } else
			// alert("删除规格值出错!");
			// }
			// });
		} else {
			var deleteProvPVal = obj.props[$propIndex]["propvalues"][$valIndex];
			var $count = obj.props[$propIndex]["proDelValues"].length;
			obj.props[$propIndex]["proDelValues"][$count] = deleteProvPVal;
			obj.props[$propIndex]["propvalues"].splice($valIndex, 1);
		}
		if (obj.props.length == 0) {
			$("#txtProductSalePrice").removeAttr("disabled");
			$("#txtProductCount").removeAttr("disabled");
		} else {
			$("#txtProductSalePrice").attr("disabled", "disabled");
			$("#txtProductCount").attr("disabled", "disabled");
		}
	}
	/**
	 * 删除数组中以及数据库中的 规格
	 * 
	 * $provPId 属性 的id $is_Del 是否要删除数组中的数据 0代表不删除 1代表删除
	 */
	function deleteProvp($provPId, $is_Del) {
		// 删除添加的商品规格
		if (goodsid != 0) {
			for (var $i = 0; $i < obj.props.length; $i++) {
				if (obj.props[$i]["propId"] == $provPId) {
					obj.props.splice($i, 1);
					break;
				}
			}
		} else {
			// $.ajax({
			// url : "CateGoryPropsDelete",
			// type : "post",
			// asysc : false,
			// data : {
			// "provpId" : $provPId
			// },
			// success : function(res) {
			// if (res != 0) {
			// if ($is_Del == 1) {
			for (var $i = 0; $i < obj.props.length; $i++) {
				if (obj.props[$i]["propId"] == $provPId) {
					obj.props.splice($i, 1);
					break;
				}
			}
			// refProvHtml(1);
			// }
			// } else
			// alert("删除规格出错!");
			// }
			// });
		}
		refProvHtml(1);
		$('.js-sku-group-opts').css("display", "block");
		if (obj.props.length == 0) {
			$("div[name='skuTable']").css("display", "none");
			$("#txtProductCount").removeAttr("disabled");
			$("#txtProductSalePrice").removeAttr("disabled");
		} else {
			$("#txtProductSalePrice").attr("disabled", "disabled");
			$("#txtProductCount").attr("disabled", "disabled");
		}
	}

	/**
	 * 处理界面的显示和不显示 $is_value 是否是添加 属性值 0 代表不刷新sku表格 1 代表刷新sku表格
	 */
	function refProvHtml($is_value) {
		$('.js-sku-list-container').children().remove();
		for (var $i = 0; $i < obj.props.length; $i++) {
			var isFirst = true;
			if ($i != 0) {
				isFirst = false;
			}
			var provpHtml = getProvPHtml(obj.props[$i]["propId"],
					obj.props[$i]["name"], obj.props[$i]["propvalues"], isFirst);
			// alert("provpHtml:"+provpHtml);
			$('.js-sku-list-container').append($(provpHtml));
		}
		if ($is_value == 1) {
			create_sku();
		}
	}

	/**
	 * 创建时间：2015年6月9日09:02:30 创建人：高伟 功能说明：通过pvs从数组中查询 查看数组中是否有这条数据
	 */
	function judge_SkuData($pvs) {
		var $count = obj.skus.length;
		if ($count == 0)
			return null;
		for (var $i = 0; $i < $count; $i++) {
			if ($pvs == obj.skus[$i]["pvs"]) {
				return obj.skus[$i];
			}
		}
		return null;
	}
	/**
	 * 创建时间：2015年6月10日08:54:35 创建人：高伟 功能说明：将以前添加好的sku表的数据放到数组中
	 */
	function save_skuArray() {
		var trs = $('.js-goods-stock .table-sku-stock').show().find('tbody')
				.find('tr');
		for (var i = 0; i < trs.length; i++) {
			var tr = $(trs[i]);
			var pvs = tr.attr("sku-ids");
			var tds = tr.find('td');
			var price = "";
			var stock = "";
			var code = "";
			// - 6：从价格那一列开始到商家编码
			for (var y = tds.length - 6; y < tds.length - 1; y++) {
				var $td = $(tds[y]);
				var $input = $td.find('input');
				var $name = $input.attr("name");
				switch ($name) {
				case "sku_price":
					price = $input.val();
					break;
				case "stock_num":
					stock = $input.val();
					break;
				case "code":
					code = $input.val();
					break;
				}
			}
			var $count = obj.skus.length;
			if ($count == 0)
				return null;
			for (var $y = 0; $y < $count; $y++) {
				if (pvs == obj.skus[$y]["pvs"]) {
					obj.skus[$y]["price"] = price;
					obj.skus[$y]["Stock"] = stock;
					obj.skus[$y]["code"] = code;
					obj.skus[$y]["sales"] = 0;
					break;
				}
			}
		}
	}
	/**
	 * 创建时间：2015年6月15日18:18:19 创建人：高伟 功能说明：将pvs添加到数组中
	 */
	function save_Sku($skuId, $pvs, $price, $stock, $code, $sales,
			$market_price, $cost_price) {
		var PvsArray = new Array();
		PvsArray.skuId = $skuId;
		PvsArray.pvs = $pvs;
		PvsArray.price = $price;
		PvsArray.Stock = $stock;
		PvsArray.code = $code;
		PvsArray.sales = $sales;
		PvsArray.market_price = $market_price;
		PvsArray.cost_price = $cost_price;
		var $count = skuArray.length;
		skuArray[$count] = PvsArray;
	}
	/**
	 * 创建时间：2015年6月11日15:41:33 创建人：高伟 功能说明：生成sku表格的前期准备
	 */
	function prepare_sku() {
		var $count = 0;
		var skuObj = new Array();
		skuObj.indexObj = new Array();
		for (var $i = 0; $i < obj.props.length; $i++) {
			if (obj.props[$i]["propvalues"].length != 0) {
				var sku = new Object();
				sku.index = $i;
				$count = skuObj.indexObj.length;
				skuObj.indexObj[$count] = sku;
				$count++;
			}
		}
		skuObj.count = $count;
		return skuObj;
	}
	/**
	 * 生成sku表格
	 */
	function create_sku() {
		save_skuArray();
		$('.js-goods-stock').show().find('table.table-sku-stock').children()
				.remove();
		var $provpList = obj.props;
		var html = '';
		var $skuObj = prepare_sku();
		var $count = $skuObj.count;
		switch ($count) {
		case 1:
			var index = $skuObj.indexObj[0].index;
			html += '<thead><tr><th class="text-center">'
					+ $provpList[index]["name"]
					+ '</th><th class="th-price">价格（元）</th><th class="th-price">市场价（元）</th><th class="th-price">成本价（元）</th><th class="th-stock">库存</th><th class="th-code">商家编码</th><th class="text-right">销量</th></tr></thead>';
			html += '<tbody>';
			for (var $i = 0; $i < $provpList[index]["propvalues"].length; $i++) {
				var skuId = "";
				var price = "";
				var stock = "";
				var code = "";
				var sales = 0;
				var market_price = "";// 市场价
				var cost_price = "";// 成本价
				var pvs = $provpList[index]["propId"] + ':'
						+ $provpList[index]["propvalues"][$i]["propValueId"];
				var skuObject = judge_SkuData(pvs);
				if (skuObject != null) {
					skuId = skuObject["skuId"];
					price = skuObject["price"];
					stock = skuObject["Stock"];
					code = skuObject["code"];
					sales = skuObject["sales"];
					market_price = skuObject["market_price"];
					cost_price = skuObject["cost_price"];
				} else {
					save_Sku(0, pvs, price, stock, code, 0, market_price,
							cost_price);
				}
				if (shop_type == 1 && goodsid != 0) {
					html += '<tr  id="'
							+ skuId
							+ '" sku-ids="'
							+ pvs
							+ '"><td rowspan="1">'
							+ $provpList[index]["propvalues"][$i]["name"]
							+ '</td><td><input type="text" name="sku_price" disabled="disabled" class="js-price input-mini"  value="'
							+ price
							+ '" maxlength="10"/><span class="help-inline" style="font-size:11px; color:#b94a48; display:none">价格最小为 0.01</span></td><td><input type="text" name="stock_num" class="js-stock-num input-mini" disabled="disabled"  value="'
							+ stock
							+ '" maxlength="9"/><span class="help-inline" style="font-size:11px; color:#b94a48; display:none" >库存不能为空</span></td><td><input type="text" name="code" class="js-code input-small"  disabled="disabled" value="'
							+ code + '"></td><td class="text-right">' + sales
							+ '</td></tr>';
				} else {
					html += '<tr  id="'
							+ skuId
							+ '" sku-ids="'
							+ pvs
							+ '"><td rowspan="1">'
							+ $provpList[index]["propvalues"][$i]["name"]
							+ '</td><td><input type="text" name="sku_price"  style="width: 80%;" class="js-price input-mini" style="width: 80%;" value="'
							+ price
							+ '" maxlength="10"/><span class="help-inline" style="font-size:11px; color:#b94a48; display:none">价格最小为 0.01</span></td>'

							// ==========================市场价==================
							+ '<td><input type="text" name="market_price" value="'
							+ market_price
							+ '" maxlength="10" style="width: 80%;" class="js-market-price" />'
							+ '<span class="help-inline" style="font-size:11px; color:#b94a48; display:none">价格最小为 0.01</span>'
							+ '</td>'
							// ==========================市场价==================

							// ==========================成本价==================
							+ '<td><input type="text" name="cost_price" value="'
							+ cost_price
							+ '" maxlength="10" style="width: 80%;" class="js-cost-price" />'
							+ '<span class="help-inline" style="font-size:11px; color:#b94a48; display:none">价格最小为 0.01</span>'
							+ '</td>'
							// ==========================成本价==================

							+ '<td><input type="text" name="stock_num" class="js-stock-num input-mini"  value="'
							+ stock
							+ '" maxlength="9"/><span class="help-inline" style="font-size:11px; color:#b94a48; display:none" >库存不能为空</span></td><td><input type="text" name="code" class="js-code input-small" value="'
							+ code + '"></td><td class="text-right">' + sales
							+ '</td></tr>';
				}
			}
			html += '</tbody>';
			html += '<tfoot><tr><td colspan="9" style="text-align:left;"><div class="batch-opts">批量设置： '
					+ '<span class="js-batch-type"><a class="js-batch-price" href="javascript:;">价格</a>&nbsp;&nbsp;'
					+ '<a class="js-batch-market_price" href="javascript:;">市场价</a>&nbsp;&nbsp;'
					+ '<a class="js-batch-cost_price" href="javascript:;">成本价</a>&nbsp;&nbsp;'
					+ '<a class="js-batch-stock" href="javascript:;">库存</a></span>'
					+ '<span class="js-batch-form" style="display:none;"><input type="text" maxlength="11" class="js-batch-txt input-mini" style="width:100px;margin:0;" placeholder="">&nbsp;&nbsp;'
					+ '<a class="js-batch-save" href="javascript:;">保存</a> <a class="js-batch-cancel" href="javascript:;">取消</a>'
					+ '<p class="help-desc"></p></span></div></td></tr></tfoot>';
			break;
		case 2:
			var $indexOne = $skuObj.indexObj[0].index;
			var $indexTwo = $skuObj.indexObj[1].index;
			html += '<thead><tr><th class="text-center">'
					+ $provpList[$indexOne]["name"]
					+ '</th><th class="text-center">'
					+ $provpList[$indexTwo]["name"]
					+ '</th><th class="th-price">价格（元）</th><th class="th-price">市场价（元）</th><th class="th-price">成本价（元）</th><th class="th-stock">库存</th><th class="th-code">商家编码</th><th class="text-right">销量</th></tr></thead>';
			html += '<tbody>';
			for (var $i = 0; $i < $provpList[$indexOne]["propvalues"].length; $i++) {
				var valueItem = $provpList[$indexOne]["propvalues"][$i];
				for (var $j = 0; $j < $provpList[$indexTwo]["propvalues"].length; $j++) {
					var valueJtem = $provpList[$indexTwo]["propvalues"][$j];
					var skuId = "";
					var price = "";
					var stock = "";
					var code = "";
					var sales = 0;
					var market_price = "";// 市场价
					var cost_price = "";// 成本价
					var pvs = $provpList[$indexOne]["propId"] + ':'
							+ valueItem["propValueId"] + ';'
							+ $provpList[$indexTwo]["propId"] + ':'
							+ valueJtem["propValueId"];
					var skuObject = judge_SkuData(pvs);
					if (skuObject != null) {
						skuId = skuObject["skuId"];
						price = skuObject["price"];
						stock = skuObject["Stock"];
						code = skuObject["code"];
						sales = skuObject["sales"];
						market_price = skuObject["market_price"];
						cost_price = skuObject["cost_price"];
					} else {
						save_Sku(0, pvs, price, stock, code, 0, market_price,
								cost_price);
					}
					html += '<tr id="' + skuId + '" sku-ids="' + pvs + '">';
					if ($j == 0) {
						html += '<td rowspan="'
								+ $provpList[$indexTwo]["propvalues"].length
								+ '">' + valueItem["name"] + '</td>';
					}
					if (shop_type == 1 && goodsid != 0) {
						html += '<td>'
								+ valueJtem["name"]
								+ '</td><td><input type="text" name="sku_price"  style="width: 80%;" class="js-price input-mini" disabled="disabled" value="'
								+ price
								+ '" maxlength="10"/><span class="help-inline" style="font-size:11px; color:#b94a48; display:none">价格最小为 0.01</span> </td><td><input type="text" name="stock_num" class="js-stock-num input-mini" disabled="disabled" value="'
								+ stock
								+ '" maxlength="9"/><span class="help-inline" style="font-size:11px; color:#b94a48; display:none" >库存不能为空</span></td><td><input type="text" name="code" class="js-code input-small" disabled="disabled" value="'
								+ code + '"></td><td class="text-right">'
								+ sales + '</td></tr>';
					} else {
						html += '<td>'
								+ valueJtem["name"]
								+ '</td><td><input type="text" name="sku_price" class="js-price input-mini" style="width: 80%;" value="'
								+ price
								+ '" maxlength="10"/><span class="help-inline" style="font-size:11px; color:#b94a48; display:none">价格最小为 0.01</span> </td>'

								// ==========================市场价==================
								+ '<td><input type="text" name="market_price" value="'
								+ market_price
								+ '" maxlength="10" style="width: 80%;" class="js-market-price" />'
								+ '<span class="help-inline" style="font-size:11px; color:#b94a48; display:none">价格最小为 0.01</span>'
								+ '</td>'
								// ==========================市场价==================

								// ==========================成本价==================
								+ '<td><input type="text" name="cost_price" value="'
								+ cost_price
								+ '" maxlength="10" style="width: 80%;" class="js-cost-price" />'
								+ '<span class="help-inline" style="font-size:11px; color:#b94a48; display:none">价格最小为 0.01</span>'
								+ '</td>'
								// ==========================成本价==================

								+ '<td><input type="text" name="stock_num" class="js-stock-num input-mini" value="'
								+ stock
								+ '" maxlength="9"/><span class="help-inline" style="font-size:11px; color:#b94a48; display:none" >库存不能为空</span></td><td><input type="text" name="code" class="js-code input-small" value="'
								+ code + '"></td><td class="text-right">'
								+ sales + '</td></tr>';
					}
				}
			}
			html += '</tbody>';
			html += '<tfoot><tr><td colspan="9" style="text-align:left;"><div class="batch-opts">批量设置： '
					+ '<span class="js-batch-type"><a class="js-batch-price" href="javascript:;">价格</a>&nbsp;&nbsp;'
					+ '<a class="js-batch-market_price" href="javascript:;">市场价</a>&nbsp;&nbsp;'
					+ '<a class="js-batch-cost_price" href="javascript:;">成本价</a>&nbsp;&nbsp;'
					+ '<a class="js-batch-stock" href="javascript:;">库存</a></span>'
					+ '<span class="js-batch-form" style="display:none;"><input type="text" maxlength="11" class="js-batch-txt input-mini" style="width:100px;" placeholder="">&nbsp;&nbsp;'
					+ '<a class="js-batch-save" href="javascript:;">保存</a> <a class="js-batch-cancel" href="javascript:;">取消</a>'
					+ '<p class="help-desc"></p></span></div></td></tr></tfoot>';
			break;
		case 3:
			html += '<thead><tr><th class="text-center">'
					+ $provpList[0]["name"]
					+ '</th><th class="text-center">'
					+ $provpList[1]["name"]
					+ '</th><th class="text-center">'
					+ $provpList[2]["name"]
					+ '</th><th class="th-price">价格（元）</th><th class="th-price">市场价（元）</th><th class="th-price">成本价（元）</th><th class="th-stock">库存</th><th class="th-code">商家编码</th><th class="text-right">销量</th></tr></thead>';
			html += '<tbody>';
			for (var $i = 0; $i < $provpList[0]["propvalues"].length; $i++) {
				var valueItem = $provpList[0]["propvalues"][$i];
				for (var $j = 0; $j < $provpList[1]["propvalues"].length; $j++) {
					var valueJtem = $provpList[1]["propvalues"][$j];
					for (var $y = 0; $y < $provpList[2]["propvalues"].length; $y++) {
						var valueYtem = $provpList[2]["propvalues"][$y];
						var skuId = "";
						var price = "";
						var stock = "";
						var code = "";
						var sales = 0;
						var market_price = "";// 市场价
						var cost_price = "";// 成本价
						var pvs = $provpList[0]["propId"] + ':'
								+ valueItem["propValueId"] + ';'
								+ $provpList[1]["propId"] + ':'
								+ valueJtem["propValueId"] + ';'
								+ $provpList[2]["propId"] + ':'
								+ valueYtem["propValueId"];
						var skuObject = judge_SkuData(pvs);
						if (skuObject != null) {
							skuId = skuObject["skuId"];
							price = skuObject["price"];
							stock = skuObject["Stock"];
							code = skuObject["code"];
							sales = skuObject["sales"];
							market_price = skuObject["market_price"];
							cost_price = skuObject["cost_price"];
						} else {
							save_Sku(0, pvs, price, stock, code, 0,
									market_price, cost_price);
						}

						html += '<tr id="' + skuId + '" sku-ids="' + pvs + '">';
						if ($j == 0 && $y == 0) {
							html += '<td rowspan="'
									+ ($provpList[1]["propvalues"].length * $provpList[2]["propvalues"].length)
									+ '">' + valueItem["name"] + '</td>';
						}
						if ($y == 0)
							html += '<td rowspan="'
									+ ($provpList[2]["propvalues"].length)
									+ '">' + (valueJtem["name"]) + '</td>';
						if (shop_type == 1 && goodsid != 0) {
							html += '<td>'
									+ (valueYtem["name"])
									+ '</td><td><input type="text" name="sku_price" class="js-price input-mini"  disabled="disabled" value="'
									+ price
									+ '" maxlength="10"/><span class="help-inline" style="font-size:11px; color:#b94a48; display:none">价格最小为 0.01</span></td><td><input type="text" name="stock_num" class="js-stock-num input-mini" disabled="disabled" value="'
									+ stock
									+ '" maxlength="9"/><span class="help-inline" style="font-size:11px; color:#b94a48; display:none" >库存不能为空</span></td><td><input type="text" name="code" class="js-code input-small" disabled="disabled" value="'
									+ code + '"></td><td class="text-right">'
									+ sales + '</td></tr>';
						} else {
							html += '<td>'
									+ (valueYtem["name"])
									+ '</td><td><input type="text" name="sku_price" class="js-price input-mini" style="width: 80%;" value="'
									+ price
									+ '" maxlength="10"/><span class="help-inline" style="font-size:11px; color:#b94a48; display:none">价格最小为 0.01</span></td>'

									// ==========================市场价==================
									+ '<td><input type="text" name="market_price" value="'
									+ market_price
									+ '" maxlength="10" style="width: 80%;" class="js-market-price" />'
									+ '<span class="help-inline" style="font-size:11px; color:#b94a48; display:none">价格最小为 0.01</span>'
									+ '</td>'
									// ==========================市场价==================

									// ==========================成本价==================
									+ '<td><input type="text" name="cost_price" value="'
									+ cost_price
									+ '" maxlength="10" style="width: 80%;" class="js-cost-price" />'
									+ '<span class="help-inline" style="font-size:11px; color:#b94a48; display:none">价格最小为 0.01</span>'
									+ '</td>'
									// ==========================成本价==================

									+ '<td><input type="text" name="stock_num" class="js-stock-num input-mini" value="'
									+ stock
									+ '" maxlength="9"/><span class="help-inline" style="font-size:11px; color:#b94a48; display:none" >库存不能为空</span></td><td><input type="text" name="code" class="js-code input-small" value="'
									+ code + '"></td><td class="text-right">'
									+ sales + '</td></tr>';

						}
					}
				}
			}
			html += '</tbody>';
			html += '<tfoot><tr><td colspan="9" style="text-align:left;"><div class="batch-opts">批量设置： '
					+ '<span class="js-batch-type"><a class="js-batch-price" href="javascript:;">价格</a>&nbsp;&nbsp;'
					+ '<a class="js-batch-market_price" href="javascript:;">市场价</a>&nbsp;&nbsp;'
					+ '<a class="js-batch-cost_price" href="javascript:;">成本价</a>&nbsp;&nbsp;'
					+ '<a class="js-batch-stock" href="javascript:;">库存</a></span>'
					+ '<span class="js-batch-form" style="display:none;"><input type="text" maxlength="11" class="js-batch-txt input-mini" style="width:100px;" placeholder="">&nbsp;&nbsp;'
					+ '<a class="js-batch-save" href="javascript:;">保存</a> <a class="js-batch-cancel" href="javascript:;">取消</a>'
					+ '<p class="help-desc"></p></span></div></td></tr></tfoot>';
			break;
		}
		$('.js-goods-stock').show().find('table.table-sku-stock').html(html);
	}
	/**
	 * 循环处理价格 不让价格为空
	 */
	$('input[name="sku_price"]')
			.live(
					'keyup',
					function() {
						var $this = $(this);
						if ($this.val().replace(/(^\s*)|(\s*$)/g, "") == ""
								|| $this.val().replace(/(^\s*)|(\s*$)/g, "") == "0.00") {
							$this.val("0.00");
							$this.css("border-color", "#b94a48");
							$this.parent().find(".help-inline").show();
						} else {
							num = parseInt($this.val());
							$this.css("border-color", "");
							$this.parent().find(".help-inline").hide();
						}
						eachPrice();
					});
	/**
	 * 循环处理价格 不让价格为空
	 */
	$('input[name="market_price"]')
			.live(
					'keyup',
					function() {
						var $this = $(this);
						if ($this.val().replace(/(^\s*)|(\s*$)/g, "") == ""
								|| $this.val().replace(/(^\s*)|(\s*$)/g, "") == "0.00") {
							$this.val("0.00");
							$this.css("border-color", "#b94a48");
							$this.parent().find(".help-inline").show();
						} else {
							num = parseInt($this.val());
							$this.css("border-color", "");
							$this.parent().find(".help-inline").hide();
						}
						eachMarketPrice();
					});
	/**
	 * 循环处理价格 不让价格为空
	 */
	$('input[name="cost_price"]')
			.live(
					'keyup',
					function() {
						var $this = $(this);
						if ($this.val().replace(/(^\s*)|(\s*$)/g, "") == ""
								|| $this.val().replace(/(^\s*)|(\s*$)/g, "") == "0.00") {
							$this.val("0.00");
							$this.css("border-color", "#b94a48");
							$this.parent().find(".help-inline").show();
						} else {
							num = parseInt($this.val());
							$this.css("border-color", "");
							$this.parent().find(".help-inline").hide();
						}
						eachCostPrice();
					});
	/**
	 * 循环价格
	 */
	function eachPrice() {
		var $price = 0;
		$.each($('input[name="sku_price"]'), function(i, item) {
			var $this = $(item);
			var num = $this.val();
			var numint = parseInt(num);
			var priceint = parseInt($price);
			if ($price == 0 || numint < priceint)
				$price = num;
		});
		$("#txtProductSalePrice").val($price);
		$("#txtProductSalePrice").attr("disabled", "disabled");
	}
	/**
	 * 循环市场价 2016年12月2日 11:55:30
	 */
	function eachMarketPrice() {
		var $price = 0;
		$.each($('input[name="market_price"]'), function(i, item) {
			var $this = $(item);
			var num = $this.val();
			var numint = parseInt(num);
			var priceint = parseInt($price);
			if ($price == 0 || numint < priceint)
				$price = num;
		});
		$("#txtProductMarketPrice").val($price);
		$("#txtProductMarketPrice").attr("disabled", "disabled");
	}
	/**
	 * 循环成本价 2016年12月2日 12:14:27
	 */
	function eachCostPrice() {
		var $price = 0;
		$.each($('input[name="cost_price"]'), function(i, item) {
			var $this = $(item);
			var num = $this.val();
			var numint = parseInt(num);
			var priceint = parseInt($price);
			if ($price == 0 || numint < priceint)
				$price = num;
		});
		$("#txtProductCostPrice").val($price);
		$("#txtProductCostPrice").attr("disabled", "disabled");
	}
	/**
	 * 循环 处理库存
	 */
	$('input[name="stock_num"]').live('keyup', function() {
		$stock = $(this);
		// if($stock.val().replace(/(^\s*)|(\s*$)/g,
		// "")==""||$stock.val().replace(/(^\s*)|(\s*$)/g, "")=="0"){
		if ($stock.val().replace(/(^\s*)|(\s*$)/g, "") == "") {
			$stock.css("border-color", "#b94a48");
			$stock.parent().find(".help-inline").show();
		} else {
			$stock.css("border-color", "");
			$stock.parent().find(".help-inline").hide();
		}
		eachInput();
	});

	/**
	 * 循环库存
	 */
	function eachInput() {
		var $stockTotal = 0;
		$.each($('input[name="stock_num"]'), function(i, item) {
			var $this = $(item);
			var num = 0;
			num = parseInt($this.val());
			$stockTotal = $stockTotal + num;
		});
		$("#txtProductCount").val($stockTotal);
		//$("#txtProductCount").attr("disabled", "disabled");
	}

	// （是否要添加规格图片）
	$("#js-addImg-function").live('click', function() {
		if ($("#js-addImg-function").find("input").attr("checked")) {
			$(".upload-img-wrap").css("display", "block");
			$("#js-tip-instruction").css("display", "block");
			IsShowImg = true;
		} else {
			$(".upload-img-wrap").css("display", "none");// 图片
			$("#js-tip-instruction").css("display", "none");// 提示
			IsShowImg = false;
		}
	})
	$(".brick.small").live('mouseover', function() {
		$(this).children().next().show();
	}).live("mouseout", function() {
		$(this).children().next().hide();
	});
	/**
	 * 鼠标浮在图片上，显示删除和替换
	 */
	$(".add-image").live('mouseover', function() {
		$(this).children().prev().show();
		$(this).children().next().show();
	}).live('mouseout', function() {
		$(this).children("a").css("display", "none");
		$(this).children("span").hide();
	}).live("click", function() {
		if (deleteFlag) {
			speciFicationsImgCid = $(this).attr("img-id");
			setObject(this);
			speciFicationsFlag = 1;
			OpenPricureDialog("PopPicure", ADMINMAIN, 1);
		} else {
			deleteFlag = true;
		}
	});
	var deleteFlag = true;
	// 删除图片
	$(".add-image a").live("click", function() {
		var index = $(this).next().attr("index");
		speciFlcationsImgSrc[index] = "";
		speciFlcationsImgIdList[index] = "";
		$(this).parent().text("+");
		deleteFlag = false;
	})
	/**
	 * 得到商品规格的属性 html代码字符串
	 */
	function getProvPHtml($provpId, $name, $propvalues, $isFirst) {
		var provpHtml = "";
		speciFicationsLength = $propvalues.length;
		var IsShowImgPrompt = false;// 显示图片上传提示信息
		provpHtml += "<div class='sku-sub-group'>";
		provpHtml += "<h3 class='sku-group-title'>";
		provpHtml += "<div class='select2-container js-sku-name select2-dropdown-open ' style='width: 180px;' data-id='"
				+ $provpId + "'>";
		provpHtml += "<a tabindex='-1' class='select2-choice' onclick='return false;' href='javascript:void(0)'>";
		provpHtml += "<span class='select2-chosen'>" + $name + "</span>";
		provpHtml += "<abbr class='select2-search-choice-close'></abbr>";
		provpHtml += "<span class='select2-arrow'><b></b></span></a>";
		provpHtml += "</div>";
		if ($('.js-sku-list-container .sku-sub-group').size() == 0) {
			// 添加规格图片是否显示
			if (IsShowImg) {
				provpHtml += '<span style="display: inline-block; margin-left: 25px;"><label id="js-addImg-function"><input type="checkbox" checked="checked" style="vertical-align: text-top; margin-right: 5px;" />添加规格图片</label></span>';
			} else {
				provpHtml += '<span style="display: inline-block; margin-left: 25px;"><label id="js-addImg-function"><input type="checkbox" style="vertical-align: text-top; margin-right: 5px;" />添加规格图片</label></span>';
			}
		}
		provpHtml += "<a class='js-remove-sku-group remove-sku-group'>×</a>";
		provpHtml += "</h3>";
		provpHtml += "<div class='js-sku-atom-container sku-group-cont'>";
		/**
		 * 添加属性值
		 */
		var imgHtml = "";
		if ($isFirst) {
			atomIdArr = new Array();
			FirstImgId = $provpId;
		}
		for (var $i = 0; $i < $propvalues.length; $i++) {
			IsShowImgPrompt = true;
			var $provaluesId = $propvalues[$i]["propValueId"];
			var $values = $propvalues[$i]["name"];
			provpHtml += '<div style="display: inline-block;margin-bottom:15px;">';
			provpHtml += "<div class='js-sku-atom-list sku-atom-list'>";
			provpHtml += "<div class='sku-atom' atom-id='" + $provaluesId
					+ "'>";
			if ($isFirst) {
				atomIdArr[$i] = $provaluesId;
			}
			provpHtml += "<span style='font-size: 14px;'>" + $values
					+ "</span>";
			provpHtml += "<div class='close-modal small js-remove-sku-atom' index="
					+ $i + ">×</div>";
			provpHtml += "</div>";
			if (($i + 1) == $propvalues.length) {
				provpHtml += "<a class='js-add-sku-atom add-sku' id='"
						+ $provpId
						+ "' style='font-size: 12px;'href='javascript:;'>+添加</a>";
			}
			provpHtml += "</div>";
			if (IsShowImg) {
				imgHtml = '<div class="upload-img-wrap" ><div class="arrow"></div><div class="js-upload-container" style="position: relative;">';
			} else {
				imgHtml = '<div class="upload-img-wrap" style="display:none;"><div class="arrow"></div><div class="js-upload-container" style="position: relative;">';
			}
			if (speciFlcationsImgSrc.length != 0) {
				if (speciFlcationsImgSrc[$i] != null) {
					imgHtml += '<div class="add-image" img-id="' + $i + '">';
					imgHtml += '<a href="javascript:;" class="close-modal small "title="删除">×</a>';
					imgHtml += '<img src="' + speciFlcationsImgSrc[$i]
							+ '" cid="spec_img_' + $i
							+ '" style="width:84px;height:84px;" index="' + $i
							+ '" />';
					imgHtml += '<span>替换</span></div>';
				} else {
					imgHtml += '<div class="add-image" img-id="' + $i
							+ '">+</div>';
				}
			} else {
				imgHtml += '<div class="add-image" img-id="' + $i + '">+</div>';
			}
			imgHtml += '</div></div>';
			if ($isFirst) {
				provpHtml += imgHtml;
			}
			provpHtml += "</div>";
		}
		if ($propvalues.length == 0) {
			provpHtml += "<a class='js-add-sku-atom add-sku' id='" + $provpId
					+ "' style='font-size: 12px;'href='javascript:;'>+添加</a>";
		}
		if (IsShowImg && $isFirst && IsShowImgPrompt) {
			provpHtml += '<div class="sku-group-cont" id="js-tip-instruction" style="padding: 0px 10px; display: block;"><p class="help-desc">目前只支持为第一个规格设置不同的规格图片</p><p class="help-desc">设置后，用户选择不同规格会显示不同图片</p><p class="help-desc">建议尺寸：640 x 640像素</p></div>';
		}
		provpHtml += "</div>";
		return provpHtml;
	}
	/**
	 * 添加规格项目的点击方法
	 */
	$('.js-add-sku-group').live('click',function() {
		var html = "";
		if ($('.js-sku-list-container .sku-sub-group').size() == 3) {
			$('.js-sku-group-opts').hide();
		}
		if ($('.js-sku-list-container .sku-sub-group').size() == 0) {
			html = '<div class="sku-sub-group"><h3 class="sku-group-title"><div class="select2-container js-sku-name select2-dropdown-open " style="width: 180px;"> <a href="javascript:void(0)" onclick="return false;" class="select2-choice" tabindex="-1"><span class="select2-chosen">&nbsp;</span><abbr class="select2-search-choice-close"></abbr><span class="select2-arrow"><b></b></span></a></div> <span style="display: inline-block; margin-left: 25px;"><label  id="js-addImg-function" ><input type="checkbox" style="vertical-align: text-top; margin-right: 5px;" />添加规格图片</label></span><a class="js-remove-sku-group remove-sku-group">×</a></h3><div class="js-sku-atom-container sku-group-cont"></div></div>';
		} else {
			html = '<div class="sku-sub-group"><h3 class="sku-group-title"><div class="select2-container js-sku-name select2-dropdown-open " style="width: 180px;"> <a href="javascript:void(0)" onclick="return false;" class="select2-choice" tabindex="-1"><span class="select2-chosen">&nbsp;</span><abbr class="select2-search-choice-close"></abbr><span class="select2-arrow"><b></b></span></a></div><a class="js-remove-sku-group remove-sku-group">×</a></h3><div class="js-sku-atom-container sku-group-cont"></div></div>';
		}
		$('.js-sku-list-container').append(html);
		$('div.js-sku-name:last').click();
	});
	/**
	 * 删除 规格项目的点击方法
	 */
	$('.js-remove-sku-group').live('click', function() {
		var $skuSub = $(this).closest('.sku-sub-group');
		var id = $skuSub.find('.select2-container').attr("data-id");
		deleteProvp(id, 1);
		if (goodsid != 0) {
			$("#skuIsChange").val(1);
		}
	});
	// 删除规格样式
	$('.js-remove-sku-atom').live('click', function() {
		var $skuAtom = $(this).closest('.sku-atom');
		var pid = $skuAtom.attr("atom-id");
		/**
		 * 删除属性值
		 */
		var index = $(this).attr("index");
		speciFlcationsImgSrc[index] = "";
		speciFlcationsImgIdList[index] = "";
		deleteProvpValue(pid, 1, 0);
		if (goodsid != 0) {
			$("#skuIsChange").val(1);
		}
		refProvHtml(1);
	});
	/**
	 * 规格项目的点击下拉菜单的方法
	 */
	var now_sku_name_dom = null;
	$('.js-sku-name').live('click',function() {
		now_sku_name_dom = $(this);
		$(this).addClass('select2-dropdown-open select2-container-active');
		if ($('#select2-drop').is(":hidden")) {
			$('#select2-drop').css({
				top : ($(this).offset().top - 46),
				left : '172px',
				width : $(this).width() + 'px',
				display : 'block'
			});
		} else {
			$(this).removeClass('select2-dropdown-open select2-container-active');
			$('#select2-drop').css("display", "none");
		}
		$('body').bind('click', function() {
			close_div_select();
		});
		$('.select2-input').live('click', function() {
			$('#select2-drop').css("display", "block");
			$('.select2-input').focus();
		});
		putSelectProvHtml();
	});

	/**
	 * j加载 下拉菜单
	 */
	$('#select2-drop .select2-input')
			.live(
					'keyup',
					function(event) {
						var find_str = $.trim($(this).val());
						if (event.keyCode == 13 && find_str.length != 0) {
							var selName = now_sku_name_dom.find(
									'.select2-chosen').html().replace('&nbsp;',
									'');
							if (is_ProvPExists(find_str)) {
								var guid = $("#guids").val();
								$
										.ajax({
											url : "CateGoryPropsGet",
											type : "post",
											asysc : false,
											data : {
												"guid" : guid,
												"isSku" : 1,
												"name" : find_str,
												"cpvId" : 0
											},
											success : function(res) {
												if (res != 0) {
													addProvPArray(res, 0,
															find_str, 1,
															selName);
													$(
															'#select2-drop-mask,#select2-drop')
															.hide();
													$(
															'#select2-drop .select2-input')
															.val('');
													if (goodsid != 0) {
														$("#skuIsChange")
																.val(1);
													}
												}
											}
										});
							}
						}
						var html = '';
						if (find_str.length != 0) {
							$
									.each(
											obj.selProps,
											function(i, item) {
												if (item.name.indexOf(find_str) != -1) {
													html += '<li class="select2-results-dept-0 select2-result select2-result-selectable " id="'
															+ item.c_pId
															+ '" data-id="'
															+ item.propId
															+ '" ><div class="select2-result-label" >'
															+ (item.name
																	.replace(
																			find_str,
																			'<span class="select2-match">'
																					+ find_str
																					+ '</span>'))
															+ '</div></li>';
												}
											});
							if (html == '') {
								html += '<li class="select2-results-dept-0 select2-result select2-result-selectable " id="0" data-id="0" ><div class="select2-result-label" >'
										+ ('<span class="select2-match">'
												+ find_str + '</span>')
										+ '</div></li>';
							}
						} else {
							$
									.each(
											obj.selProps,
											function(i, item) {
												html += '<li class="select2-results-dept-0 select2-result select2-result-selectable " id="'
														+ item.c_pId
														+ '" data-id="'
														+ item.propId
														+ '" ><div class="select2-result-label">'
														+ item.name
														+ '</div></li>';
											});
						}
						$('#select2-drop .select2-results').html(html);
						$('#select2-drop .select2-results .select2-result').eq(
								0).addClass('select2-highlighted').siblings()
								.removeClass('select2-highlighted');
					});
	$('#select2-drop-mask')
			.live(
					'click',
					function() {
						now_sku_name_dom
								.removeClass('select2-dropdown-open select2-container-active');
						$('#select2-drop-mask,#select2-drop').hide();
						$('#select2-drop .select2-input').val('');
						$('#select2-drop .select2-results').empty();
					});

	/**
	 * 下拉菜单的 选项的鼠标得到的事件
	 */
	$('#select2-drop .select2-result').live(
			'mouseover click',
			function(event) {
				if (event.type == 'mouseover') {
					$(this).addClass('select2-highlighted').siblings()
							.removeClass('select2-highlighted');
				} else {
					var provpId = $(this).attr('data-id');
					var c_pid = $(this).attr('id');
					var selName = now_sku_name_dom.find('.select2-chosen')
							.html().replace('&nbsp;', '');
					var text_value = $.trim($(this).text());
					if (is_ProvPExists(text_value)) {
						var guid = $("#guids").val();
						// if(provpId==0){
						$.ajax({
							url : "CateGoryPropsGet",
							type : "post",
							asysc : false,
							data : {
								"guid" : guid,
								"isSku" : 1,
								"name" : text_value,
								"cpvId" : c_pid
							},
							success : function(res) {
								if (res != 0) {
									addProvPArray(res, c_pid, text_value, 1,
											selName);
								}
							}
						});
						// }else{
						// addProvPArray(provpId,c_pid,text_value,1,selName);
						// }
						if (goodsid != 0) {
							$("#skuIsChange").val(1);
						}
						$('#select2-drop-mask,#select2-drop').hide();
						$('#select2-drop .select2-input').val('');
					}
				}
			});

	// 添加规格 点击添加 规格的事件
	$('.js-add-sku-atom')
			.live(
					'click',
					function(event) {
						var add_sku_atom_dom = $(this);
						button_box(
								$(this),
								event,
								'bottom',
								'multi_txt',
								'添加规格值（按Enter键完成）',
								function() {
									$
											.each(
													$('.select2-choices .select2-search-choice'),
													function(i, item) {
														var $div = $(item)
																.find('div');
														var $id = $div
																.attr("id");
														if (delVals.length == 0) {
															return;
														}
														for (var $i = 0; $i < delVals.length; $i++) {
															var $provId = delVals[$i]["id"];
															if ($provId == $id) {
																delVals.splice(
																		$i, 1);
															}
														}

													});
									if (delVals.length != 0) {
										for (var $i = 0; $i < delVals.length; $i++) {
											var $provId = delVals[$i]["id"];
											deleteProvpValue($provId, 0, 1);
										}
									} else {
										refProvHtml(1);
									}
									delVals.length = 0;
									close_button_box(0);
								});
					});

	// 批量设置
	var js_batch_type = '';
	$('.js-batch-price').live('click', function() {
		if (shop_type == 2 || (shop_type == 1 && goodsid == 0)) {
			js_batch_type = 'price';
			$('.js-batch-form').show();
			$('.js-batch-type').hide();
			$('.js-batch-txt').attr('placeholder', '请输入价格');
			$('.js-batch-txt').focus();
		}
	});

	$(".js-batch-market_price").live("click", function() {
		if (shop_type == 2 || (shop_type == 1 && goodsid == 0)) {
			js_batch_type = 'market_price';
			$('.js-batch-form').show();
			$('.js-batch-type').hide();
			$('.js-batch-txt').attr('placeholder', '请输入市场价');
			$('.js-batch-txt').focus();
		}
	});

	$(".js-batch-cost_price").live("click", function() {
		if (shop_type == 2 || (shop_type == 1 && goodsid == 0)) {
			js_batch_type = 'cost_price';
			$('.js-batch-form').show();
			$('.js-batch-type').hide();
			$('.js-batch-txt').attr('placeholder', '请输入成本价');
			$('.js-batch-txt').focus();
		}
	});

	$('.js-batch-stock').live('click', function() {
		if (shop_type == 2 || (shop_type == 1 && goodsid == 0)) {
			js_batch_type = 'stock';
			$('.js-batch-form').show();
			$('.js-batch-type').hide();
			$('.js-batch-txt').attr('placeholder', '请输入库存');
			$('.js-batch-txt').focus();
		}
	});
	$('.js-batch-save')
			.live(
					'click',
					function() {
						var batch_txt = $('.js-batch-txt');
						if (batch_txt.val() != null && batch_txt.val() != '') {
							var float_val = parseFloat(batch_txt.val());
							if (js_batch_type == 'price') {// 原价
								if (float_val > 9999999.99) {
									layer_tips(1, '价格最大为 9999999.99');
									batch_txt.focus();
									return false;
								} else if (!/^\d+(\.\d+)?$/.test(batch_txt
										.val())) {
									layer_tips(1, '只输入合法的价格');
									batch_txt.focus();
									return false;
								} else {
									batch_txt.val(float_val.toFixed(2));
								}
								$('.js-goods-stock .js-price').val(
										batch_txt.val());
								batch_txt.val('');
								// 商品价格
								$("input[name='price']").val(
										float_val.toFixed(2));
								$("input[name='price']").attr('readonly', true);
								eachPrice();
							} else if (js_batch_type == 'market_price') {// 市场价
								if (float_val > 9999999.99) {
									layer_tips(1, '价格最大为 9999999.99');
									batch_txt.focus();
									return false;
								} else if (!/^\d+(\.\d+)?$/.test(batch_txt
										.val())) {
									layer_tips(1, '只输入合法的价格');
									batch_txt.focus();
									return false;
								} else {
									batch_txt.val(float_val.toFixed(2));
								}
								$('.js-goods-stock .js-market-price').val(
										batch_txt.val());
								batch_txt.val('');
								eachMarketPrice();
							} else if (js_batch_type == 'cost_price') {// 成本价
								if (float_val > 9999999.99) {
									layer_tips(1, '价格最大为 9999999.99');
									batch_txt.focus();
									return false;
								} else if (!/^\d+(\.\d+)?$/.test(batch_txt
										.val())) {
									layer_tips(1, '只输入合法的价格');
									batch_txt.focus();
									return false;
								} else {
									batch_txt.val(float_val.toFixed(2));
								}
								$('.js-goods-stock .js-cost-price').val(
										batch_txt.val());
								batch_txt.val('');
								// 商品价格
								$("input[name='price']").val(
										float_val.toFixed(2));
								$("input[name='price']").attr('readonly', true);
								eachCostPrice();
							} else {
								if (!/^\d+$/.test(batch_txt.val())) {
									alert('只输入合法的数量');
									// layer_tips(1,'只输入合法的数量');
									batch_txt.focus();
									return false;
								}
								$('.js-goods-stock .js-stock-num').val(
										batch_txt.val());
								eachInput();
								$('input[name="total_stock"]').val(
										parseInt(batch_txt.val())
												* $('.js-stock-num').size());
								batch_txt.val('');
							}
							$('.js-batch-form').hide();
							$('.js-batch-type').show();
						} else {
							alert("请输入价格");
							batch_txt.focus();
						}
					});
	$('.js-batch-cancel').live('click', function() {
		$('.js-batch-form').hide();
		$('.js-batch-type').show();
	});
	/**
	 * 创建时间：2015年6月9日10:57:33 创建人：高伟 功能说明：通过规格的id和属性值得名称 查看在当前的删除数组中是否已经存在
	 */
	function Deal_DeleteValues($provpId, $name) {
		for (var $i = 0; $i < obj.props.length; $i++) {
			if (obj.props[$i]["propId"] == $provpId) {
				for (var $j = 0; $j < obj.props[$i]["proDelValues"].length; $j++) {
					if (obj.props[$i]["proDelValues"][$j]["name"] == $name) {
						var $count = obj.props[$i]["propvalues"].length;
						obj.props[$i]["propvalues"][$count] = obj.props[$i]["proDelValues"][$j];
						obj.props[$i]["proDelValues"].splice($j, 1);
						return obj.props[$i]["propvalues"][$count];
					}
				}
				break;
			}
		}
		return null;
	}
	;
	/**
	 * 小的弹出层
	 * 
	 * param dom 弹出层的ID 使用 $(this); param e 弹出层的ID点击返回事件 使用 event; param
	 * position 方向 left,top,right,bottom param type 弹出层的类别
	 * copy,edit_txt,delete,confirm,multi_txt,radio,input,url,module param
	 * content 内容 param ok_obj 点击确认键的回调方法 param placeholder 点位符 param propId
	 * 添加的规格id
	 */
	function button_box(dom, event, position, type, content, ok_obj,
			placeholder) {
		event.stopPropagation();
		var left = 0, top = 0, width = 0, height = 0;
		var dom_offset = dom.offset();
		$('.popoverCate').remove();
		$('.MAIN')
				.append(
						'<div class="popoverCate '
								+ position
								+ '" style="left:-'
								+ ($(window).width() * 5)
								+ 'px;top:'
								+ $(window).scrollTop()
								+ 'px;"><div class="arrow"></div><div class="popoverCate-inner popoverCate-chosen"><div class="popoverCate-content"><div class="select2-container select2-container-multi js-select2 select2-dropdown-open" style="width:242px;display:inline-block;"><ul class="select2-choices"><li class="select2-search-field">    <input type="text" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" class="select2-input" id="s2id_autogen26" tabindex="-1" style="width:192px;"></li></ul></div> <button type="button" class="btn js-btn-confirm"  data-loading-text="确定">确定</button> <button type="reset" class="btn js-btn-cancel">取消</button></div></div></div>');
		$('.popoverCate-chosen .select2-input').attr('placeholder', content)
				.focus();
		$('.popoverCate-chosen .select2-input').attr("name", $(dom).attr("id"));
		multi_choose_obj();
		button_box_after();
		function button_box_after() {
			$('.popoverCate .js-btn-cancel').one('click', function() {
				close_button_box(1);
			});
			$('.popoverCate .js-btn-confirm').one('click', function() {
				ok_obj();
			});
			$('.popoverCate').click(function(e) {
				e.stopPropagation();
			});
			$('body').bind('click', function() {
				close_button_box(1);
			});
			var popover_height = $('.popoverCate').height();
			var popover_width = $('.popoverCate').width();
			switch (position) {
			case 'left':
				$('.popoverCate').css(
						{
							top : dom_offset.top
									- (popover_height + 10 - dom.height()) / 2,
							left : dom_offset.left - popover_width - 14
						});
				break;
			case 'right':
				$('.popoverCate').css(
						{
							top : dom_offset.top
									- (popover_height + 10 - dom.height()) / 2,
							left : dom_offset.left + dom.width() + 27
						});
				$('.popoverCate-confirm').css('margin-left', '0');
				break;
			case 'top':
				$('.popoverCate').css(
						{
							top : (dom_offset.top - dom.height() - 40),
							left : dom_offset.left - (popover_width / 2)
									+ (dom.width() / 2)
						});
				break;
			case 'bottom':
				$('.popoverCate').css(
						{
							top : dom_offset.top + dom.height() - 3,
							left : dom_offset.left - (popover_width / 2)
									+ (dom.width() / 2)
						});
				break;
			}
		}
		// 添加商品添加规格专用方法
		function multi_choose_obj() {
			$('.popoverCate-chosen .select2-input')
					.keyup(
							function(event) {
								var input_select2 = $.trim($(this).val());
								var propId = $(this).attr("name");
								if (event.keyCode == 13
										&& input_select2.length != 0) {
									var is_li = false;// 判断是否已经有了li
									var c_vId = 0;
									if ($(
											'.popoverCate-chosen .select2-choices .select2-search-choice')
											.size() > 0) {
										is_li = true;
									}
									if (is_ProvpValueExists(propId,
											input_select2)) {
										$(this).removeAttr('placeholder').val(
												'').focus();
										var valueObj = Deal_DeleteValues(
												propId, input_select2);
										if (valueObj != null) {
											var des = new Object();
											des.id = valueObj["propValueId"];
											$count = delVals.length;
											delVals[$count] = des;
											var html = $('<li class="select2-search-choice"><div id='
													+ valueObj["propValueId"]
													+ '>'
													+ input_select2
													+ '</div><a href="#" class="select2-search-choice-close" tabindex="-1" onclick="$(this).closest(\'li\').remove();$(\'.popoverCate-chosen .select2-input\').focus();"></a></li>');
											if (is_li == false) {
												$(
														'.popoverCate-chosen .select2-choices')
														.prepend(html);
											} else {
												$(
														'.popoverCate-chosen .select2-choices .select2-search-choice:last')
														.after(html);
											}
										} else {
											$
													.ajax({
														url : "CateGoryPropvaluesGet",
														type : "post",
														asysc : false,
														data : {
															"propId" : propId,
															"cvId" : c_vId,
															"value" : input_select2
														},
														success : function(res) {
															addProvPValueArray(
																	res, 0,
																	propId,
																	input_select2);
															var des = new Object();
															des.id = res;
															$count = delVals.length;
															delVals[$count] = des;
															var html = $('<li class="select2-search-choice"><div id='
																	+ res
																	+ '>'
																	+ input_select2
																	+ '</div><a href="#" class="select2-search-choice-close" tabindex="-1" onclick="$(this).closest(\'li\').remove();$(\'.popoverCate-chosen .select2-input\').focus();"></a></li>');
															if (is_li == false) {
																$(
																		'.popoverCate-chosen .select2-choices')
																		.prepend(
																				html);
															} else {
																$(
																		'.popoverCate-chosen .select2-choices .select2-search-choice:last')
																		.after(
																				html);
															}
														}
													});
											if (goodsid != 0) {
												$("#skuIsChange").val(1);
											}
										}

									}
								}
							});
		}
		;
	}
	;

	/**
	 * 关闭选择的下拉菜单
	 */
	function close_div_select() {
		$('#select2-drop').css("display", "none");
	}
	/**
	 * 判断是否需要删除添加的数据
	 */
	function close_button_box($is_Del) {
		if ($is_Del == 1) {
			$.each($('.popoverCate-chosen .select2-search-choice'), function(i,
					item) {
				var choice_html = $.trim($(item).find('div').html());
				var propvaId = $.trim($(item).find('div').attr("id"));
				deleteProvpValue(propvaId, 0, 0);
			});
		}
		$('.popoverCate').remove();
	}
};