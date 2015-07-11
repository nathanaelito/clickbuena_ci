<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends MY_Controller {
	function index(){
		$data_contenido = array();
		$data['contenido'] = $this->load->view("home", $data_contenido,true);
		$this->load->view("base", $data);
	}
}