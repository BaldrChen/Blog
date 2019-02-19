{extend name="glob/base" /}

{block name="content"}
	<div class="jumbotron">
		<h1>{$homeUser->nick}的个人博客</h1>
		<p>这里是简介</p>
	</div>
	<div class="page-header">
		<h1>他的文章</h1>
	</div>
	{volist name="newData" id="item"}
		{include file='glob/blogitem'}
	{/volist}
	{$newData->render()|raw}
{/block}