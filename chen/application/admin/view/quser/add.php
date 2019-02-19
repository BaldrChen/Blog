<?php

{extend name="glob/base" /}
{block name="content"}
	<div class="row">
		<div class="col-md-8">
				<div class="page-header">
					<h1>用户 {$typename}</h1>
				</div>
				<div  class="bs-example" data-example-id="striped-table">


					<form method="post" action="{:url('admin/user/save')}" class="form-horizontal">
						{:token()}

						<input type="hidden" name="id" value='{$item->id|default=""}'>
						<div class="form-group">
							<label for="username" class="col-sm-2 control-label">用户名</label>
							<div class="col-sm-5">
								<input type="text" class="form-control" name="username" id="username" value='{$item->username|default=""}' {$disabled|default=""}>
							</div>
						</div>

						<div class="form-group">
							<label for="passwd" class="col-sm-2 control-label">密码</label>
							<div class="col-sm-5">
								<input type="password" class="form-control" name="passwd" id="passwd">
							</div>
						</div>

						<div class="form-group">
							<label for="nick" class="col-sm-2 control-label">昵称</label>
							<div class="col-sm-5">
								<input type="text" class="form-control" name="nick" id="nick" value='{$item->nick|default=""}'>
							</div>
						</div>

						<div class="form-group">
							<label for="phone" class="col-sm-2 control-label">手机</label>
							<div class="col-sm-5">
								<input type="text" class="form-control" name="phone" id="phone" value='{$item->phone|default=""}'>
							</div>
						</div>

						<div class="form-group">
							<label for="email" class="col-sm-2 control-label">邮箱</label>
							<div class="col-sm-5">
								<input type="text" class="form-control" name="email" id="email" value='{$item->email|default=""}'>
							</div>
						</div>

						<div class="form-group">
							<label for="user_status" class="col-sm-2 control-label">状态</label>
							<div class="col-sm-5">
								<select name="user_status" id="user_status" class="form-control col-sm-5">
									{volist name="user_status" id="row"}
									<option value="{$key}">{$row}</option>
									{/volist}
								</select>
							</div>


						</div>


						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<button type="submit" class="btn btn-default">提交</button>
							</div>
						</div>
					</form>



				</div>			
		</div>


		

	</div>



<script>
	$("#user_status") .val({$item->user_status|default="1"});



	
</script>





{/block}