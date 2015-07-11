<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Codes_model extends CI_Model {
	
	function __construct(){
        parent::__construct();
		$this->load->database();
    }
	
	function get_code($id) {
		$this->load->library("Mongo_db");
		return $this->mongo_db->select()->where(array('_id' => $id))->get("codes");
	}

	function redeem_code($id, $user_id=NULL){
		$this->load->library("Mongo_db");
		return $this->mongo_db->where(array('_id' => $id))->set(array("redeemed"=>true, "user"=>$user_id))->update('codes');
	}
	
	function get_redemption_codes($user_id, $por_pagina=null, $pagina=null) {
		$paginacion="";
		if(isset($por_pagina) && isset($pagina)){
			$paginacion = " LIMIT ".(($pagina-1)*$por_pagina).",".$por_pagina;
		}
		
		$query = $this->db->query("SELECT id,code,value,redemption_date FROM codes_redemption WHERE user_id=?".$paginacion,array($user_id));
		
		if($query->num_rows() > 0){
			return $query->result();
		}else
			return array();
	}
	
	function total_redemption_codes($user_id){
		$query = $this->db->query("SELECT count(1) as total FROM codes_redemption WHERE user_id=?", array($user_id));
		if($query->num_rows() > 0){
			return $query->row()->total;
		}else
			return 0;
	}
	
	function log_codes_redemption($code,$user_id){
		$this->db->trans_begin();

		$this->db->query("INSERT INTO codes_redemption (code,type,value,status,redemption_date,user_id,flag,tag) VALUES(?,1,?,1,NOW(),?,0,?)", 
		array($code['_id'],$code['points'],$user_id,$code['tag']));
		
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}
	}
	
	/* Redemption Attemps */
	
	function get_redemption_attempt_user($user_id){
		$query = $this->db->query("SELECT * FROM redemption_attempt_log WHERE user_id=?", array($user_id));
		
		if($query->num_rows() > 0){
			return $query->result();
		}else
			return array();
	}
	
	function get_redemption_attempt($id){
		$query = $this->db->query("SELECT * FROM redemption_attempt_log WHERE id=?", array($id));
		
		if($query->num_rows() > 0){
			return $query->row();
		}else
			return null;
	}
	
	function count_redemption_attempt_time($user_id){ 
		//Last minute
		$query = $this->db->query("SELECT count(id) as total FROM `redemption_attempt_log` WHERE user_id=? AND date >= now() - interval 1 minute;", array($user_id));
		
		if($query->num_rows() > 0){
			return $query->row()->total;
		}else
			return 0;
	}
	
	function add_redemption_attempt( $user_id, $code, $status ){
		$this->db->trans_begin();

		$this->db->query("INSERT INTO redemption_attempt_log (user_id,code,status,date) VALUES(?,?,?,NOW());", 
		array($user_id,$code,$status));
		
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}
	}
	
	function time_since_last_redeem( $user_id ){
		$query = $this->db->query("SELECT ( UNIX_TIMESTAMP() - UNIX_TIMESTAMP(redemption_date)) as seconds FROM `codes_redemption` WHERE user_id=? ORDER BY redemption_date DESC LIMIT 1", array($user_id));
		
		if($query->num_rows() > 0){
			return $query->row()->seconds;
		}else
			return 0;
	}
	
	function last_redemeed( $user_id, $lapse ){
		$query = $this->db->query("SELECT count(1) as total FROM `codes_redemption` WHERE user_id=? AND NOW() - interval ? second < redemption_date ORDER BY redemption_date DESC", array($user_id, $lapse));
		if($query->num_rows() > 0){
			return $query->row()->total;
		}else
			return 0;
	}
}