<?php

class Audittrail extends CI_Controller {

   function __construct()
   {
       parent::__construct();
       $this->load->model('audittrailmodel');
   }

   public function index()
   {
       $data = array(
           'rows' => $this->db->get('audittrail'),
       );
       $this->load->view('audittrail/index', $data);
   }
   
   public function reportformlist($id)
   {
	   $data = array();
	   
	   $data = array(
           'rows' => $this->audittrailmodel->get_report_list($id),
       );
	   
	   $this->load->view('audittrail/reportlist', $data);
   }

   public function add()
   {
       $this->load->view('audittrail/add');
   }

   public function add_validate()
   {
       $this->load->library('form_validation');
       $this->form_validation->set_rules('user_id', 'User id', 'trim|required');
       $this->form_validation->set_rules('reportingform_id', 'Reportingform id', 'trim|required');
       $this->form_validation->set_rules('date_of_action', 'Date of action', 'trim|required');
       $this->form_validation->set_rules('action', 'Action', 'trim|required');
       if ($this->form_validation->run() == false) {
           $this->add();
       } else {
           $data = array(
               'user_id' => $this->input->post('user_id'),
               'reportingform_id' => $this->input->post('reportingform_id'),
               'date_of_action' => $this->input->post('date_of_action'),
               'action' => $this->input->post('action'),
           );
           $this->db->insert('audittrail', $data);
           $this->index();
       }
   }

   public function edit($id)
   {
       $row = $this->db->get_where('post', array('id' => $id))->row();
       $data = array(
           'row' => $row,
       );
       $this->load->view('audittrail/edit', $data);
   }

   public function edit_validate($id)
   {
       $this->load->library('form_validation');
       $this->form_validation->set_rules('user_id', 'User id', 'trim|required');
       $this->form_validation->set_rules('reportingform_id', 'Reportingform id', 'trim|required');
       $this->form_validation->set_rules('date_of_action', 'Date of action', 'trim|required');
       $this->form_validation->set_rules('action', 'Action', 'trim|required');
       if ($this->form_validation->run() == false) {
           $this->edit();
       } else {
           $data = array(
               'user_id' => $this->input->post('user_id'),
               'reportingform_id' => $this->input->post('reportingform_id'),
               'date_of_action' => $this->input->post('date_of_action'),
               'action' => $this->input->post('action'),
           );
           $this->db->where('id', $id);
           $this->db->update('audittrail', $data);
           $this->index();
       }
   }

   public function delete($id)
   {
       $this->db->delete('post', array('id' => $id));
       $this->index();
   }

}
