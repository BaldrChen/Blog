<div class="list-group" >
	<p class="list-group-item active">
	 分类导航
	</p>


		<div id="tree ">
			{volist name="classify" id="item"}
				{if $item['pid'] == '0'}
				<div id="f{$item['id']}" style="position:relative;">
					<?php $one_id = $item['id'];?>
					<a href="{:url("index/index/class",['id'=>$item['id']])}" class="list-group-item">{$item['name']}</a>
					<div id="s{$item['id']}" style="z-index:1050;display:none;position:absolute;width: 250px;height: 150px;background: #FAFAFA;left: 166px;top:0px;">
					{volist name="classify" id="hello"}
						{if $hello['pid'] == $one_id}
							<div class="list-group"  id="{$hello['id']}" ">
								<a href="{:url("index/index/class",['id'=>$hello['id']])}" class="list-group-item">{$hello['name']}</a>
								
							</div>
						{/if}
					{/volist}


					</div>


				</div>
				{/if}



			{/volist}

		</div>



</div>
<script>
	var data = <?php echo json_encode($classify) ?> 
	$(document).ready(function(){
		function slide(){
			$.each(data,function(index,obj){
				if (obj.pid == 0) {
					var f = "#f"+obj.id;
					var s = "#s"+obj.id;
					$(f).mouseover(function(){
						$(s).css({'display':''});
					}).mouseout(function(){
						$(s).css({'display':'none'});
					});
				}
			});
		}
		slide();
	});



</script>