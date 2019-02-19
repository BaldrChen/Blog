
{extend name="glob/base" /}
{block name='webname'}
首页
{/block}
{block name="slide"}

{/block}


{block name="content"}

	
	{volist name="newData" id="item"}
		{include file='glob/blogitem'}
	{/volist}
	{$newData->render()|raw}
{/block}