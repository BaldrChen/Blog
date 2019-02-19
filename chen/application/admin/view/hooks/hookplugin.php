<?php

{extend name="glob/base" /}
{block name="content"}
	<div class="row">
		<div class="col-md-8">
				<div class="page-header">
					<h1>{$hook}下的插件</h1>
				</div>



				<div class="bs-example" data-example-id="striped-table">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>#</th>
								<th>插件标识</th>
								<th>简介</th>
								<th>作者</th>
								<th>状态</th>
							</tr>
						</thead>

						<tbody>
			
						{volist name="pluginInfo" id="item"}
								<tr>
								<th scope="row">{$item['id']|default=""}</th>
								<td>{$item['name']}</td>
								<td>{$item['description']}</td>
								<td>{$item['author']}</td>
								<td>{$plugin_status[$item['status']]}</td>

									
								</tr>
						{/volist}
						</tbody>
					</table>
				</div>	
		</div>


		

	</div>












{/block}