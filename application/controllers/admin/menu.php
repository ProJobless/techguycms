<?php
class Menu extends Admin_Controller{
    public function index(){
         
         //Show stats
         $data['statistics'] = $this->Dashboard_model->get_statistics();
         //Get all menus
         $data['menus'] = $this->Menu_model->get_all_menus();
            
         //Views
         $data['main_content'] = 'admin/menu/menus';
         $this->load->view('admin/template', $data);
     }
     
      //Directs the checkbox actions on "Menus" view
     public function action_direct_menu(){ 
         if($this->input->post('add')){
             redirect('admin/menu/add_menu');
             
         } elseif($this->input->post('edit')){
             $menu_array = $this->input->post('menu_id');
             $menu_id = $menu_array[0];
              redirect("admin/menu/edit_menu/$menu_id");
             
         } elseif($this->input->post('delete')){
             //Get menu ids from checkboxes
             $menu_array = $this->input->post('menu_id');
             //Pass to delete function
             $this->delete($menu_array);
             
         } elseif($this->input->post('publish')){
             //Get menu ids from checkboxes
             $menu_array = $this->input->post('menu_id');
             //Pass to delete function
             $this->publish($menu_array);
             
         } elseif($this->input->post('unpublish')){
             //Get menu ids from checkboxes
             $menu_array = $this->input->post('menu_id');
             //Pass to delete function
             $this->unpublish($menu_array);
             
         } else {
             redirect('admin/menus');
         }
     }
     
     
     public function add_menu(){
         $this->form_validation->set_rules('menu_name','Menu Name','trim|required|min_length[4]|xss_clean');
         $this->form_validation->set_rules('module_position','Module Position','required');
         $this->form_validation->set_rules('published','Published','required');
         $this->form_validation->set_rules('show_name','Show Name','required');
         $this->form_validation->set_rules('global','Global','required');
        
          if($this->form_validation->run() == FALSE){
              //Get positions
              $data['module_positions'] = $this->Module_model->get_module_positions();
             
              //Views
              $data['main_content'] = 'admin/menu/add_new_menu';
              $this->load->view('admin/template', $data);
                
          } else {   
             //Array of menu data
            $data = array(
                    'name' => $this->input->post('menu_name'),
                    'module_position' => $this->input->post('module_position'),
                    'show_name' => $this->input->post('show_name'),
                    'order' => $this->input->post('order'),
                    'class_suffix' => $this->input->post('suffix'),
                    'registered_only' => $this->input->post('registered_only'),
                    'is_global' => $this->input->post('global'),
                    'is_published' => $this->input->post('published')
             );
            
            //Add new menu
            $this->Menu_model->add_menu($data);               
           
            //Create Message
            $this->session->set_flashdata('menu_added', 'Your menu has been added');
            
            //Redirect to pages
            redirect('admin/menus');
          }
     }
     
     
     public function edit_menu($menu_id){
         $this->form_validation->set_rules('menu_name','Menu Name','trim|required|min_length[4]|xss_clean');
          if($this->form_validation->run() == FALSE){
              
              //Get items
              $data['menu_items'] = $this->Menu_model->get_all_items();
              //Get Selected items
              $data['selected_menu_items'] = $this->Menu_model->get_selected_items($menu_id);
              //Get the menu to edit 
              $data['this_menu'] = $this->Menu_model->get_single_menu($menu_id);
              //Get module position options  
              $data['module_positions'] = $this->Module_model->get_module_positions();
              //Get which positions are selected
              $data['selected_module_position'] = $this->Menu_model->get_selected_position($menu_id);
              
              //Views
              $data['main_content'] = 'admin/menu/edit_menu';
              $this->load->view('admin/template', $data);
                
          } else {
           
            $data = array(
                    'name' => $this->input->post('menu_name'),
                    'module_position' => $this->input->post('module_position'),
                    'order' => $this->input->post('order'),
                    'show_name' => $this->input->post('show_name'),
                    'is_global' => $this->input->post('global'),
                    'registered_only' => $this->input->post('registered_only'),
                    'class_suffix' => $this->input->post('suffix'),
                    'is_published' => $this->input->post('published')
             );
                    
            //Edit/update menu data
            $this->Menu_model->edit_menu($menu_id,$data);  
            

            //Create Message
            $this->session->set_flashdata('menu_edited', 'Your menu has been saved ');
            
            //Redirect to menus
            redirect('admin/menu/edit_menu/' .$menu_id . '');
          }
     }
     
     
     public function delete($menu_array){      
            if(!isset($menu_array) || $menu_array == ''){
                redirect('admin/menus');
            }         
            //Delete menus
            $this->Menu_model->delete_menus($menu_array);
            //Delete menu items in array
            $this->Menu_model->delete_menu_items($menu_array);
         
            //Create Message
            $this->session->set_flashdata('menu_deleted', 'Your menu(s) have been deleted');
            
            //Redirect to menus
            redirect('admin/menus');
     }
     
     
     
     public function publish($menu_array){
          if(!isset($menu_array) || $menu_array == ''){
                redirect('admin/menus');
            }
            //Publish menus in array
            $this->Menu_model->publish_menus($menu_array);
              
            //Create Message
            $this->session->set_flashdata('menu_published', 'Your menu(s) have been published');
            
            //Redirect to pages
            redirect('admin/menus');
     }
     
     
     
      public function unpublish($menu_array){
           if(!isset($menu_array) || $menu_array == ''){
                redirect('admin/menus');
            }
           $this->Menu_model->unpublish_menus($menu_array);
         
            //Create Message
            $this->session->set_flashdata('menu_unpublished', 'Your menu(s) have been unpublished');
            
            //Redirect to pages
            redirect('admin/menus');
     }
     
     
     public function add_items($menu_id){
         
         //Views
         $data['main_content'] = 'admin/menu/add_items';
         $this->load->view('admin/template', $data);
     }
     
    
}
