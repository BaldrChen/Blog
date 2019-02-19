 	<div  class="row media clarity">
		<div style="padding: 15px;" class="col-md-3 media-left">
			<a href='{$item->url}'>
				<img width="100%" height="160" class="media-object img-rounded" src="{$item->image}" alt="...">
			</a>
		</div>
		<div style="padding: 10px;" class="col-md-9">
			<h4 class="media-heading fixed-bottom"><a href='{$item->url}'>{$item->title}</a></h4>
			<br/>
			{if $item->chen_qq_user}
			<p class="text-muted pull-right"><img width="35" src="{$item->chen_qq_user->images}" class="img-circle" alt=""></p>
			<p class="text-muted pull-right">作者：{$item->chen_qq_user->nick}</a></p>
			{/if}

			{if !$item->chen_qq_user}
			<div>
			<p class="text-muted pull-left">
				<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
				<span>&nbsp;BALDR</span>
				&nbsp;&nbsp;&nbsp;&nbsp;
			</p>
			
			<p class="text-muted pull-left">
				<span class="glyphicon glyphicon-time" aria-hidden="true"></span>
				<span>&nbsp;{$item->create_time|date='Y-m-d'}</span>
				&nbsp;&nbsp;&nbsp;&nbsp;
			</p>

			<p class="text-muted">
				<span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
				<span>&nbsp;{$item->hits}浏览</span>
			</p>

			</div>
			{/if}
			<br/>
			<p  class="text-muted">{$item->intra}...</p>

		</div>
	</div>