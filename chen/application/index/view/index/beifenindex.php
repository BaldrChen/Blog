
{extend name="glob/base" /}
{block name="slide"}
<link href="{:url('/static/slide/style.css')}" type="text/css" rel="stylesheet">
<div class="test row">
	<div class="poster-main">
		<div class="poster-btn poster-prev-btn"></div>
		<ul class="poster-list">
			<li class="poster-item"><a href="#"><img src="{:url('/uploads/slide/a1.png')}"></a>
				 <span class="poster-item-title">地球</span>
			</li>
			<li class="poster-item"><a href="#"><img src="{:url('/uploads/slide/a2.png')}"></a>
				 <span class="poster-item-title">星海</span>
			</li>
			<li class="poster-item"><a href="#"><img src="{:url('/uploads/slide/a3.png')}"></a>
				<span class="poster-item-title">火星</span>
			</li>
			<li class="poster-item"><a href="#"><img src="{:url('/uploads/slide/a4.png')}"></a>
				<span class="poster-item-title">星云</span>
			</li>
			<li class="poster-item"><a href="#"><img src="{:url('/uploads/slide/a5.png')}"></a>
				<span class="poster-item-title">蓝色地球</span>
			</li>
		</ul>
		<div class="poster-btn poster-next-btn"></div>
	</div>
</div>
<script src="http://www.jq22.com/jquery/jquery-1.10.2.js"></script>
<script src="{:url('/static/slide/Carousel.js')}"></script>
<script>
// 获取浏览器分辨率宽度
var w = window.screen.width;
var z = w-500;

$(".poster-main").Carousel({
"width":w,		
"height":545,		
"posterWidth":w,	
"posterHeight":515,
"scale":0.9,		
"speed": 500,	
"autoPlay":true,	
"delay":1500,	
"verticalAlign":"middle"	
});

</script>
{/block}


{block name="content"}

	
	{volist name="newData" id="item"}
		{include file='glob/blogitem'}
	{/volist}
	{$newData->render()|raw}
{/block}