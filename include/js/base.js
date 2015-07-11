var current_hash;
function check_hash(){
	if (location.hash == "" || location.hash == "#") {
		return;
	}

	var pos_hash = location.hash.indexOf("#!"); 
	if( pos_hash != -1  ){
		var n_hash = location.hash.substring(3, location.hash.length);
		current_hash = n_hash;
		hash_array = n_hash.split("/");
		switch( hash_array[0] ){
			case 'terminos':
				builder.terminos_modal();
			break;
			case 'privacidad':
				builder.privacidad_modal();
			break;
			default:
				history.replaceState({}, document.title, base_url );
			break;
		}
	}
}

function redimir( codigo, form ){
	if(codigo.length<10){
		alertify.alert("El código que ingresaste no existe");
		return;
	}
	
	if(! /^[a-z0-9]+$/i.test( codigo ) ){
		alertify.alert("El código debe tener solo letras y números");
		return;
	}
	
	form.find('input[type=submit]').attr('disabled', 'disabled');
	$.ajax({
		url: form.attr('action'),
		method: form.attr('method'),
		data: form.serialize()
	})
	.done(function(data){
		data = eval("("+data+")");
		if(typeof data.success != "undefined"){
			if(data.success==1){
				if( form.hasClass("form_redemption_captcha") ){
					$(".modal_redemption_captcha").modal('destroy');
				}
				
				alertify.alert("Código redimido correctamente");
				form[0].reset();
				//ga('send', 'event', 'redemption', 'send_code_success');
			}else if(typeof data.errors != "undefined"){
				var error = "";
				for(key in data.errors){
					error += data.errors[key] + "<br/>";
				}
				alertify.alert( error);
			}else{
				if( form.hasClass("form_redemption_captcha") ){
					$(".modal_redemption_captcha").modal('destroy');
				}
				
				switch(data.data){
					case "ALREADY_REDEEM":
						//ga('send', 'event', 'redemption', 'send_code_error', 'ALREADY_REDEEM');
						alertify.alert( "Este código ya ha sido redimido");
					break;
					case "ALREADY_REDEEMED_BY_SAME_USER":
						//ga('send', 'event', 'redemption', 'send_code_error', 'ALREADY_REDEEMED_BY_SAME_USER');
						alertify.alert( "Ya redimiste este código");
					break;
					case "REDEEM_ERROR":
						//ga('send', 'event', 'redemption', 'send_code_error', 'REDEEM_ERROR');
						alertify.alert( "Hay un problema con el servidor, intenta redimir tu código más tarde");
					break;
					case "CODE_DONT_EXIST":
						//ga('send', 'event', 'redemption', 'send_code_error', 'CODE_DONT_EXIST');
						alertify.alert( "El código que ingresaste no existe");
					break;
					case "LOGIN_REQUIRED":
						//ga('send', 'event', 'redemption', 'send_code_error', 'LOGIN_REQUIRED');
						builder.login_modal();
					break;
					case "IGNORE":
						//ga('send', 'event', 'redemption', 'send_code_error', 'IGNORE');
						alertify.alert( "Has rebasado el número de intentos permitidos");
					break;
					case "CAPTCHA_REQUIRED":
						builder.redemption_captcha_modal( data.code );
					break;
					default:
						//ga('send', 'event', 'redemption', 'send_code_error', 'OTHER');
						alertify.alert( "Hay un problema con el servidor, intenta redimir tu código más tarde");
					break;
				};
			}
		}else{
			//ga('send', 'event', 'redemption', 'send_code_error', 'SERVER_ERROR_1');
			alertify.alert("Hay un problema con el servidor, intenta más tarde");
		}
	})
	.fail(function(data){
		//ga('send', 'event', 'redemption', 'send_code_error', 'SERVER_ERROR_2');
		alertify.alert("Hay un problema, intenta más tarde");
	})
	.always(function(){
		$(".captcha").attr("src", base_url+"captcha?_="+Math.random());
		form.find('input[type=submit]').removeAttr('disabled');
	});
}

function actions( action, data ){
	switch( action ){
		case 'redeem':
			redimir( data, $(".form_redemption_redeem") );
		break;
		default:
		break;
	}
}

function regex_only( este, regex ){
	var val = este.value;
	var val_r = val.replace( regex , '');
	if (val != val_r) {
	   este.value = val_r;
	}
}

$(document).ready(function() {
	$.ajaxSetup({ cache: false });
	
	$.fn.modal.defaults.spinner = $.fn.modalmanager.defaults.spinner = 
	'<div class="loading-spinner" style="width: 200px; margin-left: -100px;">' +
		'<div class="progress progress-striped active">' +
			'<div class="progress-bar" style="width: 100%;"></div>' +
		'</div>' +
	'</div>';
	
	$(document).on("click",".terminos_modal", function(e){
		e.preventDefault();
		builder.terminos_modal();
	});
	
	$(document).on("click",".privacidad_modal", function(e){
		e.preventDefault();
		builder.privacidad_modal();
	});
	
	$(document).on("click",".editar_perfil_modal", function(e){
		e.preventDefault();
		builder.editar_perfil_modal();
	});
	
	$(document).on("click",".refresh_captcha", function(e){
		e.preventDefault();
		$(".captcha").attr("src", base_url+"captcha?"+Math.random());
	});
	
	$(document).on("click","#facebook_cancel",function(e){
		e.preventDefault();
		$.ajax({
			url: base_url + "social/facebook_cancel"
		})
		.done(function(){
			$("#facebook_cancel").parent(".alert").remove();
		})
		.fail(function(){});
	});
	
	$(window).on('hashchange', function() {
		if (location.hash == "" || location.hash == "#") {
			location.hash = "";
			return;
		}

		var pos_hash = location.hash.indexOf("#!"); 
		if( pos_hash != -1  ){
			var n_hash = location.hash.substring(3, location.hash.length);
			if( current_hash != n_hash ){
				check_hash();
			}
		}
	});
	
	$( document ).on('submit','#form_user_register',function(e){
		e.preventDefault();
		var $form = $(this);
		
		$form.find('input[type=submit]').attr('disabled', 'disabled');
		$.ajax({
			url: $form.attr('action'),
			method: $form.attr('method'),
			data: $form.serialize()
		})
		.done(function(data){
			data = eval("("+data+")");
			
			if(typeof data.success != "undefined"){
				if(data.success==1){
					$form[0].reset();
					//$('#register_modal').modal('destroy'); //descomenta si está en un modal
					if(typeof data.href != "undefined"){
						location.href = data.href;
					}else if(typeof data.actions != "undefined"){
						actions( data.actions.action, data.actions.data );
					}else{
						location.href = base_url;
					}
				}else if(typeof data.errors != "undefined"){
					var error_string = '';
					for(key in data.errors){
						error_string += data.errors[key]+"<br/>";
					}
					alertify.alert( error_string );
				}else{
					alertify.alert( data.data );
			}
			}else{
				alertify.alert("Ocurrió un error durante el proceso");
			}
		})
		.fail(function(data){
			alertify.alert("Ocurrió un error durante el proceso");
		})
		.always(function(){
			$(".captcha").attr("src", base_url+"captcha?"+Math.random());
			$form.find('input[type=submit]').removeAttr('disabled');
		});
	});
	
	$( document ).on('submit','#form_user_login',function(e){
		e.preventDefault();
		var $form = $(this);
		
		$form.find('input[type=submit]').attr('disabled', 'disabled');
		$.ajax({
			url: $form.attr('action'),
			method: $form.attr('method'),
			data: $form.serialize()
		})
		.done(function(data){
			data = eval("("+data+")");
			
			if(typeof data.success != "undefined"){
				if(data.success==1){
					$form[0].reset();
					if(typeof data.href != "undefined"){
						location.href = data.href;
					}else if(typeof data.actions != "undefined"){
						actions( data.actions.action, data.actions.data );
					}else{
						location.href = base_url;
					}
				}else if(typeof data.errors != "undefined"){
					var error_string = '';
					for(key in data.errors){
						error_string += data.errors[key]+"<br/>";
					}
					alertify.alert( error_string );
				}else{
					alertify.alert( data.data );
			}
			}else{
				alertify.alert("Ocurrió un error durante el proceso");
			}
		})
		.fail(function(data){
			alertify.alert("Ocurrió un error durante el proceso");
		})
		.always(function(){
			$(".captcha").attr("src", base_url+"captcha?"+Math.random());
			$form.find('input[type=submit]').removeAttr('disabled');
		});
	});
	
	$( document ).on('submit','#form_user_send_recovery',function(e){
		e.preventDefault();
		var $form = $(this);
		
		$form.find('input[type=submit]').attr('disabled', 'disabled');
		$.ajax({
			url: $form.attr('action'),
			method: $form.attr('method'),
			data: $form.serialize()
		})
		.done(function(data){
			data = eval("("+data+")");
			
			if(typeof data.success != "undefined"){
				$form[0].reset();
				if(data.success==1){
					$('#recover_modal').modal('destroy');
					alertify.alert( data.data );
				}else if(typeof data.errors != "undefined"){
					var error_string = '';
					for(key in data.errors){
						error_string += data.errors[key]+"<br/>";
					}
					alertify.alert( error_string );
				}else{
					alertify.alert( data.data );
			}
			}else{
				alertify.alert("Ocurrió un error durante el proceso");
			}
		})
		.fail(function(data){
			alertify.alert("Ocurrió un error durante el proceso");
		})
		.always(function(){
			$form.find('input[type=submit]').removeAttr('disabled');
		});
	});
	
	$( document ).on('submit','#form_user_recover_password',function(e){
		e.preventDefault();
		var $form = $(this);
		
		$form.find('input[type=submit]').attr('disabled', 'disabled');
		$.ajax({
			url: $form.attr('action'),
			method: $form.attr('method'),
			data: $form.serialize()
		})
		.done(function(data){
			data = eval("("+data+")");
			
			if(typeof data.success != "undefined"){
				if(data.success==1){
					$form[0].reset();
					alertify.alert("Tu contraseña ha sido reactivada satisfactoriamente.<br/><a href='"+base_url+"'>Regresar al home</a>.", function(){
						location.href = base_url;
					});
				}else if(typeof data.errors != "undefined"){
					var error_string = '';
					for(key in data.errors){
						error_string += data.errors[key]+"<br/>";
					}
					alertify.alert( error_string );
				}else{
					alertify.alert( data.data );
			}
			}else{
				alertify.alert("Ocurrió un error durante el proceso");
			}
		})
		.fail(function(data){
			alertify.alert("Ocurrió un error durante el proceso");
		})
		.always(function(){
			$form.find('input[type=submit]').removeAttr('disabled');
		});
	});
	
	$( document ).on('submit','#form_contact_send',function(e){
		e.preventDefault();
		var $form = $(this);
		
		$form.find('input[type=submit]').attr('disabled', 'disabled');
		$.ajax({
			url: $form.attr('action'),
			method: $form.attr('method'),
			data: $form.serialize()
		})
		.done(function(data){
			data = eval("("+data+")");
			
			if(typeof data.success != "undefined"){
				if(data.success==1){
					$form[0].reset();
					alertify.alert( data.data );
				}else if(typeof data.errors != "undefined"){
					var error_string = '';
					for(key in data.errors){
						error_string += data.errors[key]+"<br/>";
					}
					alertify.alert( error_string );
				}else{
					alertify.alert( data.data );
			}
			}else{
				alertify.alert("Ocurrió un error durante el proceso");
			}
		})
		.fail(function(data){
			alertify.alert("Ocurrió un error durante el proceso");
		})
		.always(function(){
			$(".captcha").attr("src", base_url+"captcha?"+Math.random());
			$form.find('input[type=submit]').removeAttr('disabled');
		});
	});
	
	$( document ).on('submit','#form_user_edit_profile',function(e){
		e.preventDefault();
		var $form = $(this);
		
		$form.find('input[type=submit]').attr('disabled', 'disabled');
		$.ajax({
			url: $form.attr('action'),
			method: $form.attr('method'),
			data: $form.serialize()
		})
		.done(function(data){
			data = eval("("+data+")");
			
			if(typeof data.success != "undefined"){
				if(data.success==1){
					alertify.alert( data.data );
				}else if(typeof data.errors != "undefined"){
					var error_string = '';
					for(key in data.errors){
						error_string += data.errors[key]+"<br/>";
					}
					alertify.alert( error_string );
				}else{
					alertify.alert( data.data );
			}
			}else{
				alertify.alert("Ocurrió un error durante el proceso");
			}
		})
		.fail(function(data){
			alertify.alert("Ocurrió un error durante el proceso");
		})
		.always(function(){
			$form.find('input[type=submit]').removeAttr('disabled');
		});
	});
	
	$( document ).on('submit','.form_redemption_redeem',function(e){
		e.preventDefault();
		var $form = $(this);
		
		redimir( $form.find("#code").val(), $form );
	});
	
	$(document).on('blur','input[name=zipcode]',function(){
		builder.ubication( $(this).val() );
	});
	
	$(document).on('change','select[name=state]',function(){
		builder.cities( $(this).val() );
	});
	
	$(document).on('change','select[name=city]',function(){
		builder.wards( $(this).val() );
	});
	
	$(document).on('change',"select[name=ward]",function(){
		if( $(this).val() == "-1"){
			builder.wards( $("select[name=city]").val() );
		}
	});
	
	$('body').on('keyup', '.numeric', function () {
		regex_only( this, /[^0-9]/g );
	});
	
	$('body').on('input paste drop', '.numeric', function() {
		regex_only( this , /[^0-9]/g );
	});
	
	$('body').on('keyup', '.wordsOnly', function () {
		regex_only( this, /[^a-záéíóúäëïöüñâêîôû'\s\-]/gi );
	});
	
	$('body').on('input paste drop', '.wordsOnly', function() {
		regex_only( this , /[^a-záéíóúäëïöüñâêîôû'\s\-]/gi );
	});
	
	check_hash();
});