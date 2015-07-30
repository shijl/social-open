<?php
use yii\helpers\Html;
$this->title = '登录与注册';
?>
<div class="main" style="margin-top:-1px;">
	<div class="header" >
		<h1>登录或创建一个免费帐户！</h1>
	</div>
	<p></p>
	<form>
		<ul class="left-form">
			<h2>新账户:</h2>
			<li>
				<input type="text" id="reg_username" placeholder="手机号"/>
				<a href="#" class="icon ticker"> </a>
				<div class="clear"> </div>
			</li> 
			<li>
				<input type="password" id="reg_password" placeholder="密码"/>
				<a href="#" class="icon ticker"> </a>
				<div class="clear"> </div>
			</li> 
			<li>
				<input type="text" id="department" placeholder="部门"/>
				<a href="#" class="icon ticker"> </a>
				<div class="clear"> </div>
			</li> 
			<li>
				<input type="text" id="project" placeholder="项目"/>
				<a href="#" class="icon ticker"> </a>
				<div class="clear"> </div>
			</li>
			<li>
				<input type="text" id="qq" placeholder="qq"/>
				<a href="#" class="icon into"> </a>
				<div class="clear"> </div>
			</li>
			<h5 id="error"></h5>
			<input type="submit" onClick="return reg()" value="创建账户">
				<div class="clear"> </div>
		</ul>
	</form>
	<form>
		<ul class="right-form">
			<h3>登录:</h3>
			<div>
				<li><input type="text" id="login_username"  placeholder="手机号" required/></li>
				<li> <input type="password" id="login_password" placeholder="密码" required/></li>
				<div style="margin-left:135px;margin-top:-12px;">
					<input type="submit" onClick="return check()" value="登录" >
				</div>
				
			</div>
			<div class="clear"> </div>
		</ul>
		<div class="clear"> </div>			
	</form>	
</div>
<script>
function check(){
	var _username = $('#login_username').val(),
	_password = $('#login_password').val();
	if(_username == ''){
		$('#error').html("请输入手机号");
		return false;
	}
	if(_password == ''){
		$('#error').html("请输入密码");
		return false;
	}
	$.ajax({
		url : 'user/login',
		type: 'POST',
		data : {username:_username,password:_password,rememberMe:0},
		dataType : 'json',
		success : function(e){
			if(e.success){
				window.location.assign('/apply');
				return false;
			}else{
				alert(e.message);
				return false;
			}
		},
		error : function(){
			alert('登录失败');
		}
	});
	return false;
}
function reg(){
	var _username = $('#reg_username').val(),
	_password = $('#reg_password').val(),
	_project = $('#project').val(),
	_department = $('#department').val(),
	_qq = $('#qq').val();
	var reg = /^0?1[3|4|5|8][0-9]\d{8}$/;
    if(!reg.test(_username)){
    	$('#error').html("请输入有效的手机号码");
         return false;
    }
    if(_password == ''){
		$('#error').html("请填写密码");
		return false;
	}
    if(_department == ''){
		$('#error').html("请填写部门");
		return false;
	}
    if(_project == ''){
		$('#error').html("请填写项目");
		return false;
	}

    if(_qq == ''){
		$('#error').html("请填写qq");
		return false;
	}
	
	$.ajax({
		url : 'user/create',
		type: 'POST',
		data : {username:_username,password:_password,project:_project,department:_department,qq:_qq},
		dataType : 'json',
		success : function(e){
			if(e.success){
				alert('注册成功');
				$('#login_username').val(_username);
				$('#login_password').val(_password);
				check();
				return false;
			}else{
				alert(e.message);
				return false;
			}
		},
		error : function(){
			alert('注册失败');
		}
	});
	return false;
}
</script>