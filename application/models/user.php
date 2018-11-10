<?php

Class User extends CI_Model

{

	 

	  private $tbl_users= 'users';



	 function login($username, $password)

	 {

	   $this -> db -> select('id, username, password, isadmin, active');

	   $this -> db -> from('users');

	   $this -> db -> where('username = ' . "'" . $username . "'");

	   $this -> db -> where('password = ' . "'" . MD5($password) . "'");

	   $this -> db -> where('active = 1');

	   $this -> db -> limit(1);

	

	   $query = $this -> db -> get();

	

	   if($query -> num_rows() == 1)

	   {

		 return $query->result();

	   }

	   else

	   {

		 return false;

	   }

	 }

	 

	 	 //get all the roles

	 function get_list() {

		$data = array();

		$Q = $this->db->get('users');

		if ($Q->num_rows() > 0) {

			foreach ($Q->result_array() as $row){

		         	$data[] = $row;

		        }

		}	

		$Q->free_result();

		return $data;	

	}

	 

	 

	// get number of users in database

	function count_all(){

		return $this->db->count_all($this->tbl_users);

	}

	// get users with paging

	function get_paged_list($limit = 10, $offset = 0){

		$this->db->order_by('id','asc');

		return $this->db->get($this->tbl_users, $limit, $offset);

	}
	
	function get_paged_role($limit = 10, $offset = 0, $role_id){
			
		$this->db->where('role_id', $role_id);
		$this->db->order_by('id','asc');

		return $this->db->get($this->tbl_users, $limit, $offset);

	}

	// get user by id
	
	function get_by_hf_id($healthfacility_id){

		$this->db->where('healthfacility_id', $healthfacility_id);

		return $this->db->get($this->tbl_users);

	}

	function get_by_id($id){

		$this->db->where('id', $id);

		return $this->db->get($this->tbl_users);

	}
	
	function get_by_pass_or_id($idno){

		$this->db->where('idno', $idno);

		return $this->db->get($this->tbl_users);

	}
	

	

	

	function get_by_role($role_id) {

		$data = array();

		

		$this->db->select('t1.*')

          ->from('users AS t1')

          ->where('t1.role_id',$role_id);

		

		$Q  = $this->db->get();

		if ($Q->num_rows() > 0) {

			foreach ($Q->result_array() as $row){

		         	$data[] = $row;

		        }

		}	

		$Q->free_result();

		return $data;	

	}
	
	
	function get_by_referrrer($refferedby) {

		$data = array();

		

		$this->db->select('t1.*')

          ->from('users AS t1')

          ->where('t1.refferedby',$refferedby);

		

		$Q  = $this->db->get();

		if ($Q->num_rows() > 0) {

			foreach ($Q->result_array() as $row){

		         	$data[] = $row;

		        }

		}	

		$Q->free_result();

		return $data;	

	}

	
	
	// add new user

	function save($user){

		$this->db->insert($this->tbl_users, $user);

		return $this->db->insert_id();

	}

	// update user by id

	function update($id, $user){

		$this->db->where('id', $id);

		$this->db->update($this->tbl_users, $user);

	}

	// delete user by id

	function delete($id){

		$this->db->where('id', $id);

		$this->db->delete($this->tbl_users);

	}

}

?>