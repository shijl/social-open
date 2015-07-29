<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>Open</title>
		<link rel="stylesheet" type="text/css" href="/static/jquery-easyui-1.4.3/themes/default/easyui.css">
        <link rel="stylesheet" type="text/css" href="/static/jquery-easyui-1.4.3/themes/icon.css">
        <link rel="stylesheet" type="text/css" href="/static/jquery-easyui-1.4.3/demo.css">
		<script type="text/javascript" src="/static/jquery-easyui-1.4.3/jquery.min.js"></script>
		<script type="text/javascript" src="/static/jquery-easyui-1.4.3/jquery.easyui.min.js"></script>
		<script type="text/javascript" src="/static/jquery-easyui-1.4.3/locale/easyui-lang-zh_CN.js"></script>
		<script type="text/javascript">
			function open1(plugin,url){
				if ($('#tt').tabs('exists',plugin)){
					$('#tt').tabs('select', plugin);
				} else {
					$('#tt').tabs('add',{
						title:plugin,
						href:url,
						closable:true,
					});
				}
			}
		</script>
	</head>
	<body class="easyui-layout" style="text-align:left">
		<div region="north" border="false" style="background:rgba(0, 0, 0, 0) linear-gradient(to bottom, #eff5ff 0px, #e0ecff 100%) repeat-x scroll 0 0;text-align:center">
						<div id="header-inner">
				<table cellpadding="0" cellspacing="0" style="width:100%;">
					<tr>
						<td rowspan="2" style="width:20px;">
						</td>
						<td style="height:52px;">
							<div style="color:#fff;font-size:22px;font-weight:bold;">
								<a href="" style="color:#0e2d5f;font-size:22px;font-weight:bold;text-decoration:none">Open Platform</a>
							</div>
						</td>
						
					</tr>
				</table>
			</div>
			
		</div>
		<div region="west" split="true" title="Menu" style="width:250px;padding:5px;">
			<ul class="easyui-tree">
				<li iconCls="icon-base">
					<span>接入申请管理</span>
						<ul>
							<li iconCls="icon-gears"><a class="e-link" href="#" onclick="open1('接口管理','/admin.php/api/list')">接口管理</a></li>
							<li iconCls="icon-gears"><a class="e-link" href="#" onclick="open1('接入申请列表','/admin.php/apply/list')">接入申请列表</a></li>
							<li iconCls="icon-gears"><a class="e-link" href="#" onclick="open1('秘钥管理','/admin.php/secret/list')">秘钥管理</a></li>
						</ul>
				</li>
				<li iconCls="icon-gears"><a class="e-link" href="/admin.php/login/logout">退出</a></li>
				
			</ul>
		</div>
		<div region="center">
			<div id="tt" class="easyui-tabs" fit="true" border="false" plain="true" >
				<div title="welcome" href=""></div>
			</div>
		</div>
	</body>
</html>


