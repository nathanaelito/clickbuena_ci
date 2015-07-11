<div class="modal_editar_perfil modal fade" id="aviso" tabindex="-1" role="dialog" aria-labelledby="meta_modalLabel" aria-hidden="true">
	<div class="legales-ganador">
		<div class="modal-header">
			<div class="cont-close">
				<div class="close modal-close_x" data-dismiss="modal" aria-hidden="true"></div>
			</div>
			<!-- <h4 class="modal-title" id="meta_modalLabel"></h4> -->
			<h2 class="">Editar Perfil</h2>
		</div>

		<div class="modal-body body_legales">
			<div class="modal-padd">
                <!--<div class="modal-body-scroll">-->
                <p class="">A continuación llena tu perfil:</p>
                <form role="form" id="form_user_edit_profile" class="form_user_edit_profile" method="post" action="<?=base_url()?>user/edit_profile">
					<?=form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash())?>
					
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 form-group">
                            <label for="name" class="">Nombre</label>
                            <input id="name" name="name" type="text" class="form-control wordsOnly">
                        </div>
						<div class="col-xs-12 col-sm-6 form-group">
                            <label for="lastname" class="">Apellidos</label>
                            <input id="lastname" name="lastname" type="text" class="form-control wordsOnly">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 form-group">
                            <label for="number_ext" class="">No. exterior</label>
                            <input id="number_ext" name="number_ext" type="text" class="form-control">
                        </div>
                        <div class="col-xs-12 col-sm-6 form-group">
                            <label for="number_int" class="">No interior</label>
                            <input id="number_int" name="number_int" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="row">
						
                        <div class="col-xs-12 col-sm-6 form-group">
                            <label for="zipcode" class="">C. P.</label>
                            <input id="zipcode" name="zipcode" type="text" class="zipcode form-control numeric" maxlength="5">
                        </div>
                        <div class="col-xs-12 col-sm-6 form-group">
                            <label for="state" class="">Estado</label>
                            <select id="state" name="state" class="form-control"></select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 form-group">
                            <label for="city" class="">Municipio</label>
                            <select id="city" name="city" class="form-control"></select>
                        </div>
                        <div class="col-xs-12 col-sm-6 form-group">
                            <label for="ward" class="">Colonia</label>
                            <select id="ward" name="ward" class="form-control"></select>
                        </div>
                    </div>
                    <div class="row">
						<div class="col-xs-12 col-sm-6 form-group">
                            <label for="street" class="">Calle</label>
                            <input id="street" name="street" type="text" class="form-control">
                        </div>
                    </div>  
					<div class="row">
						<div class="col-xs-12 col-sm-6 form-group">
                            <label for="phone" class="">Teléfono</label>
                            <input id="phone" name="phone" type="text" maxlength="10" class="form-control numeric">
                        </div>
						<div class="col-xs-12 col-sm-6 form-group">
                            <label for="cellphone" class="">Celular</label>
                            <input id="cellphone" name="cellphone" type="text" maxlength="10" class="form-control numeric">
                        </div>
                    </div>
					<div class="row">
						<div class="ol-sm-12 form-group-btn">
                            <input type="submit" value="ENVIAR" class="btn btn-primary pull-right">
                        </div>
					</div>
                </form>
                <!--</div>-->
			</div>
		</div>
	</div>
</div>