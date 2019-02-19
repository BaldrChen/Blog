{extend name="glob/base" /}


{block name="sidebar"}
	{include file='glob/sidebar_usercenter'}
{/block}
{block name="content"}<div class="row">
		<div class="col-md-8">
				<div class="page-header">
					<h1>个人资料</h1>
				</div>
				<div class="bs-example" data-example-id="striped-table">
					<form method="post" action="{:url('index/usercenter/profile_save')}" class="form-horizontal">
						{:token()}

						<div class="form-group">
							<label for="username" class="col-sm-2 control-label">用户名</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" name="username" id="username" value='{$user->username|default=""}' disabled>
							</div>
						</div>

						<div class="form-group">
							<label for="passwd" class="col-sm-2 control-label">密码</label>
							<div class="col-sm-9">
								<input type="password" class="form-control" name="passwd" id="passwd" placeholder="不修改密码请留空">
							</div>
						</div>

						<div class="form-group">
							<label for="nick" class="col-sm-2 control-label">昵称</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" name="nick" id="nick" value='{$user->nick|default=""}'>
							</div>
						</div>

						<div class="form-group">
							<label for="phone" class="col-sm-2 control-label">手机</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" name="phone" id="phone" value='{$user->phone|default=""}'>
							</div>
						</div>

						<div class="form-group">
							<label for="email" class="col-sm-2 control-label">邮箱</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" name="email" id="email" value='{$user->email|default=""}'>
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