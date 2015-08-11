<table id="other-access-list"></table>

<script type="text/javascript">
$('#other-access-list').datagrid({
	url:'/admin.php/access/other?ajax=1',
	title: '接入申请列表',
	toolbar:[{
		id: 'add-access',
		text:'添加第三方接入',
		iconCls:'icon-add',
		handler:addAccess,
	}],
    columns:[[
		{field:'id', title:'ID',width:20},
        {field:'project_name',title:'项目名称',width:200,align:'center'},
        {field:'leader',title:'项目负责人',width:150,align:'center'},
        {field:'qq',title:'负责人qq',width:150,align:'center'},
        {field:'phone',title:'负责人电话',width:100,align:'center'},
        {field:'access_ip',title:'接入ip',width:150,align:'center'},
        {field:'created_time',title:'创建日期',width:100,align:'center'},
        {field:'access_status',title:'状态',width:100,align:'center'},
            
        {field:'operation',title:'操作',width:100,align:'center',
            formatter:function(value, rowData, index){
                var status = '<a href="#" onclick="status(\''+rowData.id+'\', 1)">开启</a>';
                var unstatus = '<a href="#" onclick="status(\''+rowData.id+'\', 2)">关闭</a>';
                var view = '<a href="#" onclick="open1(\'编辑-'+rowData.project_name+'\',\'/admin.php/access/other/view?id='+rowData.id+'\')">编辑</a>';
                var deal = '';
                if(rowData.status == 1) {
                	deal = unstatus+' | '+view;
                } else {
                	deal = status+' | '+view;
                }
				return deal;
			}
        }
    ]],
    pagination:true,
    rownumbers:true
});

function status(id,status)
{
	$.getJSON('/admin.php/access/other/status', {id:id,status:status}, function(data){
		if(data.code == 10000){
			$.messager.alert('提示','保存成功');
		} else {
			$.messager.alert('提示','保存失败');
		}
		$('#other-access-list').datagrid('reload');
	});
}

function addAccess()
{
	open1('添加第三方接入','/admin.php/access/other/view');
}
</script>
