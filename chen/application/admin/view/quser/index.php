<?php

{extend name="glob/base" /}
{block name="content"}
	<div class="row">
		<div class="col-md-8">
				<div class="page-header">
					<h1>登陆过本站QQ用户查看</h1>
				</div>

				<form class="form-inline" action="{:url('admin/quser/index')}" method="get">
					<div class="form-group">
						<label for="exampleInputName2">关键字：</label>
						<input type="text" class="form-control" id="search" name='search' placeholder="输入关键字进行搜索" value="{$search|default=""}">
					</div>
					<button type="submit" class="btn btn-default">搜索</button>
				</form>


				<div class="bs-example" data-example-id="striped-table">
					<table class="table table-striped">
						<thead>
							<tr>
								<th> # </th>
								<th>QQ昵称</th>
								<th>QQ头像</th>
								<th>OPENID</th>
								<th>第一次登陆时间</th>
							</tr>
						</thead>
						<tbody>
							
							{volist name="uData" id="list" }
							<tr>
								<th scope="row">{$list->id}</th>
								<td>{$list->nick}</td>
								<td><img src="{$list->images}" /></a></td>
								<td>{$list->openid}</td>
								<td>{$list->create_time}</td>
								
							</tr>
						{/volist}
						</tbody>
					</table>
					{$uData->render()|raw}
				</div>			
		</div>


		

	</div>












{/block}