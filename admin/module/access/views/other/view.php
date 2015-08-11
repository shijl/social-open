<div class="easyui-panel" title="增加第三方接入" style="width:300px;padding:10px;">
	 <form id="other-fm" method="post" enctype="multipart/form-data">
            <table>
                <tr>
                    <td>项目名:</td>
                    <td><input name="project_name" value="<?php echo !empty($access_info['project_name']) ? $access_info['project_name'] : ''; ?>" class="f1 easyui-textbox" data-options="required:true"></input></td>
                </tr>
                <tr>
                    <td>负责人:</td>
                    <td><input name="leader" value="<?php echo !empty($access_info['leader']) ? $access_info['leader'] : ''; ?>" class="f1 easyui-textbox" data-options="required:true"></input></td>
                </tr>
                <tr>
                    <td>qq:</td>
                    <td><input name="qq" value="<?php echo !empty($access_info['qq']) ? $access_info['qq'] : ''; ?>" class="f1 easyui-textbox" data-options="required:true"></input></td>
                </tr>
                <tr>
                    <td>电话</td>
                    <td><input name="phone" value="<?php echo !empty($access_info['phone']) ? $access_info['phone'] : ''; ?>" class="f1 easyui-textbox" data-options="required:true"></input></td>
                </tr>
                <tr>
                    <td>接入IP</td>
                    <td><input name="access_ip" value="<?php echo !empty($access_info['access_ip']) ? long2ip($access_info['access_ip']) : ''; ?>" class="f1 easyui-textbox" data-options="required:true"></input></td>
                </tr>
                	<input type="hidden" value="<?php echo !empty($access_info['id']) ? $access_info['id'] : ''; ?>" name="id"/>
	                <input type="hidden" name="sub"/>
            </table>
        </form>
        
        <div id="login-button" style="margin-top:30px;">
            <a href="javascript:;" id="add-other" class="easyui-linkbutton" data-options="iconCls:'icon-ok'" style="padding:5px 0px;width:100%;">
                <span style="font-size:14px;">提交</span>
            </a>
        </div>
</div>
<script>
(function(){
	var addOther = function(){
		$('#other-fm').form('submit',{
	        url: '/admin.php/access/other/view',
	        onSubmit: function(){
	            return $(this).form('validate');
	        },
	        success: function(result){
	            var result = eval('('+result+')');
	            if (result.code != 10000){
	            	$.messager.alert('提示',result.message);
	            } else {
	            	$.messager.alert('提示',result.message);
	            }
	        }
	    });
	}
	$("#add-other").bind("click", addOther);
})();

</script>
<style scoped>
        .f1{
            width:200px;
        }
</style>


