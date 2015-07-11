<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Examples extends MY_Controller {
	function index(){
		$data_contenido = array();
		
		/* Current code to redeem */
		$sess_code = $this->session->userdata('sess_code');
		$data_contenido['codigo'] = ($sess_code)?$sess_code:"";
		
		/* Faceboook connect */
		$fbuser = $this->session->userdata("facebook_register");
		$data["name"] = "";
		$data["email"] = "";
		$data["fbuser"] = $fbuser;
		if(!empty($fbuser)){
			$data_contenido["name"] = $this->form_validation->words_only( !empty($fbuser['first_name'])?$fbuser['first_name']:"" );
			$data_contenido["lastname"] = $this->form_validation->words_only( !empty($fbuser['last_name'])?$fbuser['last_name']:"" );
			$data_contenido["email"] = (!empty($fbuser['email']))?$fbuser['email']:"";
		}
		$data_contenido['fbuser'] = $fbuser;
		
		$data_contenido['logged_in'] = $this->session->userdata("logged_in");
		$data['contenido'] = $this->load->view("examples", $data_contenido,true);
		$this->load->view("base", $data);
		
	}
}