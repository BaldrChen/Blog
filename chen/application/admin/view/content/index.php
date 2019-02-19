<?php

{extend name="glob/base" /}
{block name="content"}
	<div class="row">
		<div class="col-md-8">
				<div class="page-header">
					<h1>内容 <small><a href="{:url('admin/content/add')}" class="btn btn-primary navbar-right" >添加</a></small></h1>
				</div>

				<form class="form-inline" action="{:url('admin/content/index')}" method="get">
					<div class="form-group">
						<label for="exampleInputName2">关键字：</label>
						<input type="text" class="form-control" id="key" name='key' placeholder="输入关键字进行搜索" value="{$ckey|default=""}">
					</div>
					<button type="submit" class="btn btn-default">搜索</button>
				</form>


				<div class="bs-example" data-example-id="striped-table">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>#</th>
								<th>标题</th>
								<th>管理员</th>
								<th>用户</th>
								<th>创建时间/修改时间</th>
								<th>状态</th>
								<th>允许评论</th>
								<th>评论审核</th>
								<td>管理</td>
							</tr>
						</thead>
						<tbody>
							
							{volist name="cData" id="list" }
							<tr>
								<th scope="row">{$list->id}</th>
								<td><a href="{$list->url}">{$list->caption}...</a></td>
								<td>{$list->chen_admin_user->username|default=''}</td>
								<td>{$list->chen_qq_user->nick|default=''}</td>
								<td>{$list->create_time|date='Y-m-d H:i:s'}<br />{$list->update_time|date='Y-m-d H:i:s'}</td>


								<td>
									<a href='{:url("admin/content/status",["id"=>$list->id,"differ"=>"content", "type"=>"content", "status"=>$list->content_status])}' class="btn btn-default">{$content_status[$list->content_status]}</a>
								</td>

								<td>
									<a href='{:url("admin/content/status",["id"=>$list->id,"differ"=>"content", "type"=>"comment", "status"=>$list->comment_status])}' class="btn btn-default">
										{$comment_status[$list->comment_status]}
									</a>
								</td>

								<td>
									<a href='{:url("admin/content/status",["id"=>$list->id,"differ"=>"content", "type"=>"examine", "status"=>$list->examine_status])}' class="btn btn-info">
										{$examine_status[$list->examine_status]}
									</a>
								</td>

								<th>
									<a href="{:url('admin/content/modify',["id"=>$list->id])}" class="btn btn-primary">修改</a>
									<a href="{:url('admin/content/del',["id"=>$list->id,"differ"=>"content"])}" class="btn btn-primary">删除</a>
								</th>
								
							</tr>
						{/volist}
						</tbody>
					</table>
					{$cData->render()|raw}
				</div>			
		</div>


		

	</div>












{/block}