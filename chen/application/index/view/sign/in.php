{extend name="glob/base" /}
{block name='webname'}登陆{/block}
{block name="content"}
		<div class="container" style="margin-top: 200px">
			<div class="row">
				<div class="col-md-4 col-md-offset-4 well" >

					<form class="form-horizontal" action="{:url('index/sign/in_check')}" method="post">
						{:token()}
						<div class="form-group">
							<label for="username" class="col-sm-3 control-label">用户名</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" name="username" id="username" placeholder="输入用户名">
							</div>
						</div>
						<div class="form-group">
							<label for="passwd" class="col-sm-3 control-label">密码</label>
							<div class="col-sm-9">
								<input type="password" class="form-control" name="passwd" id="passwd" placeholder="输入密码">
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-offset-3 col-sm-9">
								<button type="submit" class="btn btn-default">登录</button>
							</div>
						</div>
					</form>

				</div>
			</div>
		</div>

{/block}