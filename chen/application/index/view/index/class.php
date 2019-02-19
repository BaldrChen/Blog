{extend name="glob/base" /}
{block name='webname'}{$classname->name}{/block}
{block name="content"}
	<h3>{$classname->name}</h3>


	<hr/>
	{volist name="classitem" id="item"}

		{include file='glob/blogitem'}

	{/volist}
	{$classitem->render()|raw}


{/block}