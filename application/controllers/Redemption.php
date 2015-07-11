<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Redemption extends MY_Controller {
	public function __construct(){
		parent::__construct();
	}


	public function index(){		
		show_404();
	}
	
	function _sanitize_code( $code ){
		$code = strtoupper( trim( $code ) );
		$code = $this->security->xss_clean($code);
		return $code;
	}
	
	function redeem(){
		$code = $this->input->post('code');
		$captcha = $this->input->post('captcha');

		$code = $this->_sanitize_code( $code );
		$logged_in = $this->session->userdata('logged_in');
		if(!empty($logged_in)){
			$this->session->unset_userdata('sess_code');
			$this->form_validation->set_rules('code', 'Código', 'required|alpha_numeric|min_length[10]|max_length[10]');
			if($captcha!== NULL){
				$this->form_validation->set_rules('captcha', 'Código de Validación', 'trim|required|callback__valid_captcha');
			}
			if($this->form_validation->run() == FALSE) {
				$data = array('success' =>0, 'errors' => $this->form_validation->error_array());
			} else {
				$this->load->model("request_model");
				$data_request['url'] = uri_string();
				$data_request['user_id'] = $logged_in['id'];
				$this->request_model->create( $data_request );
			
				$captcha = $this->input->post('captcha');
				if(!$this->_validate_redeem_attempt()){
					$this->load->model("ban_model");
					$data_ban['user_id'] = $logged_in['id'];
					$data_ban['type'] = 4;
					$data_ban['minutes'] = 10;
					$this->ban_model->create( $data_ban );

					$data = array('success' =>0, 'data' => "IGNORE");
				}else{
					$this->load->model("codes_model");
					
					$last_redemeed = $this->codes_model->last_redemeed( $logged_in['id'], 86400); //24 hours
					if( $last_redemeed < 3 || $captcha!== NULL){
						$codes = $this->codes_model->get_code($code);
						
						if(!empty($codes)){
							$codedb = $codes[0];
							if(!empty($codedb['redeemed']) && $codedb['redeemed']==true){
								if(!empty($codedb['user']) && $codedb['user']==$logged_in['id']){
									$data = array('success' =>0, 'data' => "ALREADY_REDEEMED_BY_SAME_USER");
								}else{
									$this->_sess_code_errors($code, "ALREADY_REDEEM");
									$data = array('success' =>0, 'data' => "ALREADY_REDEEM");
								}
							}else{
									$redeem = $this->codes_model->redeem_code($code, $logged_in['id']);
									if($redeem){
										$this->codes_model->log_codes_redemption($codedb, $logged_in['id']);

										$actions = $this->session->userdata("actions");
										if( !empty($actions) && $actions['action']=="redeem"){
											$this->session->set_userdata("actions", '');
										}
										
										$data = array('success' =>1, 'data' => "GOOD", 'code'=>$code);
									}else{
										$data = array('success' =>0, 'data' => "REDEEM_ERROR");
									}
							}
						}else{
							$this->_sess_code_errors($code, "CODE_DONT_EXIST");
							$data = array('success' =>0, 'data' => "CODE_DONT_EXIST");
						}
					}else{
						$data = array('success' =>0, 'data' => "CAPTCHA_REQUIRED", 'code'=>$code);
					}
				}
			}
		}else{
			$this->session->set_userdata('sess_code',$code);
			$this->session->set_userdata("actions", array("action"=>"redeem","data"=>$code));
			$data = array('success' =>0, 'data' => "LOGIN_REQUIRED");
		}

		$data = json_encode($data);
		$data=array('response'=>$data);
		$this->load->view('ajax',$data);
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
	
	function _validate_redeem_attempt(){
		$logged_in = $this->session->userdata('logged_in');
		if(!empty($logged_in)){
			$this->load->model("ban_model");
			$banned = $this->ban_model->redeem_banned( $logged_in['id'] );
			if(!empty($banned) && $banned){
				return false; //10min BANNED
			}
			
			$this->load->model("codes_model");
			$total = $this->codes_model->count_redemption_attempt_time( $logged_in['id'] );
			if($total>12){ //más de 12 intentos por minuto
				return false;
			}else{
				return true;
			}
		}else{
			return false;
		}
	}
	
	function _sess_code_errors( $code="",  $status="" ){
		$logged_in = $this->session->userdata('logged_in');
		if(!empty($logged_in)){
			$this->load->model("codes_model");
			$this->codes_model->add_redemption_attempt( $logged_in['id'], $code, $status );
		}
	}
}