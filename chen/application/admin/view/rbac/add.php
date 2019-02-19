<?php

{extend name="glob/base" /}
{block name="content"}
	<div class="row">
		<div class="col-md-8">
				<div class="page-header">
					<h1>角色 {$typename}</h1>
				</div>
				<div class="bs-example" data-example-id="striped-table">
					<form method="post" action="{:url('admin/rbac/save')}" class="form-horizontal">
						{:token()}
						<input type="hidden" name="id" value='{$item->id|default=""}'>
						<div class="form-group">
							<label for="name" class="col-sm-2 control-label">角色名称</label>
							<div class="col-sm-5">
								<input type="text" class="form-control" name="name" id="name" value='{$item->name|default=""}'>
							</div>
						</div>
						<div class="form-group">
							<label for="remark" class="col-sm-2 control-label">角色描述</label>
							<div class="col-sm-5">
								<input type="text" class="form-control" name="remark" id="remark" value='{$item->remark|default=""}'>
							</div>
						</div>

						<div class="form-group">
							<label for="role_status" class="col-sm-2 control-label">状态</label>
							<div class="col-sm-5">
								<select name="role_status" id="role_status" class="form-control col-sm-5">
									{volist name="role_status" id="row"}
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
	$("#role_status") .val({$item->status|default="1"});



	
</script>






{/block}