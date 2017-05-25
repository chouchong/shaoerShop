/**
 * 定义上传(存入相册) 
 */
function fileAlbumUpload(url, fileid, datajson ,is_load){
	//datajason   {"album_id":,"type":,"pic_name":,"pic_tag":,"pic_id":,"path"}
	//is_load  false: 不刷新页面数据  true: 刷新页面数据
	$.ajaxFileUpload({
		url : url+'/Upload/fileAlbumUpload', //用于文件上传的服务器端请求地址
		secureuri : false, //一般设置为false
		fileElementId : fileid, //文件上传空间的id属性  <input type="file" id="file" name="file" />
		dataType : 'text', //返回值类型 一般设置为json
		data : datajson,
		async : false,
		contentType : "text/json;charset=utf-8",
		success : function(data) //服务器成功响应处理函数
		{
			if (data > 0) {
				if(is_load == true){
					LoadingInfo(1);
				}				
				showMessage('success', '上传成功',"#");
			}else{
				showMessage('error', '上传失败');
			}
		}
	});
}

/**
 * 定义上传(不存入相册) 
 */
function fileCommonUpload(url, fileid,path,str){
	var result='';
	if(str == undefined){
		var imgpath = "#imgLogo";
		var imgval = "#Logo";
	}else{
		var imgpath = "#img"+str;
		var imgval = "#"+str;
	}
	$.ajaxFileUpload({
		url : url+'/Upload/fileCommonUpload', //用于文件上传的服务器端请求地址
		secureuri : false, //一般设置为false
		fileElementId : fileid, //文件上传空间的id属性  <input type="file" id="file" name="file" />
		dataType : 'text', //返回值类型 一般设置为json
		async : false,
		contentType : "text/json;charset=utf-8",
		success : function(data) //服务器成功响应处理函数
		{
			if (data) {
				$(imgpath).attr("src",path+"/"+data);
				$(imgval).val(data);	
				showMessage('success', '上传成功');
			}else{
				showMessage('error', '上传失败');
			}
		}
	});
}



/**
 * 上传文件 
 */
function fileUpload(obj,fileid,url){
	$.ajaxFileUpload({
		url : url+'/Upload/fileUpload', //用于文件上传的服务器端请求地址
		secureuri : false, //一般设置为false
		fileElementId : fileid, //文件上传空间的id属性  <input type="file" id="file" name="file" />
		dataType : 'text', //返回值类型 一般设置为json
		async : false,
		contentType : "text/json;charset=utf-8",
		success : function(data) //服务器成功响应处理函数
		{
			if (data) {
				$("#p_"+fileid).text(data);
				$("#hidden_"+fileid).val(data);
				showMessage('success', '上传成功');
			}else{
				showMessage('error', '上传失败');
			}
		}
	});
}