<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:41:"template/admin\b2c\System\moduleList.html";i:1494580739;s:28:"template/admin\b2c\base.html";i:1495424696;s:34:"template/admin\b2c\openDialog.html";i:1495424452;}*/ ?>
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
						
<li><a class="nscs-table-handle_green" href="javascript:;" onclick="addModule()"><i class="fa fa-plus-circle"></i>&nbsp;添加模块</a></li>

					</ul>
				</div>
			</div>
			<hr class="tabmenu_hr" style="border:1px solid #00C0FF;margin:0 0px 10px 20px;"  />
			<div class="main">
			
<style>
.style0list table input {
	color: #666;
	width: 206px;
	margin-bottom: 0px;
	border: 1px solid #ccc;
}
.style0list table input.sort {
	width: auto;
	text-align: center;
}
.style0list tbody td {
	line-height: 28px;
}
</style>
<input type="hidden" id="pid" value="0" />
<div class="style0list">
	<table>
		<colgroup>
			<col style="width: 1%;">
			<col style="width: 5%;">
			<col style="width: 50%;">
			<col style="width: 10%;">
			<col style="width: 10%;">
		</colgroup>
		<thead>
			<tr class="row-selected">
				<th></th>
				<th>排序</th>
				<th style="text-align: left;">模块名</th>
				<th>是否是菜单</th>
				<th>操作</th>
			</tr>
		</thead>
		<tbody>
		<?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): if( count($list)==0 ) : echo "" ;else: foreach($list as $key=>$v1): ?>
		<tr class="pid_0" style="height: 30px;">
			<td>
				<?php if($v1['sub_menu'] != array()): ?>
				<a href="javascript:;" onclick="tab_switch(<?php echo $v1['module_id']; ?>)" class="tab_jia_<?php echo $v1['module_id']; ?>" style="display: block;"><i class="fa fa-plus-circle"></i></a>
				<a href="javascript:;" onclick="tab_switch(<?php echo $v1['module_id']; ?>)" class="tab_jian_<?php echo $v1['module_id']; ?>" style="display: none;"><i class="fa fa-minus-circle"></i></a>
				<?php endif; ?>
			</td>
			<td style="text-align: center;"><input type="text" class="sort"
					fieldid="<?php echo $v1['module_id']; ?>" fieldname="sort" value="<?php echo $v1['sort']; ?>"
					size="1"></td>
				<td><input type="text" fieldid="<?php echo $v1['module_id']; ?>"
					fieldname="module_name" value="<?php echo $v1['module_name']; ?>"></td>
				<td style="text-align: center;"><?php echo !empty($v1['is_menu'])?'是' : '否'; ?></td>
				<td style="text-align: center;"><a
					href="ADMIN_MAIN/System/editModule.html?module_id=<?php echo $v1['module_id']; ?>">修改</a>
					<a href="javascript:void(0);"
					onclick="delModule(<?php echo $v1['module_id']; ?>)">删除</a></td>
			</tr>
			<?php if(is_array($v1['sub_menu']) || $v1['sub_menu'] instanceof \think\Collection || $v1['sub_menu'] instanceof \think\Paginator): if( count($v1['sub_menu'])==0 ) : echo "" ;else: foreach($v1['sub_menu'] as $key=>$v2): ?>
			<tr class="pid_<?php echo $v1['module_id']; ?>"
				style="height: 30px; display: none;">
				<td><?php if($v2['sub_menu'] != array()): ?><a
					href="javascript:void(0)" onclick="tab_switch(<?php echo $v2['module_id']; ?>)"
					class="tab_jian_<?php echo $v2['module_id']; ?> tab_jian_<?php echo $v1['module_id']; ?>"
					style="display: block;"><i class="fa fa-minus-circle"></i></a><a
					href="javascript:void(0)" onclick="tab_switch(<?php echo $v2['module_id']; ?>)"
					class="tab_jia_<?php echo $v2['module_id']; ?> tab_jia_<?php echo $v1['module_id']; ?>"
					style="display: none;"><i class="fa fa-plus-circle"></i></a> <?php endif; ?>
				</td>
				<td style="text-align: center;"><input type="text" class="sort"
					fieldid="<?php echo $v2['module_id']; ?>" fieldname="sort" value="<?php echo $v2['sort']; ?>"
					size="1"></td>
				<td><span style="color: #ccc;">|——</span> <input type="text"
					fieldid="<?php echo $v2['module_id']; ?>" fieldname="module_name"
					value="<?php echo $v2['module_name']; ?>"></td>
				<!--<th>控制器名</th>
									<th>方法名</th>
									<th>url</th>-->
				<!--<td><?php echo !empty($v2['is_menu'])?'是' : '否'; ?></td>
						<td><?php echo !empty($v2['is_menu'])?'是' : '否'; ?></td>-->
				<td style="text-align: center;"><?php echo !empty($v2['is_menu'])?'是' : '否'; ?></td>
				<td style="text-align: center;"><a
					href="ADMIN_MAIN/System/editModule.html?module_id=<?php echo $v2['module_id']; ?>">修改</a>
					<a href="javascript:void(0);"
					onclick="delModule(<?php echo $v2['module_id']; ?>)">删除</a></td>
			</tr>
			<?php if(is_array($v2['sub_menu']) || $v2['sub_menu'] instanceof \think\Collection || $v2['sub_menu'] instanceof \think\Paginator): if( count($v2['sub_menu'])==0 ) : echo "" ;else: foreach($v2['sub_menu'] as $key=>$v3): ?>
			<tr class="pid_<?php echo $v2['module_id']; ?> pid_<?php echo $v1['module_id']; ?>"
				style="height: 30px; display: none;">
				<td><label></td>
				<td style="text-align: center;"><input type="text" class="sort"
					fieldid="<?php echo $v3['module_id']; ?>" fieldname="sort" value="<?php echo $v3['sort']; ?>"
					size="1"></td>
				<td><span style="color: #ccc;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|——</span>
					<input type="text" fieldid="<?php echo $v3['module_id']; ?>"
					fieldname="module_name" value="<?php echo $v3['module_name']; ?>"></td>
				<!--<th>控制器名</th>
									<th>方法名</th>
									<th>url</th>-->
				<!--<td><?php echo !empty($v3['is_menu'])?'是' : '否'; ?></td>
						<td><?php echo !empty($v3['is_menu'])?'是' : '否'; ?></td>-->
				<td style="text-align: center;"><?php echo !empty($v3['is_menu'])?'是' : '否'; ?></td>
				<td style="text-align: center;"><a
					href="ADMIN_MAIN/System/editModule.html?module_id=<?php echo $v3['module_id']; ?>">修改</a>
					<a href="javascript:void(0);"
					onclick="delModule(<?php echo $v3['module_id']; ?>)">删除</a></td>
			</tr>
			<?php if(is_array($v3['sub_menu']) || $v3['sub_menu'] instanceof \think\Collection || $v3['sub_menu'] instanceof \think\Paginator): if( count($v3['sub_menu'])==0 ) : echo "" ;else: foreach($v3['sub_menu'] as $key=>$v4): ?>
			<tr
				class="pid_<?php echo $v3['module_id']; ?> pid_<?php echo $v2['module_id']; ?> pid_<?php echo $v1['module_id']; ?>"
				style="height: 30px; display: none;">
				<td><label></td>
				<td style="text-align: center;"><input type="text" class="sort"
					fieldid="<?php echo $v4['module_id']; ?>" fieldname="sort" value="<?php echo $v4['sort']; ?>"
					size="1"></td>
				<td><span style="color: #ccc;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|——</span>
					<input type="text" fieldid="<?php echo $v4['module_id']; ?>"
					fieldname="module_name" value="<?php echo $v4['module_name']; ?>"></td>
				<!--<th>控制器名</th>
									<th>方法名</th>
									<th>url</th>-->
				<!--<td><?php echo !empty($v3['is_menu'])?'是' : '否'; ?></td>
						<td><?php echo !empty($v3['is_menu'])?'是' : '否'; ?></td>-->
				<td style="text-align: center;"><?php echo !empty($v4['is_menu'])?'是' : '否'; ?></td>
				<td style="text-align: center;"><a
					href="ADMIN_MAIN/System/editModule.html?module_id=<?php echo $v4['module_id']; ?>">修改</a>
					<a href="javascript:void(0);"
					onclick="delModule(<?php echo $v4['module_id']; ?>)">删除</a></td>
			</tr>
			<?php if(is_array($v4['sub_menu']) || $v4['sub_menu'] instanceof \think\Collection || $v4['sub_menu'] instanceof \think\Paginator): if( count($v4['sub_menu'])==0 ) : echo "" ;else: foreach($v4['sub_menu'] as $key=>$v5): ?>
			<tr
				class="pid_<?php echo $v4['module_id']; ?> pid_<?php echo $v3['module_id']; ?> pid_<?php echo $v2['module_id']; ?> pid_<?php echo $v1['module_id']; ?>"
				style="height: 30px; display: none;">
				<td><label></td>
				<td style="text-align: center;"><input type="text" class="sort"
					fieldid="<?php echo $v5['module_id']; ?>" fieldname="sort" value="<?php echo $v5['sort']; ?>"
					size="1"></td>
				<td><span style="color: #ccc;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|——</span>
					<input type="text" fieldid="<?php echo $v5['module_id']; ?>"
					fieldname="module_name" value="<?php echo $v5['module_name']; ?>"></td>
				<!--<th>控制器名</th>
									<th>方法名</th>
									<th>url</th>-->
				<!--<td><?php echo !empty($v3['is_menu'])?'是' : '否'; ?></td>
						<td><?php echo !empty($v3['is_menu'])?'是' : '否'; ?></td>-->
				<td style="text-align: center;"><?php echo !empty($v5['is_menu'])?'是' : '否'; ?></td>
				<td style="text-align: center;"><a
					href="ADMIN_MAIN/System/editModule.html?module_id=<?php echo $v5['module_id']; ?>">修改</a>
					<a href="javascript:void(0);"
					onclick="delModule(<?php echo $v5['module_id']; ?>)">删除</a></td>
			</tr>
			<?php endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; ?>
		</tbody>
	</table>
</div>
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
$(".style0list table input").change(function(){
	var fieldid = $(this).attr('fieldid');
	var fieldname = $(this).attr('fieldname');
	var fieldvalue = $(this).val();
	$.ajax({
		type:"post",
		url:"ADMIN_MAIN/System/modifyField",
		data:{'fieldid':fieldid,'fieldname':fieldname,'fieldvalue':fieldvalue},
		async:true,
		success: function (data) {
			if(data['code'] <= 0){
				showMessage('error', data["message"]);
			}
		}
	});
});
	function tab_switch(module_id){
		if($(".pid_"+module_id).css('display') != 'none'){
			$(".tab_jian_"+module_id).hide();
			$(".tab_jia_"+module_id).show();
			$(".pid_"+module_id).hide(300);
		}else{
			$(".tab_jian_"+module_id).show();
			$(".tab_jia_"+module_id).hide();
			$(".pid_"+module_id).show(500);
		}
	}
		function addModule(){
			var pid = $("#pid").val();
			location.href = "ADMIN_MAIN/System/addModule.html?pid="+pid;
		}
		function delModule(module_id){
			$( "#dialog" ).dialog({				
	            buttons: {
	                "确定,#e57373": function() {
	                    $(this).dialog('close');
	                    $.ajax({
	        				type:"post",
	        				url:"ADMIN_MAIN/System/delModule",
	        				data:{'module_id':module_id},
	        				async:true,
	        				dataType: 'json',
	        				success:function (data) {
	        					
	        					if(data['code'] > 0){
	        						location.href = "ADMIN_MAIN/System/moduleList.html";
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
	            contentText:"确定删除？",
	        });
			/* if(confirm("确定删除？")){
				
			} */
		}
        var appCode = GetUrlAppCode();
        var menuCode = GetUrlMenuCode();
        if (appCode != 'PLATFORM' && appCode != "" && appCode != null) {
            $("#type").css("display", "none");
            $("#Operate ul").css("display", "none");
            $(".separationLine").css("display", "none");
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