function saveAddress() {
	if (!Check_Consignee()) {
		return false;
	}
	var addressID = $("#AddressID").val();
	var addressinfo = $("#AddressInfo").val();
	var province = $("#seleAreaNext").val();
	var city = $("#seleAreaThird").val();
	var district = $("#seleAreaFouth").val();
	var name=$("#Name").val();
	var mobile=$("#Moblie").val();
	var $remark=$("#AddressInfo").val();
	var address_id=$("#adressid").val();
	var data_json='',ajax_url='';
	
	if(typeof(address_id)=='undefined'){
		data_json = {"consigner":name,"mobile":mobile,"province":province,"city":city,"district":district,"address":addressinfo};
		ajax_url = 'addMemberAddress';
	}else{
		data_json = {"id":address_id,"consigner":name,"mobile":mobile,"province":province,"city":city,"district":district,"address":addressinfo};
		ajax_url = 'updateMemberAddress';
	}
	var flag = $("#hidden_flag").val();
	var ref_url = $("#ref_url").val();
	$.ajax({
		type: "POST",
		url: ajax_url,
		data: data_json,
		success: function (txt) {
			if (txt["code"] >0) {
				if(flag == 1){
					location.href=APPMAIN+"/Member/memberAddress?flag=1";
				}else{
					if(ref_url != ''){
//						window.location.href=ref_url;
						location.href=APPMAIN+"/Order/PaymentOrder";
					}
				}
			} else {
				showBox(txt);
			}
		}
	});
}

function Check_Consignee() {
	var reg = /^\d{11}$/;
	if ($("#Name").val() == "") {
		showBox("收货人姓名不能为空");
		$("#Name").focus();
		return false;
	} 
	if ($("#Moblie").val() == "") {
		showBox("手机号码不能为空");
		$("#Moblie").focus();
		return false;
	} 
	if (!reg.test($("#Moblie").val())) {
		showBox("请输入正确的手机号码");
		$("#Moblie").focus();
		return false;
	} 
	if ($("#AddressInfo").val() == "") {
		showBox("详细地址不能为空");
		$("#AddressInfo").focus();
		return false;
	} 
	if ($("#seleAreaFouth").val() < 0 || $("#seleAreaFouth").val() == "") {
		if ($("#seleAreaNext").val() == "") {
			showBox("请选择省份");
			$("#seleAreaNext").focus();
			return false;
		}
		if ($("#seleAreaThird").val() == "") {
			showBox("请选择市");
			$("#seleAreaThird").focus();
			return false;
		}
		if ($("#seleAreaFouth")[0].length == 1 && $("#seleAreaThird")[0].length > 1 && $("#seleAreaThird").val() > -1) {
			return true;
		} else {
			showBox("请选择区/县");
			$("#seleAreaFouth").focus();
			return false;
		}
	}
	return true;
}

// 选择省份弹出市区
function GetProvince() {
	var id = $("#seleAreaNext").find("option:selected").val();
	var selCity = $("#seleAreaThird")[0];
	for (var i = selCity.length - 1; i >= 0; i--) {
		selCity.options[i] = null;
	}
	
	var opt = new Option("请选择市", "-1");
	selCity.options.add(opt);
	$.ajax({
		type : "post",
		url : "getCity",
		dataType : "json",
		data : {
			"province_id" : id
		},
		success : function(data) {
			if (data != null && data.length > 0) {
				for (var i = 0; i < data.length; i++) {
					var opt = new Option(data[i].city_name,data[i].city_id);
					selCity.options.add(opt);
				}
				if(typeof($("#cityid").val())!='undefined'){
					$("#seleAreaThird").val($("#cityid").val());
					getSelCity();
					$("#cityid").val('-1');
				}
			}
		}
	});
};
// 选择市区弹出区域
function getSelCity() {
	var id = $("#seleAreaThird").find("option:selected").val();
	var selArea = $("#seleAreaFouth")[0];
	for (var i = selArea.length - 1; i >= 0; i--) {
		selArea.options[i] = null;
	}
	var opt = new Option("请选择区/县", "-1");
	selArea.options.add(opt);
	$.ajax({
		type : "post",
		url : "getDistrict",
		dataType : "json",
		data : {
			"city_id" : id
		},
		success : function(data) {
			if (data != null && data.length > 0) {
				for (var i = 0; i < data.length; i++) {
					var opt = new Option(data[i].district_name,data[i].district_id);
					selArea.options.add(opt);
				}
				if(typeof($("#districtid").val())!='undefined'){
					$("#seleAreaFouth").val($("#districtid").val());
					$("#districtid").val('-1');
				}
				
			}
		}
	});
}

$(function() {
	var selCity = $("#seleAreaNext")[0];
	for (var i = selCity.length - 1; i >= 0; i--) {
		selCity.options[i] = null;
	}
	var opt = new Option("请选择省", "-1");
	selCity.options.add(opt);
	// 添加省
	$.ajax({
		type : "post",
		url : "getProvince",
		dataType : "json",
		success : function(data) {
			if (data != null && data.length > 0) {
				for (var i = 0; i < data.length; i++) {
					var opt = new Option(data[i].province_name,
							data[i].province_id);
					selCity.options.add(opt);
				}
				if(typeof($("#provinceid").val())!='undefined'){
					$("#seleAreaNext").val($("#provinceid").val());
					GetProvince();
					$("#provinceid").val('-1');
				}
			}
		}
	});
});