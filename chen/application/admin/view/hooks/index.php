<?php

{extend name="glob/base" /}
{block name="content"}
	<div class="row">
		<div class="col-md-8">
				<div class="page-header">
					<h1>钩子管理  <a class="btn btn-primary pull-right" href="{:url('admin/hooks/sync')}">更新</a></h1> 
				</div>



				<div class="bs-example" data-example-id="striped-table">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>#</th>
								<th>钩子名称</th>
								<th>钩子标识</th>
								<th>钩子类型</th>
								<th>描述</th>
								<th>操作</th>
							</tr>
						</thead>
						<tbody>
			
						{volist name="hook" id="val"}
							<tr>
								<th scope="row">{$val['id']}</th>
								<td maxlenth="5">{$val['name']}</td>
								<td maxlenth="5">{$val['hook']}</td>
								<td>{$hook_type[$val['type']]}</td>
								<td>{$val['description']}</td>
								<td>
								<a href='{:url("admin/hooks/hookplugin",["name"=>$val["hook"] ])}' class="btn btn-primary">插件信息</a>
								</td>
								
							</tr>
						{/volist}
						</tbody>
					</table>
				</div>	
		</div>




	</div>












{/block}