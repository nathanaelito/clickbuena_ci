<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends MY_Controller {
	function __construct(){
		parent::__construct();
		$this->form_validation->set_error_delimiters('', '<br/>');
	}
	
	public function index(){
		show_404();
	}
	
	/* Login usuario común */
	function login(){
		$this->form_validation->set_rules('email', 'Correo', 'trim|required|xss_clean|valid_email|prep_for_form|htmlspecialchars');
		$this->form_validation->set_rules('password', 'Contraseña', 'trim|required|min_length[4]|max_length[50]');
		if ($this->form_validation->run() == FALSE){
			$data = array('success' =>0, 'errors' => $this->form_validation->error_array());
		}else{
			$this->load->model('user_model');
		
			$data['email'] = $this->input->post('email');
			$data['password'] = $this->input->post('password');
			
			$login=$this->user_model->login($data);
			
			if($login['status'] == 1){
				$user = $login['user'];
				
				$this->load->model("account_model");
				$account = $this->account_model->get_account($user->id, 1);
				
				$sess_array = array(
					'id' => $user -> id,
					'fid' => (!empty( $account )? $account->account_key :""),
					'correo' => $user->email,
					'role' => $user->role
				);
				$this -> session -> set_userdata('logged_in', $sess_array);
				
				$actions = $this->session->userdata("actions");
				if( !empty($actions)){
					$data = array('success' =>1, 'data' => ('Ingresando'), 'actions'=>$actions);
				}else{
					$data = array('success' =>1, 'data' => ('Ingresando'), 'href'=>base_url());
				}
			}else{
				if($login['status'] == -1){
					$data = array('error' => ('Usuario o contraseña incorrectos'));//Contraseña incorrecta
				}else if($login['status'] == -2){
					$data = array('error' => ('Usuario o contraseña incorrectos'));//Usuario inexistente 
				}else if($login['status'] == -3){
					$data = array('error' => ('Ocurrió un error durante el proceso'));
				}else{
					$data = array('error' => ('Ocurrió un error durante el proceso'));
				}
			}
		}

		$data = json_encode($data);
		$data=array('response'=>$data);
		$this->load->view('ajax',$data);
	}
	
	/* Login panel */
	function login_panel(){
		$this->form_validation->set_rules('email', 'Correo', 'trim|required|xss_clean|valid_email|prep_for_form|htmlspecialchars');
		$this->form_validation->set_rules('password', 'Contraseña', 'trim|required|min_length[4]|max_length[50]');
		$this->form_validation->set_rules('captcha', 'Código de Validación', 'trim|required|callback__valid_captcha');
		if ($this->form_validation->run() == FALSE){
			$data = array('success' =>0, 'errors' => $this->form_validation->error_array());
		}else{
			$this->load->model('user_model');
		
			$data['email'] = $this->input->post('email');
			$data['password'] = $this->input->post('password');
			
			$login=$this->user_model->login_panel( $data );
			
			if($login['status'] == 1){
				$user = $login['user'];
				$sess_array = array(
					'id' => $user -> id,
					'fid' => '',
					'correo' => $user->email,
					'role' => $user->role
				);
				$this -> session -> set_userdata('logged_in', $sess_array);
				$data = array('success' =>1, 'data' => ('Ingresando'), 'href'=>site_url("panel") );
			}else{
				if($login['status'] == -1){
					$data = array('error' => ('Usuario o contraseña incorrectos'));//Contraseña incorrecta
				}else if($login['status'] == -2){
					$data = array('error' => ('Usuario o contraseña incorrectos'));//Usuario inexistente 
				}else if($login['status'] == -3){
					$data = array('error' => ('Ocurrió un error durante el proceso'));
				}else{
					$data = array('error' => ('Ocurrió un error durante el proceso'));
				}
			}
		}
		
		$data = json_encode($data);
		$data=array('response'=>$data);
		$this->load->view('ajax',$data);
	}
	
	function logout(){
		$this->session->sess_destroy();
		redirect();
	}
	
	function edit(){
		$logged_in = $this->session->userdata("logged_in");
		if(!empty($logged_in) && $logged_in['role']==1){
			$this->form_validation->set_rules('name', 'Nombre', 'trim|required|xss_clean|prep_for_form|htmlspecialchars|is_words_only');
			$this->form_validation->set_rules('lastname', 'Apellidos', 'trim|required|xss_clean|prep_for_form|htmlspecialchars|is_words_only');
			
			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
			$this->form_validation->set_rules('password', 'Password', 'trim|min_length[4]|max_length[100]');
			$this->form_validation->set_rules('cpassword', 'Confirm Password', 'trim|matches[password]');
			$this->form_validation->set_rules('role', 'Role', 'trim|required|is_natural_no_zero|prep_for_form');

			if($this->form_validation->run() == FALSE) {
				$data = array('success' =>0, 'data' => validation_errors());
			} else {
				$this->load->model('user_model');
				$id = $this->input->post('id');
				$user = $this->user_model->get_user( $id );
				if(!empty($user)){
					$this->load->model('role_model');
					$data['name'] = $this->input->post('name');
					$data['lastname'] = $this->input->post('lastname');
					
					$data['email'] = $this->input->post('email');
					$data['password'] = $this->input->post('password');
					$role = $this->input->post('role');
					$v_role = $this->role_model->get_role($role);
					$data['role'] = !empty($v_role)? $role:2;
				
					$edited=$this->user_model->edit($data, $id);
					if($edited){
						$user = $this->user_model->get_user( $id );	
						$data = array('success' =>1, 'data' => ('Usuario editado satisfactoriamente.'),'user'=>$user);
					}else
						$data = array('success' =>0, 'data' => ('Ocurrió un error durante el proceso.'));
				}else{
					$data = array('success' =>0, 'data' => ('Ocurrió un error durante el proceso.'));
				}
			}
			$data = json_encode($data);
			$data=array('response'=>$data);
			$this->load->view('ajax',$data);
		}else
			show_404();
	}
	
	public function create(){
		$logged_in = $this->session->userdata("logged_in");
		if(!empty($logged_in) && $logged_in['role']==1){
			$this->form_validation->set_rules('name', 'Nombre', 'trim|required|xss_clean|prep_for_form|htmlspecialchars|is_words_only');
			$this->form_validation->set_rules('lastname', 'Apellidos', 'trim|required|xss_clean|prep_for_form|htmlspecialchars|is_words_only');
			
			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]|max_length[100]');
			$this->form_validation->set_rules('cpassword', 'Confirm Password', 'trim|required|matches[password]');
			$this->form_validation->set_rules('role', 'Role', 'trim|required|is_natural_no_zero|prep_for_form');

			if($this->form_validation->run() == FALSE) {
				$data = array('success' =>0, 'data' => validation_errors());
			} else {
				$this->load->model('user_model');
				$this->load->model('role_model');

				$data['name'] = $this->input->post('name');
				$data['lastname'] = $this->input->post('lastname');
				
				$data['email'] = $this->input->post('email');
				$data['password'] = $this->input->post('password');
				$role = $this->input->post('role');
				$v_role = $this->role_model->get_role($role);
				$data['role'] = !empty($v_role)? $role:2;
			
				$create=$this->user_model->create($data);
				if($create){
					$data = array('success' =>1, 'data' => ('Usuario creado satisfactoriamente.'));
				}else
					$data = array('success' =>0, 'data' => ('Ocurrió un error durante el proceso.'));
			}
			$data = json_encode($data);
			$data=array('response'=>$data);
			$this->load->view('ajax',$data);
		}else
			show_404();
	}
	
	function delete($id=null){
		$logged_in = $this->session->userdata("logged_in");
		if(!empty($logged_in) && $logged_in['role']==1){
			$id+=0;
			if(is_int($id) && $id>0){
				$this->load->model('user_model');
				$user=$this->user_model->get_user($id);
				if(!empty($user)){
					if($this->user_model->delete($id) === TRUE){
						$output = array('success' =>1, 'data' => 'Se ha eliminado correctamente');
					}else
						$output = array('success' =>0, 'data' =>  'Ocurrió un error durante el proceso');
				}else
					show_404();
				$data = json_encode($output);
				$data=array('response'=>$data);
				$this->load->view('ajax',$data);
			}else
				show_404();
		}else
			show_404();
	}
	
	function edit_form( $user_id=null ){
		$logged_in = $this->session->userdata("logged_in");
		if(!empty( $logged_in ) && $logged_in['role']==1){
			$user_id += 0;
			$data = array();
			$this->load->model("user_model");
			if( is_int($user_id) && $user_id>0){
				$user = $this->user_model->get_user( $user_id );
				$user_profile = $this->user_model->get_user_profile( $user_id );
				$data['user'] = $user;
				$data['user_profile'] = $user_profile;
			}
			$this->load->model("role_model");
			$data['roles'] = $this->role_model->get_roles();
			
			$this->load->view("admin/user_form", $data);
		}else{
			show_404();
		}
	}
	
	function register(){
		$this->form_validation->set_rules('name', 'Nombre', 'trim|required|xss_clean|prep_for_form|htmlspecialchars|is_words_only');
		$this->form_validation->set_rules('lastname', 'Apellidos', 'trim|required|xss_clean|prep_for_form|htmlspecialchars|is_words_only');
		
		$this->form_validation->set_rules('email', 'Correo', 'trim|required|valid_email|callback__unique_email');
		$this->form_validation->set_rules('password', 'Contraseña', 'trim|required|min_length[4]|max_length[50]|matches[cpassword]');
		$this->form_validation->set_rules('cpassword', 'Confirmar Contraseña', 'trim|required');
		$this->form_validation->set_rules('captcha', 'código de validación', 'trim|required|callback__valid_captcha');
		$this->form_validation->set_rules('privacy_cbox', 'Política de Privacidad', 'trim|callback__privacidad');
		
		if($this->form_validation->run() == FALSE) {
			$data = array('success' =>0, 'errors' => $this->form_validation->error_array());
		} else {
			$data['name'] = $this->input->post('name');
			$data['lastname'] = $this->input->post('lastname');
			$data['email'] = strtolower($this->input->post('email'));
			$data['password'] = $this->input->post('password');
			
			$this->load->model("user_model");
			$this->load->model("account_model");

			$user_id = $this->user_model->create( $data );
			if($user_id){
				$fbuser = $this->session->userdata("facebook_register");
				if(!empty($fbuser)){
					$data_account['user_id'] = $user_id;
					$data_account['account_key'] = $fbuser['id'];
					$data_account['account_type_id'] = 1;
					$this->account_model->create($data_account);
					$this->session->unset_userdata("facebook_register");
				}
				$sess_array = array(
					'id' => $user_id,
					'fid' => (!empty( $data_account['account_key'] )? $data_account['account_key']:""),
					'correo' => $data['email'],
					'role' => (!empty($data['role'])? $data['role']: 3)
				);
				$this -> session -> set_userdata('logged_in', $sess_array);

				$this->load->library('user_agent');
				if ($this->agent->is_referral()){
					$data = array('success' =>1, 'data' => ('Te has registrado correctamente'), 'href' => base_url() );
				}else{
					$data = array('success' =>1, 'data' => ('Te has registrado correctamente'));
				}
			}else
				$data = array('success' =>0, 'data' => ('Ocurrió un error durante el proceso.'));
		}
		$data = json_encode($data);
		$data=array('response'=>$data);
		$this->load->view('ajax',$data);
	}

	function recovery( $key = "", $email = "" ){
		$email = urldecode($email);
		$this->load->library("form_validation");
		if(strlen($key)==32 && valid_email($email)){
			$this->load->model("account_model");
			$recuperar = $this->account_model->get_recovery($key);
			if(!empty($recuperar)){
				$this->load->model("user_model");

				$usuario = $this->user_model->get_user($recuperar->user_id);
				if(!empty($usuario) && strtolower($email)==strtolower($usuario->email)){
					$this->session->set_userdata("recuperar", $usuario->id);
					
					$data['logged_in'] = $this->session->userdata('logged_in');
					$data['contenido'] = $this->load->view("recover","",true);
					$this->load->view("base", $data);
				}else
					redirect();
			}else
				redirect();
		}else
			redirect();
	}
	
	function recover_password(){
		$recuperar = $this->session->userdata("recuperar");
		if(!empty($recuperar)){
			$this->form_validation->set_rules('password', 'Contraseña', 'trim|required|xss_clean|prep_for_form|htmlspecialchars|min_length[6]|matches[cpassword]');
			$this->form_validation->set_rules('cpassword', 'Confirmar Contraseña', 'trim|required');
			if($this->form_validation->run() == FALSE) {
				$data = array('success' =>0, 'errors' => $this->form_validation->error_array());
			} else {
				$password = $this->input->post('password');
				$this->load->model("account_model");
				$actualizar = $this->account_model->update_password($password, $recuperar);
				if($actualizar){
					$this->session->unset_userdata("recuperar");
					$this->account_model->delete_recovery($recuperar);
					
					$this->load->model("user_model");
					$user = $this->user_model->get_user( $recuperar );
					if(!empty($user)){
						$account = $this->account_model->get_account( $user->id, 1);
						
						$sess_array = array(
							'id' => $user -> id,
							'fid' => (!empty($account)? $account->account_key : ""),
							'correo' => $user->email,
							'role' => $user->role
						);
						$this -> session -> set_userdata('logged_in', $sess_array);
					}
					
					$data = array('success' =>1, 'data' => ('Contraseña actualizada'));
				}else{
					$data = array('success' =>0, 'data' => ('Ocurrió un error durante el proceso.'));
				}
			}
			$data = json_encode($data);
			$data=array('response'=>$data);
			$this->load->view('ajax',$data);
		}else
			show_404();
	}
	
	function send_recovery(){
		$this->form_validation->set_rules('email', 'Correo', 'trim|required|valid_email');
		if($this->form_validation->run() == FALSE) {
			$data = array('success' =>0, 'errors' => $this->form_validation->error_array());
		} else {
			$this->load->model("user_model");
			$email = $this->input->post('email');
			$user = $this->user_model->get_user_email( $email );
			if(!empty($user)){
				$this->load->model("ban_model");
				$banned = $this->ban_model->banned( $user->id, 8 );
				if(empty($banned)){
					$this->load->model('account_model');
					$token = $this->_generate_recovery();
					$crear=$this->account_model->create_recovery($email, $token);
					if($crear==1){
						$this->load->library('email');
						$this->email->to($email);
						$this->email->from("no-reply@saladitas.com.mx", "Saladitas");
						$this->email->subject("Recuperación de contraseña - Saladitas");
						$this->email->message($this->load->view("email/recovery",array("email"=>$email,"token"=>$token),true));
						$this->email->send();
								
						$data = array('success' =>1, 'data' => ('Hemos enviado un link a tu correo para que recuperes tu contraseña.'));
					}else if($crear==-1){
						$data = array('success' =>0, 'data' => ('Ocurrió un error durante el proceso.'));
					}else if($crear==-2){
						$data = array('success' =>0, 'data' => ('Has intentado demasiadas veces en poco tiempo, intenta más tarde.'));
					}else if($crear==-3){
						$data = array('success' =>0, 'data' => ('Correo inexistente.'));
					}
				}else{
					$data = array('success' =>0, 'data' => ('Correo inexistente.')); //Baneado
				}
			}else{
				$data = array('success' =>0, 'data' => ('Correo inexistente.'));
			}
		}
		$data = json_encode($data);
		$data=array('response'=>$data);
		$this->load->view('ajax',$data);
	}
	
	function confirm( $key = "", $email = ""){
		if(!empty($key)){
			$this->load->model("account_model");
			$this->load->model("user_model");
			$this->load->helper('email');
			$confirm = $this->account_model->get_confirm( $key );
			if(!empty($confirm)){
				$user = $this->user_model->get_user( $confirm->user_id );
				$email = urldecode($email);
				if(!empty($user) && !empty($email) && valid_email($email) && $user->email == $email){
					$this->account_model->confirm( $user->id );
					$account = $this->account_model->get_account( $user->id, 1);
					
					$sess_array = array(
						'id' => $user -> id,
						'fid' => (!empty($account)? $account->account_key : ""),
						'correo' => $user->email,
						'role' => $user->role
					);
					$this -> session -> set_userdata('logged_in', $sess_array);
					
					$sess_code = $this->session->userdata('sess_code');
					if(!empty($sess_code)){
						redirect(""); //poner la sección de canje 
					}else{
						redirect();
					}
				}else
					show_404();
			}else
				show_404();
		}else
			show_404();
	}
	
	function check_login(){
		$logged_in = $this -> session -> userdata('logged_in');
		if(!empty($logged_in)){
			$data = array('success' =>1);
		}else{
			$data = array('success' =>0);
		}
		
		$data = json_encode($data);
		$data=array('response'=>$data);
		$this->load->view('ajax',$data);
	}
	
	function data_profile(){
		$logged_in = $this -> session -> userdata('logged_in');
		if(!empty($logged_in)){
			$this->load->model("user_model");
			$data['profile'] = $this->user_model->get_user_profile( $logged_in['id'] );
			$data = json_encode($data);
			$data=array('response'=>$data);
			$this->load->view('ajax',$data);
		}else{
			show_404();
		}
	}
	
	function edit_profile(){
		$logged_in = $this -> session -> userdata('logged_in');
		if(!empty($logged_in)){
			$this->load->model("user_model");
			$active_user = $this->user_model->get_user($logged_in['id']);
		
			if(!empty($active_user)){
				$this->form_validation->set_rules('name', 'Nombre', 'trim|required|xss_clean|prep_for_form|htmlspecialchars|is_words_only');
				$this->form_validation->set_rules('lastname', 'Nombre', 'trim|required|xss_clean|prep_for_form|htmlspecialchars|is_words_only');
				$this->form_validation->set_rules('street', 'Calle', 'trim|xss_clean|prep_for_form|htmlspecialchars');
				$this->form_validation->set_rules('ward', 'Colonia', 'trim|xss_clean|prep_for_form|htmlspecialchars');
				$this->form_validation->set_rules('number_ext', 'Número Exterior', 'trim|xss_clean|prep_for_form|htmlspecialchars');
				$this->form_validation->set_rules('number_int', 'Número Interior', 'trim|xss_clean|prep_for_form|htmlspecialchars');
				$this->form_validation->set_rules('zipcode', 'Código Postal', 'trim|xss_clean|prep_for_form|htmlspecialchars|max_length[5]|is_natural');
				$this->form_validation->set_rules('state', 'Estado', 'trim|xss_clean|prep_for_form|htmlspecialchars');
				$this->form_validation->set_rules('city', 'Municipio', 'trim|xss_clean|prep_for_form|htmlspecialchars');
				$this->form_validation->set_rules('phone', 'Teléfono', 'trim|xss_clean|prep_for_form|htmlspecialchars|min_length[10]|max_length[10]|is_natural');
				$this->form_validation->set_rules('cellphone', 'Celular', 'trim|xss_clean|prep_for_form|htmlspecialchars|min_length[10]|max_length[10]|is_natural');
				
				if($this->form_validation->run() == FALSE) {
					$data = array('success' =>0, 'errors' => $this->form_validation->error_array());
				} else {

					$data['name'] = $this->input->post('name');
					$data['lastname'] = $this->input->post('lastname');
					$data['street'] = $this->input->post('street');
					$data['ward'] = $this->input->post('ward');
					$data['number_ext'] = $this->input->post('number_ext');
					$data['number_int'] = $this->input->post('number_int');
					$data['zipcode'] = $this->input->post('zipcode');
					$data['state'] = $this->input->post('state');
					$data['city'] = $this->input->post('city');
					$data['phone'] = $this->input->post('phone');
					$data['cellphone'] = $this->input->post('cellphone');

					$edit = $this->user_model->edit_profile( $data, $logged_in['id'] );

					if($edit){
						/*
						Enviar correo sobre datos de la persona cuando edita su perfil
						útil para cuando los ganadores llenan sus datos
						
						$this->load->model("locations_model");
						$ward = $this->locations_model->get_ward( $data['ward'] );
						if(!empty($ward)){
							$data['ward'] = $ward->name;
						}
						$city = $this->locations_model->get_city( $data['city'] );
						if(!empty($city)){
							$data['city'] = $city->name;
						}
						$state = $this->locations_model->get_state( $data['state'] );
						if(!empty($state)){
							$data['state'] = $state->name;
						}
						$this->load->library('user_agent');
						$data['agent'] = $this->security->xss_clean($this->agent->agent_string());
						$data['logged_in'] = $this->session->userdata("logged_in");

						
						$this->load->library('email');
						$this->email->to("correo@sitio.com");
						$this->email->from("correo@sitio.com", "SITIO");
						$this->email->subject("Datos de usuario ganador");
						$this->email->message($this->load->view("email/datos_ganador",$data,true));
						$this->email->send();
						*/
						
						$data = array('success' =>1, 'data' => ('Perfil editado satisfactoriamente.'));
					}else{
						$data = array('success' =>0, 'data' => ('Ocurrió un error durante el proceso.'));
					}
				}
					
				$data = json_encode($data);
				$data=array('response'=>$data);
				$this->load->view('ajax',$data);
			}else
				show_404();
		}else
			show_404();
	}
	
	function _unique_email( $email ){
		$logged_in = $this -> session -> userdata('logged_in');
		$this->load->model("user_model");
		$this->form_validation->set_message('_unique_email', 'El email introducido ya se encuentra registrado en el sistema, favor de rectificarlo.');
		$user_by_email = $this->user_model->get_user_email( $email );
		return empty($user_by_email);
	}
	
	function _terminos( $value ) {
		$this->form_validation->set_message('_terminos', 'Debes aceptar los términos y condiciones.');
		return ($value=='on')?true:false;
	}
	
	function _privacidad( $value ) {
		$this->form_validation->set_message('_privacidad', 'Debes aceptar el aviso de privacidad.');
		return ($value =='on')?true:false;
	}
	
	public function _valid_captcha($captcha){
		/*Captcha*/
		$this->load->library('securimage');
		$securimage = new Securimage();
		
		if (!$securimage->check($captcha)) {
			return FALSE;
		}else{
			return TRUE;
		}
	}
	
	private function _generate_confirm( $length = 32 ){
		$this->load->helper('security');
		$this->load->model("account_model");
		do{
			$salt = do_hash(time().mt_rand());
			$key = substr($salt, 0, $length);
			$confirm = $this->account_model->get_confirm($key);
		}while ( !empty( $confirm ) );
		return $key;
	}
	
	private function _generate_recovery( $length = 32 ){
		$this->load->helper('security');
		$this->load->model("account_model");
		do{
			$salt = do_hash(time().mt_rand());
			$key = substr($salt, 0, $length);
			$recovery = $this->account_model->get_recovery($key);
		}while ( !empty( $recovery ) );
		return $key;
	}
}