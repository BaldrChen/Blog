<?php

{extend name="glob/base" /}

{block name="content"}
	<div class="row">
		<div class="col-md-8">
				<div class="page-header">
					<h1>权限设置</h1>
				</div>
				<div class="bs-example" data-example-id="striped-table">
					<form method="post" action="{:url('admin/rbac/auth_save')}" class="form-horizontal">
						
						<input type="hidden" name="id" value='{$id|default=""}'>
						<div class="col-md-5" id="tree"></div>
							


						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10 pull-left">
								<button type="submit" class="btn btn-default">提交</button>
							</div>
						</div>
					</form>

				</div>			
		</div>



		

	</div>





<script>
	var json = <?php echo $auth_tree;?>;
	var menu_id = <?php echo $menu_id;?>;
	var tree = $("#tree");

	function checkTree(pid,container,level=0){

		$.each(json,function(index,obj){
			
		if (obj.pid == pid) {
			
			container.append("<div id='t"+obj.id+"'><input type='checkbox' class='tree_box' id='c"+obj.id+"' name='menu_id[]' value="+obj.id+" >"+obj.name+"</div>");
			level++;
			checkTree(obj.id,$("#t"+obj.id),level);
		}
		
		});	
	}
	checkTree(0,tree);

	$(".tree_box").click(function(){
	  var is = $(this).prop('checked');
	  var id = $(this).val();

	  parent(id,is);

	  $("#t"+id).find("input").each(function(){
	  	$(this).prop('checked',is);
	  });
	});

	function parent( id, is){
		var obj = json[ id ];
		if (obj.pid > 0) {
			
			if (is) {
				$("#c"+obj.pid).prop('checked',is);
			}
			parent(obj.pid,is);
		}
	}
	$(document).ready(function(){
		$.each(menu_id,function(index,obj){
			$("#c"+obj.menu_id).prop('checked','true');
			
		});	
	});	
	
</script>

<style type="text/css">
	#tree div{
		margin-left:20px;
	}


</style>




{/block}