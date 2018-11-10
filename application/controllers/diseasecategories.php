<?php

class Diseasecategories extends CI_Controller {

   function __construct()
   {
       parent::__construct();
       $this->load->model('diseasecategoriesmodel');
   }

   public function index()
   {
       if (!$this->erkanaauth->try_session_login()) {
       	redirect('login','refresh');
       }
       $data = array(
           'rows' => $this->db->get('diseasecategories'),
       );
       $this->load->view('diseasecategories/index', $data);
   }

   public function add()
   {
       if (!$this->erkanaauth->try_session_login()) {
       	redirect('login','refresh');
       }
       $data = array();
       $this->load->view('diseasecategories/add',$data);
   }

   public function add_validate()
   {
       if (!$this->erkanaauth->try_session_login()) {
       	redirect('login','refresh');
       }
       $this->load->library('form_validation');
       $this->form_validation->set_rules('category_name', 'Category name', 'trim|required');
       if ($this->form_validation->run() == false) {
           $this->add();
       } else {
           $data = array(
               'category_name' => $this->input->post('category_name'),
           );
           $this->db->insert('diseasecategories', $data);
           redirect('diseasecategories','refresh');
       }
   }

   public function edit($id)
   {
       if (!$this->erkanaauth->try_session_login()) {
       	redirect('login','refresh');
       }
       $row = $this->db->get_where('diseasecategories', array('id' => $id))->row();
       $data = array(
           'row' => $row,
       );
       $this->load->view('diseasecategories/edit', $data);
   }

   public function edit_validate($id)
   {
       if (!$this->erkanaauth->try_session_login()) {
       	redirect('login','refresh');
       }
       $this->load->library('form_validation');
       $this->form_validation->set_rules('category_name', 'Category name', 'trim|required');
       if ($this->form_validation->run() == false) {
           $this->edit($id);
       } else {
           $data = array(
               'category_name' => $this->input->post('category_name'),
           );
           $this->db->where('id', $id);
           $this->db->update('diseasecategories', $data);
           redirect('diseasecategories','refresh');
       }
   }

   public function delete($id)
   {
       if (!$this->erkanaauth->try_session_login()) {
       	redirect('login','refresh');
       }
       $this->db->delete('diseasecategories', array('id' => $id));
       redirect('diseasecategories','refresh');
   }

}
