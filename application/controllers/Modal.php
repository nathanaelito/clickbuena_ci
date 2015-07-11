<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Modal extends MY_Controller {
	function __construct(){
		parent::__construct();
		$this->form_validation->set_error_delimiters('', '<br/>');
	}
	
	public function index(){
		show_404();
	}
	
	function terminos(){
		$this->load->view("modal/terminos");	
	}
	
	function privacidad(){
		$this->load->view("modal/privacidad");	
	}
	
	function login(){
		$this->load->view("modal/login");	
	}
	
	function editar_perfil(){
		$logged_in = $this->session->userdata("logged_in");
		if( !empty($logged_in) ){
			$this->load->view("modal/editar_perfil");
		}else{
			show_404();
		}
	}
	
	function redemption_captcha(){
		$this->load->view("modal/redemption_captcha");	
	}
}
	