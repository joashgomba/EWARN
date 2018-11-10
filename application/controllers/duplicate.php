<?php

class Duplicate extends CI_Controller {

   function __construct()
   {
       parent::__construct();
       $this->load->model('exportmodel');
	   $this->load->library("Excel");
   }

   public function index()
   {

     //$rows = $this->db->get('healthfacilities');

    $this->db->select('*')->from('healthfacilities')->order_by("health_facility", "ASC");
    $rows = $this->db->get();

     $table = '<table width="50%" border="1">';

    foreach ($rows->result() as $row):

      $table .= '<tr><td><input type="checkbox" name="id[]" value="'.$row->id.'"></td><td>'.$row->health_facility.'</td><td>'.$row->id.'</td><tr>';

     endforeach;

     $table .= '</table>';

    // echo $table;

     $data = array();
     $data['table'] = $table;

     $this->load->view('healthfacilities/duplicate',$data);

   }

   public function generatesql()
   {
     if (!empty($_POST['id'])) {
       echo reset($_POST['id']).'<br>';
		   foreach ($_POST['id'] as $row => $id) {


			   echo $id.'<br>';

       }

     }
   }



}
