//数字跳转页面 2016年11月16日 16:07:24
var jumpNumber = 1;
// 样式处理
function changeClass(flag) {
	switch (flag) {
	case "begin":
		$("#beginPage").addClass("page-disable");
		$("#prevPage").addClass("page-disable");
		$("#lastPage").removeClass("page-disable");
		$("#nextPage").removeClass("page-disable");
		break;
	case "prev":
		$("#lastPage").removeClass("page-disable");
		$("#nextPage").removeClass("page-disable");
		$("#beginPage").addClass("page-disable");
		$("#prevPage").addClass("page-disable");
		break;
	case "next":
		$("#lastPage").addClass("page-disable");
		$("#nextPage").addClass("page-disable");
		$("#beginPage").removeClass("page-disable");
		$("#prevPage").removeClass("page-disable");
		break;
	case "all":
		$("#lastPage").addClass("page-disable");
		$("#nextPage").addClass("page-disable");
		$("#beginPage").addClass("page-disable");
		$("#prevPage").addClass("page-disable");
		break;
	default:
		$("#lastPage").removeClass("page-disable");
		$("#nextPage").removeClass("page-disable");
		$("#beginPage").removeClass("page-disable");
		$("#prevPage").removeClass("page-disable");
		break;
	}
}


function  pagenumShow(pageindex,pagecount,pageshow){	
	var $html='';
	var pageindex = parseInt(pageindex);
	var pagecount = parseInt(pagecount);
	var pageshow = parseInt(pageshow);
	if(pagecount<=pageshow){
		var i = 0;
		for (i = 1; i <= pagecount; i++) {
			if (pageindex == i) {
				$html += "<a   onclick='JumpForPage(this)' class='currentPage'>"
						+ i + "</a>";
			} else {
				$html += "<a   onclick='JumpForPage(this)' >"
						+ i + "</a>";
			}
		}
	}else{
		if((pageshow%2) ==1){
			var pagehalf = (pageshow-1)/2;
			
			if (pageindex <= (pagehalf + 1)) {
				for (i = 1; i <= pageshow; i++) {

					if (pageindex == i) {
						$html += "<a   onclick='JumpForPage(this)' class='currentPage'>"
								+ i + "</a>";
					} else {
						$html += "<a   onclick='JumpForPage(this)' >"
								+ i + "</a>";
					}
				}
			} else {
				if ((pagecount - pageindex) < pagehalf) {
					var start = pagecount - pageshow+1;
					for (i = start; i <= pagecount; i++) {
						if (pageindex == i) {
							$html += "<a   onclick='JumpForPage(this)' class='currentPage'>"
									+ i + "</a>";
						} else {
							$html += "<a   onclick='JumpForPage(this)' >"
									+ i + "</a>";
						}
					}
				} else {
					var start = pageindex - pagehalf;
					var end = pageindex + pagehalf;
					for (i = start; i <= end; i++) {
						if (pageindex == i) {
							$html += "<a   onclick='JumpForPage(this)' class='currentPage'>"
									+ i + "</a>";
						} else {
							$html += "<a   onclick='JumpForPage(this)' >"
									+ i + "</a>";
						}
					}
				}
			}
		}else{
			var pagehalf = pageshow/2;
			if (pageindex <= pagehalf) {
				for (i = 1; i <= pageshow; i++) {

					if (pageindex == i) {
						$html += "<a   onclick='JumpForPage(this)' class='currentPage'>"
								+ i + "</a>";
					} else {
						$html += "<a   onclick='JumpForPage(this)' >"
								+ i + "</a>";
					}
				}
			} else {
				if ((pagecount - pageindex) < pagehalf) {
					var start = pagecount - pageshow+1;
					for (i = start; i <= pagecount; i++) {
						if (pageindex == i) {
							$html += "<a   onclick='JumpForPage(this)' class='currentPage'>"
									+ i + "</a>";
						} else {
							$html += "<a   onclick='JumpForPage(this)' >"
									+ i + "</a>";
						}
					}
				} else {
					var start = pageindex - pagehalf+1;
					var end = pageindex + pagehalf;
					for (i = start; i <= end; i++) {
						if (pageindex == i) {
							$html += "<a   onclick='JumpForPage(this)' class='currentPage'>"
									+ i + "</a>";
						} else {
							$html += "<a   onclick='JumpForPage(this)' >"
									+ i + "</a>";
						}
					}
				}
			}
		}
	}
	return $html;
}