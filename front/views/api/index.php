<?php
use yii\helpers\Html;
$this->title = '接口申请';
?>
<div class="main" style="margin-top: -1px;">
	<?php foreach(yii::$app->params['api_type'] as $key=>$val){?>
		<h3><?php echo $val?></h3>
	<table class="bordered">
		<thead>
			<tr>
				<th>接口名称</th>
				<th>接口地址</th>
				<th>创建时间</th>
				<th>接口速率</th>
				<th>操作</th>
			</tr>
		</thead>   
			    <?php
			    foreach($list as $k=>$v){
			    	if($key==$v['api_type']){
			    ?>
				    <tr data-id="<?php echo $v['id'];?>">
			<td><?php echo $v['api_name'];?></td>
			<td><?php echo $v['api_url'];?></td>
			<td><?php echo $v['created_at'];?></td>
			<td><select class="rate">
				        	<?php 
				        		foreach(yii::$app->params['rate'] as $k1=>$v1){
									echo '<option value="'.$k1.'">'.$v1.'</option>';
								}	
				        	?>
				        </select></td>
			<td><a class="apply" style="cursor: pointer;">申请</a></td>
		</tr>   
				<?php 
					}
				}
				?> 
		</table>
	<?php }?>
	<button style="margin-bottom:20px;background-color:#dce9f9;" onclick="javascript:window.location.assign('/apply');">返回接口申请列表</button>
</div>

<script>
$(function(){
	$(".apply").click(function(){
		var apiid = $(this).parent().parent().attr('data-id');
		var rate = $(this).parent().siblings().children(".rate").val();
		$.ajax({
			url : 'apply/create',
			type: 'POST',
			data : {apiid:apiid,rate:rate},
			dataType : 'json',
			success : function(e){
				if(e.success){
					alert('申请成功');
					return false;
				}else{
					alert(e.message);
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