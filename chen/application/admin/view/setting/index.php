<?php

{extend name="glob/base" /}
{block name='webname'}
基础设置
{/block}
{block name="content"}
	<div class="row">
		<div class="col-md-8">
				<div class="page-header">
					<h1>系统设置</h1>
				</div>
				<div class="bs-example" data-example-id="striped-table">
					<form method="post" action="{:url('admin/setting/save')}" class="form-horizontal">
						{:token()}

						{volist name="setting" id="item"}
						<div class="form-group">
							<label for="{$item->key}" class="col-sm-2 control-label">{$item->name}</label>
							<div class="col-sm-5">
								<input type="text" class="form-control" name="formdata[{$item->key}]" id="{$item->key}" value="{$item->value}">
							</div>
						</div>

						{/volist}

						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<button type="submit" class="btn btn-default">提交</button>
							</div>
						</div>
					</form>

				</div>	
		
		</div>


		

	</div>


{/block}