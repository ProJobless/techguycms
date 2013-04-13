<?php
class Form extends Public_controller{
    public function __construct() {
        parent::__construct();
        
    }
    
     public function index(){
        redirect('home');
    }
    
    public function display($id){
        //Get the fields for the specified form
        $fields = $this->Form_model->get_published_form_fields($id);
        
        //Check if sidebar is enabled
        $data['sidebar_enabled'] = $this->Module_model->is_sidebar_enabled($id,'form','regular');
        
        foreach($fields as $field){
            //Set validation rules from database for each field
             $this->form_validation->set_rules($field->name,$field->label,$field->validation);
        } 
        
        if($this->form_validation->run() == FALSE){
             //Get the form type - need to use settings model because form model hasnt been loaded yet
            $form_type = $this->Settings_model->get_form_type($id);
            //Form config array for constructor
            $config = array('type' => $form_type,'width' => '');
            //Load form builder class
            $this->load->library('Form_builder',$config);
            //Get the specified form
            $data['form'] = $this->Form_model->get_form($id);
            //Get the fields for the specified form
            $fields = $this->Form_model->get_published_form_fields($id);
 
        
            //Loop through fields for that form
            foreach($fields as $field_data){
                //Create an array of options out of the csv in the db
                $options_array = $this->Form_model->get_array_from_string($field_data->options);
                $this->form_builder->addField(
                                        $field_data->name, 
                                        $field_data->label, 
                                        $field_data->type, 
                                        $field_data->height, 
                                        $field_data->width,
                                        $options_array
                                 );
            }
        
            //Gets the output from the form builder class
            $data['code'] = $this->form_builder->getCode();
    
        
            //Views
            $data['main_content'] = 'public/form/display';
            $this->load->view('public/template', $data);
        } else { //If validation succeeds
            //Get the fields for the specified form
            $fields = $this->Form_model->get_form_fields($id);
            //Get form info
            $form = $this->Form_model->get_form($id);
            //Get site name
            $site_name = $this->Settings_model->get_site_name();
   
            //Get "To" email        
            $to_email = $form->to_email;
 
            //Get the "from email"
            if($this->input->post('email')){
                $from_email = $this->input->post('email');
            } elseif($this->input->post('email_address')) {
                $from_email = $this->input->post('email_address');
            } else {
                $from_email = $this->Settings_model->get_site_email();
            }
            
            //Get the "from name"
            if($this->input->post('name')){
                $from_name = $this->input->post('name');
            } elseif($this->input->post('first_name')) {
                $from_name = $this->input->post('first_name');
            } else {
                $from_name = $site_name;
            }
            
            //Get subject
            $subject = $form->subject;
            
            //Create Message
            $message = "There has been a submission at ".$site_name.". Details are below...<br /><br />";
            $message .= "<strong>Form Name:</strong><br />";
            $message .= ucwords($form->name)."<br /><br />";
            $message .= "<strong>Form Fields:</strong><br />";
            foreach($fields as $field){
                $message .= "<strong>".$field->label.":</strong> ".$this->input->post($field->name)."<br />";
            }
     
             //Load email class
             $this->load->library('email');
             //Set email to html
             $this->email->set_mailtype("html");
             //Set email variables
             $this->email->from($from_email,$from_name);
             $this->email->to($to_email);             

             $this->email->subject($subject);
             $this->email->message($message);	

             if($this->email->send()){
                 //Create Message
                $this->session->set_flashdata('mail_sent', 'Your email has been sent. Someone will get back with you shortly');
                //Views
                $data['main_content'] = 'public/form/form_submitted';
                $this->load->view('public/template', $data);
             } else {
                 //Send failed
                 echo 'We had a problem sending';
                 show_error($this->email->print_debugger());
             }
        }
    }
}