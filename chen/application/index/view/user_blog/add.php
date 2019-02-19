{extend name="glob/base" /}
{block name="sidebar"}
	{include file='glob/sidebar_usercenter'}
{/block}
{block name='header'}
		<script type="text/javascript" src="{:url('static/simditor/scripts')}/module.js"></script>
		<script type="text/javascript" src="{:url('static/simditor/scripts')}/hotkeys.js"></script>
		<script type="text/javascript" src="{:url('static/simditor/scripts')}/uploader.js"></script>
		<script type="text/javascript" src="{:url('static/simditor/scripts')}/simditor.js"></script>
{/block}
{block name="content"}
	<div class="row">
		<div class="col-md-12">
				<div class="page-header">
					<h1>添加博客</h1>
				</div>
				<div class="bs-example" data-example-id="striped-table">
					<form method="post" action="{:url('index/userblog/save')}" class="form-horizontal">
						{:token()}

						<input type="hidden" name="id" value='{$item->id|default=""}'>
						<div class="form-group">
							<label for="title" class="col-sm-2 control-label">标题</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="title" id="title" value='{$item->title|default=""}' >
							</div>
						</div>

						<div class="form-group">
							<label for="chen_classify_id" class="col-sm-2 control-label">所属分类</label>
							<div class="col-sm-3">
								<select name="chen_classify_id"  id="chen_classify_id" class="form-control col-sm-5">
									{volist name="tree" id="class"}
									<?php
										$distance = $class['level'];
									?>
									<option style="padding-left:{$distance}px;" value="{$class['id']}">
										{if $distance}
											{for start="0" end="$distance"}
											{$nbsp = '&nbsp;'|raw}
											{/for}

											┗
										{/if}
										{$class['name']}

									</option>
									{/volist}
								</select>
							</div>


						</div>


						<div class="form-group">
							<label for="content" class="col-sm-2 control-label">内容</label>
							<div class="col-sm-10">
								<textarea name="content" id="content" class="form-control" rows="20" >{$item->content|default=""}</textarea>
							</div>
						</div>
						<script>
							var editor = new Simditor({
							  textarea: $('#content'),
							  toolbar:[
								'title',
								'bold',
								'italic',
								'underline',
								'strikethrough',
								'fontScale',
								'color',
								'ol',            
								'ul',          
								'blockquote',
								'code',        
								'table',
								'link',
								'image',
								'hr',            
								'indent',
								'outdent',
								'alignment'
							  ],
							  upload:{
							  	url:"{:url('index/userblog/up')}",
							  	params:{

							  	},
							  	fileKey:"file1",
							  	leveCinfirm:"文件上传中 确定离开本页面？"
							  },
							  pasteImage:true
							});
						</script>

	
						<div class="form-group">
							<label for="content_status" class="col-sm-2 control-label">状态</label>
							<div class="col-sm-3">
								<select name="content_status" id="content_status" class="form-control col-sm-5">
									{volist name="content_status" id="row"}
									<option value="{$key}">{$row}</option>
									{/volist}
								</select>
							</div>


						</div>


						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<button type="submit" class="btn btn-default">提交</button>
							</div>
						</div>
					</form>

				</div>			
		</div>


		

	</div>



<script>
	$("#content_status") .val({$item->content_status|default="1"});
	$("#chen_classify_id") .val({$item->chen_classify_id|default="1"});
	
</script>





{/block}