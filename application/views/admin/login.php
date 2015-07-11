<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title></title>
        <meta name="description" content="">

		<link rel="shortcut icon" href="<?=base_url()?>favicon.ico" type="image/x-icon">
		<link rel="icon" href="<?=base_url()?>favicon.ico" type="image/x-icon">
		<link rel="stylesheet" href="<?=base_url()?>include/css/bootstrap.css">
		<link rel="stylesheet" href="<?=base_url()?>include/css/font-awesome.css">
		<link rel="stylesheet" type="text/css" href="<?=base_url()?>include/css/alertify.core.css" />
		<link rel="stylesheet" type="text/css" href="<?=base_url()?>include/css/alertify.bootstrap.css" />
        <link rel="stylesheet" href="<?=base_url()?>include/css/login.css">
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script>window.jQuery || document.write('<script src="<?=base_url()?>include/js/vendor/jquery-1.10.2.min.js"><\/script>')</script>
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
		<script>
			var base_url = "<?=base_url()?>";
		</script>
		<script src="<?=base_url()?>include/js/alertify.js"></script>
		<script src="<?=base_url()?>include/js/vendor/bootstrap.min.js"></script>
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        <div id="container">
			<div id="login_box">	
				<div class="box_content">
					<img src="//placehold.it/180x55" id="main_logo" />
					
					<?if(!empty($error)){?>
					<div class="alert alert-danger" role="alert">
						<i class="fa fa-exclamation-triangle"></i>
						<?=$error?>
					</div>
					<?}?>
					<form role="form" id="form_user_login" action="<?=site_url("user/login_panel")?>" method="post" class="form-actions">
						<?=form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash())?>
						<div class="form-group">
							<label for="email">Correo</label>
							<input id="email" type="text" class="form-control" name="email" onfocus="if (this.value == 'Correo') {this.value =''} " onblur="if (this.value =='') {this.value = 'Correo'}" value="Correo">
						</div>
						<div class="form-group">
							<label for="password">Contraseña</label>
							<input id="password" type="password" class="form-control" name="password" autocomplete="off" value="">
						</div>
						<div class="form-group">
							<label for="captcha">Escribir el código de validación:</label>
							<div id="content_captcha">
								<img id="captcha_img" class="captcha" src="<?=site_url("captcha")?>"/>
								
								<div class="input-group">
									
									<input id="captcha" type="text" class="form-control" name="captcha" autocomplete="off" onfocus="if (this.value == 'Código de Validación') {this.value =''} " onblur="if (this.value =='') {this.value = 'Código de Validación'}" value="Código de Validación">
									<span class="input-group-btn">
										<button id="" class="btn btn-default refresh_captcha" type="button"><i class="fa fa-refresh"></i></button>
									</span>
								</div>
							</div>
						</div>
						<button type="submit" class="btn btn-primary">Ingresar</button>
					</form>
				</div>
			</div>
		</div>
		<script type="text/javascript">
		$(function(){
			$("body").on("submit","#form_user_login",function(e){
				e.preventDefault();
				$.ajax({
					url: $(this).attr("action"),
					method: $(this).attr("method"),
					data: $(this).serialize()
				})
				.done(function(data){
					data = eval("("+data+")");
					if(typeof data.success != "undefined"){
						if(data.success == 1){
							alertify.success(data.data);
							if(typeof data.href != "undefined"){
								location.href = data.href;
							}
						}else if(typeof data.errors != "undefined"){
							var error_string = '';
							for(key in data.errors){
								error_string += data.errors[key]+"<br/>";
							}
							alertify.alert( error_string );
						}else{
							alertify.error( data.data );
						}
					}else{
						alertify.error( data.data );
					}
				})
				.fail(function(){})
				.always(function(){
					$(".captcha").attr("src", base_url+"captcha?"+Math.random());
				});
			});
			
			$(document).on("click",".refresh_captcha", function(e){
				e.preventDefault();
				$(".captcha").attr("src", base_url+"captcha?"+Math.random());
			});
		});
		</script>
    </body>
</html>