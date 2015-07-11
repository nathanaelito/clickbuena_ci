<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Panel extends CI_Controller {
	function index(){
		$logged_in = $this->session->userdata("logged_in");
		if(!empty($logged_in)){
			if($logged_in['role']==1){
				redirect("panel/users");
			}else{
				redirect(""); //primera sección para editores, cambiar por "panel/seccion_para_editores"
			}
		}else{
			$this->load->view("admin/login");
		}
	}
	
	function users(){
		$logged_in = $this->session->userdata("logged_in");
		if(!empty($logged_in) && $logged_in['role']==1){
			$tmpl = array ( 'table_open'  => '<table id="users_dt" class="table table-bordered table-striped users_dt" cellpadding="0" cellspacing="0" border="0" width="100%">' );
			$this->load->library('table');
			$this->table->set_template($tmpl);
			$this->table->set_heading('Email','Role', 'Options');
			$this->table->set_footer('Email','Role', 'Options');
			$data_contenido["table"] = $this->table->generate();
		
			$data['logged_in'] = $logged_in;
			$data["contenido"]=$this->load->view("admin/users",$data_contenido,true);
			$this->load->view("admin/base", $data);
		}else{
			redirect();
		}
	}
}