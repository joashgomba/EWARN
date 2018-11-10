<?php

class Diseasesmodel extends CI_Model {

	private $tbl_roles= 'diseases';
   function __construct()
   {
       parent::__construct();
   }

   public function get_list()
   {
       $data = array();
       $Q = $this->db->get('diseases');
       if ($Q->num_rows() > 0) {
       	foreach ($Q->result_array() as $row){
       		$data[] = $row;
       	}
       }
       $Q->free_result();
       return $data;
   }
   
   function get_by_category_country($category_one,$country_id)
   {
	   $sql = "SELECT * FROM diseases
	   WHERE diseasecategory_id = ".$category_one."
	   AND country_id=".$country_id;
	   
	   $query = $this->db->query($sql);
        
      return $query->result();
   }
   
   function get_by_category($category_one,$country_id,$limit)
   {
	   $sql = "SELECT * FROM diseases
	   WHERE diseasecategory_id = ".$category_one."
	   AND country_id=".$country_id."
	   LIMIT ".$limit;
	   
	   $query = $this->db->query($sql);
        
      return $query->result();
   }
   
   function get_by_category_country_limit($category_one,$category_two,$country_id,$limit)
   {
	   $sql = "SELECT * FROM diseases
	   WHERE diseasecategory_id IN (".$category_one.",".$category_two.")
	   AND country_id=".$country_id."
	   LIMIT ".$limit;
	   
	   $query = $this->db->query($sql);
        
      return $query->result();
   }
   
    public function get_country_list($country_id)
   {
       $data = array();
	   $this->db->where('country_id',$country_id);
       $Q = $this->db->get('diseases');
       if ($Q->num_rows() > 0) {
       	foreach ($Q->result_array() as $row){
       		$data[] = $row;
       	}
       }
       $Q->free_result();
       return $data;
   }
   
   function get_paged_list($perpage=0,$start=0)
   {
	 	$one=false;
		$array='array';
		$data = array();
		$this->db->select('t1.*')
          ->from('diseases AS t1')
		  ->order_by('t1.country_id ASC')
		  ->limit($perpage,$start);
		  
		$query = $this->db->get();
        
        $result =  !$one  ? $query->result($array) : $query->row() ;
        return $result;
	}
	
	function get_paged_country_list($perpage=0,$start=0,$country_id)
   {
	 	$one=false;
		$array='array';
		$data = array();
		$this->db->select('t1.*')
          ->from('diseases AS t1')
		  ->where('t1.country_id',$country_id)
		  ->order_by('t1.country_id ASC')
		  ->limit($perpage,$start);
		  
		$query = $this->db->get();
        
        $result =  !$one  ? $query->result($array) : $query->row() ;
        return $result;
	}


   public function count_all()
   {
       return $this->db->count_all($this->tbl_roles);
   }

   public function get_by_id($id)
   {
       $this->db->where('id', $id);
       return $this->db->get($this->tbl_roles);
   }

   public function save($role)
   {
       $this->db->insert($this->tbl_roles, $role);
       return $this->db->insert_id();
   }

   public function update($id,$role)
   {
       $this->db->where('id', $id);
       $this->db->update($this->tbl_roles, $role);
   }

   public function delete($id)
   {
       $this->db->where('id', $id);
       $this->db->delete($this->tbl_roles);
   }

}
