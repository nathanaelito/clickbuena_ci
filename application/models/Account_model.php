<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Account_model extends CI_Model {
	
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}
	
	function get_account($user_id, $type_id) {
		$query = $this->db->query("SELECT * FROM account WHERE user_id=? AND account_type_id=?",array($user_id,$type_id));
		//echo $this->mjDB->last_query();
		if($query->num_rows() > 0){
			return $query->row();
		}else
			return null;
	}
	
	function get_account_by_key($account_key, $type_id) {
		$query = $this->db->query("SELECT * FROM account WHERE account_key=? AND account_type_id=?",array($account_key,$type_id));
		//echo $this->mjDB->last_query();
		if($query->num_rows() > 0){
			return $query->row();
		}else
			return null;
	}
	
	function get_accounts( $user_id ) {
		$query = $this->db->query("SELECT * FROM account WHERE user_id=?",array($user_id));
		//echo $this->db->last_query();
		if($query->num_rows() > 0){
			return $query->row();
		}else
			return null;
	}
	
	function create( $data ){
		$user_id = $data['user_id'];
		$account_key = $data['account_key'];
		$account_type_id = $data['account_type_id'];
		
		$this->db->trans_begin();
		$this->db->query("INSERT INTO account (user_id,account_key,account_type_id, register_date) VALUES (?,?,?,NOW())", 
		array($user_id, $account_key, $account_type_id));
		
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}
	}
	
	function create_confirm( $user_id, $key ){		
		$this->db->trans_begin();
		
		$this->db->query("INSERT INTO account_confirm (id,user_id,record_date) VALUES (?,?,NOW())", array($key,$user_id));
		
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}
	}
	
	function get_confirm( $id ){
		$query = $this->db->query("SELECT * FROM account_confirm WHERE id=?",array($id));
		//echo $this->mjDB->last_query();
		if($query->num_rows() > 0){
			return $query->row();
		}else
			return null;
	}
	
	function confirm( $user_id ){
		$this->db->trans_begin();
	
		$query = $this->db->query("SELECT * FROM user WHERE id=?", array($user_id));
		if($query->num_rows() > 0){
			$user = $query->row();
			
			$this->db->query("DELETE FROM account_confirm WHERE user_id=?", array( $user_id ));
			$this->db->query("UPDATE user SET status=1 WHERE id=?", array( $user_id ));
			$this->db->query("DELETE FROM user WHERE status=0 AND email = ?",array( $user->email ));
		}
		
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}
	}
	
	function delete_confirm($id){
		$this->db->trans_begin();
		$this->db->query("DELETE FROM account_confirm WHERE id=?", 
		array($id));
		
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}
	}
	
	function create_recovery( $email, $token){
		$this->db->trans_begin();
		
		$query = $this->db->query("SELECT id FROM user WHERE email=?",array($email));
		if ($query->num_rows() > 0){
			$user=$query->row();
			$query2 = $this->db->query("SELECT id FROM account_recover  WHERE record_date > (NOW()-interval 1 minute)  AND user_id = ?",array($user->id));
			if ($query2->num_rows() == 0){
				$this->db->query("INSERT INTO account_recover (user_id,id,record_date) VALUES (?,?,NOW())", array($user->id,$token));
			}else{
				return -2; //Aun no puedes
			}
		}else
			return -3; //No existe
		
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return -1;
		}else{
			$this->db->trans_commit();
			return 1;
		}
	}
	
	function get_recovery($token){
		$query = $this->db->query("SELECT * FROM account_recover WHERE id=?",array($token));
		//echo $this->db->last_query();
		if($query->num_rows() > 0){
			return $query->row();
		}else
			return null;
	}
	
	function delete_recovery($user_id){
		$this->db->trans_begin();

		$this->db->query("DELETE FROM account_recover WHERE user_id=?", array($user_id));
		
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}
	}
	
	function update_password($password, $user_id){
		$this->db->trans_begin();

		$salt = random_string('alnum', 24);
		$password=hash('sha256', $salt.$password);
		$this->db->query("UPDATE user SET salt=?, password=? WHERE id=?", array($salt, $password, $user_id));
		
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}
	}
	
	function delete($id){
		$this->db->trans_begin();
		$this->db->query("DELETE FROM account WHERE user_id=?", 
		array($id));
		
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}	
	}
}