<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" href="{:url('static/css/index.css')}">
		<script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.js"></script>
		<script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<link rel="stylesheet" type="text/css" href="{:url('static/simditor/styles')}/simditor.css" />
		{block name='header'}{/block}
		<title>{block name='webname'}{/block} - {$webname}</title>
	</head>
	<!-- 页头导航栏 -->
	<body style="background:#eee;">
		<nav class="navbar navbar-inverse">
			<div class="container">
				
				<div class="navbar-header">

					<a class="navbar-brand">{$webname}</a>
				</div>

				
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav">
					<li class="active"><a href="{:url('/')}">首页 <span class="sr-only">(current)</span></a></li>
						{volist name="classify" id="item"}
						{if $item['pid'] == '0'}
							<li><a href="{:url("index/index/class",['id'=>$item['id']])}">{$item['name']}</a></li>
						{/if}
						{/volist}
					</ul>
					<ul class="nav navbar-nav navbar-right">
						{if !$quser}
						<li><a href="{:url('callback/index/login')}"> <img src="http://qzonestyle.gtimg.cn/qzone/vas/opensns/res/img/bt_white_76X24.png"></a></li>
						{/if}

						{if $quser}
						<img class="img-circle" height="40"  src="{$qimg}" alt="" />
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">欢迎,{$quser->nick} <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="{:url('callback/index/logout')}">退出</a></li>
							</ul>
						</li>
						{/if}
					</ul>
				</div>
			</div>
		</nav>
		<!-- 首页展示幻灯片 Power by Swiper 3.4.2 -->
		{block name="slide"}{/block}
		<!-- 页面主要内容 -->
		<div  class="container">
			<div class="row">
				{if $tplType == 'one'}
					<div class='col-sm-12'>
						{block name="content"}动态区域{/block}
					</div>
				{/if}

				{if $tplType == 'two'}

				<div class="col-md-9">{block name="content"}动态区域{/block}</div>

				<div class="col-md-3" >
					{block name='sidebar'}

						{include file='glob/sidebar_index' /}

					{/block}

				</div>
				
				{/if}

				{if $tplType == 'index'}

				<div class="col-md-8">{block name="content"}动态区域{/block}</div>
				<div class="col-md-4" >
					{block name='sidebar'}

						{include file='glob/sidebar_index' /}

					{/block}

				</div>
				{/if}

			</div>
		</div>
		<div  style="margin-bottom:85px;">
		</div>
		<div style="padding-top:20px;background:#222;" class=" clearfix text-center">
			<p class="text-muted">www.baldr.cn,All Rights Reserved.</p>
			<p class="text-muted">备案号：<a href="http://www.miitbeian.gov.cn/" target="_blank">闽ICP备18027061号</a>

		</div>
	</body>

</html>
