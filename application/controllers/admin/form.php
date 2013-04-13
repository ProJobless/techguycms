<?php
class Form extends Admin_controller{
    public function __construct() {
        parent::__construct();
        //Validate user
       if($this->session->userdata('logged_in_a') != true){
           redirect('admin/login');
       }    
    }
    
   public function index(){   
            //Show stats
            $data['statistics'] = $this->Dashboard_model->get_statistics();

            $data['forms'] = $this->Form_model->get_all_forms();
     
            //Views
            $data['main_content'] = 'admin/form/forms';
            $this->load->view('admin/template', $data);
    }
    
    
     //Directs the checkbox actions on "Forms" view
     public function action_direct_form(){ 
         if($this->input->post('add')){
             redirect('admin/form/add');
             
         } elseif($this->input->post('edit')){
             $form_array = $this->input->post('form_id');
             $form_id = $form_array[0];
              redirect("admin/form/edit/$form_id");
         } elseif($this->input->post('delete')){
             //Get form_ ids from checkboxes
             $form_array = $this->input->post('form_id');
             //Pass to delete function
             $this->delete($form_array);
             
         } elseif($this->input->post('publish')){
             //Get formids from checkboxes
             $form_array = $this->input->post('form_id');
             //Pass to delete function
             $this->publish($form_array);
             
         } elseif($this->input->post('unpublish')){
             //Get form ids from checkboxes
             $form_array = $this->input->post('form_id');
             //Pass to delete function
             $this->unpublish($form_array);
         } else {
             redirect('admin/forms');
         }
     }
    
    public function add(){  
        $this->form_validation->set_rules('form_name','Form Name','trim|required|min_length[4]|xss_clean');
        $this->form_validation->set_rules('to_email','To Email','trim|email|required|min_length[4]|xss_clean');
        $this->form_validation->set_rules('page_modules','Page Modules','xss_clean');
        $this->form_validation->set_rules('published','Published','required');
        $this->form_validation->set_rules('page_menu','Page Menu','required');
         $this->form_validation->set_rules('anchor','Menu Item Title','trim|xss_clean');
         $this->form_validation->set_rules('order','Order','integer');
        
          if($this->form_validation->run() == FALSE){
              //Get module options  
              $data['mod_select'] = $this->Module_model->get_modules();
              //Get menu options  
              $data['menu_select'] = $this->Menu_model->get_menus();   
              //Get menu items
              $data['menu_items'] = $this->Menu_model->get_all_items();
              //Get parent menu items
              $data['top_items'] = $this->Menu_model->get_parent_items();
              //Get child menu items
              $data['child_items'] = $this->Menu_model->get_child_items();
              
              //Views
              $data['main_content'] = 'admin/form/add_new_form';
              $this->load->view('admin/template', $data);
                
          } else {  
              //Get Page Modules if Any
              if($this->input->post('page_modules') != ""){
                $modules[] = $this->input->post('page_modules');
                foreach ($modules as $mods) {
                    foreach($mods as $mod){
                    $mod_string[] = $mod;
                    }
                }
                //Make Array CSV string
                $mod_string = implode(",",$mod_string);
              } else {
                  $mod_string = 0;
              }          
           
            $data = array(
                    'name' => $this->input->post('form_name'),    
                    'type' => 'custom', 
                    'to_email' => $this->input->post('to_email'), 
                    'subject' => $this->input->post('subject'), 
                    'page_modules' => $mod_string,   
                    'is_published' => $this->input->post('published'),
                    
             );
      
            $this->Form_model->add_form($data);  
          
            //Get the last insert id
            $last_form_id = $this->Form_model->get_insert_id();
            $next_form_id = $last_form_id;
            
               //Get Page Menu if Any
              if($this->input->post('page_menu') != "" && $this->input->post('page_menu') != 0 && $this->input->post('page_menu') != 'none'){
                     $alias = "form/display/".$next_form_id;
                   
                     //Get a page id from the order field
                     $order = $this->input->post('order')+1;
                     
              //Decide if child item
                   if($this->input->post('parent_item') != 0){
                       $is_child = 1;
                   } else {
                       $is_child = 0;
                   }
                     
                    //Gather data for menu_items table
                    $data = array(
                        'menu_id'           => $this->input->post('page_menu'),
                        'anchor'            => $this->input->post('anchor'),
                        'form_id'           => $next_form_id,
                        'parent_id'         => $this->input->post('parent_item'),
                        'is_child'          => $is_child,
                        'order'             => $order,
                        'alias'             => $alias,
                        'is_published'      => 1
                    );
                    
                    //Add data to menu_items table
                    $this->Form_model->add_form_to_menu($data);
               
                }
            
            //Create Message
            $this->session->set_flashdata('form_added', 'Your form has been added');
            
            //Redirect to forms
            redirect('admin/forms');
          }
    }
    
    
    public function edit($form_id){
        $this->form_validation->set_rules('form_name','Form Name','trim|required|min_length[4]|xss_clean');
        $this->form_validation->set_rules('to_email','To Email','trim|email|required|min_length[4]|xss_clean');    
        $this->form_validation->set_rules('anchor','Menu Item Title','trim|xss_clean');
        
          if($this->form_validation->run() == FALSE){
              //Get the form
              $data['this_form'] = $this->Form_model->get_form($form_id);
               //Get the page to edit 
              $data['this_item'] = $this->Menu_model->get_item_by_form($form_id);
              //Get module options  
              $data['mod_select'] = $this->Module_model->get_modules();
              //Get which modules are selected
              $data['selected_modules'] = $this->Module_model->get_selected_modules($form_id,'forms');
              //Check for the parent menu item/page
              $data['selected_parent'] = $this->Form_model->get_selected_parent($form_id);
              //Get menu options  
              $data['menu_select'] = $this->Menu_model->get_menus();   
              //Get menu items
              $data['menu_items'] = $this->Menu_model->get_all_items();
              //Get parent menu items
              $data['top_items'] = $this->Menu_model->get_parent_items();
              //Get child menu items
              $data['child_items'] = $this->Menu_model->get_child_items();
              //Check for the menu that this current page is attached to 
              $data['selected_menu'] = $this->Form_model->get_selected_menu($form_id);
              
              
              //Views
              $data['main_content'] = 'admin/form/edit_form';
              $this->load->view('admin/template', $data);
                
          } else {  
              //Get Page Modules if Any
              if($this->input->post('page_modules') != ""){
                $modules[] = $this->input->post('page_modules');
                foreach ($modules as $mods) {
                    foreach($mods as $mod){
                    $mod_string[] = $mod;
                    }
                }
                //Make Array CSV string
                $mod_string = implode(",",$mod_string);
              } else {
                  $mod_string = 0;
              }          
           
            $data = array(
                    'name' => $this->input->post('form_name'),    
                    'type' => 'custom', 
                    'to_email' => $this->input->post('to_email'), 
                    'subject' => $this->input->post('subject'), 
                    'page_modules' => $mod_string,   
                    'is_published' => $this->input->post('published'),
                    
             );
      
            $this->Form_model->edit_form($form_id,$data);  
          
               //Get Page Menu if Any
              if($this->input->post('page_menu') != "" && $this->input->post('page_menu') != 0 && $this->input->post('page_menu') != 'none'){
                     
                     //Set alias
                     $alias = "form/display/".$form_id;
                     
                     //Decide if child item
                   if($this->input->post('parent_item') != 0){
                       $is_child = 1;
                   } else {
                       $is_child = 0;
                   }
                     
                    //Gather data for menu_items table
                    $data = array(
                        'menu_id'           => $this->input->post('page_menu'),
                        'anchor'            => $this->input->post('anchor'),
                        'order'             => $this->input->post('order'),
                        'form_id'           => $form_id,
                        'parent_id'         => $this->input->post('parent_item'),
                        'is_child'          => $is_child,
                        'alias'             => $alias,
                        'is_published'      => 1
                    );
                    
                    //Add data to menu_items table
                    $this->Form_model->edit_form_to_menu($data);
               
                } else if($this->input->post('page_menu') == "0"){
                   $this->Form_model->delete_single_menu_item($form_id);
                }
            
            //Create Message
            $this->session->set_flashdata('form_saved', 'Your form has been saved');
                      
            //Redirect to pages
            redirect('admin/form/edit/' .$form_id . '');
          }
    }
    
    
    
     public function delete($form_array){      
            if(!isset($form_array) || $form_array == ''){
                redirect('admin/forms');
            }
            //Delete forms in array
            $this->Form_model->delete_forms($form_array);
            //Delete menu items in array
            $this->Form_model->delete_menu_items($form_array);
         
            //Create Message
            $this->session->set_flashdata('form_deleted', 'Your form(s) have been deleted');
            
            //Redirect to forms
            redirect('admin/forms');
     }
     
     
     
     public function publish($form_array){
          if(!isset($form_array) || $form_array == ''){
                redirect('admin/forms');
            }
            //Publish forms in array
            $this->Form_model->publish_forms($form_array);
            //Publish Menu Items in array
            $this->Form_model->publish_menu_items($form_array);
         
            //Create Message
            $this->session->set_flashdata('form_published', 'Your form(s) have been published');
            
            //Redirect to forms
            redirect('admin/forms');
     }
     
     
     
      public function unpublish($form_array){
           if(!isset($form_array) || $form_array == ''){
                redirect('admin/forms');
            }
         //Unpublish forms in array
          $this->Form_model->unpublish_forms($form_array);
          //Unpublish menu items in array
          $this->Form_model->unpublish_menu_items($form_array);
         
            //Create Message
            $this->session->set_flashdata('form_unpublished', 'Your form(s) have been unpublished');
            
            //Redirect to forms
            redirect('admin/forms');
     }
     
     
     
     
     /******FORM FIELDS FUNCTIONS START********/
     
     public function fields($form_id){
         //Show stats
         $data['statistics'] = $this->Dashboard_model->get_statistics();
         $data['fields'] = $this->Form_model->get_form_fields($form_id);
         $data['forms'] = $this->Form_model->get_all_forms();
         $data['form'] = $this->Form_model->get_form($form_id);
         
         
         //Views
         $data['main_content'] = 'admin/form/fields/fields';
         $this->load->view('admin/template', $data);
     }
     
    
      //Directs the checkbox actions on "Fields" view
     public function action_direct_fields($form_id){ 
         if($this->input->post('add')){
             redirect('admin/form/add_fields/'.$form_id);            
         } elseif($this->input->post('edit')){
             $field_array = $this->input->post('field_id');
             $field_id = $field_array[0];
              redirect("admin/form/edit_field/$form_id/$field_id");
         } elseif($this->input->post('delete')){
             //Get field ids from checkboxes
             $field_array = $this->input->post('field_id');
             //Pass to delete function
             $this->delete_fields($form_id,$field_array); 
         } elseif($this->input->post('publish')){
             //Get field ids from checkboxes
             $field_array = $this->input->post('field_id');
             //Pass to publish function
             $this->publish_fields($form_id,$field_array);
         } elseif($this->input->post('unpublish')){
             //Get field ids from checkboxes
             $field_array = $this->input->post('field_id');
             //Pass to unpublish function
             $this->unpublish_fields($form_id,$field_array);
         } else {
             //Redirect to fields
              redirect('admin/form/fields/'.$form_id);
         }
     }
     
     
     public function add_fields($form_id){    
          $this->form_validation->set_rules('label','Field Label','trim|required|xss_clean');
          $this->form_validation->set_rules('name','Field Name','trim|required|xss_clean');
          $this->form_validation->set_rules('type','Field Type','required');
          $this->form_validation->set_rules('width','Field Width','integer|xss_clean');
          $this->form_validation->set_rules('height','Field Height','integer|xss_clean');
          $this->form_validation->set_rules('published','Published','required');
          $this->form_validation->set_rules('order','Order','required|integer');

          if($this->form_validation->run() == FALSE){
              //Get form info
              $data['this_form'] = $this->Form_model->get_form($form_id);
              //Get fields info
              $data['this_form_fields'] = $this->Form_model->get_form_fields($form_id);
             
              
              //Views
              $data['main_content'] = 'admin/form/fields/add_new_field';
              $this->load->view('admin/template', $data);
                
          } else {
              //Create validation array
              $validation_array = $this->input->post('validation');
              //Check if array is not empty
              if(!empty($validation_array)){
                  //Create validation string
                  $validation_string = implode("|", $validation_array);
              } else {
                  $validation_string = "";
              }

              $data = array(
                    'form_id' => $form_id,
                    'label' => $this->input->post('label'),    
                    'name' => strtolower($this->input->post('name')), 
                    'type' => $this->input->post('type'),
                    'options' => $this->input->post('options'),
                    'width' => $this->input->post('width'), 
                    'height' => $this->input->post('height'),
                    'order' => $this->input->post('order'),  
                    'is_published' => $this->input->post('published'),
                    'validation' => $validation_string
             );
              
              //Add the field to the specified form
              $this->Form_model->add_field($form_id,$data);  
             
              //Create Message
              $this->session->set_flashdata('field_added', 'Your field has been added');
            
              //Redirect to forms
              redirect('admin/form/fields/'.$form_id);
          }
       
     }
     
     
     public function edit_field($form_id,$field_id){
         $this->form_validation->set_rules('label','Field Label','trim|required|xss_clean');
          $this->form_validation->set_rules('name','Field Name','trim|required|xss_clean');
          $this->form_validation->set_rules('type','Field Type','required');
          $this->form_validation->set_rules('width','Field Width','integer|xss_clean');
          $this->form_validation->set_rules('height','Field Height','integer|xss_clean');
          $this->form_validation->set_rules('published','Published','required');
          $this->form_validation->set_rules('order','Order','required|integer');

          if($this->form_validation->run() == FALSE){
              //Get form info
              $data['this_form'] = $this->Form_model->get_form($form_id);
              //Get field info
              $data['this_field'] = $this->Form_model->get_form_field($form_id,$field_id);
              //Get fields info
              $data['this_form_fields'] = $this->Form_model->get_form_fields($form_id);
              //Get which validations are selected
              $validation_string = $this->Form_model->get_selected_validations($form_id,$field_id);
              $data['selected_validations'] = explode("|",$validation_string);
              
              //Views
              $data['main_content'] = 'admin/form/fields/edit_field';
              $this->load->view('admin/template', $data);
                
          } else {
              //Create validation array
              $validation_array = $this->input->post('validation');
              //Check if array is not empty
              if(!empty($validation_array)){
                  //Create validation string
                  $validation_string = implode("|", $validation_array);
              } else {
                  $validation_string = "";
              }

              $data = array(
                    'form_id' => $form_id,
                    'label' => $this->input->post('label'),    
                    'name' => strtolower($this->input->post('name')),
                    'type' => $this->input->post('type'),
                    'options' => $this->input->post('options'),
                    'width' => $this->input->post('width'), 
                    'height' => $this->input->post('height'),
                    'order' => $this->input->post('order'),  
                    'is_published' => $this->input->post('published'),
                    'validation' => $validation_string
             );
              
              //Edit field info for the specified form
              $this->Form_model->edit_field($form_id,$field_id,$data);  
             
              //Create Message
              $this->session->set_flashdata('field_edited', 'Your field has been saved');
            
              //Redirect to forms
              redirect('admin/form/fields/'.$form_id);
          }
     }
     
     
     public function delete_fields($form_id,$field_array){
         if(!isset($field_array) || $field_array == ''){
                redirect('admin/form/fields/'.$form_id);
         }
            
         $this->Form_model->delete_fields($form_id,$field_array);
         
         //Create Message
         $this->session->set_flashdata('field_deleted', 'Your field(s) have been deleted');
         
         //Redirect to fields view
         redirect('admin/form/fields/'.$form_id);
     }
     
     
     public function publish_fields($form_id,$field_array){
          if(!isset($field_array) || $field_array == ''){
                redirect('admin/form/fields/'.$form_id);
         }
         //Publish fields in array
         $this->Form_model->publish_fields($form_id,$field_array);
       
         //Create Message
         $this->session->set_flashdata('field_published', 'Your field(s) have been published');
            
         //Redirect to fields view
         redirect('admin/form/fields/'.$form_id);
     }
     
     
     public function unpublish_fields($form_id,$field_array){
          if(!isset($field_array) || $field_array == ''){
                redirect('admin/form/fields/'.$form_id);
         }
         //Publish fields in array
         $this->Form_model->unpublish_fields($form_id,$field_array);
       
         //Create Message
         $this->session->set_flashdata('field_unpublished', 'Your field(s) have been unpublished');
            
         //Redirect to fields view
         redirect('admin/form/fields/'.$form_id);
     }
     
     
     
}
