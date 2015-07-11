<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MY_Controller extends CI_Controller{
	public function __construct(){
		parent::__construct();
		
		$this->load->helper('url');
		$this->load->library('user_agent');

		if ($this->agent->browser() == 'Internet Explorer' and $this->agent->version() <= 7){
			redirect('screen/old_browser');
		}
		
		/* Sistema de mantenimiento */
		$this->load->config('general');
		$maintenance = $this->config->item("maintenance");
		$current_class = $this->router->fetch_class();
		$current_method = $this->router->fetch_method();
		if(!empty($maintenance)){
			if( is_array( $maintenance ) ){
				foreach($maintenance as $class_name=>$class){
					if(empty($class)){
						if($current_class == $class_name){
							redirect('screen/maintenance');
						}
					}else{
						foreach($class as $method_name){
							if($current_class == $class_name && $current_method == $method_name){
								redirect('screen/maintenance');
							}
						}
					}
				}
			}else if( $maintenance == true){
				redirect('screen/maintenance');
			}
		}
		
		/*Verificar baneo*/
		$logged_in = $this->session->userdata('logged_in');
		if(!empty($logged_in)){
			$this->load->model("ban_model");
			$banned = $this->ban_model->banned( $logged_in['id'], 8 );
			if(!empty($banned)){
				$this->session->sess_destroy();
				$this->session->sess_create();
			}
		}
	}
}