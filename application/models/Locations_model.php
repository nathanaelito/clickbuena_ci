<?php defined('BASEPATH') OR exit('No direct script access allowed');
class locations_model extends CI_Model {

	function __construct(){
        parent::__construct();
		$this->load->database();
    }
	
	
	function get_states(){
		$query = $this->db->query("SELECT * FROM info_location_states order by name asc");
		
		if($query->num_rows() > 0){
			return $query->result();
		}else
			return array();
	}
	
	function get_state( $state_id ){
		$query = $this->db->query("SELECT * FROM info_location_states WHERE id=?",array($state_id));
		
		if($query->num_rows() > 0){
			return $query->row();
		}else
			return null;
	}
	
	function get_cities($state_id){
		$query = $this->db->query("SELECT * FROM info_location_cities WHERE state=? order by name asc", array($state_id));
		
		if($query->num_rows() > 0){
			return $query->result();
		}else
			return array();
	}
	
	function get_city($city_id){
		$query = $this->db->query("SELECT * FROM info_location_cities WHERE id=?", array($city_id));
		
		if($query->num_rows() > 0){
			return $query->row();
		}else
			return null;
	}
	
	function get_wards($city_id){
		$query = $this->db->query("SELECT * FROM info_location_wards WHERE city=? order by name asc", array($city_id));
		
		if($query->num_rows() > 0){
			return $query->result();
		}else
			return array();
	}
	
	function get_ward($ward_id){
		$query = $this->db->query("SELECT * FROM info_location_wards WHERE id=?", array($ward_id));
		
		if($query->num_rows() > 0){
			return $query->row();
		}else
			return null;
	}
	
	function get_location($zipcode){
		$query = $this->db->query("SELECT 
		info_location_states.id as state_id, info_location_states.name as state_name,
		info_location_cities.id as city_id, info_location_cities.name as city_name,
		info_location_wards.id as ward_id, info_location_wards.name as ward_name
		FROM info_location_states
		LEFT JOIN info_location_cities ON info_location_states.id = info_location_cities.state
		LEFT JOIN info_location_wards ON info_location_cities.id = info_location_wards.city
		WHERE zipcode=? order by info_location_wards.name asc", array($zipcode));
		
		if($query->num_rows() > 0){
			return $query->result();
		}else
			return array();
	}
}