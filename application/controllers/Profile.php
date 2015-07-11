<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Perfil extends MY_Controller {
	public function __construct(){
		parent::__construct();
	}

	public function index(){
		show_404();
	}
	
	public function data(){
		$logged_in = $this->session->userdata('logged_in');
		if(!empty($logged_in)){
			$this->load->model("user_model");
			$this->load->model("account_model");
			$user = $this->user_model->get_user( $logged_in['id'] );
			unset($user->password);
			unset($user->salt);
			$data['user'] = $user;
			
			$profile = $this->user_model->get_user_profile( $logged_in['id'] );
			unset($profile->promotion);
			$data['profile'] = $profile;
			
			$this->load->model("mod_calendar_model");
			$current_calendar = $this->mod_calendar_model->get_current_calendar();
			$event_id = !empty( $current_calendar )? $current_calendar->id: null;
			
			$data['account'] = $this->account_model->get_account( $logged_in['id'], 1 );
			$data['points'] = number_format( $this->user_model->get_total_points( $event_id, $logged_in['id'] ) );
		}else{
			$data = array();
		}	
		
		$data = json_encode($data);
		$data=array('response'=>$data);
		$this->load->view('ajax',$data);
	}
	
	public function codes_redemption( $pagina = 0 ){
		$logged_in = $this->session->userdata('logged_in');
		if(!empty($logged_in)){
			$pagina+=0;
			if(! (is_int($pagina) && $pagina>0)){
				$pagina = 1;
			}
			
			$por_pagina = 10;
		
			$this->load->model("codes_model");
			$total = $this->codes_model->total_redemption_codes( $logged_in['id'] );
			//$codes = $this->codes_model->get_redemption_codes( $logged_in['id'], $por_pagina, $pagina );
			$codes = $this->codes_model->get_redemption_codes( $logged_in['id'] );
			$data['codes']=$codes;
			
			$this->load->library('pagination');
			$config['base_url'] = site_url("profile/codes_redemption");
			$config['total_rows'] = $total;
			$config['per_page'] = $por_pagina;

			$this->pagination->initialize($config);
			$data['pag']=$this->pagination->create_links();	
		}else{
			$data['guessing']=array();
			$data['pag']=array();
		}	
		
		$data = json_encode($data);
		$data=array('response'=>$data);
		$this->load->view('ajax',$data);
	}
}