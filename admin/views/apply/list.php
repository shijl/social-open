<table id="apply-list"></table>

<script type="text/javascript">
$('#apply-list').datagrid({
	url:'/admin.php/apply/list?ajax=1',
	title: '接入申请列表',
    columns:[[
		{field:'id', hidden:true,width:20},
        {field:'api_name',title:'接口名称',width:200,align:'center'},
        {field:'username',title:'使用人',width:200,align:'center'},
        {field:'department',title:'部门',width:200,align:'center'},
        {field:'rate_val',title:'频次',width:100,align:'center'},
        {field:'agree_status',title:'申请状态',width:100,align:'center'},
            
        {field:'operation',title:'操作',width:100,align:'center',
            formatter:function(value, rowData, index){
                var agree = '<a href="#" onclick="agree(\''+rowData.id+'\', 1)">通过</a>';
                var unagree = '<a href="#" onclick="agree(\''+rowData.id+'\', 2)">不通过</a>';
                var deal = '';
                if(rowData.is_agree == 0) {
                	deal = agree + ' | ' + unagree;
                } else if (rowData.is_agree == 1) {
                	deal = unagree;
                } else {
                	deal = agree;
                }
				return deal;
			}
        }
    ]],
    pagination:true,
    rownumbers:true
});

function agree(id,status)
{
	$.getJSON('/admin.php/apply/agree', {id:id,status:status}, function(data){
		if(data.code == 10000){
			$.messager.alert('提示','保存成功');
		} else {
			$.messager.alert('提示','保存失败');
		}
		$('#apply-list').datagrid('reload');
	});
}
</script>
