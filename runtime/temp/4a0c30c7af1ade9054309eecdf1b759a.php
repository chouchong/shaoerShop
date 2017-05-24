<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:42:"template/admin\b2c\Auth\authGroupList.html";i:1495418659;s:28:"template/admin\b2c\base.html";i:1495424696;s:34:"template/admin\b2c\pageCommon.html";i:1492765125;s:34:"template/admin\b2c\openDialog.html";i:1495424452;}*/ ?>
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
		
<script src="ADMIN_JS/allselect.js" type="text/javascript"></script>
<script src="ADMIN_JS/rolejs.js" type="text/javascript"></script>
<script src="ADMIN_JS/art_dialog.source.js" type="text/javascript"></script>
<link href="ADMIN_CSS/default1.css" rel="stylesheet" type="text/css">
<link href="ADMIN_CSS/system.css" rel="stylesheet" type="text/css">
<style type="text/css">
.mod-table-main .style0line td input {
	margin: 3px 0 5px 5px;
}
.overflow table td{border-bottom:1px solid #ccc; }
table{width:100%;}
.tr-Current ul{clear:both;}
.tr-Current ul li{float:left;}
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
						
<li><a class="nscs-table-handle_green" href="javascript:;" id="addrole"><i class="fa fa-plus-circle"></i>&nbsp;添加用户组</a></li>

					</ul>
				</div>
			</div>
			<hr class="tabmenu_hr" style="border:1px solid #00C0FF;margin:0 0px 10px 20px;"  />
			<div class="main">
			
<div class="mod-table">
	<div class="mod-table-head">
		<div class="con style0list">
			<table>
				<colgroup>
					<col style="width: 5%;">
					<col style="width: 50%;">
					<col style="width: 15%;">
					<col style="width: 15%;">
					<col style="width: auto;">
				</colgroup>
				<thead>
					<tr align="center">
						<th>
							<label style="margin-left: 5px;">
								<input id="ckall" type="checkbox" onclick="CheckAll(event)">
							</label>
						</th>
						<th style="text-align: left;">用户组</th>
						<th>是否是管理员组</th>
						<th>操作</th>
					</tr>
				</thead>
				<colgroup>
					<col style="width: 5%;">
					<col style="width: 80%;">
					<col style="width: 15%;">
					<col style="width: auto;">
				</colgroup>
				<tbody id="grouplis" style="font-size: 12px;"></tbody>
			</table>
		</div>
	</div>
</div>
<input type="hidden" id="hidden_rolename" />
<input type="hidden" name="sendCheckDatas" id="sendCheckDatas">
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
<script type="text/javascript">
function open_UpdateRoleManage(module_id_array, roleId, name) {
	popupOperate("gray-edit-role", "角色设置", "gray-edit-role");
	$("#currentRoleID").val(roleId);
	$("#EditRoleName").val(name);
	if (roleId == 1) {
		$("[name = permiss]").attr("checked", true);
	} else {
		$("[name = permiss]").attr("checked", false);
		$('input[name = permiss]').each(function() {
				//alert($(this).attr('id'));
			if (module_id_array.indexOf($(this).attr('id')) >= 0) {
				//alert($(this).attr('id'));
				$(this).attr('checked', 'checked');
			}
		});
	}
}

//修改
function update_RoleManage() {
	var roleId = $("#currentRoleID").val();
	$roleName = $("#EditRoleName").val();
	$array = $("#EditsendCheckDatas").val();
	if ($array == '') {
		showMessage("error","修改失败");
		return;
	}
	$.ajax({
		url : "ADMIN_MAIN/Auth/addUserGroup",
		type : "post",
		data : {
			"roleId" : roleId,
			"array" : $array,
			"roleName" : $roleName
		},
		success : function(res) {
			if(res['code'] > 0){
				window.location.reload();
			}else{
				showMessage("error",res['message']);
			}
		}
	})
}

//删除
function deleteRole(group_id) {
	$( "#dialog" ).dialog({
		buttons: {
			"确定,#e57373": function() {
				$(this).dialog('close');
				$.ajax({
				url : "ADMIN_MAIN/Auth/deleteSystemUserGroup",
				data : { "group_id" : group_id },
				type : "post",
				dataType : "json",
				success : function(data) {
					//alert(group_id);
					if(data['code'] > 0){
						$("#dialog").dialog({
							buttons: {
								"确定,#e57373": function() {
									$(this).dialog('close');
								}
							},
							time:2,
							contentText:data['message']
						})
						window.location.reload();
					}else{
						$("#dialog").dialog({
							buttons: {
								"确定,#e57373": function() {
									$(this).dialog('close');
								}
							},
							contentText:data['message']
						})
					}
				}
			});
		},
		"取消": function() {
			$(this).dialog('close');
		}
	},
	contentText:"确定删除吗"
	});
}

//添加
function add_RoleManage() {
	$roleName = $("#RoleName").val();
	var array = $("#sendCheckDatas").val();
	if ($roleName == '') {
		showMessage("error","请填写信息");
		$("#btn").removeAttr("disabled");
		return;
	}
	var roleNamestr = $("#hidden_rolename").val();
	roleNamestr = roleNamestr.substr(1);
	var roleNameArray = new Array();
	roleNameArray = roleNamestr.split(",");
	for (var i = 0; i < roleNameArray.length; i++) {
		if (roleNameArray[i] == $roleName) {
			showMessage("error","已存在该角色");
			$("#btn").removeAttr("disabled");
			return;
		}
	}

	$.ajax({
		url : "ADMIN_MAIN/Auth/addUserGroup",
		type : "post",
		data : {
			"array" : array,
			"roleName" : $roleName
		},
		success : function(res) {
			if(res['code'] > 0){
				window.location.reload();
			}else{
				showMessage("error",res['message']);
				$("#btn").removeAttr("disabled");
			}
		}
	})
}

var pageindex = 1;
//查询 pageNum：显示那一页   where：条件
function LoadingInfo(pageindex) {
	$.ajax({
		url : "ADMIN_MAIN/Auth/authGroupList",
		type : "post",
		data : { "pageindex" : pageindex },
		dataType : "json",
		success : function(res) {
			$("#page_count").val(res["page_count"]);
			$("#pageNumber a").remove();
			$("#grouplis").children("tr").remove();
			for (var i = 0; i < res['data'].length; i++) {
				var array = res['data'][i];
				var name = array["group_name"];
				var roleId = array["group_id"];
				var is_system = array["is_system"];
				var module_id_array = array['module_id_array'];
				if(is_system == 0){
					var is_system_name = '否';
				}else{
					var is_system_name = '是';
				}
				$("#hidden_rolename").val($("#hidden_rolename").val() + "," + name);
				var strBeg = "<tr class='tr-Current' align='center'><td><div class='cell'><label ><input name='sub' type='checkbox' value="
					+ roleId
					+ " is_system="
					+ is_system
					+ " onclick='CheckThis()'></label>";
				strBeg = strBeg
					+ "</div></td><td align='left'><div class='cell'>"
					+ name
					+ "</div></td><td>"
					+ is_system_name
					+ "</td>";
				if(is_system == 0){
					strBeg = strBeg
					+ "<td><div class='cell'><div class='mod-operate'><div class='con style0editel'><a class='edit' href='javascript:void(0)' onclick='open_UpdateRoleManage(&#39;"
					+ module_id_array
					+ "&#39;,"
					+ roleId
					+ ",&#39;"
					+ name
					+ "&#39;)'>编辑</a>  <a class='del' href='javascript:void(0)' onclick='javascript:deleteRole("
					+ roleId + ")'>删除</a>";
				}else{
					strBeg = strBeg
					+ "<td>";
				}
				strBeg = strBeg + "</div></div></div></td></tr>";
				$('#grouplis').append(strBeg);
			}
			var totalpage = $("#page_count").val();
			if (totalpage == 1) {
				changeClass("all");
			}
			var $html = pagenumShow(jumpNumber,totalpage,<?php echo $pageshow; ?>)
			$("#pageNumber").append($html);
		}
	})
}
// enter 键模糊查询 bug 2013-11-16 14:10:06
document.onkeypress = function() {
	var iKeyCode = -1;
	if (arguments[0]) {
		iKeyCode = arguments[0].which;
	} else {
		iKeyCode = event.keyCode;
	}
	if (iKeyCode == 13) {
		if ($("#txtSearch").val() == null || $("#txtSearch").val() == "请输入角色..." || $("#txtSearch").val().trim() == '') {
			roleManageList(1);
		} else {
			roleManageList(1, $("#txtSearch").val());
		}
	}
}

// 查询
function txtSearch() {
	if ($("#txtSearch").val() == null || $("#txtSearch").val() == "请输入角色..." || $("#txtSearch").val().trim() == '') {
		roleManageList(1);
	} else {
		roleManageList(1, $("#txtSearch").val());
	}
}
</script>
<!-- 添加权限 -->
<div id="gray-add-role" style="display: none;">
	<div style="width: 850px; height: 350px;" class="content scroll">
		<div>
			<!--content begin-->
			<div class="mod-form">
				<div class="con style0alert b10">
					<ul class="list-ul">
						<li class="list-li"><span class="star">*</span> 角色名称 <input
							type="text" value="" name="RoleName" id="RoleName"
							style="margin-left: 10px;"> <span class="prompt"></span>
						</li>
						<li class="list-li">
							<div class="float-l w100" style="height: 20px; line-height: 20px;"><span class="star">*</span> 权限</div>
							<div class="overflow">
								<ul id="AllMenuConetnt">
									<li id="contentPaltForm"><input id="Add01" name="import"
										style="margin: -1px 0 0;" dir="title" type="checkbox"
										onclick="AllCheckBoxClick(event);"><span>平台</span> <!-- 列表 begin -->
										<div class="mod-table l30">
											<div class="mod-table-main">
												<div class="con style0line" style="padding-left: 9px;">
													<table class="table table-hover">
														<colgroup>
															<col style="width: 10%;">
															<col style="width: 90%;">
														</colgroup>
														<tbody id="platFormContent">
															<?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): if( count($list)==0 ) : echo "" ;else: foreach($list as $key=>$vo): ?>
														<tr class="tr-Current">
															<td><div>
																		<label> <input type="checkbox" name="add_per"
																			dir="parent" id="<?php echo $vo['module_id']; ?>"
																			value="<?php echo $vo['module_id']; ?>"
																			onclick="AllCheckBoxClick(event);" />&nbsp;<?php echo $vo['module_name']; ?>
																		</label>
																	</div></td>
															<td>
															<?php if(is_array($vo['child']) || $vo['child'] instanceof \think\Collection || $vo['child'] instanceof \think\Paginator): if( count($vo['child'])==0 ) : echo "" ;else: foreach($vo['child'] as $key=>$per): ?>
																<ul class="second">
																<li style="margin-right:10px;"><div class="cell">
																		<label class="w120"><input
																			type="checkbox" name="add_per" dir="son"
																			id="<?php echo $per['module_id']; ?>" value="<?php echo $per['module_id']; ?>"
																			onclick="AllCheckBoxClick(event);" />&nbsp;<span style="font-weight:normal;color:#000;"><?php echo $per['module_name']; ?></span></label>
																	</div></li>
																
																	<?php if(is_array($per['child']) || $per['child'] instanceof \think\Collection || $per['child'] instanceof \think\Paginator): if( count($per['child'])==0 ) : echo "" ;else: foreach($per['child'] as $key=>$three): ?> 
																<li><div class="cell">
																					<label class="w120"><input
																						type="checkbox" name="add_per" dir="sonson"
																						id="<?php echo $three['module_id']; ?>" value="<?php echo $three['module_id']; ?>"
																						onclick="AllCheckBoxClick(event);" />&nbsp;<span style="font-weight:normal;color:#666;"><?php echo $three['module_name']; ?></span></label>
																				</div></li>
																<?php endforeach; endif; else: echo "" ;endif; ?>
																</ul>
															<?php endforeach; endif; else: echo "" ;endif; ?>
															</td>
															
														</tr>
														<?php endforeach; endif; else: echo "" ;endif; ?>
														</tbody>
													</table>
												</div>
											</div>
										</div> <!-- 列表 end --></li>
								</ul>
							</div>
							<div class="float-l">
								<span class="prompt"></span>
							</div>
						</li>
					</ul>
				</div>
			</div>
			<!--content end-->
			<button class="submit01-alert r10" style="display: none"
				id="addSubmit" type="submit">保存</button>
		</div>
	</div>
	<div class="btn">
		<div class="indiv" style="text-align:right;">
			<button class="submit01-alert r10" onclick="btn()" type="button"
				id="btn">保存</button>
			<button class="reset01-alert" onclick="roleClose()">关闭</button>
		</div>
	</div>
</div>

<!-- 修改权限 -->
<div id="gray-edit-role" style="display: none;">
	<div style="width: 850px; height: 350px;" class="content scroll">
		<div>
			<!--content begin-->
			<div class="mod-form ">
				<div class="con style0alert b10">
					<ul class="list-ul">
						<li class="list-li"><span class="star">*</span> 角色名称 <input
							type="text" name="EditRoleName" id="EditRoleName" class="w230">
							<span class="prompt"></span></li>
						<li class="list-li">
							<div class="float-l w100">
								<span class="star">*</span>权限
							</div>
							<div class="overflow">
								<ul id="EditAllMenuConetnt">
									<li id="EditcontentPaltForm"><input id="Edit01"
										name="import" dir="top" type="checkbox"
										style="margin: -1px 0 0;"
										onclick="EditAllCheckBoxClick(event);"> <span
										for="Edit01"> 平台</span> <!-- 列表 begin -->
										<div class="mod-table l30">
											<div class="mod-table-main" style="padding-left: 9px;">
												<div class="con style0line">
													<table class="table table-hover">
														<colgroup>
															<col style="width: 10%;">
															<col style="width: 90%;">
														</colgroup>
														<tbody id="EditplatFormContent">
														<?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): if( count($list)==0 ) : echo "" ;else: foreach($list as $key=>$vo): ?>
														<tr class="tr-Current">
															<td><div>
																		<label> <input type="checkbox" name="permiss"
																			dir="parent" id="<?php echo $vo['module_id']; ?>"
																			value="<?php echo $vo['module_id']; ?>"
																			onclick="AllCheckBoxClick(event);" />&nbsp;<?php echo $vo['module_name']; ?>
																		</label>
																	</div></td>
															<td>
															<?php if(is_array($vo['child']) || $vo['child'] instanceof \think\Collection || $vo['child'] instanceof \think\Paginator): if( count($vo['child'])==0 ) : echo "" ;else: foreach($vo['child'] as $key=>$per): ?>
																<ul class="second">
																<li  style="margin-right:10px;"><div class="cell">
																		<label class="w120"><input
																			type="checkbox" name="permiss" dir="son"
																			id="<?php echo $per['module_id']; ?>" value="<?php echo $per['module_id']; ?>"
																			onclick="AllCheckBoxClick(event);" />&nbsp;<span style="font-weight:normal;color:#000;"><?php echo $per['module_name']; ?></span></label>
																	</div></li>
																	<?php if(is_array($per['child']) || $per['child'] instanceof \think\Collection || $per['child'] instanceof \think\Paginator): if( count($per['child'])==0 ) : echo "" ;else: foreach($per['child'] as $key=>$three): ?> 
																<li><div class="cell">
																					<label class="w120"><input
																						type="checkbox" name="permiss" dir="sonson"
																						id="<?php echo $three['module_id']; ?>" value="<?php echo $three['module_id']; ?>"
																						onclick="AllCheckBoxClick(event);" />&nbsp;<span style="font-weight:normal;color:#666;"><?php echo $three['module_name']; ?></span></label>
																				</div></li>
																<?php endforeach; endif; else: echo "" ;endif; ?>
																</ul>
															<?php endforeach; endif; else: echo "" ;endif; ?>
															</td>
															
														</tr>
														<?php endforeach; endif; else: echo "" ;endif; ?>
														</tbody>
													</table>
												</div>
											</div>
										</div> <!-- 列表 end --></li>
								</ul>
							</div>
							<div class="float-l">
								<span class="prompt"></span>
							</div>
						</li>
					</ul>
				</div>
			</div>
			<!--content end-->
			<button type="submit" id="EditSubmit" style="display: none"
				class="submit01 r10">保存</button>
		</div>
	</div>
	<input type="hidden" id="currentRoleID" name="EditRoleID"> <input
		type="hidden" name="EditsendCheckDatas" id="EditsendCheckDatas">
	<div class="btn">
		<div class="indiv" style="text-align:right;">
			<button class="submit01-alert r10" onclick="Editbtn()">保存</button>
			<button class="reset01-alert" onclick="btnCancel()">关闭</button>
		</div>
	</div>
</div>

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