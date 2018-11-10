<?php

class Formsdata extends CI_Controller {

   function __construct()
   {
       parent::__construct();
       $this->load->model('formsdatamodel');
   }

   public function index()
   {
       if (!$this->erkanaauth->try_session_login()) {
       	redirect('login','refresh');
       }
       $data = array(
           'rows' => $this->db->get('formsdata'),
       );
       $this->load->view('formsdata/index', $data);
   }

   public function add()
   {
       if (!$this->erkanaauth->try_session_login()) {
       	redirect('login','refresh');
       }
       $data = array();
       $this->load->view('formsdata/add',$data);
   }

   public function add_validate()
   {
       if (!$this->erkanaauth->try_session_login()) {
       	redirect('login','refresh');
       }
       $this->load->library('form_validation');
       $this->form_validation->set_rules('form_id', 'Form id', 'trim|required');
       $this->form_validation->set_rules('disease_id', 'Disease id', 'trim|required');
       $this->form_validation->set_rules('male_under_five', 'Male under five', 'trim|required');
       $this->form_validation->set_rules('female_under_five', 'Female under five', 'trim|required');
       $this->form_validation->set_rules('male_over_five', 'Male over five', 'trim|required');
       $this->form_validation->set_rules('female_over_five', 'Female over five', 'trim|required');
       if ($this->form_validation->run() == false) {
           $this->add();
       } else {
           $data = array(
               'form_id' => $this->input->post('form_id'),
               'disease_id' => $this->input->post('disease_id'),
               'male_under_five' => $this->input->post('male_under_five'),
               'female_under_five' => $this->input->post('female_under_five'),
               'male_over_five' => $this->input->post('male_over_five'),
               'female_over_five' => $this->input->post('female_over_five'),
           );
           $this->db->insert('formsdata', $data);
           redirect('formsdata','refresh');
       }
   }

   public function edit($id)
   {
       if (!$this->erkanaauth->try_session_login()) {
       	redirect('login','refresh');
       }
       $row = $this->db->get_where('formsdata', array('id' => $id))->row();
       $data = array(
           'row' => $row,
       );
       $this->load->view('formsdata/edit', $data);
   }

   public function edit_validate($id)
   {
       if (!$this->erkanaauth->try_session_login()) {
       	redirect('login','refresh');
       }
       $this->load->library('form_validation');
       $this->form_validation->set_rules('form_id', 'Form id', 'trim|required');
       $this->form_validation->set_rules('disease_id', 'Disease id', 'trim|required');
       $this->form_validation->set_rules('male_under_five', 'Male under five', 'trim|required');
       $this->form_validation->set_rules('female_under_five', 'Female under five', 'trim|required');
       $this->form_validation->set_rules('male_over_five', 'Male over five', 'trim|required');
       $this->form_validation->set_rules('female_over_five', 'Female over five', 'trim|required');
       if ($this->form_validation->run() == false) {
           $this->edit($id);
       } else {
           $data = array(
               'form_id' => $this->input->post('form_id'),
               'disease_id' => $this->input->post('disease_id'),
               'male_under_five' => $this->input->post('male_under_five'),
               'female_under_five' => $this->input->post('female_under_five'),
               'male_over_five' => $this->input->post('male_over_five'),
               'female_over_five' => $this->input->post('female_over_five'),
           );
           $this->db->where('id', $id);
           $this->db->update('formsdata', $data);
           redirect('formsdata','refresh');
       }
   }

   public function delete($id)
   {
       if (!$this->erkanaauth->try_session_login()) {
       	redirect('login','refresh');
       }
       $this->db->delete('formsdata', array('id' => $id));
       redirect('formsdata','refresh');
   }

}
