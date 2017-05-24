<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:42:"template/admin\b2c\Wchat\replayConfig.html";i:1495108489;s:28:"template/admin\b2c\base.html";i:1495424696;s:45:"template/admin\b2c\Wchat\controlWxDialog.html";i:1494580825;s:34:"template/admin\b2c\pageCommon.html";i:1492765125;s:34:"template/admin\b2c\openDialog.html";i:1495424452;}*/ ?>
<!DOCTYPE html>
<html>
	<head>
	<?php if($frist_menu['module_name']=='首页'): ?>
	<title><?php echo $title_name; ?> - 商家管理</title>
	<?php else: ?>
		<title><?php echo $title_name; ?> - <?php echo $frist_menu['module_name']; ?>管理</title>
	<?php endif; ?>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="baidu-site-verification" content="phGGG7jWOJ" />
		<link rel="shortcut  icon" type="image/x-icon" href="ADMIN_IMG/admin_icon.ico" media="screen"/>
		<link rel="stylesheet" type="text/css" href="__STATIC__/bootstrap/css/bootstrap.css">
<!-- 		<link rel="stylesheet" type="text/css" href="__STATIC__/bootstrap/css/bootstrapSwitch.css"> -->
		<link rel="stylesheet" type="text/css" href="__STATIC__/bootstrap/css/bootstrap-responsive.css">
		<link rel="stylesheet" type="text/css" href="__STATIC__/css/common.css">
		<link rel="stylesheet" type="text/css" href="__STATIC__/css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="__STATIC__/css/seller_center.css">
		<link rel="stylesheet" type="text/css" href="__STATIC__/simple-switch/css/simple.switch.three.css">
		<script src="__STATIC__/js/jquery-1.8.1.min.js"></script>
		<script src="__STATIC__/bootstrap/js/bootstrap.js"></script>
<!-- 		<script src="__STATIC__/bootstrap/js/bootstrapSwitch.js"></script> -->
		<script src="__STATIC__/simple-switch/js/simple.switch.min.js"></script>
		<script src="__STATIC__/js/jquery.unobtrusive-ajax.min.js"></script>
		<script src="__STATIC__/js/common.js"></script>
		<script src="__STATIC__/js/seller.js"></script>
		<script>
			var PLATFORM_NAME="<?php echo $title_name; ?>";
			var ADMINIMG = "ADMIN_IMG";
			var ADMINMAIN = "ADMIN_MAIN";
			var UPLOAD = "__UPLOAD__";
		</script>
		<!-- <script src="__STATIC__/js/highcharts.js"></script> -->
		
<style>
.step_0{text-align:center;margin-top:100px;}
.reply-div{border:1px solid #d3d3d3;width:360px;padding:15px;margin-top:20px;}
.cover-div{background:#f5f5f5;position:relative;}
.cover-title{position:absolute;left:0;bottom:0;background:#000;color:#fff;width:350px;padding:5px;opacity:0.6;}
.cover-pic{max-width:360px;max-height:200px;margin:auto;display:block;}
.reply-one p,h5{padding:3px 0;}
.reply-one p{color:#999;font-size:13px;}
ul.reply-more li{border-bottom:1px solid #d3d3d3;padding:10px 0;}
ul.reply-more li:after{content:'';clear:both;display:block;}
ul.reply-more li:last-child{border-bottom:0px solid #d3d3d3;padding-bottom:0;}
ul.reply-more li:first-child{padding-top:0;}
.media-div-l{width:270px;margin-right:10px;float:left;}
.media-div-r{width:80px;float:right;}
.media-img{max-width:80px;max-height:200px;margin:auto;display:block;}
.media-button{border:1px solid #d3d3d3;width:390px;border-top:0px solid #d3d3d3;background:#e7e7eb;display:table;}
.media-button a{display:inline-block;width:194.5px;text-align:center;padding:10px 0;}
.media-button a:first-child{border-right:1px solid #d3d3d3;}
</style>

	</head>
<body>
<style>
.wrapper{width:1268px;}
</style>
	<header class="ncsc-head-layout">
		<div class="wrapper">
			<div class="ncsc-admin">
<!-- 				<div class="ncsc-admin-info dropdown-toggle" data-toggle="dropdown"> -->
					<div class="ncsc-admin-headimg">
					<?php if($user_headimg != ''): ?>
						<img src="__ROOT__/<?php echo $user_headimg; ?>"/>
					<?php else: ?>
						<img src="__STATIC__/images/default_user_portrait.gif"/>
					<?php endif; ?>
					</div>
					<span class="user-name"><?php echo $username; ?></span>
					<a class="ncsc-admin-a ncsc-admin-info" data-toggle="dropdown"><i class="ncsc-admin-i ncsc-admin-down"></i></a>
					<a class="ncsc-admin-a h40"><i class="ncsc-admin-line"></i></a>
					<a class="ncsc-admin-a" href="SHOP_MAIN/Index/index" target="_blank" title="新窗口打开商城前台首页"><i class="ncsc-admin-i ncsc-admin-home"></i></a>
					<a class="ncsc-admin-a" href="ADMIN_MAIN/Login/logout.html" title="安全退出管理中心"><i class="ncsc-admin-i ncsc-admin-off"></i></a>
<!-- 						<img src="__STATIC__/images/topright_list.png"/> -->
<!-- 				</div> -->
				<div class="user-operation dropdown-menu">
<!-- 					<a href="ADMIN_MAIN" title="首页"> -->
<!-- 						<i class="fa fa-home"></i>首页 -->
<!-- 					</a>  -->
<!-- 					<a href="ADMIN_MAIN/Auth/userDetail.html" title="个人资料"> -->
<!-- 						<i class="fa fa-user"></i>个人资料 -->
<!-- 					</a>  -->
					<a href="javascript:;" title="修改密码" onclick="editpassword()">
						<i class="fa fa-wrench"></i>修改密码
					</a>
<!-- 					<a href="ADMIN_MAIN/Login/logout.html" title="安全退出"> -->
<!-- 						<i class="fa fa-sign-out"></i>安全退出 -->
<!-- 					</a> -->
				</div>
			</div>
			<div class="center-logo">
				<a href="ADMIN_MAIN"><img src="ADMIN_IMG/shop_logo.png"/></a>
<!-- 				<h1><a href="#" title="<?php echo $title_name; ?>"><span>NIU</span>SHOP&nbsp;<span>电商系统</span></a></h1> -->
			</div>
			<div class="index-search-container" style="position: relative;">
				<div class="index-sitemap" onclick="nav_open(this)">
					<a href="javascript:void(0);">导航管理<i class="icon-angle-down"></i></a>
					<div class="sitemap-menu" style="display: none; z-index: 1000;">
						<div class="title-bar" onclick="nav_close()">
							<h2>
								<i class="icon-sitemap"></i>管理导航<em></em>
							</h2>
							<span id="closeSitemap" class="close">X</span>
						</div>
						<div id="quicklink_list" class="content">
							<?php if(is_array($nav_list) || $nav_list instanceof \think\Collection || $nav_list instanceof \think\Paginator): if( count($nav_list)==0 ) : echo "" ;else: foreach($nav_list as $key=>$nav): ?>
							<dl>
								<dt><?php echo $nav['data']['module_name']; ?></dt>
								<?php if(is_array($nav['sub_menu']) || $nav['sub_menu'] instanceof \think\Collection || $nav['sub_menu'] instanceof \think\Paginator): if( count($nav['sub_menu'])==0 ) : echo "" ;else: foreach($nav['sub_menu'] as $key=>$nav_sub): ?>
								<dd>
									<a href="ADMIN_MAIN/<?php echo $nav_sub['url']; ?>"> <?php echo $nav_sub['module_name']; ?></a>
								</dd>
								<?php endforeach; endif; else: echo "" ;endif; ?>
							</dl>
							<?php endforeach; endif; else: echo "" ;endif; ?>
						</div>
					</div>
				</div>
				<div class="search-bar">
					<!-- <form method="get" target="_blank"> -->
						<input type="hidden" name="act" value="search"> 
						<input type="text" id="search_goods" name="keyword" placeholder="商品搜索" class="search-input-text" > 
						<input type="submit" class="search-input-btn pngFix" value="" onclick="search()">
					<!-- </form> -->
				</div>
			</div>
			<nav class="ncsc-nav">
				<?php if(is_array($headlist) || $headlist instanceof \think\Collection || $headlist instanceof \think\Paginator): if( count($headlist)==0 ) : echo "" ;else: foreach($headlist as $key=>$per): if(strtoupper($per['module_id']) == $headid): ?>
				<dl class="current_nav" onmouseover="add_nav_class(this)"
					onmouseout="remove_nav_class(this)">
					<dt>
						<a href="ADMIN_MAIN/<?php echo $per['url']; ?>"><?php echo $per['module_name']; ?></a>
					</dt>
					<dd class="arrow"></dd>
				</dl>
				<?php else: ?>
				<dl onmouseover="add_nav_class(this)" onmouseout="remove_nav_class(this)">
					<dt>
						<a href="ADMIN_MAIN/<?php echo $per['url']; ?>"><?php echo $per['module_name']; ?></a>
					</dt>
				</dl>
				<?php endif; endforeach; endif; else: echo "" ;endif; ?>
			</nav>
		</div>
	</header>
	<!-- 	左边菜单的加载 -->
	<div class="MAIN">
		
		<div class="LEFT">
			<div id="accordion2" class="accordion leftmenu">
				<div class="accordion-group">
					<div class="sidebarX">
						<?php if($frist_menu['module_picture'] != ''): ?>
						<img src="__UPLOAD__/<?php echo $frist_menu['module_picture']; ?>">
						<?php else: ?>
						<img src="__STATIC__/images/admin_left_logo.png">
						<?php endif; ?>
						<h2><?php echo $frist_menu['module_name']; ?></h2>
					</div>
					<div class="accordion-body collapse in" id="collapseOne">
						<ul class="nav nav-pills nav-stacked" id="left_menu-small">
							<?php if(is_array($leftlist) || $leftlist instanceof \think\Collection || $leftlist instanceof \think\Paginator): if( count($leftlist)==0 ) : echo "" ;else: foreach($leftlist as $key=>$leftItem): if(strtoupper($leftItem['module_id']) == $second_menu_id): ?>
							<li class="active"><h1></h1><a href="ADMIN_MAIN/<?php echo $leftItem['url']; ?>"><?php echo $leftItem['module_name']; ?></a></li>
							<?php else: ?>
							<li><a href="ADMIN_MAIN/<?php echo $leftItem['url']; ?>"><?php echo $leftItem['module_name']; ?></a></li>
							<?php endif; endforeach; endif; else: echo "" ;endif; ?>
						</ul>
					</div>
				</div>
			</div>
		</div>
		
		<!-- 	右边主要内容的加载 -->
		<div class="RIGHT">
			<div class="ncsc-path">
				<i class="icon-desktop"></i><?php echo $title_name; if($frist_menu['module_name'] != ''): ?>
				<i class="icon-angle-right"></i>
				<a href="ADMIN_MAIN/<?php echo $frist_menu['url']; ?>"><?php echo $frist_menu['module_name']; ?></a>
				<?php endif; if($secend_menu['module_name'] != ''): ?>
				<i class="icon-angle-right"></i>
				<a href="ADMIN_MAIN/<?php echo $secend_menu['url']; ?>"><?php echo $secend_menu['module_name']; ?></a>
				<?php endif; ?>
			</div>
			<!--顶部边框开始  -->
			<div class="tabmenu">
				<ul class="tab pngFix">
					<?php if(is_array($child_menu_list) || $child_menu_list instanceof \think\Collection || $child_menu_list instanceof \think\Paginator): if( count($child_menu_list)==0 ) : echo "" ;else: foreach($child_menu_list as $k=>$child_menu): if($child_menu['active'] == '1'): ?>
					<li class="active"><a href="ADMIN_MAIN/<?php echo $child_menu['url']; ?>"><?php echo $child_menu['menu_name']; ?></a></li>
					<?php else: ?>
					<li class="daohang_no"><a href="ADMIN_MAIN/<?php echo $child_menu['url']; ?>"><?php echo $child_menu['menu_name']; ?></a></li>
					<?php endif; endforeach; endif; else: echo "" ;endif; ?>
				</ul>
				<div class="right_side_operation">
					<ul>
						
<?php if($type == '2'): ?>
	<li><a class="nscs-table-handle_green" href="ADMIN_MAIN/Wchat/addOrUpdateKeyReplay.html"><i class="fa fa-plus-circle"></i>&nbsp;添加关键词回复</a></li>
<?php endif; ?>

					</ul>
				</div>
			</div>
			<hr class="tabmenu_hr" style="border:1px solid #00C0FF;margin:0 0px 10px 20px;"  />
			<div class="main">
			
<!-- 关注时回复 -->
<?php if($type == '1'): ?>
<div id="type1">
	<p class="step_0" <?php if(empty($info) || (($info instanceof \think\Collection || $info instanceof \think\Paginator ) && $info->isEmpty())): ?>style="display:block;"<?php else: ?>style="display:none;"<?php endif; ?>>您还未设置回复内容，
		<a href="javascript:;" onclick="showMaterial()">我要马上设置。</a>
	</p>
	
	<div class="step_1" <?php if(empty($info) || (($info instanceof \think\Collection || $info instanceof \think\Paginator ) && $info->isEmpty())): ?>style="display:none;"<?php else: ?>style="display:block;"<?php endif; ?>>
	<!-- 样式模板 -->
		<?php if(!(empty($info) || (($info instanceof \think\Collection || $info instanceof \think\Paginator ) && $info->isEmpty()))): if($info['media_info']['type'] == '1'): ?>
				<div class="reply-div">
					<div class="reply-text">
						<p><?php echo $info['media_info']['title']; ?></p>
					</div>
				</div>
			<?php endif; if($info['media_info']['type'] == '2'): ?>
				<div class="reply-div">
					<div class="reply-one">
						<h5><?php echo $info['media_info']['title']; ?></h5>
						<p>xx月xx日</p>
						<div class="cover-div"><img class="cover-pic" src="__UPLOAD__/<?php echo $info['media_info']['item_list'][0]['cover']; ?>"></div>
						<p><?php echo $info['media_info']['item_list'][0]['summary']; ?></p>
					</div>
				</div>
			<?php endif; if($info['media_info']['type'] == '3'): ?>
				<div class="reply-div">
					<ul class="reply-more">
					<?php if(is_array($info['media_info']['item_list']) || $info['media_info']['item_list'] instanceof \think\Collection || $info['media_info']['item_list'] instanceof \think\Paginator): if( count($info['media_info']['item_list'])==0 ) : echo "" ;else: foreach($info['media_info']['item_list'] as $k=>$v): if($k == '0'): ?>
							<li>
								<div class="cover-div">
									<img class="cover-pic" src="__UPLOAD__/<?php echo $v['cover']; ?>">
									<p class="cover-title"><?php echo $v['title']; ?><p>
								</div>
							</li>
						<?php endif; if($k > '0'): ?>
							<li>
								<div class="media-div-l"><p class="media-title"><?php echo $v['title']; ?></p></div>
								<div class="media-div-r"><img class="media-img" src="__UPLOAD__/<?php echo $v['cover']; ?>"></div>
							</li>
						<?php endif; endforeach; endif; else: echo "" ;endif; ?>
					</ul>
				</div>
			<?php endif; endif; ?>
		<div class="media-button">
			<a class="" href="javascript:;" onclick="showMaterial()">修改</a>
			<a class="" href="javascript:;" onclick="delReply()">删除</a>
		</div>
	</div>
</div>
<input type="hidden" id="id" value="<?php echo $info['id']; ?>">
<link rel="stylesheet" href="ADMIN_CSS/wxMenu/wx_base.css">
<link rel="stylesheet" href="ADMIN_CSS/wxMenu/wx_tooltip.css">
<link rel="stylesheet" href="ADMIN_CSS/wxMenu/wx_lib.css" />
<style>
.table tr td{text-align:center;vertical-align:middle;}
.table tr td:first-child{width:50%;}
.table tr td:last-child{width:20%;}
ul.mater{border:1px solid #e7e7eb;border-radius:5px;}
ul.mater li{padding:5px;border-bottom:1px solid #e7e7eb;}
ul.mater li:first-child{padding:13px 5px;}
ul.mater li:last-child{border-bottom:0px solid #e7e7eb;}
ul.mater li .btn_primary{display:inline-block;padding:3px;border-radius:3px;margin-right:10px;}
.dialog_ft .page{background:#f4f5f9;margin-top:10px;}
</style>
<div class="dialog_wrp media align_edge ui-draggable" style="display:none;width: 960px; margin-left: -480px; margin-top: -313.5px;" id="dialog_media">
	<div class="dialog">
		<div class="dialog_hd">
			<h3>选择素材</h3>
			<!--#0001#-->
			<a href="javascript:;" onclick="closeMaterial()"
				class="icon16_opr closed pop_closed">关闭</a>
			<!--%0001%-->
		</div>
		<div class="dialog_bd">
			<div class="dialog_media_container appmsg_media_dialog">
				<div class="sub_title_bar in_dialog">
					<div class="search_bar js-btn-media">
						<a class="btn btn_default" value="1" href="javascript:;" onclick="checkBtn(this)"> 文本 </a>
						<a class="btn btn_primary btn_default" value="2" href="javascript:;" onclick="checkBtn(this)"> 单图文 </a>
						<a class="btn btn_default" href="javascript:;" value="3" onclick="checkBtn(this)"> 多图文 </a>
					</div>
					<div class="appmsg_create tr">

						<!--
            <a class="" target="_blank" href="/cgi-bin/appmsg?t=media/appmsg_edit&action=edit&type=10&lang=zh_CN&token=254836048">
                <i class="icon_appmsg_small"></i><strong>新建单图文消息</strong>
            </a>
            -->
						<a class="btn btn_primary btn_add" target="_blank"
							href="ADMIN_MAIN/Wchat/addMedia.html">
							<i class="icon14_common add_white"></i>新建图文消息
						</a>

					</div>
				</div>
				<div class="dialog_media_inner" style="overflow:auto;">
					<div class="table_wrp user_list">
						<table class="table" cellspacing="0">
							<tbody class="tbody" id="materia_data">
								
							</tbody>
							
						</table>
					</div>

					
				</div>
			</div>
		</div>

		<div class="dialog_ft">
			<script src="__STATIC__/js/page.js"></script>
<div class="page" id="turn-ul" style="display: none">
	<div class="pagination pagination-right">
		<ul>
			<li><a id="beginPage" class="page-disable">首页</a></li>
			<li><a id="prevPage" class="page-disable">上一页</a></li>
			<li id="pageNumber"></li>
			<li><a id="nextPage">下一页</a></li>
			<li><a id="lastPage">末页</a></li>
		</ul>
	</div>
</div>
<input type="hidden" id="page_count" />
<script>
	$(function() {
		$("#turn-ul").show();//显示分页z
		LoadingInfo(1);//通过此方法调用分页类
	});
	function JumpForPage(obj) {
		jumpNumber = $(obj).text();
		LoadingInfo($(obj).text());
		$(".currentPage").removeClass("currentPage");
		$(obj).addClass("currentPage");
		if (jumpNumber == 1) {
			changeClass("prev");
		} else if (jumpNumber < parseInt($("#page_count").val())) {
			changeClass();
		} else if (jumpNumber == parseInt($("#page_count").val())) {
			changeClass("next");
		}
	}
	$("#beginPage").click(function() {
		if(jumpNumber!=1){
			jumpNumber = 1;
			LoadingInfo(1);
			changeClass("begin");
		}
	});
	//上一页
	$("#prevPage").click(function() {
		var obj = $(".currentPage");
		var index = parseInt(obj.text()) - 1;
		if (index > 0) {
			obj.removeClass("currentPage");
			obj.prev().addClass("currentPage");
			jumpNumber = index;
			LoadingInfo(index);
			//判断是否是第一页
			if (index == 1) {
				changeClass("prev");
			} else {
				changeClass();
			}
		}
	});
	//下一页
	$("#nextPage").click(function() {
		var obj = $(".currentPage");
		//当前页加一（下一页）
		var index = parseInt(obj.text()) + 1;
		if (index <= $("#page_count").val()) {
			jumpNumber = index;
			LoadingInfo(index);
			obj.removeClass("currentPage");
			obj.next().addClass("currentPage");
			//判断是否是最后一页
			if (index == $("#page_count").val()) {
				changeClass("next");
			} else {
				changeClass();
			}
		}
	});
	//末页
	$("#lastPage").click(
			function() {
				jumpNumber = $("#page_count").val();
				if(jumpNumber>1){
					LoadingInfo(jumpNumber);
					$("#pageNumber a:eq("+ (parseInt($("#page_count").val()) - 1) + ")").text($("#page_count").val());
					changeClass("next");
				}
			});
</script>
		</div>

	</div>
</div>

<div class="mask mask_metar" style="display: none;"></div>
<script>
$(function(){
	//showMaterial();
});
function checkBtn(event){
	$(".js-btn-media").find('.btn').removeClass('btn_primary');
	$(event).addClass('btn_primary');
	LoadingInfo(1);
}
/**
 * 显示素材
 */
function showMaterial(){
	$("#dialog_media").fadeIn(500);
	$(".mask_metar").fadeIn(300);
}
// function LoadingInfo(pageIndex){
// 	var type = 2;
// 	onloadMaterial(pageIndex, type);
// }
/**
 * 加载 素材 数据
 */
function LoadingInfo(pageIndex){
// 	$(".js-btn-media").find('.btn').eq(type-1).addClass('btn_primary');
	var type = $(".js-btn-media .btn_primary").attr('value');
// 	var aa = $(".js-btn-media").find('.btn').eq(type).html();
	var search_text = '';
	$.ajax({
		type : "post",
		url : "ADMIN_MAIN/Wchat/onloadMaterial",
		async : true,
		data : {
			"pageIndex" : pageIndex, "search_text" : search_text, "type" : type
		},
		success : function(data) {
			$("#page_count").val(data["page_count"]);
			$("#pageNumber a").remove();
			var html = '';
			if(data['data'].length > 0){
				for(var i=0; i<data['data'].length; i++){
					if(data['data'][i]['type'] == 1){
						var type_name = '文本 ';
					}else if(data['data'][i]['type'] == 2){
						var type_name = '单图文 ';
					}else if(data['data'][i]['type'] == 3){
						var type_name = '多图文 ';
					}
					html += '<tr><td class="table_cell"><ul class="mater">';
					for(var l=0; l<data['data'][i]['item_list'].length; l++){
						var k = l+1;
						html += '<li><span class="btn_primary">'+ type_name + k+' </span><a href="#">'+data['data'][i]['item_list'][l]['title']+'</a></li>';
					}
					html += '</ul></td>';
					html += '<td>'+data['data'][i]['create_time']+'</td>';
					html += '<td class="table_cell user_opr tr"><a class="btn remark js_msgSenderRemark" onclick="selectedMaterial('+data['data'][i]['media_id']+')">选取</a></td>';
					html += '</tr>';
				}
			}else{
				html += '<tr>';
				html += '<td colspan="3" class="table_cell" style="text-align:center;">暂无素材</td>';
				html += '</tr>';
			}
			
			$("#materia_data tr").remove();
			$("#materia_data").append(html);
			var totalpage = $("#page_count").val();
			if (totalpage == 1) {
				changeClass("all");
			}
			var $html = pagenumShow(jumpNumber,totalpage,<?php echo $pageshow; ?>)
			$("#pageNumber").append($html);
		}
	});
}
/**
 * 选择 图文素材
 */
function selectedMaterial(media_id){
	getMaterial(media_id);
	closeMaterial();
}
/**
 *  取消  关闭
 */
function closeMaterial(){
	$("#dialog_media").fadeOut(300);
	$(".mask_metar").fadeOut();
}
</script>
<?php endif; if($type == '3'): ?>
<div id="type3">
	<p class="step_0" <?php if(empty($info) || (($info instanceof \think\Collection || $info instanceof \think\Paginator ) && $info->isEmpty())): ?>style="display:block;"<?php else: ?>style="display:none;"<?php endif; ?>>您还未设置回复内容，
		<a href="javascript:;" onclick="showMaterial()">我要马上设置。</a>
	</p>
	
	<div class="step_1" <?php if(empty($info) || (($info instanceof \think\Collection || $info instanceof \think\Paginator ) && $info->isEmpty())): ?>style="display:none;"<?php else: ?>style="display:block;"<?php endif; ?>>
	<!-- 样式模板 -->
		<?php if(!(empty($info) || (($info instanceof \think\Collection || $info instanceof \think\Paginator ) && $info->isEmpty()))): if($info['media_info']['type'] == '1'): ?>
				<div class="reply-div">
					<div class="reply-text">
						<p><?php echo $info['media_info']['title']; ?></p>
					</div>
				</div>
			<?php endif; if($info['media_info']['type'] == '2'): ?>
				<div class="reply-div">
					<div class="reply-one">
						<h5><?php echo $info['media_info']['title']; ?></h5>
						<p>xx月xx日</p>
						<div class="cover-div"><img class="cover-pic" src="__UPLOAD__/<?php echo $info['media_info']['item_list'][0]['cover']; ?>"></div>
						<p><?php echo $info['media_info']['item_list'][0]['summary']; ?></p>
					</div>
				</div>
			<?php endif; if($info['media_info']['type'] == '3'): ?>
				<div class="reply-div">
					<ul class="reply-more">
					<?php if(is_array($info['media_info']['item_list']) || $info['media_info']['item_list'] instanceof \think\Collection || $info['media_info']['item_list'] instanceof \think\Paginator): if( count($info['media_info']['item_list'])==0 ) : echo "" ;else: foreach($info['media_info']['item_list'] as $k=>$v): if($k == '0'): ?>
							<li>
								<div class="cover-div">
									<img class="cover-pic" src="__UPLOAD__/<?php echo $v['cover']; ?>">
									<p class="cover-title"><?php echo $v['title']; ?><p>
								</div>
							</li>
						<?php endif; if($k > '0'): ?>
							<li>
								<div class="media-div-l"><p class="media-title"><?php echo $v['title']; ?></p></div>
								<div class="media-div-r"><img class="media-img" src="__UPLOAD__/<?php echo $v['cover']; ?>"></div>
							</li>
						<?php endif; endforeach; endif; else: echo "" ;endif; ?>
					</ul>
				</div>
			<?php endif; endif; ?>
		<div class="media-button">
			<a class="" href="javascript:;" onclick="showMaterial()">修改</a>
			<a class="" href="javascript:;" onclick="delReply()">删除</a>
		</div>
	</div>
</div>
<input type="hidden" id="id" value="<?php echo $info['id']; ?>">
<link rel="stylesheet" href="ADMIN_CSS/wxMenu/wx_base.css">
<link rel="stylesheet" href="ADMIN_CSS/wxMenu/wx_tooltip.css">
<link rel="stylesheet" href="ADMIN_CSS/wxMenu/wx_lib.css" />
<style>
.table tr td{text-align:center;vertical-align:middle;}
.table tr td:first-child{width:50%;}
.table tr td:last-child{width:20%;}
ul.mater{border:1px solid #e7e7eb;border-radius:5px;}
ul.mater li{padding:5px;border-bottom:1px solid #e7e7eb;}
ul.mater li:first-child{padding:13px 5px;}
ul.mater li:last-child{border-bottom:0px solid #e7e7eb;}
ul.mater li .btn_primary{display:inline-block;padding:3px;border-radius:3px;margin-right:10px;}
.dialog_ft .page{background:#f4f5f9;margin-top:10px;}
</style>
<div class="dialog_wrp media align_edge ui-draggable" style="display:none;width: 960px; margin-left: -480px; margin-top: -313.5px;" id="dialog_media">
	<div class="dialog">
		<div class="dialog_hd">
			<h3>选择素材</h3>
			<!--#0001#-->
			<a href="javascript:;" onclick="closeMaterial()"
				class="icon16_opr closed pop_closed">关闭</a>
			<!--%0001%-->
		</div>
		<div class="dialog_bd">
			<div class="dialog_media_container appmsg_media_dialog">
				<div class="sub_title_bar in_dialog">
					<div class="search_bar js-btn-media">
						<a class="btn btn_default" value="1" href="javascript:;" onclick="checkBtn(this)"> 文本 </a>
						<a class="btn btn_primary btn_default" value="2" href="javascript:;" onclick="checkBtn(this)"> 单图文 </a>
						<a class="btn btn_default" href="javascript:;" value="3" onclick="checkBtn(this)"> 多图文 </a>
					</div>
					<div class="appmsg_create tr">

						<!--
            <a class="" target="_blank" href="/cgi-bin/appmsg?t=media/appmsg_edit&action=edit&type=10&lang=zh_CN&token=254836048">
                <i class="icon_appmsg_small"></i><strong>新建单图文消息</strong>
            </a>
            -->
						<a class="btn btn_primary btn_add" target="_blank"
							href="ADMIN_MAIN/Wchat/addMedia.html">
							<i class="icon14_common add_white"></i>新建图文消息
						</a>

					</div>
				</div>
				<div class="dialog_media_inner" style="overflow:auto;">
					<div class="table_wrp user_list">
						<table class="table" cellspacing="0">
							<tbody class="tbody" id="materia_data">
								
							</tbody>
							
						</table>
					</div>

					
				</div>
			</div>
		</div>

		<div class="dialog_ft">
			<script src="__STATIC__/js/page.js"></script>
<div class="page" id="turn-ul" style="display: none">
	<div class="pagination pagination-right">
		<ul>
			<li><a id="beginPage" class="page-disable">首页</a></li>
			<li><a id="prevPage" class="page-disable">上一页</a></li>
			<li id="pageNumber"></li>
			<li><a id="nextPage">下一页</a></li>
			<li><a id="lastPage">末页</a></li>
		</ul>
	</div>
</div>
<input type="hidden" id="page_count" />
<script>
	$(function() {
		$("#turn-ul").show();//显示分页z
		LoadingInfo(1);//通过此方法调用分页类
	});
	function JumpForPage(obj) {
		jumpNumber = $(obj).text();
		LoadingInfo($(obj).text());
		$(".currentPage").removeClass("currentPage");
		$(obj).addClass("currentPage");
		if (jumpNumber == 1) {
			changeClass("prev");
		} else if (jumpNumber < parseInt($("#page_count").val())) {
			changeClass();
		} else if (jumpNumber == parseInt($("#page_count").val())) {
			changeClass("next");
		}
	}
	$("#beginPage").click(function() {
		if(jumpNumber!=1){
			jumpNumber = 1;
			LoadingInfo(1);
			changeClass("begin");
		}
	});
	//上一页
	$("#prevPage").click(function() {
		var obj = $(".currentPage");
		var index = parseInt(obj.text()) - 1;
		if (index > 0) {
			obj.removeClass("currentPage");
			obj.prev().addClass("currentPage");
			jumpNumber = index;
			LoadingInfo(index);
			//判断是否是第一页
			if (index == 1) {
				changeClass("prev");
			} else {
				changeClass();
			}
		}
	});
	//下一页
	$("#nextPage").click(function() {
		var obj = $(".currentPage");
		//当前页加一（下一页）
		var index = parseInt(obj.text()) + 1;
		if (index <= $("#page_count").val()) {
			jumpNumber = index;
			LoadingInfo(index);
			obj.removeClass("currentPage");
			obj.next().addClass("currentPage");
			//判断是否是最后一页
			if (index == $("#page_count").val()) {
				changeClass("next");
			} else {
				changeClass();
			}
		}
	});
	//末页
	$("#lastPage").click(
			function() {
				jumpNumber = $("#page_count").val();
				if(jumpNumber>1){
					LoadingInfo(jumpNumber);
					$("#pageNumber a:eq("+ (parseInt($("#page_count").val()) - 1) + ")").text($("#page_count").val());
					changeClass("next");
				}
			});
</script>
		</div>

	</div>
</div>

<div class="mask mask_metar" style="display: none;"></div>
<script>
$(function(){
	//showMaterial();
});
function checkBtn(event){
	$(".js-btn-media").find('.btn').removeClass('btn_primary');
	$(event).addClass('btn_primary');
	LoadingInfo(1);
}
/**
 * 显示素材
 */
function showMaterial(){
	$("#dialog_media").fadeIn(500);
	$(".mask_metar").fadeIn(300);
}
// function LoadingInfo(pageIndex){
// 	var type = 2;
// 	onloadMaterial(pageIndex, type);
// }
/**
 * 加载 素材 数据
 */
function LoadingInfo(pageIndex){
// 	$(".js-btn-media").find('.btn').eq(type-1).addClass('btn_primary');
	var type = $(".js-btn-media .btn_primary").attr('value');
// 	var aa = $(".js-btn-media").find('.btn').eq(type).html();
	var search_text = '';
	$.ajax({
		type : "post",
		url : "ADMIN_MAIN/Wchat/onloadMaterial",
		async : true,
		data : {
			"pageIndex" : pageIndex, "search_text" : search_text, "type" : type
		},
		success : function(data) {
			$("#page_count").val(data["page_count"]);
			$("#pageNumber a").remove();
			var html = '';
			if(data['data'].length > 0){
				for(var i=0; i<data['data'].length; i++){
					if(data['data'][i]['type'] == 1){
						var type_name = '文本 ';
					}else if(data['data'][i]['type'] == 2){
						var type_name = '单图文 ';
					}else if(data['data'][i]['type'] == 3){
						var type_name = '多图文 ';
					}
					html += '<tr><td class="table_cell"><ul class="mater">';
					for(var l=0; l<data['data'][i]['item_list'].length; l++){
						var k = l+1;
						html += '<li><span class="btn_primary">'+ type_name + k+' </span><a href="#">'+data['data'][i]['item_list'][l]['title']+'</a></li>';
					}
					html += '</ul></td>';
					html += '<td>'+data['data'][i]['create_time']+'</td>';
					html += '<td class="table_cell user_opr tr"><a class="btn remark js_msgSenderRemark" onclick="selectedMaterial('+data['data'][i]['media_id']+')">选取</a></td>';
					html += '</tr>';
				}
			}else{
				html += '<tr>';
				html += '<td colspan="3" class="table_cell" style="text-align:center;">暂无素材</td>';
				html += '</tr>';
			}
			
			$("#materia_data tr").remove();
			$("#materia_data").append(html);
			var totalpage = $("#page_count").val();
			if (totalpage == 1) {
				changeClass("all");
			}
			var $html = pagenumShow(jumpNumber,totalpage,<?php echo $pageshow; ?>)
			$("#pageNumber").append($html);
		}
	});
}
/**
 * 选择 图文素材
 */
function selectedMaterial(media_id){
	getMaterial(media_id);
	closeMaterial();
}
/**
 *  取消  关闭
 */
function closeMaterial(){
	$("#dialog_media").fadeOut(300);
	$(".mask_metar").fadeOut();
}
</script>
<?php endif; ?>
<!-- 关键字回复 -->
<?php if($type == '2'): ?>
<div class="mod-table">
	<div class="mod-table-head">
		<div class="style0list">
			<table>
				<colgroup>
					<col style="width: 40%;">
					<col style="width: 20%;">
					<col style="width: 30%;">
				</colgroup>
				<thead>
					<tr>
						<th>关键字</th>
						<th>匹配类型</th>
						<th>操作</th>
					</tr>
				</thead>
				<colgroup>
					<col style="width: 40%;">
					<col style="width: 20%;">
					<col style="width: 30%;">
				</colgroup>
				<tbody></tbody>
			</table>
		</div>
	</div>
</div>
<script src="__STATIC__/js/page.js"></script>
<div class="page" id="turn-ul" style="display: none">
	<div class="pagination pagination-right">
		<ul>
			<li><a id="beginPage" class="page-disable">首页</a></li>
			<li><a id="prevPage" class="page-disable">上一页</a></li>
			<li id="pageNumber"></li>
			<li><a id="nextPage">下一页</a></li>
			<li><a id="lastPage">末页</a></li>
		</ul>
	</div>
</div>
<input type="hidden" id="page_count" />
<script>
	$(function() {
		$("#turn-ul").show();//显示分页z
		LoadingInfo(1);//通过此方法调用分页类
	});
	function JumpForPage(obj) {
		jumpNumber = $(obj).text();
		LoadingInfo($(obj).text());
		$(".currentPage").removeClass("currentPage");
		$(obj).addClass("currentPage");
		if (jumpNumber == 1) {
			changeClass("prev");
		} else if (jumpNumber < parseInt($("#page_count").val())) {
			changeClass();
		} else if (jumpNumber == parseInt($("#page_count").val())) {
			changeClass("next");
		}
	}
	$("#beginPage").click(function() {
		if(jumpNumber!=1){
			jumpNumber = 1;
			LoadingInfo(1);
			changeClass("begin");
		}
	});
	//上一页
	$("#prevPage").click(function() {
		var obj = $(".currentPage");
		var index = parseInt(obj.text()) - 1;
		if (index > 0) {
			obj.removeClass("currentPage");
			obj.prev().addClass("currentPage");
			jumpNumber = index;
			LoadingInfo(index);
			//判断是否是第一页
			if (index == 1) {
				changeClass("prev");
			} else {
				changeClass();
			}
		}
	});
	//下一页
	$("#nextPage").click(function() {
		var obj = $(".currentPage");
		//当前页加一（下一页）
		var index = parseInt(obj.text()) + 1;
		if (index <= $("#page_count").val()) {
			jumpNumber = index;
			LoadingInfo(index);
			obj.removeClass("currentPage");
			obj.next().addClass("currentPage");
			//判断是否是最后一页
			if (index == $("#page_count").val()) {
				changeClass("next");
			} else {
				changeClass();
			}
		}
	});
	//末页
	$("#lastPage").click(
			function() {
				jumpNumber = $("#page_count").val();
				if(jumpNumber>1){
					LoadingInfo(jumpNumber);
					$("#pageNumber a:eq("+ (parseInt($("#page_count").val()) - 1) + ")").text($("#page_count").val());
					changeClass("next");
				}
			});
</script>
<script>
$(function(){
	var type = $("#type").val();
	if(type == 2){
		LoadingInfo(1);
	}
});
function LoadingInfo(pageIndex) {
	$.ajax({
		type : "post",
		url : "ADMIN_MAIN/Wchat/keyReplayList",
		async : true,
		data : {
			"pageIndex" : pageIndex
		},
		success : function(data) {
			$("#page_count").val(data["page_count"]);
			$("#pageNumber a").remove();
			var html = '';
			if (data["data"].length > 0) {
				for (var i = 0; i < data["data"].length; i++) {
					html += '<tr align="center">';
					html += '<td>' + data["data"][i]["key"] + '</td>';
					if(data["data"][i]["match_type"] == 1){
						html += '<td>模糊匹配</td>';
					}else{
						html += '<td>全部匹配</td>';
					}
						html += '<td><a href="ADMIN_MAIN/Wchat/addOrUpdateKeyReplay.html?id=' + data["data"][i]["id"] + '">修改</a>&nbsp;&nbsp; ';
						html += '<a href="javascript:void(0);" onclick="delKeyReply(' + data["data"][i]["id"] + ')">删除</a></td>';
					html += '</tr>';
				}
			} else {
				html += '<tr align="center"><th colspan="3">暂无符合条件的数据记录</th></tr>';
			}
			$(".style0list tbody").html(html);
			var totalpage = $("#page_count").val();
			if (totalpage == 1) {
				changeClass("all");
			}
			var $html = pagenumShow(jumpNumber,totalpage,<?php echo $pageshow; ?>)
			$("#pageNumber").append($html);
		}
	});
}
</script>
<?php endif; ?>
<input type="hidden" id="type" value="<?php echo $type; ?>">

<script>
function delKeyReply(id){
	$( "#dialog" ).dialog({				
        buttons: {
            "确定,#e57373": function() {
                $(this).dialog('close');
                $.ajax({
            		url : ADMINMAIN + "/Wchat/delKeyReply",
            		type : "post",
            		async : true,
            		data : { "id" : id },
            		success : function(data){
            			if(data['code'] > 0){
            				showMessage('success', data['message'], ADMINMAIN + "/Wchat/replayConfig?type=2");
            			}else{
            				showMessage('error', data['message']);
            			}
            		}
            	});
            },
            "取消": function() {
                $(this).dialog('close');
            }
        },
        contentText:"确定删除？",
    });
	
}
function getMaterial(media_id){
	$.ajax({
		url : ADMINMAIN + "/Wchat/getWeixinMediaDetail",
		type : "post",
		async : true,
		data : { "media_id" : media_id },
		success : function(data){
			var html = '';
			if(data){
				html += '<div class="reply-div">';
				if(data['type'] == 1){
					html += '<div class="reply-text">';
					html += '<p>'+data['title']+'</p>';
					html += '</div>';
				}else if(data['type'] == 2){
					html += '<div class="reply-one">';
					html += '<h5>'+data['item_list'][0]['title']+'</h5>';
					html += '<p>xx月xx日</p>';
					html += '<div class="cover-div"><img class="cover-pic" src="'+UPLOAD+'/'+data['item_list'][0]['cover']+'"></div>';
					html += '<p>'+data['item_list'][0]['summary']+'</p>';
					html += '</div>';
				}else if(data['type'] == 3){
					html += '<ul class="reply-more">';
					for(var i=0; i < data['item_list'].length; i++){
						if(i < 1){
							html += '<li><div class="cover-div">';
							html += '<img class="cover-pic" src="'+UPLOAD+'/'+data['item_list'][i]['cover']+'">';
							html += '<p class="cover-title">'+data['item_list'][i]['title']+'<p>';
							html += '</div></li>';
						}else{
							html += '<li>';
							html += '<div class="media-div-l"><p class="media-title">'+data['item_list'][i]['title']+'</p></div>';
							html += '<div class="media-div-r"><img class="media-img" src="'+UPLOAD+'/'+data['item_list'][i]['cover']+'"></div>';
							html += '</li>';
						}
					}
					html += '</ul>';
				}
				html += '</div>';
			}
			var type = $("#type").val();
			$("#type"+type+" .step_0").hide();
			$("#type"+type+" .step_1").show();
			$("#type"+type+" .step_1 .reply-div").remove();
			$("#type"+type+" .step_1 .media-button").before(html);
			if(type == 1){
				addOrUpdateFollowReply(media_id);
			}else if(type == 3){
				addOrUpdateDefaultReply(media_id);
			}
		}
	})
}
/**
 * 添加 或 修改 关注时回复
 */
function addOrUpdateFollowReply(media_id){
	var id = $("#id").val();
	var type = $("#type").val();
	$.ajax({
		url : ADMINMAIN + "/Wchat/addOrUpdateFollowReply",
		type : "post",
		async : true,
		data : { "media_id" : media_id, "id" : id },
		success : function(data){
			if(data['code'] > 0){
				showMessage('success', data['message']);
			}else{
				showMessage('error', data['message']);
			}
		}
	})
}
/**
 * 添加 或 修改 默认回复
 */
function addOrUpdateDefaultReply(media_id){
	var id = $("#id").val();
	var type = $("#type").val();
	$.ajax({
		url : ADMINMAIN + "/Wchat/addOrUpdateDefaultReply",
		type : "post",
		async : true,
		data : { "media_id" : media_id, "id" : id },
		success : function(data){
			if(data['code'] > 0){
				showMessage('success', data['message']);
			}else{
				showMessage('error', data['message']);
			}
		}
	})
}
/**
 * 删除 回复
 */
function delReply(){
	var type = $("#type").val();
	$.ajax({
		url : ADMINMAIN + "/Wchat/delReply",
		type : "post",
		async : true,
		data : { "type" : type},
		success : function(data){
			if(data['code'] > 0){
				showMessage('success', data['message'], ADMINMAIN + "/Wchat/replayconfig?type="+type);
			}else{
				showMessage('error', data['message']);
			}
		}
	})
}
</script>
<link rel="stylesheet" type="text/css"
	href="ADMIN_CSS/jquery-ui-private.css">
<script>
var platform_shopname= 'NIUSHOP';
</script>
<script type="text/javascript" src="ADMIN_JS/jquery-ui-private.js" charset="utf-8"></script>
<script type="text/javascript" src="ADMIN_JS/jquery.timers.js"></script>
<div id="dialog"></div>
<script type="text/javascript">
		function showMessage(type, message,url,time)
		{
			if(url == undefined){
				url = '';
			}
			if(time == undefined){
				time = 2;
			}
			//成功之后的跳转
			if(type == 'success')
				{
				$( "#dialog" ).dialog({
		            buttons: {
		                "确定,#51A351": function() {
		                    $(this).dialog('close');
		                }
		            },
		            contentText:message,
		      		time:time,
		      		timeHref: url,
		        });
				}
			//失败之后的跳转
			if(type == 'error')
				{
				$( "#dialog" ).dialog({
		            buttons: {
		                "确定,#e57373": function() {
		                    $(this).dialog('close');
		                }
		            },
		            time:time,
		            contentText:message,
		            timeHref: url,
		        });
				}
			
		}
		function showConfirm(content)
		{
			$( "#dialog" ).dialog({
	            buttons: {
	                "确定,#e57373": function() {
	                    $(this).dialog('close');
	                    return 1;
	                },
	                "取消": function() {
	                    $(this).dialog('close');
	                    return 0;
	                }
	            },
	            contentText:content,
			});
			
		}
	</script>

			</div>
			<div class="page" id="turn-ul" style="display: none;">
				<div class="pagination pagination-right">
					<ul>
						<li><a id="beginPage" class="page-disable">首页</a></li>
						<li><a id="prevPage" class="page-disable">上一页</a></li>
						<li id="pageNumber"></li>
						<li><a id="nextPage">下一页</a></li>
						<li><a id="lastPage">末页</a></li>
					</ul>
				</div>
			</div>
			<input type="hidden" id="page_count" />
		</div>
	</div>
	<!--修改密码弹出框 -->
	<div id="edit-password" class="modal hide" tabindex="-1" role="dialog"
		aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel">修改密码</h3>
		</div>
		<div class="modal-body">
			<form class="form-horizontal">
				<div class="control-group">
					<label class="control-label" for="inputPassword"><span class="color-red">*</span>原密码</label>
					<div class="controls">
						<input type="password" id="pwd0" placeholder="请输入原密码">
						<span class="help-block"></span>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputPassword"><span class="color-red">*</span>新密码</label>
					<div class="controls">
						<input type="password" id="pwd1" placeholder="请输入新密码">
						<span class="help-block"></span>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputPassword"><span class="color-red">*</span>再次输入密码</label>
					<div class="controls">
						<input type="password" id="pwd2" placeholder="请输入确认密码">
						<span class="help-block"></span>
					</div>
				</div>
				<div style="text-align: center; height: 20px;" id="show"></div>
			</form>
		</div>
		<div class="modal-footer">
			<button class="btn btn-info" onclick="submitPassword()"  style="display:inline-block;">保存</button>
			<button class="btn" data-dismiss="modal" aria-hidden="true">关闭</button>
		</div>
	</div>
	<!--修改密码弹框结束  -->
	<div class="footer">
		<div id="faq" style="background: #eee; padding-top: 10px;">
			<div class="faq-wrapper"></div>
		</div>
		<div id="footer" class="wrapper">
			<p>
				<?php if(is_array($ShopNavigationData) || $ShopNavigationData instanceof \think\Collection || $ShopNavigationData instanceof \think\Paginator): if( count($ShopNavigationData)==0 ) : echo "" ;else: foreach($ShopNavigationData as $key=>$vo): if($key>0): ?> |<?php endif; ?> <a href="<?php echo $vo['nav_url']; ?>"><?php echo $vo['nav_title']; ?></a> 
				<?php endforeach; endif; else: echo "" ;endif; ?>
			</p>
			Copyright 2015-2025 <a href="" target="_blank"><?php echo $title_name; ?></a> All rights
			reserved.<br>
		</div>
	</div>
	<script>
	$(".checkbox").simpleSwitch({
		"theme": "FlatCircular"
	});
</script>
	<script>
		$(function() {
			//设置最小高度  2016年8月1日17:57:09
			var height = Number($(window).height()) - 173;
			$('.MAIN').css('minHeight', height);
			$('.index-sitemap > a').bind("click", function() {
				$(".sitemap-menu-arrow").slideDown("slow");
				$(".sitemap-menu").slideDown("slow");
			});
			$('.add-quickmenu > a').bind("click", function() {
				$(".sitemap-menu-arrow").slideDown("slow");
				$(".sitemap-menu").slideDown("slow");
			});
			$('#closeSitemap').bind("click", function() {
				$(".sitemap-menu-arrow").slideUp("fast");
				$(".sitemap-menu").slideUp("fast");
			});
		})
		// 系统注销菜单的控制
		var closetimer = 0;
		function exitSystemOver() {
			cancelColseMenu();
			$("#exit_System").css("display", "block");
		};

		function exitSystemOut() {
			closetimer = window.setTimeout(mclose, 600);
		};

		function cancelColseMenu() {
			window.clearTimeout(closetimer);
			closetimer = null;
		};

		function mclose() {
			$("#exit_System").css("display", "none");
		}
		$(document).ready(function() {
			//获取页面完整地址
			var url = window.location.host;
			if (url.indexOf('autoscript') != -1) {
				$("#hm_a").remove();
			}
		});
		//弹出修改密码的弹窗
		function editpassword() {
			$('#edit-password').modal('show');
		}
		//保存修改密码的按钮
		function submitPassword() {
			var pwd0 = $("#pwd0").val();
			var pwd1 = $("#pwd1").val();
			var pwd2 = $("#pwd2").val();
			if (pwd1 == '') {
				$("#pwd1").focus();
				$("#pwd1").siblings("span").html("密码不能为空");
				return;
			} else if ($("#pwd1").val().length < 6) {
				$("#pwd1").focus();
				$("#pwd1").siblings("span").html("密码不能少于6位数");
				return;
			}
			if (pwd2 == '') {
				$("#pwd2").focus();
				$("#pwd2").siblings("span").html("密码不能为空");
				return;
			} else if ($("#pwd2").val().length < 6) {
				$("#pwd2").focus();
				$("#pwd2").siblings("span").html("密码不能少于6位数");
				return;
			}
			if (pwd1 != pwd2) {
				$("#pwd2").focus();
				$("#pwd2").siblings("span").html("两次密码输入不一样，请重新输入");
				return;
			}
			$.ajax({
				url : "ADMIN_MAIN/Login/ModifyPassword",
				type : "post",
				data : {
					"old_pass" : $("#pwd0").val(),
					"new_pass" : $("#pwd1").val()
				},
				dataType : "json",
				success : function(data) {
					if (data['code'] > 0) {
						$("#show").html('<span style="color:green">密码修改成功</span>');
					} else {
						$("#show").html('<span style="color:red">'+data['message']+'</span>');
					}
				}
			});
		}

		function add_nav_class(doc) {
			$(doc).addClass("hover");
		}
		function remove_nav_class(doc) {
			$(doc).removeClass("hover");
		}
		function nav_open() {
			$(".sitemap-menu-arrow").show();
			$(".sitemap-menu").show();
		}
		function nav_close() {
			$(".sitemap-menu-arrow").hide();
			$(".sitemap-menu").hide();
		}
		//查询
		function search(){
			var search_info = $("#search_goods").val();
			window.location.href="ADMIN_MAIN/Goods/goodsList.html?search_info="+search_info;
		}
	</script>
	
</body>
</html>