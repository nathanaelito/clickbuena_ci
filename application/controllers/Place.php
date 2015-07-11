<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Place extends CI_Controller {	
	var $logged_in;
	
	public function __construct(){
		parent::__construct();
	}
	
	function states(){
		$this->load->model("locations_model");
		$data = $this->locations_model->get_states();
		$data = json_encode($data);
		$data=array('response'=>$data);
		$this->load->view('ajax',$data);
	}
	
	function cities($state_id=1){
		$state_id += 0;
		if(is_int($state_id) && $state_id>0){
			$this->load->model("locations_model");
			$data = $this->locations_model->get_cities($state_id);
		}else
			$data = array();
		$data = json_encode($data);
		$data=array('response'=>$data);
		$this->load->view('ajax',$data);
	}
	
	function wards($city_id=1){
		$city_id += 0;
		if(is_int($city_id) && $city_id>0){
			$this->load->model("locations_model");
			$data = $this->locations_model->get_wards($city_id);
		}else
			$data = array();
		$data = json_encode($data);
		$data=array('response'=>$data);
		$this->load->view('ajax',$data);
	}
	
	function ubication( $zipcode="" ){
		$this->load->model("locations_model");
		$data = $this->locations_model->get_location($zipcode);
		$data = json_encode($data);
		$data=array('response'=>$data);
		$this->load->view('ajax',$data);
	}
}