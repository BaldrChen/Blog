<?php

{extend name="glob/base" /}
{block name="content"}
	<div class="row">
		<div class="col-md-8">
				<div class="page-header">
					<h1>管理员 <small><a href="{:url('admin/auser/add')}" class="btn btn-primary navbar-right" >添加</a></small></h1>
				</div>
				<div class="bs-example" data-example-id="striped-table">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>#</th>
								<th>用户名</th>
								<td>操作</td>
							</tr>
						</thead>
						<tbody>
						{volist name="auData" id="list" }
							<tr>
								<th scope="row">{$list->id}</th>
								<td>{$list->username}</td>
								<th>
									<a href="{:url("admin/auser/modify",["id"=>$list->id])}" class="btn btn-primary">修改</a>
									<a href="{:url("admin/auser/del",["id"=>$list->id])}" class="btn btn-danger">删除</a>
								</th>
								
							</tr>
						{/volist}
						</tbody>
					</table>
				</div>


		</div>


		

	</div>












{/block}