<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
http://www.youtube.com/watch?v=EL-WWQ0RnnA&list=EC61E46B981C930D36
*/
class Social extends MY_Controller {
	function __construct(){
		parent::__construct();
	}
	
	public function facebook_request($accion=""){
		$this->load->library('fbconnect');
		$data = array(
			'redirect_uri' => site_url('social/facebook_handle_login/'.$accion),
			'scope' => 'email'
		);
		redirect($this->fbconnect->getLoginUrl($data));
	}

	public function facebook_handle_login($accion=""){
		$this->load->library('fbconnect');
		$this->load->model('account_model');
		$this->load->model('user_model');
		
		if($this->fbconnect->user){
			//print_r($this->fbconnect->user);
			$account=$this->account_model->get_account_by_key($this->fbconnect->user['id'],1); //
			if(!empty($account)){
				$user = $this->user_model->get_user( $account->user_id );
				if(!empty($user)){
					$this->load->model("ban_model");
					$banned = $this->ban_model->banned( $user->id, 8 );
					if(empty($banned)){
						$sess_array = array(
							'id' => $user -> id,
							'fid' => (!empty( $account )? $account->account_key :""),
							'correo' => $user->email,
							'role' => $user->role
						);
						$this -> session -> set_userdata('logged_in', $sess_array);
						$sess_code = $this->session->userdata('sess_code');
						if(!empty($sess_code)){
							$this->_redirect_back("canje");
						}else{
							$this->_redirect_back();
						}
					}else{
						//Baneado
						$this->session->unset_userdata('facebook_register');
						$this->_redirect_back();
					}
				}else{
					$this->_redirect_back(); //no existe el usuario, llevar al registro
				}	
			}else{
				$this->_redirect_back(); $this->_redirect_back(); //no existe la cuenta de facebook, llevar al registro
			}
		}else{
			redirect();
		}
	}
	
	function _redirect_back( $accion="" ){
		$this->load->library('user_agent');
		
		$url = base_url();
		switch($accion){
			case "registro": 
				$url = site_url("#!/registro");
			break;
			case "canje": 
				$url = site_url("#!/canjear");
			break;
			default:
				if ($this->agent->is_referral()){
					$url =  $this->agent->referrer();
				}else{
					$url = base_url();
				}
			break;
		};
		$this -> session -> set_userdata('facebook_register', $this->fbconnect->user);
		redirect( $url );
	}
	
	public function facebook_cancel(){
		$this->session->unset_userdata('facebook_register');
		$data = json_encode(array("status"=>true));
		$data=array('response'=>$data);
		$this->load->view('ajax',$data);
	}
}