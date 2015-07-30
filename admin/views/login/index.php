<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>登陆</title>
    <link rel="stylesheet" type="text/css" href="/static/jquery-easyui-1.4.3/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="/static/jquery-easyui-1.4.3/themes/icon.css">
    <link rel="stylesheet" type="text/css" href="/static/jquery-easyui-1.4.3/demo.css">
	<script type="text/javascript" src="/static/jquery-easyui-1.4.3/jquery.min.js"></script>
	<script type="text/javascript" src="/static/jquery-easyui-1.4.3/jquery.easyui.min.js"></script>
	<script type="text/javascript" src="/static/jquery-easyui-1.4.3/locale/easyui-lang-zh_CN.js"></script>
</head>
<body>
    <div id="w" class="easyui-window" title="请先登录" data-options="modal:true,closable:false,collapsible:false,minimizable:false,maximizable:false,iconCls:'icon-man'" buttons="#login-buttons" style="width:400px;padding:20px 70px 20px 70px;">
        <form id="fm" method="post" novalidate>
	        <div style="margin-bottom:10px">
	            <input class="easyui-textbox" id="logname" name="username" style="width:100%;height:30px;padding:12px" data-options="prompt:'登录用户',iconCls:'icon-man',iconWidth:38,required:true">
	        </div>
	        <div style="margin-bottom:20px">
	            <input class="easyui-textbox" id="logpass" name="password" type="password" style="width:100%;height:30px;padding:12px" data-options="prompt:'登录密码',iconCls:'icon-lock',iconWidth:38,required:true">
	        </div>
	         <input type="hidden" name="sub"/>
        </form>
        <div id="login-button">
            <a href="javascript:;" onclick="dologin()" class="easyui-linkbutton" data-options="iconCls:'icon-ok'" style="padding:5px 0px;width:100%;">
                <span style="font-size:14px;">登录</span>
            </a>
        </div>
    </div>
</body>
</html>

<script type="text/javascript">
function dologin(){
    $('#fm').form('submit',{
        url: '/admin.php/login/login',
        onSubmit: function(){
            return $(this).form('validate');
        },
        success: function(result){
            var result = eval('('+result+')');
            if (result.code != 10000){
            	$.messager.alert('提示',result.message);
            	$("#logname").textbox("clear");
            	$("#logpass").textbox("clear");
            } else {
            	$.messager.alert('提示',result.message);
            	window.location='/admin.php';
            }
        }
    });
}
</script>