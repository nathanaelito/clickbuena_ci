<section id="home" class="container">
	<h1>Codeigniter Tuned - PEPSICO - MrJack</h1>
	
	<?if(!empty($logged_in)){?>
		<hr/>
		<h3>Sesión:</h3>
		<pre><? print_r($logged_in); ?></pre>
		<a class="btn btn-primary editar_perfil_modal" href="<?=base_url()?>#!/editar_perfil">Editar perfil</a>
		<a class="btn btn-primary" href="<?=site_url("user/logout")?>">Cerrar sesión</a>
	<?}?>
	
	<hr/>
	<h3>Lightbox:</h3>
	<a class="terminos_modal btn btn-primary" href="<?=base_url()?>#!/terminos">Terminos y condiciones</a>
	<a class="privacidad_modal btn btn-primary" href="<?=base_url()?>#!/privacidad">Política de privacidad</a>
	
	<hr/>
	<h3>Registro:</h3>
	<?if( !empty($fbuser) ){?>
	<div class="alert alert-warning alert-dismissable">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<strong>Atención:</strong> Estás registrándote con tu cuenta de Facebook, si NO quieres enlazar tu cuenta de Facebook con la cuenta que estas creando
		da clic al siguiente <a id="facebook_cancel" data-dismiss="alert" href="#">enlace</a>.
	</div>
	<?}?>
	
	<form role="form" id="form_user_register" action="<?=site_url("user/register")?>" method="post" class="form-horizontal">
		<?=form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash())?>

		<div class="form-group">
			<label for="name" class="col-sm-4 control-label">Nombre</label>
			<div class="col-sm-8">
				<input id="name" type="text" class="form-control" name="name" value="<?=!empty($name)?$name:""?>">
			</div>
		</div>
		<div class="form-group">
			<label for="lastname" class="col-sm-4 control-label">Apellidos</label>
			<div class="col-sm-8">
				<input id="lastname" type="text" class="form-control" name="lastname" value="<?=!empty($lastname)?$lastname:""?>">
			</div>
		</div>
		<div class="form-group">
			<label for="email" class="col-sm-4 control-label">Correo electrónico</label>
			<div class="col-sm-8">
				<input id="email" type="text" class="form-control" name="email" value="<?=!empty($email)?$email:""?>">
			</div>
		</div>
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
			<label for="captcha" class="col-sm-12 label_arial">Ingresa la palabra que veas en la imagen:</label>
			<div class="col-sm-6">
				<img class="captcha" src="<?=base_url()?>captcha">&nbsp;
				<a href="#" class="refresh_captcha"><i class="fa fa-refresh"></i></a>
				<div style="clear:both"></div>
			</div>
			<div class="col-sm-6">
				<input id="captcha" type="text" class="form-control" name="captcha" value="">
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6">
				<div class="checkbox">
					<label for="privacy_cbox" class="label_arial">
						<input name="privacy_cbox" type="checkbox"> Acepto <a href="<?=base_url()?>#!/privacidad" class="privacidad_modal">Aviso de privacidad</a>
					</label>
				</div>
			</div>
			<div class="col-sm-6">
				<input type="submit" class="btn btn-primary btn_enviar pull-right" value="Enviar"/>
			</div>
		</div>	
	</form>
	
	<hr/>
	<h3>Login con Facebook:</h3>
	<a href="<?=site_url("social/facebook_request")?>" class="btn btn-primary">Entrar con Facebook</a>
	
	<hr/>
	<h3>Login:</h3>
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
	
	<hr/>
	<h3>Recuperar contraseña:</h3>
	<form role="form" id="form_user_send_recovery" action="<?=site_url("user/send_recovery")?>" method="post" class="form-horizontal">
		<?=form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash())?>

		<div class="form-group">
			<label for="email" class="col-sm-4 control-label">Correo electrónico</label>
			<div class="col-sm-8">
				<input id="email" type="text" class="form-control" name="email" value="">
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<input type="submit" class="btn btn-primary btn_enviar pull-right" value="Enviar"/>
			</div>
		</div>	
	</form>

	<hr/>
	<h3>Contacto:</h3>
	<form role="form" id="form_contact_send" action="<?=site_url("contact/send")?>" method="post" class="form-horizontal">
		<?=form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash())?>
		<p class="contact_subtitle">Por favor ingresa los siguientes datos.</p>
		<p class="contacto_obligatorios">Todos los campos son obligatorios</p>
		
		<div class="contact_div_ele">
			<div class="form-group">
				<label for="nombre" class="col-sm-4 control-label">Nombre completo</label>
				<div class="col-sm-8">
					<input id="name" type="text" class="form-control" name="name">
				</div>
			</div>
			<div class="form-group">
				<label for="email" class="col-sm-4 control-label">Correo electrónico</label>
				<div class="col-sm-8">
					<input id="email" type="text" class="form-control" name="email">
				</div>
			</div>
			<div class="form-group">
				<label for="message" class="col-sm-4 control-label">Mensaje</label>
				<div class="col-sm-8">
					<textarea id="message" class="form-control" name="message" autocomplete="off"></textarea>
				</div>
			</div>
			<div class="form-group">
				<label for="captcha" class="col-sm-12 label2">Ingresa la palabra que veas en la imagen:</label>
				<div class="col-sm-6">
					<img class="captcha" src="<?=base_url()?>captcha">&nbsp;
					<a href="#" class="refresh_captcha"><i class="fa fa-refresh"></i></a>
					<div style="clear:both"></div>
				</div>
				<div class="col-sm-6">
					<input id="captcha" type="text" class="form-control" name="captcha">
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<div class="checkbox">
						<label class="label2">
							<input name="privacy_cbox" type="checkbox"> Acepto <a href="<?=base_url()?>#!/privacidad" class="privacidad_modal">Aviso de privacidad</a>
						</label>
					</div>
				</div>
				<div class="col-sm-6">
					<input type="submit" class="btn btn-primary btn_enviar pull-right" value="Enviar"/>
				</div>
			</div>
		</div>	
	</form>
	
	<hr/>
	<h3>Lugares:</h3>
	
	<div class="row">
		<div class="col-xs-12 col-sm-6 form-group">
			<label for="zipcode" class="vl-text-azul">C. P.</label>
			<input id="zipcode" name="zipcode" type="text" class="form-control numeric" maxlength="5">
		</div>
		<div class="col-xs-12 col-sm-6 form-group">
			<label for="state" class="vl-text-azul">Estado</label>
			<select id="state" name="state" class="form-control"></select>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12 col-sm-6 form-group">
			<label for="city" class="vl-text-azul">Municipio</label>
			<select id="city" name="city" class="form-control"></select>
		</div>
		<div class="col-xs-12 col-sm-6 form-group">
			<label for="ward" class="vl-text-azul">Colonia</label>
			<select id="ward" name="ward" class="form-control"></select>
		</div>
	</div>
	
	<hr/>
	<a name="redencion"></a>
	<h3>Redención:</h3>
	<form role="form" id="" action="<?=site_url("redemption/redeem")?>" method="post" class="form_redemption_redeem form-horizontal">
		<?=form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash())?>
			
		<div class="form-group">
			<label for="code" class="col-sm-4 control-label">Código</label>
			<div class="col-sm-8">
				<input id="code" type="text" class="form-control" name="code" value="<?=(!empty($codigo))?$codigo:""?>" maxlength="10" />
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<input type="submit" class="btn btn-primary btn_enviar pull-right" value="Enviar"/>
			</div>
		</div>	
	</form>
	
	<script>
		$(function(){
			builder.states();
			builder.cities("1");
			builder.wards("1");
		});
	</script>
	
</section>
<br/>
<br/>
<br/>
<br/>