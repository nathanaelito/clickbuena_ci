<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Winners_model extends CI_Model {
	
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}
	
	function get_winners() {
			return array();
	}
	
	function get_winner_user( $user_id ) {
		return array();
	}
	
	function is_winner( $user_id ){
		$query = $this->db->query("SELECT count(1) as total FROM winner WHERE user_id=?", $user_id);
		//echo $this->db->last_query();
		if($query->num_rows() > 0){
			$total = $query->row()->total;
			if($total>0){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
}