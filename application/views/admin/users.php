<section id="users_index">
	<div class="page-header">
		<h1>Users</h1>
	</div>
	
	<div class="row">
		<div class="col-xs-12">
			<div class="row">
				<div class="col-xs-6">
					<p><a id="new_user" class="btn btn-primary" href="<?=site_url("user/edit_form")?>">New <i class="fa fa-plus"></i></a></p>
					<h3>Filter</h1>
					<label for="user_email_input">Email:</label>
					<p id="user_email_input"></p>
					<label for="user_role_select">Role:</label>
					<p id="user_role_select"></p>
				</div>
			</div>	
		</div>
		<hr>
	</div>
	<div class="row">
		<div class="col-xs-12">
		<?=$table?>
		</div>
	</div>	
</section>
<script>
	$(function(){
		var responsiveHelper = undefined;
		var breakpointDefinition = {
			tablet: 949,
			portrait : 767,
			phone : 480
		};
		var tableElement = $('.users_dt');
		var oTable = tableElement.dataTable({
			"sDom": "<'row'<'col-xs-6'l><'col-xs-6'f>r>t<'row'<'col-xs-6'i><'col-xs-6'p>>",
			"autoWidth": false,
			"aoColumns": [
				{ "sType": "string", "sName": "email" },
				{ "sType": "string", "sName": "role_name" },
				{ "bSortable": false }
			],
			"bProcessing": true,
			"bServerSide": true,
			"sAjaxSource": '<?=site_url('dt/users')?>',
			"iDisplayStart ": 20,
			'fnServerData': function (sSource, aoData, fnCallback) {
				aoData.push({name: '<?=$this->security->get_csrf_token_name()?>', value : '<?=$this->security->get_csrf_hash()?>'});
				$.ajax({
				'dataType': 'json',
				'type': 'POST',
				'url': sSource,
				'data': aoData,
				'success': fnCallback
				});
			},
			"fnInitComplete": function(oSettings, json) {         
				oTable.fnAdjustColumnSizing();
			}
		}).columnFilter({
			aoColumns:[
				{ type:"string", sSelector: "#user_email_input"},
				{ type:"select", sSelector: "#user_role_select", values: [ 'Administrator', 'Editor', 'Visitor'] },
				null
			]
		});
		
		$("#new_user").click(function(e){
			e.preventDefault();
			var href = $(this).attr("href");
			admin.builder.user_modal( href );
		});

		$("body").on("click",".edit_user",function(e){
			e.preventDefault();
			var href = $(this).attr("href");
			admin.builder.user_modal( href );
		});
		
		$("body").on("click","#create_user",function(e){
			e.preventDefault();
			$("#form_user_create").submit();
		});
		
		$("body").on("click","#edit_user",function(e){
			e.preventDefault();
			$("#form_user_edit").submit();
		});

		$("body").on("submit","#form_user_create",function(e){
			e.preventDefault();
			$form = $(this);
			
			$submit = $("#create_user");
			var current_submit = $submit.html();
			$submit.html("Sending...").attr('disabled', 'disabled');
			
			$form.ajaxSubmit({ 
				url: $form.attr("action"),
				type: $form.attr("method"),
				success: function( data ){
					data = eval("("+data+")");
					if(typeof data.success != "undefined"){
						if(data.success==1){
							$form[0].reset();
							oTable.fnDraw();
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
				},
				error: function(){
					alertify.alert("Ocurrió un error durante el proceso");
					$(".modal_user").modal('destroy');
				},
				complete: function(){
					$submit.html( current_submit ).removeAttr('disabled');
				}
			});
		});
		
		$("body").on("submit","#form_user_edit",function(e){
			e.preventDefault();
			$form = $(this);
			
			$submit = $("#edit_user");
			var current_submit = $submit.html();
			$submit.html("Sending...").attr('disabled', 'disabled');
			
			$(".form_src_container").html( $.fn.modal.defaults.spinner );

			$form.ajaxSubmit({ 
				url: $form.attr("action"),
				type: $form.attr("method"),
				success: function( data ){
					data = eval("("+data+")");
					if(typeof data.success != "undefined"){
						if(data.success==1){
							oTable.fnDraw();
							alertify.alert( data.data );
							if(typeof data.user != "undefined"){
								var user = data.user;
								$(".modal_user").modal("destroy");
								admin.builder.user_modal( base_url+"user/edit_form/"+user.id );
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
				},	
				error: function(){
					alertify.alert("Ocurrió un error durante el proceso");
					$(".modal_user").modal('destroy');
				},
				complete: function(){
					$submit.html( current_submit ).removeAttr('disabled');
				}
			});
		});
		
		$(document).on('click','.eliminar_dt',function(e){
			e.preventDefault();
			enlace = $(this);
			alertify.confirm("Do you really want to delete this record?",function(e){
				if(e){
					$.ajax({
					  url: enlace.attr('href'),
					  success: function(data){
						data = eval("("+data+")");
						if(typeof(data.success) != "undefined" && data.success==1){
							var row = enlace.closest("tr").get(0);
							oTable.fnDeleteRow(oTable.fnGetPosition(row));
						}
					  }
					});
				}
			});
		});
	});
</script>