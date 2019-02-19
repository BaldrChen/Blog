{extend name="glob/base" /}


{block name="sidebar"}
	{include file='glob/sidebar_usercenter'}
{/block}
{block name="content"}


	<div class="col-md-8">
		<div class="page-header">
			<h1>头像上传</h1>
		</div>
		<div class="bs-example" data-example-id="striped-table">

			<img class=" center-block " src="{:url($img)}" alt="我的头像" />



			<form enctype="multipart/form-data" method="post" action="{:url('index/userhead/upload')}" class="form-horizontal">
				{:token()}

				<div style="margin-top: 20px" class="form-group">
					<label for="username" class="col-sm-2 control-label">上传头像</label>
					<div class="col-sm-9">
						<input type="file" name="image" /> <br> 
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

{/block}