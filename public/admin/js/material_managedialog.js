//弹出图片管理界面  2016年11月24日 17:58:41
var OpenPricureDialog = function(type, ADMIN_MAIN, photoNumber) {
	if (photoNumber == null || photoNumber == '' || photoNumber == 0) {
		photoNumber = 1;
	}
	if (type == "PopPicure") {
		art.dialog.open(ADMIN_MAIN + '/System/dialogAlbumList?photoNumber='
				+ photoNumber, {
			lock : true,
			title : "我的图片",
			width : 860,
			height : 620,
			drag : false,
			background : "#000000"
		}, true);
	}
}