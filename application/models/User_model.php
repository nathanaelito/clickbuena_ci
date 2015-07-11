<?php defined('BASEPATH') OR exit('No direct script access allowed');
class User_model extends CI_Model {
	
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}
	
	function get_user_email($email) {
		$query = $this->db->query("SELECT * FROM user WHERE email=?",array($email));
		//echo $this->db->last_query();
		if($query->num_rows() > 0){
			return $query->row();
		}else
			return null;
	}
	
	function get_user($user_id) {
		$query = $this->db->query("SELECT * FROM user WHERE id=?",array($user_id));
		//echo $this->db->last_query();
		if($query->num_rows() > 0){
			return $query->row();
		}else
			return null;
	}
	
	function get_user_profile($user_id) {
		$query = $this->db->query("SELECT * FROM user_profile WHERE user_id=?",array($user_id));
		//echo $this->db->last_query();
		if($query->num_rows() > 0){
			return $query->row();
		}else
			return null;
	}
	
	function create($data){
		$name = $data['name'];
		$lastname = $data['lastname'];
		
		$email = $data['email'];
		$salt = random_string('alnum', 24);
		$password = $data['password'];
		$password=hash('sha256', $salt.$password);
		$role = !empty($data['role'])?$data['role']:3;

		$this->db->trans_begin();
		$this->db->query("INSERT INTO user (email, salt, password, role, register_date) VALUES (?,?,?,?,NOW())", 
		array($email, $salt, $password, $role));
		$user_id = $this->db->insert_id();
		
		$this->db->query("INSERT INTO user_profile (user_id, name, lastname) VALUES (?,?,?)", 
		array($user_id, $name, $lastname));
		
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return $user_id;
		}	
	}

	function edit_profile( $data, $user_id ){
		$name = $data['name'];
		$lastname = $data['lastname'];
		$street = $data['street'];
		$ward = $data['ward'];
		$number_ext = $data['number_ext'];
		$number_int = $data['number_int'];
		$zipcode = $data['zipcode'];
		$state = $data['state'];
		$city = $data['city'];
		$phone = $data['phone'];
		$cellphone = $data['cellphone'];

		$this->db->trans_begin();
		$this->db->query("INSERT INTO user_profile (
			user_id, 
			name, 
			lastname, 
			street, 
			ward, 
			number_ext, 
			number_int, 
			zipcode, 
			state, 
			city, 
			phone, 
			cellphone
		) VALUES(?,?,?,?,?,?,?,?,?,?,?,?) ON DUPLICATE KEY UPDATE 
			name=?,
			lastname=?,
			street=?,
			ward=?,
			number_ext=?,
			number_int=?,
			zipcode=?,
			state=?,
			city=?,
			phone=?,
			cellphone=?
		", 
			array(
				$user_id,
				$name, 
				$lastname,
				$street, 
				$ward, 
				$number_ext, 
				$number_int, 
				$zipcode, 
				$state, 
				$city, 
				$phone,
				$cellphone,
				$name,
				$lastname,
				$street, 
				$ward, 
				$number_ext, 
				$number_int, 
				$zipcode, 
				$state, 
				$city, 
				$phone,
				$cellphone
			)
		);

		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback(); 
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}
	}
	
	function login( $data ){
		$email=$data['email'];
		$query = $this->db->query("SELECT id,email,password,salt,role FROM user WHERE email=? AND role=3",array($email));
		if ($query->num_rows() > 0){
			$user=$query->row();
			$password=hash('sha256', $user->salt.$data['password']);
			$this->load->helper("jacksecure_helper");
			if(slowEquals($user->password,$password)){
				return array("status"=>1, "user"=>$user); //Success
			}else
				return array("status"=>-1); //correo/*password incorrectos.
		}else
			return array("status"=>-2); //Usuario inexistente
		return array("status"=>-3);
	}
	
	/*Only Admins*/
	function login_panel( $data ){
		$email=$data['email'];
		$query = $this->db->query("SELECT id,email,password,salt,role FROM user WHERE email=? AND (role=1 OR role=2)",array($email));
		if ($query->num_rows() > 0){
			$user=$query->row();
			$password=hash('sha256', $user->salt.$data['password']);
			$this->load->helper("jacksecure_helper");
			if(slowEquals($user->password,$password)){
				return array("status"=>1, "user"=>$user); //Success
			}else
				return array("status"=>-1); //correo/*password incorrectos.
		}else
			return array("status"=>-2); //Usuario inexistente
		return array("status"=>-3);
	}
	
	function edit($data, $user_id){
		$name = $data['name'];
		$lastname = $data['lastname'];
		
		$email = $data['email'];
		$role = $data['role'];
		$password = $data['password'];
		
		$this->db->trans_begin();
		$this->db->query("UPDATE user SET email=?, role=? WHERE id=?", 
		array($email, $role,$user_id));

		$this->db->query("UPDATE user_profile SET name=?, lastname=? WHERE user_id=?", 
		array($name, $lastname,$user_id));
		
		if(!empty($password)){
			$salt = random_string('alnum', 24);
			$password=hash('sha256', $salt.$password);
			$this->db->query("UPDATE user SET salt=?, password=? WHERE id=?", array($salt, $password, $user_id));
		}
		
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}	
	}
	
	function delete( $user_id ){
		$this->db->trans_begin();
		$query = $this->db->query("DELETE FROM user WHERE id=?",array($user_id));
		//echo $this->db->last_query();
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}	
	}
}