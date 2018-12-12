<?php

class Support extends CI_Controller {

   function __construct()
   {
       parent::__construct();
   }

   public function index()
   {
       if (!$this->erkanaauth->try_session_login()) {
            
            redirect('login', 'refresh');
            
        }

       $user_id = $this->erkanaauth->getField('id');
       $data['user'] = $this->usersmodel->get_by_id($user_id)->row();

       $data['success_message'] = $this->session->flashdata('success_message');

       $this->load->view('forms/support',$data);
   }

   public function sendmail()
   {
       $this->load->library('form_validation');
       $this->form_validation->set_rules('your_name', 'Your Name', 'trim|required');
       $this->form_validation->set_rules('email', 'Email', 'trim|required');
       $this->form_validation->set_rules('subject', 'Subject', 'trim|required');
       $this->form_validation->set_rules('message', 'Message', 'trim|required');

       if ($this->form_validation->run() == false) {
           $this->index();
       } else {

           //SMTP & mail configuration
           $config = array(
               'protocol'  => 'smtp',
               'smtp_host' => 'ssl://smtp.googlemail.com',
               'smtp_port' => 465,
               'smtp_user' => 'ewarnemro@gmail.com',
               'smtp_pass' => 'ewarnpass',
               'mailtype'  => 'html',
               'charset'   => 'utf-8'
           );
           $this->email->initialize($config);
           $this->email->set_mailtype("html");
           $this->email->set_newline("\r\n");

           $your_name = $this->input->post('your_name');
           $email = $this->input->post('email');
           $subject = $this->input->post('subject');
           $message = $this->input->post('message');

           $mail_message = '<p>Dear EWARN Support,</p>';
           $mail_message .= '<p>'.$your_name.' of email '.$email.' has submitted a support request on the EWARN system. Please see the support request below:</p>';
           $mail_message .= $message;

           $htmlContent = $mail_message;

           $this->email->to('fouadn@who.int');
           $this->email->cc('joashgomba@gmail.com,karamma@who.int');
           $this->email->from('ewarnemro@gmail.com','EWARN');
           $this->email->subject($subject);
           $this->email->message($htmlContent);

           $this->email->send();

           $this->session->set_flashdata('success_message', 'Your email has been sent to EWARN support and will be worked on as soon as possible.');
           redirect('support', 'refresh');
       }
   }
   


}
