<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Ban_model extends CI_Model {
	
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

	function get_ban($ban_id) {
		$query = $this->db->query("SELECT * FROM ban WHERE id=?",array($ban_id));
		//echo $this->db->last_query();
		if($query->num_rows() > 0){
			return $query->row();
		}else
			return null;
	}
	
	function redeem_banned($user_id) {
		$query = $this->db->query("SELECT * FROM ban WHERE user_id=? AND (type & 4) = 4 AND NOW()>=start AND NOW() < start + interval `minutes` minute",array($user_id));
		//echo $this->db->last_query();
		if($query->num_rows() > 0){
			return $query->row();
		}else
			return null;
	}
	
	/*
		Binary mask
		(3) +8 login
		(2)	+4 redimir
		(1)	+2 concursar
		(0)	+1 ganar
		
		Ejemplos: 
		
		Ban para login
		1000 => 8
		
		Ban para login y redimir
		1100 => 12
		
		Ban para concursar y ganar
		0011 => 3
	*/
	function banned($user_id, $type) {
		$query = $this->db->query("SELECT * FROM ban WHERE user_id=? AND (type & ?) = ?",array($user_id,$type,$type));
		//echo $this->db->last_query();
		if($query->num_rows() > 0){
			return $query->row();
		}else
			return null;
	}

	function create( $data ){
		$user_id = $data['user_id'];
		$type = $data['type'];
		$minutes = $data['minutes'];

		$this->db->trans_begin();
		$this->db->query("INSERT INTO ban (user_id,type,start,minutes) VALUES (?,?,NOW(),?) ON DUPLICATE KEY UPDATE start=NOW(), minutes=?, type = (type | ?);", 
		array($user_id, $type, $minutes, $minutes, $type));

		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}
	}
	
	function unflag($user_id, $mask ){
		$this->db->trans_begin();
		$this->db->query("UPDATE ban SET type = (type & ?) WHERE user_id=?;", 
		array($mask, $user_id));

		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}
	}
}