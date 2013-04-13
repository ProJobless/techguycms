<?php
class Help extends Admin_Controller{
    
     public function __construct() {
            parent::__construct();

            //Validate user
            if($this->session->userdata('logged_in_a') != true){
                redirect('admin/login');
            }
        }
        
        //Display list of modules
        public function index(){   
     
            //Views
            $data['main_content'] = 'admin/help/index';
            $this->load->view('admin/template', $data);
    }
}
