<?php

class Audittrailmodel extends CI_Model {

    private $tbl_roles= 'audittrail';
   function __construct()
   {
       parent::__construct();
   }
   
   //get all the roles

	 function get_list() {

		$data = array();

		$Q = $this->db->get('audittrail');

		if ($Q->num_rows() > 0) {

			foreach ($Q->result_array() as $row){

		         	$data[] = $row;

		        }

		}	

		$Q->free_result();

		return $data;	

	}
	
	function get_report_list($reportingform_id)
	 {
	 	$array='array';
		$data = array();
		$this->db->select('t1.*, t2.*,t3.*')
          ->from('audittrail AS t1, reportingforms AS t2, users AS t3')
		  ->where('t1.reportingform_id = t2.id')
		  ->where('t1.user_id = t3.id')
		  ->where('t1.reportingform_id',$reportingform_id)
		  ->order_by('t1.id DESC');
		  
		return $this->db->get();
	 }

	// get number of roles in database

	function count_all(){

		return $this->db->count_all($this->tbl_roles);

	}

	// get roles with paging

	function get_paged_list($limit = 10, $offset = 0){

		$this->db->order_by('id','asc');

		return $this->db->get($this->tbl_roles, $limit, $offset);

	}

	// get role by id

	function get_by_id($id){

		$this->db->where('id', $id);

		return $this->db->get($this->tbl_roles);

	}

	// add new role

	function save($role){

		$this->db->insert($this->tbl_roles, $role);

		return $this->db->insert_id();

	}

	// update role by id

	function update($id, $role){

		$this->db->where('id', $id);

		$this->db->update($this->tbl_roles, $role);

	}

	// delete role by id

	function delete($id){

		$this->db->where('id', $id);

		$this->db->delete($this->tbl_roles);

	}


}
