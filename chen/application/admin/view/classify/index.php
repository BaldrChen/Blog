<?php

{extend name="glob/base" /}
{block name="content"}
	<div class="row">
		<div class="col-md-8">
			<div class="page-header">
				<h1>分类管理 <small><input style="width: 120px;" id="class_add" type="bottom" class="btn btn-primary pull-right" onclick="values('0','add')" data-toggle="modal" data-target="#myModal" value="增加一级分类" /></h1>
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
									<th>栏目名称</th>
									<th>创建时间</th>
									<th>所属分类</th>
									<th>增加子分类</th>
									<td>管理</td>
								</tr>

							</div>

						</thead>
						<tbody>
							
						{volist name="cdata" id="item"}
						<div id="{$item['id']}">

							<tr>
								<th scope="row">{$item['id']}</th>
									<?php
										$distance = $item['level'] * 20;
									?>
									<td class="bg-info" style="padding-left:{$distance}px;">
										{if $distance}
											<span class="glyphicon glyphicon-share-alt" aria-hidden="true"></span>
										{/if}
										{$item['name']}
									</td>



 
								<td>{$item['create_time']}</td>
								<td>{$classify_level[$item['level']]}</td>

								<td>
									<input style="width: 70px;" id="class_add" type="bottom" class="btn btn-primary" onclick="values({$item['id']},'add')" data-toggle="modal" data-target="#myModal" value="增加" />
									/
									<input style="width: 70px;" id="class_add" type="bottom" class="btn btn-primary" onclick="values({$item['id']},'modify')" data-toggle="modal" data-target="#myModal" value="修改" />
								</td>
								<td><a href="{:url('admin/classify/del',["id"=>$item['id']])}" class="btn btn-primary">删除</a></td>


							
							</tr>
						</div>

						{/volist}	
						</tbody>
					</table>

				</div>		




			</div>			
		</div>
		<!-- Modal -->
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" >
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">添加分类</h4>
					</div>
					<form action="{:url('admin/classify/save')}" method="post">
						<div class="modal-body">
							{:token()}
							<input type="hidden" id='item_id' name='father_id' value="">
							<input type="hidden" id='type' name='type' value="">
							<div style="height: 15px;">
								<label  class="col-sm-2 control-label">分类名:</label>
								<input class="col-md-5 " type="text" class="form-control" name="classname" value="">
							</div>
							
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
							<button type="submit" class="btn btn-primary">确定</button>
						</div>
					</form>



				</div>
			</div>
		</div>

		

	</div>






<script>
	function values(id,type){
		$("#item_id").val(id);
		$("#type").val(type);
	}
	$(document).ready(function(){
		
	});
</script>





{/block}