<div class="modal_redemption_captcha modal fade" id="redeem_modal" tabindex="-1" role="dialog" aria-labelledby="meta_modalLabel" aria-hidden="true">
	<div id="canje-contenedor">
		<div class="modal-header">
			<div class="cont-close">
				<div class="close modal-close_x" data-dismiss="modal" aria-hidden="true"></div>
			</div>
			<h4>Ingresa la palabra que veas en la imagen<br/> para canjear tu código</h4>
		</div>
		<div class="modal-body">
			<div id="captcha_div_container">
				<form method="post" action="<?=base_url()?>redemption/redeem" class="form_redemption_redeem form_redemption_captcha">
					<?=form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash())?>
					<input type="hidden" value="" id="code" name="code" maxlength="10" />
						
					<img class="captcha" id="" src="<?=base_url()?>captcha?<?=mt_rand()?>">
					<a href="#" class="refresh_captcha"><i class="fa fa-refresh"></i></a>
					<br>
					
					<div id="captcha_canje_box">					
						<input type="text" name="captcha" maxlength="6" id="captcha" class="" />
					</div>
					<input id="" type="submit" class="btn btn-primary" value="Enviar" />
				</form>
			</div>
		</div>
	</div>
</div>	