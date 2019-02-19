<?php

{extend name="glob/base" /}
{block name="content"}
	<div class="row">
		<div class="col-md-8">
				<div class="page-header">
					<h1>管理员 {$typename}</h1>
				</div>
				<div class="bs-example" data-example-id="striped-table">
					<form method="post" action="{:url('admin/auser/save')}" class="form-horizontal">
						{:token()}
						<input type="hidden" name="id" value='{$item->id|default=""}'>
						<div class="form-group">
							<label for="username" class="col-sm-2 control-label">用户名</label>
							<div class="col-sm-5">
								<input type="text" class="form-control" name="username" id="username" value='{$item->username|default=""}'>
							</div>
						</div>
						<div class="form-group">
							<label for="passwd" class="col-sm-2 control-label">密码</label>
							<div class="col-sm-5">
								<input type="password" class="form-control" name="passwd" id="passwd">
							</div>
						</div>
						<div class="form-group">
							<label for="role" class="col-sm-2 control-label">所属角色</label>
							<div class="col-sm-5">
									{volist name="role" id="row"}
										{if $row['status'] == 1}
										 <input name="role[]" id="r{$row['id']}" class="role_id" type="checkbox" value="{$row['id']}" />{$row['name']}
										{/if}
									{/volist}
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


var rid = <?php
	if (empty($role_id)) {
		echo null;
	}else{
		echo $role_id;
	} 
 ?>;

$(document).ready(function(){
	$.each(rid,function(index,obj){
		$("#r"+obj.role_id).prop('checked','true');
		
	});	

});


</script>










{/block}