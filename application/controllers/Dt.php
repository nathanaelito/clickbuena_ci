<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class DT extends CI_Controller {
	function users(){
		$logged_in = $this->session->userdata("logged_in");
		if(!empty($logged_in) && $logged_in['role']==1){
			$this->load->helpers('datatables_helper');
			$this->load->library('Datatables');
			$this->datatables->set_database("default");
			$this->datatables->select("id,email,(select name from role where role.id=user.role) as role_name")
			->from('user')
			//->join('role', 'role.id = user.role', 'left')
			->add_column('opciones', get_buttons_user('$1'),'id')
			->unset_column('id');
			
			$data=array('response'=>$this->datatables->generate());
			$this->load->view('ajax',$data);
		}else
			show_404();
	}
}