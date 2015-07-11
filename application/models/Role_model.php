<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Role_model extends CI_Model {
	
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

	function get_role( $role_id ) {
		$query = $this->db->query("SELECT * FROM role WHERE id=?",array($role_id));
		//echo $this->db->last_query();
		if($query->num_rows() > 0){
			return $query->row();
		}else
			return null;
	}
	
	function get_roles() {
		$query = $this->db->query("SELECT * FROM role",array());
		//echo $this->db->last_query();
		if($query->num_rows() > 0){
			return $query->result();
		}else
			return array();
	}
}