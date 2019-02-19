<div class="list-group">
<div class="list-group-item clarity">
    <div class="thumbnail">
      <img class="img-circle" height="200" width="200" src="/static/images/myhead.jpg" alt="...">
      <div class="caption">
        <h4 class="text-center">baldrchen | 陈家阳</h4>
        <p class="text-warning">是一个记录自己生活点滴、互联网技术的独立博客。</p>
      </div>
    </div>
</div>

</div>


<div class="list-group">
	<h4 class="list-group-item ">
	 优秀博文
	</h4>
	{volist name="newBlogs" id="item"}
		<a href="{$item->url}" class="list-group-item clarity">{$item->title}</a>
	{/volist}
</div>

<div class="list-group">
  <h4 class="list-group-item ">
   程序杂编
  </h4>
  
    <a href="{:url('index/statistics/index')}" class="list-group-item clarity">网站访问统计</a>

</div>