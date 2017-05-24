/**
 * 商品列表，点击购物车，弹出商品属性 -wyj
 * 2017年3月3日 10:12:27
 */
	function getAttribute(goods_id){
		var sku_attribute = new Array();
		$("input[name='goods_sku"+goods_id+"']").each(function(){
			var obj = new Object();
			obj.sku = $(this).val();
			obj.stock = $(this).attr("stock");
			obj.price = $(this).attr("price");
			obj.skuid = $(this).attr("skuid");
			obj.skuname = $(this).attr("skuname");
			sku_attribute.push(obj);
		});
		return sku_attribute;
	}

	//加入购物车
	function ShowGoodsAttribute(goods_id,goods_name,pic_id,obj,max_buy){
		$("#hidden_goodsid").val(goods_id);
		$("#hidden_goods_name").val(goods_name);
		$("#hidden_default_img_id").val(pic_id);
		$("#hidden_max_buy").val(max_buy);//存储当前选中商品的最大限购数量
		var sku_attribute = getAttribute(goods_id);
		$.ajax({
			url : shop_main+"/Goods/getGoodsSkuInfo",
			type : "post",
			data : {"goods_id" : goods_id},
			success : function(res){
				var str = "";
				if(res["attribute_list"].length>0){
					
					var attribute_list = res["attribute_list"];
					var attribute_value_list = res["attribute_value_list"];
					for(var i=0;i<attribute_list.length;i++){
						
						str += '<div class="dt">'+attribute_list[i]["attr_name"]+'</div>';
						str += '<div class="dd radio-dd">';
						var index = 0;
						for(var j=0;j<attribute_value_list.length;j++){
							if(attribute_list[i]["attr_id"]==attribute_value_list[j]["attr_id"]){
								var value = attribute_value_list[j]["attr_id"]+':'+attribute_value_list[j]["attr_value_id"]+";";

								if(index==0){
									str += '<span class="attr-radio curr">';
								}else{
									
									str += '<span class="attr-radio">';
								}
								index++;
								str += '<label onclick="selectAttr(this,'+i+','+goods_id+')" name="attribute_'+i+'" value="'+value+'">';
								str += '<font>'+attribute_value_list[j]["attr_value"]+'</font></label></span>';
							}else{
								index = 0;
							}
						}
						
						str += '</div><div class="blank"></div>';
					}
					
					$(".js-sku-list").html(str);
					$('#speDiv').css({'top':($(window).height()-$('#speDiv').outerHeight())/2,"display":"block"});
					$("#mask").show();
					
				}else{
					
					$("#hidden_skuname").val(sku_attribute[0].skuname);
					$("#hidden_sku_price").val(sku_attribute[0].price);
					$("#hidden_skuid").val(sku_attribute[0].skuid);
					addToCart();
	
				}
	
			}
			
		});
	}


	//弹出框，选择商品属性加入购物车
	function addToCart(){
		var num = 0;
		for(var i=0;i<cart_id_arr.length;i++)
		{
			if(cart_id_arr[i]==parseInt($("#hidden_goodsid").val()))
			{
				num ++;
			}
			if(cart_id_arr[i]==parseInt($("#hidden_goodsid").val()) && cart_num[i]>1 && cart_num[i]==$("#hidden_max_buy").val())
			{
				$.msg("该商品限购"+cart_num[i]+"件",{time:2000});
				return false;
			}
		};
		//再次检查购物车中的商品，是否有同一件商品，不同的SKU
		if(num>0 && num == $("#hidden_max_buy").val())
		{
			$.msg("购物车中已存在该商品",{time:2000});
			return false;
		}
		setSelectAttr($("#hidden_goodsid").val());
		var cart_detail = new Object();
		cart_detail.goods_id = $("#hidden_goodsid").val();
		cart_detail.count = 1;//$("#num").val();
		cart_detail.goods_name = $("#hidden_goods_name").val();
		cart_detail.sku_id = $("#hidden_skuid").val();
		cart_detail.sku_name = $("#hidden_skuname").val();
		cart_detail.price = $("#hidden_sku_price").val();
		cart_detail.picture_id = $("#hidden_default_img_id").val();
		cart_detail.cost_price = $("#hidden_sku_price").val();//成本价
		var cart_tag = "addCart";//暂时没用，保留。
		$.ajax({
			url : shop_main+"/Member/addCart",
			type : "post",
			data : {
				"cart_detail" : cart_detail,
				"cart_tag" : cart_tag
			},
			success : function(res){
				if(res > 0){
					$(".add-cart").removeClass("js-disabled");
					refreshShopCart();//里边会加载购物车中的数量
					$.msg("添加购物车成功", {
						time: 3000
					});
				}else{
					//只有会员登录之后才能购买，请进入会员中心注册或登录。
					window.location.href = shop_main+ "/login/index";
				}
				closeBuy();
			}
		});
		
	}
	
	//关闭sku弹出框
	function closeBuy(){
		$("#mask").hide();
		$('#speDiv').hide();
	}
	
	function setSelectAttr(goods_id){
		var curr = "";//当前选择的SKU
		$("span[class='attr-radio curr'").each(function(){
			curr += $(this).find("label").attr("value");
		});
		
		var flag = false;//匹配当前所选中的sku
		$("input[name='goods_sku"+goods_id+"'").each(function(){
			if(curr == $(this).val()){
				flag = true;
				$("#hidden_skuid").val($(this).attr("skuid"));
				$("#hidden_skuname").val($(this).attr("skuname"));
				$("#hidden_sku_price").val($(this).attr("price"));
			}
		})
	}
	

	//选择sku对应的属性
	function selectAttr(obj,i,goods_id){
		$("label[name='attribute_"+i+"']").each(function(){
			$(this).parent().removeClass("curr");
		})
		$(obj).parent().addClass("curr");
		setSelectAttr(goods_id);
	}