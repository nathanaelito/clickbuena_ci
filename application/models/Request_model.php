<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Request_model extends CI_Model {
	
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}
	
	function create( $data ){
		$user_id = $data['user_id'];
		$url = $data['url'];
		$ip_address = $this->input->ip_address();
		$user_agent = $this->security->xss_clean($this->agent->agent_string());

		$this->db->trans_begin();
		$this->db->query("INSERT DELAYED INTO requests_log (user_id, url, ip_address, user_agent, register_date) VALUES (?,?,?,?,NOW());", 
		array($user_id, $url, $ip_address, $user_agent));

		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}
	}
}