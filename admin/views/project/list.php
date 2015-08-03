<table id="project-list"></table>

 <div id="ip-dg" class="easyui-dialog" style="width:400px;height:290px;padding:10px 20px" closed="true" buttons="#dlg-buttons">
		<div class="ftitle" id="ip-ftitle">增加IP白名单</div>
        <form id="ip-fm" method="post" novalidate>
           <div class="fitem">
	           <table cellpadding="5">
	                <tr>
	                    <td>名单列表:</td>
	                    <td><input class="easyui-textbox" name="ip-list" data-options="required:true,multiline:true" style="height:100px"></input></td>
	                </tr>
	                <input type="hidden" name="project_id" value="" id="project_id"/>
	                <input type="hidden" name="sub"/>
	            </table>
           </div>
        </form>
    
</div>
<div id="dlg-buttons">
        <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveView()" style="width:90px">保存</a>
</div>
<script type="text/javascript">
$('#project-list').datagrid({
	url:'/admin.php/project/list?ajax=1',
	title: '项目申请列表',
    columns:[[
		{field:'id', hidden:true,width:20},
        {field:'username',title:'用户名',width:180,align:'center'},
        {field:'project',title:'项目',width:150,align:'center'},
        {field:'department',title:'部门',width:150,align:'center'},
        {field:'qq',title:'qq',width:150,align:'center'},
        {field:'created_time',title:'创建时间',width:150,align:'center'},
        {field:'status_value',title:'状态',width:60,align:'center'},
            
        {field:'operation',title:'操作',width:150,align:'center',
            formatter:function(value, rowData, index){
                var enable = '<a href="#" onclick="status(\''+rowData.id+'\', 1)">开启</a>';
                var disable = '<a href="#" onclick="status(\''+rowData.id+'\', 2)">锁定</a>';
               // var ip_list = '<a href="#" onclick="openDialog(\''+rowData.id+'\', \''+rowData.project+'\')">添加IP白名单</a>';
                if(rowData.status == 1) {
                	return disable;
                } else {
                	return enable;
                }
			}
        }
    ]],
    pagination:true,
    rownumbers:true
});

function status(id,status)
{
	$.getJSON('/admin.php/project/status', {id:id,status:status}, function(data){
		if(data.code == 10000){
			$.messager.alert('提示','保存成功');
		} else {
			$.messager.alert('提示','保存失败');
		}
		$('#project-list').datagrid('reload');
	});
}
function openDialog(project_id, project)
{
	$("#ip-dg").dialog('open').dialog('setTitle', '增加'+project+'IP白名单');
	$("#ip-fm").form('clear');
	$("#ip-ftitle").html('增加'+project+'IP白名单');
	$("#project_id").val(project_id);
	
}
function saveView(){
    $('#ip-fm').form('submit',{
        url: '/admin.php/api/add',
        onSubmit: function(){
            return $(this).form('validate');
        },
        success: function(result){
            var result = eval('('+result+')');
            if (result.code != 10000){
            	$.messager.alert('提示',result.message);
            } else {
            	$.messager.alert('提示',result.message);
                $('#ip-dg').dialog('close');        // close the dialog
            }
        }
    });
}
</script>
<style type="text/css">
        #fm{
            margin:0;
            padding:10px 30px;
        }
        .ftitle{
            font-size:14px;
            font-weight:bold;
            padding:5px 0;
            margin-bottom:10px;
            border-bottom:1px solid #ccc;
        }
        .fitem{
            margin-bottom:5px;
        }
        .fitem label{
            display:inline-block;
            width:80px;
        }
        .fitem input{
            width:160px;
        }
</style>