<?php

{extend name="glob/base" /}
{block name="content"}
	<div class="row">
		<div class="col-md-8">
			<div class="page-header">
				<h1>插件管理 </h1>
				<div class="pull-right">
					
				</div>
			</div>

			<div class="bs-example" data-example-id="striped-table">

				<div class="bs-example" data-example-id="striped-table">
					<table class="table table-striped">
						<thead>
							<div>
								<tr>
									<th>#</th>
									<th>插件标识</th>
									<th>简介</th>
									<th>作者</th>
									<th>状态</th>
									<th>管理</th>
								</tr>

							</div>

						</thead>
						<tbody>
							{volist name="plugin" id="item"}

							<tr>
								<th scope="row">{$item['id']|default=""}</th>
								<td>{$item['name']}</td>
								<td>{$item['description']}</td>
								<td>{$item['author']}</td>
								<td>{$plugin_status[$item['status']]}</td>

								<td>
									
											{if	$item['status'] == '3'}
												<a href='{:url("admin/plugins/install",["name"=>$item["name"] ])}' class="btn btn-primary">安装</a>

											{else /}
												<a href='{:url("admin/plugins/delete",["id"=>$item["id"] ])}' class="btn btn-danger">卸载</a>
												{if $item['status'] == '1'}
													<a href='{:url("admin/plugins/toggle",["id"=>$item["id"],"disable"=>$item["status"] ])}' class="btn btn-danger">禁用</a>
												{elseif $item['status'] == '0'}
													<a href='{:url("admin/plugins/toggle",["id"=>$item["id"] ])}' class="btn btn-primary">启用</a>
												{/if}
									<input style="width: 70px;" id="class_add" type="bottom" class="btn btn-primary" onclick="values(1,'modify')" data-toggle="modal" data-target="#myModal" value="更新" />												
											{/if}

	
							

								</td>				
							</tr>
							{/volist}
		

					
						</tbody>
					</table>

				</div>		




			</div>			
		</div>


		

	</div>










{/block}