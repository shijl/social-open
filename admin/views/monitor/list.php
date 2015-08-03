
<script type="text/javascript" src="/static/jquery-easyui-1.4.3/plugin/datagrid-detailview.js"></script>
<div height="100%"><table id="monitor-list"></table></div>



<script type="text/javascript">
$('#monitor-list').datagrid({
	url:'/admin.php/monitor/list?ajax=1',
	title:'接口访问频次',
	striped:true,
	view: detailview,
	detailFormatter:function(index,row){
		return '<div style="padding:2px"><table class="ddv"></table></div>';
	},
	columns:[[
	  	{field:'id', hidden:true,width:20},
        {field:'api_name',title:'接口名称',width:150,align:'center'},
        {field:'api_url',title:'接口地址',width:200,align:'center'},
        {field:'api_type',title:'接口类型',width:80,align:'center'},
        {field:'api_status',title:'接口状态',width:80,align:'center'},
        {field:'created_time',title:'创建时间',width:160,align:'center'},
        {field:'updated_time',title:'修改时间',width:160,align:'center'},
        {field:'all_num',title:'最高访问次数/mins',width:100,align:'center',
			formatter:function(value, rowData, index){
				if(value > rowData.rate_limit){
					return '<span style="color:red;">'+value+'</span>';
				} else {
					return value;
				}
			}
        },
            
        {field:'operation',title:'操作',width:80,align:'center',
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
	onExpandRow: function(index,row){
        ddv = $(this).datagrid('getRowDetail',index).find('table.ddv');
        ddv.datagrid({
            url:'/admin.php/monitor/item?id='+row.id,
            fitColumns:true,
            singleSelect:true,
            rownumbers:true,
            loadMsg:'',
            height:'auto',
            columns:[[
                {field:'username',title:'使用人',width:40,align:'center'},
                {field:'project',title:'项目名',width:100,align:'center'},
                {field:'department',title:'部门',width:100,align:'center'},
                {field:'rate_val',title:'申请峰值',width:40,align:'center'},
                {field:'access_num',title:'最高访问次数/mins',width:50,align:'center', 
                	formatter:function(value, rowData, index){
        				if(value > rowData.rate_num_val){
        					return '<span style="color:red;">'+value+'</span>';
        				} else {
        					return value;
        				}
        			}
                },
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
            onResize:function(){
                $('#monitor-list').datagrid('fixDetailRowHeight',index);
            },
            onLoadSuccess:function(){
                setTimeout(function(){
                    $('#monitor-list').datagrid('fixDetailRowHeight',index);
                },0);
            },
            pagination:true,
            rownumbers:true
        });
        //$('#monitor-list').datagrid('fixDetailRowHeight',index);
    },
});
function status(id,status)
{
	$.getJSON('/admin.php/api/status', {id:id,status:status}, function(data){
		if(data.code == 10000){
			$.messager.alert('提示','保存成功');
		} else {
			$.messager.alert('提示','保存失败');
		}
		$('#monitor-list').datagrid('reload');
	});
}

function agree(id,status)
{
	$.getJSON('/admin.php/apply/agree', {id:id,status:status}, function(data){
		if(data.code == 10000){
			$.messager.alert('提示','保存成功');
		} else {
			$.messager.alert('提示','保存失败');
		}
		ddv.datagrid('reload');
	});
}
</script>