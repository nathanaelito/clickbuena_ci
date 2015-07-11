<div class="modal_login modal fade" id="aviso" tabindex="-1" role="dialog" aria-labelledby="meta_modalLabel" aria-hidden="true">
	<div class="">
		<div class="modal-header">
			<div class="cont-close">
				<div class="close modal-close_x" data-dismiss="modal" aria-hidden="true"></div>
			</div>
			<h2 class="">Ingresar</h2>
		</div>

		<div class="modal-body body_legales">
			<div class="modal-padd">
                <form role="form" id="form_user_login" action="<?=site_url("user/login")?>" method="post" class="form-horizontal">
					<?=form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash())?>

					<div class="form-group">
						<label for="email" class="col-sm-4 control-label">Correo electrónico</label>
						<div class="col-sm-8">
							<input id="email" type="text" class="form-control" name="email" value="">
						</div>
					</div>
					<div class="form-group">
						<label for="password" class="col-sm-4 control-label">Contraseña</label>
						<div class="col-sm-8">
							<input id="password" type="password" class="form-control" name="password" autocomplete="off" value="">
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<input type="submit" class="btn btn-primary btn_enviar pull-right" value="Enviar"/>
						</div>
					</div>	
				</form>
			</div>
		</div>
	</div>
</div>