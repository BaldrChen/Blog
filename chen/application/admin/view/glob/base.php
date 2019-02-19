<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" href="{:url('/static/layui/css/layui.css')}">
		<script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.js"></script>
		<script src="{:url('/static/layui/layui.js')}"></script>
		<script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<link rel="stylesheet" type="text/css" href="{:url('static/simditor/styles')}/simditor.css" />
		{block name='header'}{/block}
		<title>{$webname} - {block name='webname'}{/block}</title>
	</head>
	<body>
		<nav class="navbar navbar-default">
			<div class="container-fluid">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="{:url('admin/index/index')}">后台管理页</a>
				</div>

				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav">
						<li class="active"><a href="#">Link <span class="sr-only">(current)</span></a></li>
						<li><a href="#">Link</a></li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">欢迎，{$user->username} <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="#">暂留</a></li>
								<li role="separator" class="divider"></li>
								<li><a href="{:url('admin/login/logout')}">退出</a></li>
							</ul>
						</li>
					</ul>
				</div><!-- /.navbar-collapse -->
			</div><!-- /.container-fluid -->
		</nav>
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-2">
					<div class="layui-collapse" lay-accordion="">
						<div>
							{volist name="menu" id="m"}
							
								{if $m['action'] == 'default'}
						</div>
									<div class="layui-colla-item">
										<h2 class="layui-colla-title">{$m['name']}</h2>
									{elseif $m['action'] !== 'default'}
										<a class="layui-colla-content" href="{:url($m['url'])}">{$m['name']}</a>
										
								{/if}
							{/volist}
									</div>
					</div>
				</div>
				<div class="col-md-10">{block name="content"}动态区域{/block}</div>

			</div>
			
		</div>

	</body>
	<script>
		layui.use(['element', 'layer'], function(){
		  var element = layui.element;
		  var layer = layui.layer;
		  
		  //监听折叠
		  element.on('collapse(test)', function(data){
		    layer.msg('展开状态：'+ data.show);
		  });
		});
</script>
</html>
