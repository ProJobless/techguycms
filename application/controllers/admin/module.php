<?php
class Module extends Admin_Controller{
    
     public function __construct() {
            parent::__construct();

            //Validate user
            if($this->session->userdata('logged_in_a') != true){
                redirect('admin/login');
            }
            //Load editor
            $this->load->helper('ckeditor');
           
        }
        
        //Display list of modules
        public function index(){   
            
            //Show stats
            $data['statistics'] = $this->Dashboard_model->get_statistics();

            $data['modules'] = $this->Module_model->get_all_modules();
     
            //Views
            $data['main_content'] = 'admin/module/modules';
            $this->load->view('admin/template', $data);
    }
    

     //Directs the checkbox actions on "Modules" view
     public function action_direct_module(){ 
         if($this->input->post('add')){
             redirect('admin/module/add');
             
         } elseif($this->input->post('edit')){
             $mod_array = $this->input->post('mod_id');
             $mod_id = $mod_array[0];
              redirect("admin/module/edit/$mod_id");
             
         } elseif($this->input->post('delete')){
             //Get mod ids from checkboxes
             $mod_array = $this->input->post('mod_id');
             //Pass to delete function
             $this->delete($mod_array);
             
         } elseif($this->input->post('publish')){
             //Get mod ids from checkboxes
             $mod_array = $this->input->post('mod_id');
             //Pass to delete function
             $this->publish($mod_array);
             
         } elseif($this->input->post('unpublish')){
             //Get mod ids from checkboxes
             $mod_array = $this->input->post('mod_id');
             //Pass to delete function
             $this->unpublish($mod_array);
             
          } elseif($this->input->post('make_global')){
             //Get mod ids from checkboxes
             $mod_array = $this->input->post('mod_id');
             //Pass to delete function
             $this->make_global($mod_array);
             
         } elseif($this->input->post('remove_global')){
             //Get mod ids from checkboxes
             $mod_array = $this->input->post('mod_id');
             //Pass to delete function
             $this->remove_global($mod_array);
         } else {
             redirect('admin/modules');
         }
     }
            
    //Add a module
    public function add(){  
        $this->form_validation->set_rules('module_name','Module Name','trim|required|min_length[4]|xss_clean');
        $this->form_validation->set_rules('order','Order','trim|required|max_length[3]|xss_clean|integer');
        $this->form_validation->set_rules('module_position','Module Position','required');
        $this->form_validation->set_rules('published','Published','required');
        $this->form_validation->set_rules('show_name','Show Name','required');
         $this->form_validation->set_rules('global','Global','required');
          if($this->form_validation->run() == FALSE){
              //Get all modules
              $data['modules'] = $this->Module_model->get_all_modules();
              //Get positions
              $data['module_positions'] = $this->Module_model->get_module_positions();
              //Get orders
              $data['orders'] = $this->Module_model->get_orders();
              //Views
              $data['main_content'] = 'admin/module/add_new_module';
              $this->load->view('admin/template', $data);
                
          } else {

            $data = array(
                    'name' => $this->input->post('module_name'),
                    'content' => $this->input->post('module_content'),
                    'module_position' => $this->input->post('module_position'),
                    'order' => $this->input->post('order'),
                    'show_name' => $this->input->post('show_name'),
                    'is_global' => $this->input->post('global'),
                    'class_suffix' => $this->input->post('suffix'),
                    'is_editable' => 1,
                    'is_published' => $this->input->post('published')
             );
       
            $this->Module_model->add_module($data);  
            
            //Create Message
            $this->session->set_flashdata('mod_added', 'Your module has been added');
            
            //Redirect to modules
            redirect('admin/modules');
          }
    }
    
    
    //Edit a module
    public function edit($mod_id){
       $this->form_validation->set_rules('module_name','Module Name','trim|required|min_length[4]|xss_clean');
       $this->form_validation->set_rules('order','Order','trim|required|max_length[3]|xss_clean|integer');
          if($this->form_validation->run() == FALSE){
              //Get all modules
              $data['modules'] = $this->Module_model->get_all_modules();
              //Get the module to edit 
              $data['this_module'] = $this->Module_model->get_module($mod_id);
              //Get module position options  
              $data['module_positions'] = $this->Module_model->get_module_positions();
              //Get which positions are selected
              $data['selected_module_position'] = $this->Module_model->get_selected_position($mod_id);
              //Get orders
              $data['orders'] = $this->Module_model->get_orders();
              
              //Views
              $data['main_content'] = 'admin/module/edit_module';
              $this->load->view('admin/template', $data);
                
          } else {
            $data = array(
                    'name' => $this->input->post('module_name'),
                    'content' => $this->input->post('module_content'),
                    'module_position' => $this->input->post('module_position'),
                    'order' => $this->input->post('order'),
                    'show_name' => $this->input->post('show_name'),
                    'is_global' => $this->input->post('global'),
                    'class_suffix' => $this->input->post('suffix'),
                    'is_editable' => $this->input->post('is_editable'),
                    'is_published' => $this->input->post('published')
             );
        
            $this->Module_model->edit_module($mod_id,$data);  

            //Create Message
            $this->session->set_flashdata('mod_edited', 'Your module has been saved ');
            
            //Redirect to modules
            redirect('admin/modules');
          }
    }
    
    
    
    //Delete a module
     public function delete($mod_array){      
            if(!isset($mod_array) || $mod_array == ''){
                redirect('admin/modules');
            }
            //Delete moduless in array
            $this->Module_model->delete_modules($mod_array);
         
            //Create Message
            $this->session->set_flashdata('mod_deleted', 'Your module(s) have been deleted');
            
            //Redirect to modules
            redirect('admin/modules');
     }
     
     
     //Publish a module
     public function publish($mod_array){
          if(!isset($mod_array) || $mod_array == ''){
                redirect('admin/modules');
            }
            //Publish modules in array
            $this->Module_model->publish_modules($mod_array);
         
            //Create Message
            $this->session->set_flashdata('mod_published', 'Your module(s) have been published');
            
            //Redirect to modules
            redirect('admin/modules');
     }
     
     
     //Unpublish module
      public function unpublish($mod_array){
           if(!isset($mod_array) || $mod_array == ''){
                redirect('admin/modules');
            }
         //Unpublish modules in array
          $this->Module_model->unpublish_modules($mod_array);
         
            //Create Message
            $this->session->set_flashdata('mod_unpublished', 'Your module(s) have been unpublished');
            
            //Redirect to modules
            redirect('admin/modules');
     }
     
     
     //Make module global
     public function make_global($mod_array){
          if(!isset($mod_array) || $mod_array == ''){
                redirect('admin/modules');
            }
            //Publish modules in array
            $this->Module_model->make_modules_global($mod_array);
         
            //Create Message
            $this->session->set_flashdata('mod_global', 'Your module(s) are now global');
            
            //Redirect to modules
            redirect('admin/modules');
     }
     
     
     //Remove global from module
      public function remove_global($mod_array){
           if(!isset($mod_array) || $mod_array == ''){
                redirect('admin/modules');
            }
         //Unpublish modules in array
          $this->Module_model->remove_modules_global($mod_array);
         
            //Create Message
            $this->session->set_flashdata('mod_remove_global', 'Your module(s) are now not global');
            
            //Redirect to modules
            redirect('admin/modules');
     }
    
}


