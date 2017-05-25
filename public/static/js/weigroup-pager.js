/**
 * 分页
 * @param totalcount	数据总数
 * @param pagecount		总页数
 * @param pageIndex		页码
 * @param pageSize		页大小
 */
function pagesum(totalcount, pagecount, pageIndex, pageSize, methodName) {

	var currentPageSum = pagecount; //总页数	
	var dataSum = totalcount; //数据总数

	var currentPageIndex = pageIndex; //当前页码
	var currentPageSize = pageSize; //当前页大小

	var currentPageShowSum = 0; //当前页显示数量
	currentPageShowSum = totalcount - (currentPageIndex - 1) * currentPageSize; //当前页显示数量

	var startPageNum = 0; //当前页开始号码
	if(totalcount != 0) {
		startPageNum = (currentPageIndex - 1) * currentPageSize + 1; //当前页开始号码
	}

	var endPageNum = 0; //当前页结束号码
	if(pagecount == currentPageIndex) {
		endPageNum = totalcount; //当前页结束号码
	} else {
		if(totalcount != 0) {
			endPageNum = currentPageIndex * currentPageSize;
		}
	}

	//    $("#currentPageShowSum").val(currentPageShowSum);//当前页显示个数
	$("#pagecount").html(pagecount); //总页数
	$("#totalcount").html(totalcount); //数据总数
	$("#startPageNum").html(startPageNum); //开始号码
	$("#endPageNum").html(endPageNum); //结束号码
	$("#pageIndex").html(currentPageIndex);

	//将页码填入
	$("#firstOne").attr("onClick", methodName + "(1)");
	$("#previousOne").attr("onClick", methodName + "(" + (currentPageIndex - 1) + ")");
	$("#lastOne").attr("onClick", methodName + "(" + pagecount + ")");
	$("#nextOne").attr("onClick", methodName + "(" + (currentPageIndex + 1) + ")");

	$("#firstOne").parent().addClass("am-disabled");
	$("#previousOne").parent().addClass("am-disabled");
	$("#lastOne").parent().addClass("am-disabled");
	$("#nextOne").parent().addClass("am-disabled");
	//    //判断是否最后一页
	if(pagecount == 1) {

		$("#lastOne").removeAttr("onClick");
		$("#nextOne").removeAttr("onClick");
		$("#firstOne").removeAttr("onClick");
		$("#previousOne").removeAttr("onClick");

	} else if(currentPageIndex == 1) {

		$("#firstOne").removeAttr("onClick");
		$("#previousOne").removeAttr("onClick");
		$("#lastOne").parent().removeClass("am-disabled");
		$("#nextOne").parent().removeClass("am-disabled");

	} else if(currentPageIndex == pagecount) {

		$("#lastOne").removeAttr("onClick");
		$("#nextOne").removeAttr("onClick");
		$("#firstOne").parent().removeClass("am-disabled");
		$("#previousOne").parent().removeClass("am-disabled");

	} else {
		$("#firstOne").parent().removeClass("am-disabled");
		$("#previousOne").parent().removeClass("am-disabled");
		$("#lastOne").parent().removeClass("am-disabled");
		$("#nextOne").parent().removeClass("am-disabled");

	}

}
/**
 * 实例 调用数据
 * @param currentPageIndex
 * @param url
 */
function getPageData(currentPageIndex) {

	//页大小设置
	var currentPageSize = 15;

	//获取数据
	$.ajax({
		type: "Post",
		url: "__MODULE__",
		data: {
			"currentPageIndex": currentPageIndex,
			"currentPageSize": currentPageSize
		},
		dataType: "json",
		success: function(responseData) {
			//         	 alert(responseData);
			$("#mod-tbody").html(responseData[0]);

			//分页
			pagesum(responseData[1][0].totalcount, responseData[1][0].pagecount, currentPageIndex, currentPageSize, "getPageData");
		}
	});
}