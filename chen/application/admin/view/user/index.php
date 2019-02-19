<?php

{extend name="glob/base" /}
{block name="content"}
	<div class="row">
		<div class="col-md-8">
				<div class="page-header">
					<h1>用户 <small><a href="{:url('admin/user/add')}" class="btn btn-primary navbar-right" >添加</a></small></h1>
				</div>

				<form class="form-inline" action="{:url('admin/user/index')}" method="get">
					<div class="form-group">
						<label for="exampleInputName2">关键字：</label>
						<input type="text" class="form-control" id="key" name='key' placeholder="输入关键字进行搜索" value="{$ukey|default=""}">
					</div>
					<button type="submit" class="btn btn-default">搜索</button>
				</form>


				<div class="bs-example" data-example-id="striped-table">
					<table class="table table-striped">
						<thead>
							<tr>
								<th> # </th>
								<th>用户名</th>
								<th>头像（点击修改）</th>
								<th>昵称</th>
								<th>电话</th>
								<th>邮箱</th>
								<th>状态</th>
								<td>管理</td>
							</tr>
						</thead>
						<tbody>
							
							{volist name="uData" id="list" }
							<tr>
								<th scope="row">{$list->id}</th>
								<td>{$list->username}</td>
								<td><a href="{:url('admin/user/head',["id"=>$list->id])}"><img src="{:url($list->head)}" /></a></td>
								<td>{$list->nick}</td>
								<td>{$list->phone}</td>
								<td>{$list->email}</td>
								<td>{$user_status[$list->user_status]}</td>
								<th>
									<a href="{:url('admin/user/modify',["id"=>$list->id])}" class="btn btn-primary">修改</a>
									<a href='{:url("admin/user/status",["id"=>$list->id, "status"=>$list->user_status])}' class="btn btn-danger">登录权限</a>
								</th>
								
							</tr>
						{/volist}
						</tbody>
					</table>
					{$uData->render()|raw}
				</div>			
		</div>


		

	</div>












{/block}