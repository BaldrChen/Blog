{extend name="glob/base" /}
{block name='webname'}注册{/block}
{block name="content"}
	<div class="row">
		<div class="col-md-9">
				<div class="page-header">
					<h1>注册</h1>
				</div>
				<div class="bs-example" data-example-id="striped-table">
					<form method="post" action="{:url('index/sign/up_save')}" class="form-horizontal">
						{:token()}
						<div class="form-group">
							<label for="username" class="col-sm-2 control-label">用户名</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" name="username" id="username" >
							</div>
						</div>

						<div class="form-group">
							<label for="passwd" class="col-sm-2 control-label">密码</label>
							<div class="col-sm-9">
								<input type="password" class="form-control" name="passwd" id="passwd">
							</div>
						</div>

						<div class="form-group">
							<label for="nick" class="col-sm-2 control-label">昵称</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" name="nick" id="nick" >
							</div>
						</div>

						<div class="form-group">
							<label for="phone" class="col-sm-2 control-label">手机</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" name="phone" id="phone" >
							</div>
						</div>

						<div class="form-group">
							<label for="email" class="col-sm-2 control-label">邮箱</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" name="email" id="email">
							</div>
						</div>


						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<button type="submit" class="btn btn-default">注册</button>
							</div>
						</div>
					</form>

				</div>			
		</div>


		

	</div>








{/block}