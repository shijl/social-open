<table id="api-list"></table>

<div id="list-dd" class="easyui-dialog" style="width:400px;height:280px;padding:10px 20px" closed="true" buttons="#dlg-buttons">
		<div class="ftitle">增加接口</div>
        <form id="fm" method="post" novalidate>
           <div class="fitem">
	           <table cellpadding="5">
	                <tr>
	                    <td>接口名称:</td>
	                    <td><input class="easyui-textbox" type="text" name="api_name" data-options="required:true"></input></td>
	                </tr>
	                <tr>
	                    <td>接口地址:</td>
	                    <td><input class="easyui-textbox" type="text" name="api_url" data-options="required:true"></input></td>
	                </tr>
	                <tr>
	                    <td>类型:</td>
	                    <td>
	                        <select class="easyui-combobox" name="type" style="width:100px;" data-options="panelHeight:50,value:'1'">
	                        <?php foreach ($type as $k=>$v){ ?>
	                        	<option value="<?php echo $k?>" <?php echo $k==1 ? 'selected="selected"' : ''; ?>><?php echo $v?></option>
	                        <?php }?>
	                        </select>
	                    </td>
	                </tr>
	                <input type="hidden" name="sub"/>
	            </table>
           </div>
        </form>
    
</div>
<div id="dlg-buttons">
        <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveView()" style="width:90px">保存</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#list-dd').dialog('close')" style="width:90px">取消</a>
    </div>
    
    
<script type="text/javascript">
$('#api-list').datagrid({
	url:'/admin.php/api/list?ajax=1',
	title: '接口列表',
	toolbar:[{
		text:'增加接口',
		iconCls:'icon-add',
		handler: openDialog,
	}],
    columns:[[
		{field:'id', hidden:true,width:20},
        {field:'api_name',title:'接口名称',width:200,align:'center'},
        {field:'api_url',title:'接口地址',width:200,align:'center'},
        {field:'api_type',title:'接口类型',width:100,align:'center'},
        {field:'api_status',title:'接口状态',width:100,align:'center'},
        {field:'created_time',title:'创建时间',width:180,align:'center'},
        {field:'updated_time',title:'修改时间',width:180,align:'center'},
            
        {field:'operation',title:'操作',width:100,align:'center',
            formatter:function(value, rowData, index){
                var enable = '<a href="#" onclick="status(\''+rowData.id+'\', 1)">启用</a>';
                var disable = '<a href="#" onclick="status(\''+rowData.id+'\', 2)">停用</a>';
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
	$.getJSON('/admin.php/api/status', {id:id,status:status}, function(data){
		if(data.code == 10000){
			$.messager.alert('提示','保存成功');
		} else {
			$.messager.alert('提示','保存失败');
		}
		$('#api-list').datagrid('reload');
	});
}

function openDialog()
{
	$("#list-dd").dialog('open').dialog('setTitle', '增加接口');
	$("#fm").form('clear');
}

function saveView(){
    $('#fm').form('submit',{
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
                $('#list-dd').dialog('close');        // close the dialog
                $('#api-list').datagrid('reload');
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