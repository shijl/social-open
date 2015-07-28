<table id="secret-list"></table>

<script type="text/javascript">
$('#secret-list').datagrid({
	url:'/back.php/secret/list?ajax=1',
	title:'秘钥管理',
    columns:[[
		{field:'id', hidden:true,width:20},
        {field:'api_name',title:'接口名称',width:200,align:'center'},
        {field:'username',title:'使用人',width:200,align:'center'},
        {field:'department',title:'部门',width:200,align:'center'},
        {field:'rate_val',title:'频次',width:100,align:'center'},
        {field:'secret_key',title:'秘钥',width:350,align:'center'}
        
    ]],
    pagination:true,
    rownumbers:true
});
</script>
