<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Winners extends MY_Controller {

	public function __construct(){
		parent::__construct();
	}

	public function index(){
		show_404();
	}
	
	public function data(){
		$this->load->model("winners_model");
		$ganadores = $this->winners_model->get_winners();
		
		$data = json_encode(
			$ganadores
		);
		$data=array('response'=>$data);
		$this->load->view('ajax',$data);
	}
}