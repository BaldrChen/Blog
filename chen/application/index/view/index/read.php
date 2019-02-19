{extend name="glob/base" /}
{block name='webname'}
	{$blogitem->title}
{/block}
{block name='header'}
		<script type="text/javascript" src="{:url('static/simditor/scripts')}/module.js"></script>
		<script type="text/javascript" src="{:url('static/simditor/scripts')}/hotkeys.js"></script>
		<script type="text/javascript" src="{:url('static/simditor/scripts')}/uploader.js"></script>
		<script type="text/javascript" src="{:url('static/simditor/scripts')}/simditor.js"></script>
{/block}
{block name="content"}
	<div class="text-center">
		<h2>{$blogitem->title}</h2>
	</div>
	

	{if $blogitem->chen_qq_user}
	<p class="text-center text-muted">
		<span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>：{$blogitem->hits}
		&nbsp;&nbsp;
		日期：{$blogitem->create_time}</a>
		&nbsp;&nbsp;&nbsp;&nbsp;
		作者：{$blogitem->chen_qq_user->nick}</a>
		&nbsp;&nbsp;
		<img class="img-circle" height="25" src="{$blogitem->chen_qq_user->images}" />
	</p>
	{/if}

	{if !$blogitem->chen_qq_user}

	<p class="text-center text-muted">
		<span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>：{$blogitem->hits}
		&nbsp;&nbsp;
		日期：{$blogitem->create_time}
		&nbsp;&nbsp;&nbsp;&nbsp;
		作者：<span style="color:red">BALDR</span>
		&nbsp;&nbsp;
		<img height="25" src="{:url('/static/head_portrait/admin.jpg')}" />
	</p>
	{/if}

	<div class="well clarity" >{$blogitem->content|raw}</div>

	<hr/>

	<div >
		<div >

		 	<h3 class="text-muted"><span class="glyphicon glyphicon-edit" aria-hidden="true">评论</span></h3>

		</div>
		{volist name="comitem" id="comment"}
		<div class="well clarity" >
			<p class="text-right text-muted">
				日期：{$comment->create_time} 
				&nbsp;&nbsp;&nbsp;&nbsp;
				{if $comment->chen_qq_user->id == 1}
					留言人：<span style="color:red">博主</span>
				{/if}

				{if $comment->chen_qq_user->id != 1}
					留言人：{$comment->chen_qq_user->nick}
				{/if}
				&nbsp;&nbsp;
				<img height="25" src="{$comment->chen_qq_user->images}" />
			</p>
			<p>{$comment->comment|raw}</p>

		</div>	
		<hr/>
		{/volist}
		{$comitem|raw}


	</div>

	{if !$quser}
	<div  class="alert alert-danger " role="alert">
		<p>
			请<a href="{:url('callback/index/login')}">登录</a>后进行评论
		</p>
	</div>
	{/if}

	{if $quser and !$blogitem->comment_status}
	<div  class="alert alert-danger " role="alert">
		<p>
			该文章已关闭评论
		</p>
	</div>
	{/if}



	{if $quser && $blogitem->comment_status}
	<div   class="bs-example" data-example-id="striped-table">
		<form method="post" action="{:url('index/index/comment')}" class="form-horizontal">
			{:token()}

			<input type="hidden" name="user_id" value='{$quser->id|default=""}'>
			<input type="hidden" name="content_id" value='{$blogitem->id|default=""}'>
			<div class="form-group">
				<textarea  name="comment" id="comment" placeholder="请自觉遵守相关政策法规，严禁发布色情暴力反动的言论" autofocus ></textarea>
			</div>
			

			<div class="form-group">
				<div class="pull-right">
					<button type="submit" class="btn btn-info">发表评论</button>
				</div>
			</div>
		</form>
	</div>
	{/if}







	<script>
		var editor = new Simditor({
		  textarea: $('#comment'),
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
			'hr',            
			'indent',
			'outdent',
			'alignment'
		  ],
		});

	</script>
{/block}