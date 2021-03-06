<?php
use yii\helpers\Html;
$this->title = '接口申请列表';
?>
<div class="main" style="margin-top:-1px;">
	<h2><span>接口申请列表</span><button onclick="javascript:window.location.assign('/apis');" style="background-color:#dce9f9;float:right">接口申请</button></h2>
	<table class="bordered">
	    <thead>
	    <tr>
	        <th>接口名称</th>
	        <th>接口地址</th>       
	        <th>接口类型</th>
	        <th>接口速率</th>
	        <th>申请时间</th>
	        <th>审核状态</th>
	        <th>审核时间</th>
	        <th>密钥</th>
	    </tr>
	    </thead>
	    <?php if(!empty($list)){?>
		    <?php foreach($list as $key=>$val){?>
			    <tr data-id="<?php echo $val['id']; ?>">
			        <td><?php echo $val['api_name'];?></td>        
			        <td><?php echo $val['api_url'];?></td>        
			        <td><?php echo $val['api_type'];?></td>        
			        <td><?php echo $val['rate'];?></td>        
			        <td><?php echo $val['created_at'];?></td>
			        <td><?php echo $val['is_agree'];?></td>             
			        <td><?php echo $val['agree_time'];?></td>        
			        <td><?php echo $val['secret_key'];?></td>        
			    </tr>   
			<?php }?>
		<?php }else{?>
				<tr><td colspan="8" style="text-align:center">暂无接口申请记录</td></tr>
		<?php }?>
	</table>
</div>
<div id='pop-div' style="width: 300px;" class="pop-box"> 
      <div class="pop-box-body" > 
	      <p id="list_key"> 
	            
	      </p>
      </div> 
</div>
<script>
$(function(){
	$(".key").click(function(){
		var id = $(this).parent().parent().attr('data-id');
		$.ajax({
			url : 'apply/get-key',
			type: 'POST',
			data : {id:id},
			dataType : 'json',
			success : function(e){
				if(e.success){
					$("#list_key").html('密钥:'+e.key);
					popupDiv('pop-div');
					return false;
				}else{
					alert('获取失败');
					return false;
				}
			},
			error : function(){
				alert('申请失败');
			}
		});
	});
});
</script>
