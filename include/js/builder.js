builder = {
	terminos_modal: function(){
		$('body').modalmanager('loading');
		$.ajax({
			url: base_url+"modal/terminos"
		}).done(function( html ){
			$("#meta_modal").html( html );
			$(".modal_terminos").modal();
		}).fail(function(){});
	},
	privacidad_modal: function(){
		$('body').modalmanager('loading');
		$.ajax({
			url: base_url+"modal/privacidad"
		}).done(function( html ){
			$("#meta_modal").html( html );
			$(".modal_privacidad").modal();
		}).fail(function(){});
	},
	login_modal: function(){
		$('body').modalmanager('loading');
		$.ajax({
			url: base_url+"modal/login"
		}).done(function( html ){
			$("#meta_modal").html( html );
			$(".modal_login").modal();
		}).fail(function(){});
	},
	redemption_captcha_modal: function( code ){
		//if( $(".modal").length ) $(".modal").modal('destroy');
		$('body').modalmanager('loading');
		$.ajax({
			url: base_url + "modal/redemption_captcha"
		}).done(function( html ){
			$("#meta_modal").html( html );
			$(".modal_redemption_captcha #code").val( code );
			$(".modal_redemption_captcha").modal();
		}).fail(function(){});
	},
	editar_perfil_modal: function(){
		$('body').modalmanager('loading');
		$.ajax({
			url: base_url+"modal/editar_perfil"
		}).done(function( html ){
			$("#meta_modal").html( html );

			$.ajax({
				url: base_url + "user/data_profile"
			}).done(function( data ){
				data = eval("("+data+")");
				if(typeof data.profile != "undefined" && data.profile){
					var state = data.profile.state!=""?data.profile.state:"0";
					var city = data.profile.city!=""?data.profile.city:"0";
					var ward = data.profile.ward!=""?data.profile.ward:"0";
					
					builder.states( state );
					builder.cities( state,city  );
					builder.wards( city, ward );
				
					$(".modal_editar_perfil #name").val( data.profile.name );
					$(".modal_editar_perfil #lastname").val( data.profile.lastname );
					$(".modal_editar_perfil #street").val( data.profile.street );
					$(".modal_editar_perfil #number_ext").val( data.profile.number_ext );
					$(".modal_editar_perfil #number_int").val( data.profile.number_int );
					$(".modal_editar_perfil #zipcode").val( data.profile.zipcode );
					$(".modal_editar_perfil #phone").val( data.profile.phone );
					$(".modal_editar_perfil #cellphone").val( data.profile.cellphone );
				}else{
					builder.states();
					builder.cities("1");
					builder.wards("1");
				}
			
				$(".modal_editar_perfil").modal();
			}).fail(function(){});
		}).fail(function(){});
	},
	states: function( state_id ){
		//#state
		$.ajax({
			url: base_url + "place/states/"
		}).done(function( data ){
			var states = eval("("+data+")");
			var states_select = $("select[name=state]");
			states_select.html("");
			states_select.append(
				$("<option/>", {"value": "0"}).text("-- Choose one --")
			);
			for(i in states){
				states_select.append(
					$("<option/>", {"value": states[i].id}).text(states[i].name)
				);
			}
			
			if(typeof state_id != "undefined"){
				states_select.val( state_id );
			}
		}).fail(function(){});
	},
	cities: function( state_id, city_id ){
		state_id = state_id.replace(/[^\d]/gi, '');
		$.ajax({
			url: base_url + "place/cities/"+state_id
		}).done(function( data ){
			var cities = eval("("+data+")");
			var cities_select = $("select[name=city]");
			cities_select.html("");
			cities_select.append(
				$("<option/>", {"value": "0"}).text("-- Choose one --")
			);
			for(i in cities){
				cities_select.append(
					$("<option/>", {"value": cities[i].id}).text(cities[i].name)
				);
			}
			
			if(typeof city_id != "undefined"){
				cities_select.val( city_id );
			}
		}).fail(function(){});
	},
	wards: function( city_id, ward_id ){
		city_id = city_id.replace(/[^\d]/gi, '');
		$.ajax({
			url: base_url + "place/wards/"+city_id
		}).done(function( data ){
			var wards = eval("("+data+")");
			var wards_select = $("select[name=ward]");
			wards_select.html("");
			wards_select.append(
					$("<option/>", {"value": "0"}).text("-- Choose one --")
				);
			for(i in wards){
				wards_select.append(
					$("<option/>", {"value": wards[i].id}).text(wards[i].name)
				);
			}
			
			if(typeof ward_id != "undefined"){
				wards_select.val( ward_id );
			}
		}).fail(function(){});
	},
	ubication: function( zipcode ){
		zipcode = zipcode.replace(/[^\d]/gi, '');
		$.ajax({
			url: base_url + "place/ubication/"+zipcode
		}).done(function( data ){
			var ubication = eval("("+data+")");
			if( ubication.length ){
				var state_id = ubication[0].state_id;
				var city_id = ubication[0].city_id;
				$("select[name=state]").val( state_id );
				builder.cities( state_id, city_id  );
				var wards_select = $("select[name=ward]");
				wards_select.html("");
				wards_select.append(
					$("<option/>", {"value": "0"}).text("-- Choose one --")
				);
				for(i in ubication){
					wards_select.append(
						$("<option/>", {"value": ubication[i].ward_id}).text(ubication[i].ward_name)
					);
				}
				wards_select.append(
					$("<option/>", {"value": "-1"}).text("-- Other --")
				);
			}
		}).fail(function(){});
	}
}