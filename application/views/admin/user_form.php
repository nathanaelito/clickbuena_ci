<div class="modal_user modal fade" id="premios_modal" tabindex="-1" role="dialog" aria-labelledby="meta_modalLabel" aria-hidden="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h3 class="modal-title" id="meta_modalLabel"><?=!empty($user)?"Edit":"Create"?> User</h3>
	</div>

	<div class="modal-body">
		<div class="row">
			<div class="col-xs-12">
				<form role="form" method="post" action="<?=site_url("user/".(!empty($user)?"edit":"create"))?>" id="form_user_<?=!empty($user)?"edit":"create"?>">
					<?=form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash())?>
					<?if(!empty($user)){?>
						<input name="id" type="hidden" value="<?=$user->id?>">
					<?}?>
					
					<div class="form-group">
						<label for="name">Name:</label>
						<input type="text" value="<?=!empty($user_profile->name)?$user_profile->name:""?>" name="name" id="name" class="form-control">
					</div>
					
					<div class="form-group">
						<label for="lastname">Lastname:</label>
						<input type="text" value="<?=!empty($user_profile->lastname)?$user_profile->lastname:""?>" name="lastname" id="lastname" class="form-control">
					</div>
					
					<div class="form-group">
						<label for="email">Email:</label>
						<input type="text" value="<?=!empty($user->email)?$user->email:""?>" name="email" id="email" class="form-control">
					</div>
					
					<div class="form-group">
						<label for="password">Password:</label>
						<input type="password" value="" name="password" id="password" class="form-control">
					</div>
					
					<div class="form-group">
						<label for="cpassword">Confirm Password:</label>
						<input type="password" value="" name="cpassword" id="cpassword" class="form-control">
					</div>
					
					<div class="form-group">
						<label for="role">Role:</label>
						<select id="role" name="role" class="form-control">
							<option value="3" <?=(!empty($user) && $user->role==3)?"selected='selected'":""?>>Visitante</option>
							<option value="2" <?=(!empty($user) && $user->role==2)?"selected='selected'":""?>>Editor</option>
							<option value="1" <?=(!empty($user) && $user->role==1)?"selected='selected'":""?>>Administrador</option>
						</select>
					</div>
				</form>
			</div>	
		</div>
	</div>
	
	<div class="modal-footer">
		<button type="button" data-dismiss="modal" class="btn btn-default">Close</button>
		<button id="<?=!empty($user)?"edit":"create"?>_user" type="button" class="btn btn-primary"><i class="fa fa-save"></i> <?=!empty($user)?"Edit":"Create"?></button>
	</div>
</div>