<?php

{extend name="glob/base" /}
{block name="content"}
	<div class="row">
		<div class="col-md-8">
				<div class="page-header">
					<h1>角色管理 <small><a href="{:url('admin/rbac/add')}" class="btn btn-primary navbar-right" >添加</a></small></h1>
				</div>
				<div class="bs-example" data-example-id="striped-table">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>#</th>
								<th>角色名称</th>
								<th>角色描述</th>
								<th>状态</th>
								<td>操作</td>
							</tr>
						</thead>
						<tbody>
							{volist name="role" id="item"}
							<tr>
								<th scope="row">{$item->id}</th>
								<td>{$item->name}</td>
								<td>{$item->remark}</td>
								<td>{$role_status[$item->status]}</td>
								<th>
									<a href="{:url('admin/rbac/auth',['id'=> $item->id])}" class="btn btn-info">权限设置</a>
									<a href="{:url('admin/rbac/modify',['id'=> $item->id])}" class="btn btn-primary">修改</a>
									<a href="{:url('admin/rbac/delete',['id'=> $item->id])}" class="btn btn-danger">删除</a>
								</th>
								
							</tr>
							{/volist}
						</tbody>
					</table>
				</div>			
		</div>


		

	</div>












{/block}