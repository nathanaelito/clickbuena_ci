<div id="content_recover" class="menu_space">	
	<div class="container">
		<div id="cositos_flotantes" class="cositos_flotantes"></div>
		<div id="recovery_content">
			<h1 class="recovery_title">Recuperar tu contraseña</h1>

			<form role="form" id="form_user_recover_password" action="<?=site_url("user/recover_password")?>" method="post" class="form-horizontal">
				<?=form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash())?>
				<div class="recovery_div_ele">
					<p class="recovery_subtitle">Escribe una nueva contraseña</p>
					
					<div class="form-group">
						<label for="password" class="col-sm-4 control-label">Contraseña</label>
						<div class="col-sm-8">
							<input id="password" type="password" class="form-control" name="password" autocomplete="off" value="">
						</div>
					</div>
					<div class="form-group">
						<label for="cpassword" class="col-sm-4 control-label">Confirmar contraseña</label>
						<div class="col-sm-8">
							<input id="cpassword" type="password" class="form-control" name="cpassword" autocomplete="off" value="">
						</div>
					</div>
					<div class="form-group">
						<label for="enviar" class="col-sm-4 control-label hidden-xs"></label>
						<div class="col-sm-8 col-xs-12">
							<button id="enviar" type="submit" class="btn_enviar btn btn-primary pull-right"> Enviar </button>
						</div>
					</div>
				</div>
			</form>	
		</div>
	</div>	
<div>