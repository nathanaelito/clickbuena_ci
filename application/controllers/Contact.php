<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contact extends MY_Controller {
	var $contact_email = "alejandro.olp+contacto@gmail.com";
	
	public function __construct(){
		parent::__construct();
	}

	public function index(){
		show_404();
	}

	public function send(){
		$this->form_validation->set_rules('name', 'Nombre Completo', 'trim|required|xss_clean|max_length[100]|is_words_only');
		$this->form_validation->set_rules('email', 'Correo', 'trim|required|valid_email|xss_clean|max_length[256]');
		$this->form_validation->set_rules('message', 'Mensaje', 'trim|required|xss_clean|min_length[10]|max_length[20480]');
		$this->form_validation->set_rules('captcha', 'código de validación', 'trim|required|callback__valid_captcha');
		$this->form_validation->set_rules('privacy_cbox', 'Política de Privacidad', 'trim|callback__privacidad');
		
		if($this->form_validation->run() == FALSE) {
			$output = array('success' =>0, 'errors' => $this->form_validation->error_array());
		} else {
			$data['name']=$this->input->post('name');
			$data['email']=$this->input->post('email');
			$data['message']=$this->input->post('message');

			$this->load->library('user_agent');
			$data['agent'] = $this->security->xss_clean($this->agent->agent_string());
			$data['logged_in'] = $this->session->userdata("logged_in");
			
			$this->load->library('email');
			$this->email->to( $this->contact_email );
			//$this->email->bcc("");
			$this->config->load('email');
			$this->email->from( $this->config->item("smtp_user") );
			$this->email->reply_to($data['email'], $data['name']);
			$this->email->subject("Contacto: ".$data['name']);
			$this->email->message($this->load->view("email/contact",$data,true));
			if($this->email->send()){
				$output = array('success' =>1, 'data' => 'Tu información ha sido enviada correctamente, nosotros la revisaremos.');
			}else{
				$output = array('success' =>0, 'data' => 'Ocurrió un error durante el proceso.');
			}
		}
		$data = json_encode($output);
		$data=array('response'=>$data);
		$this->load->view('ajax',$data);
	}
	
	function _privacidad( $value ) {
		$this->form_validation->set_message('_privacidad', 'Debes aceptar el aviso de privacidad.');
		return ($value=='on')?true:false;
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
}