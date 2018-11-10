<?php

class Smsreports extends CI_Controller {

   function __construct()
   {
       parent::__construct();
       $this->load->model('smsreportsmodel');
   }

   public function index()
   {
       $data = array(
           'rows' => $this->db->get('smsreports'),
       );
       $this->load->view('smsreports/index', $data);
   }

   public function add()
   {
       $this->load->view('smsreports/add');
   }

   public function add_validate()
   {
       $this->load->library('form_validation');
       $this->form_validation->set_rules('text', 'Text', 'trim|required');
       $this->form_validation->set_rules('number_sent', 'Number sent', 'trim|required');
       $this->form_validation->set_rules('amount_spent', 'Amount spent', 'trim|required');
       $this->form_validation->set_rules('date_sent', 'Date sent', 'trim|required');
       $this->form_validation->set_rules('date_time_sent', 'Date time sent', 'trim|required');
       if ($this->form_validation->run() == false) {
           $this->add();
       } else {
           $data = array(
               'text' => $this->input->post('text'),
               'number_sent' => $this->input->post('number_sent'),
               'amount_spent' => $this->input->post('amount_spent'),
               'date_sent' => $this->input->post('date_sent'),
               'date_time_sent' => $this->input->post('date_time_sent'),
           );
           $this->db->insert('smsreports', $data);
           $this->index();
       }
   }

   public function edit($id)
   {
       $row = $this->db->get_where('post', array('id' => $id))->row();
       $data = array(
           'row' => $row,
       );
       $this->load->view('smsreports/edit', $data);
   }

   public function edit_validate($id)
   {
       $this->load->library('form_validation');
       $this->form_validation->set_rules('text', 'Text', 'trim|required');
       $this->form_validation->set_rules('number_sent', 'Number sent', 'trim|required');
       $this->form_validation->set_rules('amount_spent', 'Amount spent', 'trim|required');
       $this->form_validation->set_rules('date_sent', 'Date sent', 'trim|required');
       $this->form_validation->set_rules('date_time_sent', 'Date time sent', 'trim|required');
       if ($this->form_validation->run() == false) {
           $this->edit();
       } else {
           $data = array(
               'text' => $this->input->post('text'),
               'number_sent' => $this->input->post('number_sent'),
               'amount_spent' => $this->input->post('amount_spent'),
               'date_sent' => $this->input->post('date_sent'),
               'date_time_sent' => $this->input->post('date_time_sent'),
           );
           $this->db->where('id', $id);
           $this->db->update('smsreports', $data);
           $this->index();
       }
   }

   public function delete($id)
   {
       $this->db->delete('post', array('id' => $id));
       $this->index();
   }

}
