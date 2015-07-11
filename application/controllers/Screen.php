<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Screen extends CI_Controller {
	public function __construct(){
		parent::__construct();
	}

	function old_browser(){
		$data = array();
		$this->load->view("screen/old_browser",$data);
	}
	function error_404(){
		$data = array();
		$this->output->set_status_header('404');
		$this->load->view("screen/error_404",$data);
	}
	function maintenance(){
		$data = array();
		$this->load->view("screen/maintenance",$data);
	}
}