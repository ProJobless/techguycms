<?php
class Page extends Admin_Controller{
    
     public function __construct() {
         
            parent::__construct();
            
            //Validate user
            if($this->session->userdata('logged_in_a') != true){
                redirect('admin/login');
            }
            //Load editor
            $this->load->helper('ckeditor');
           
        }
        
        
        public function index(){   
            //Show stats
            $data['statistics'] = $this->Dashboard_model->get_statistics();

            $data['pages'] = $this->Page_model->get_all();
            
            //Get users roles
            $data['roles'] = $this->User_model->get_roles();
     
            //Views
            $data['main_content'] = 'admin/page/pages';
            $this->load->view('admin/template', $data);
    }
    
    
    //Saves url routes
     public function save_routes(){   
            //this simply returns all the pages from my database
            $routes = $this->Page_model->get_all();
            
            // write out the PHP array to the file with help from the file helper
            if ( !empty( $routes ) ){
                // for every page in the database, get the route using the recursive function - _get_route()
                foreach( $routes as $route ){
                    $data[] = '$route["' . $this->_get_route($route->id) . '"] = "' . "page/display/{$route->id}" . '";';
                }
                $output = "<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');\n";
                $output .= implode("\n", $data);
                $this->load->helper('file');
                //Write to the custom routes file
                write_file(APPPATH . "cache/page_routes.php", $output);
            }
        }
 
        
     //Gets url routes
     private function _get_route($id){   
            // get the page from the db using it's id
            $page = $this->Page_model->get_page($id);
            
            //Creates the url prefix/alias
            @$prefix = strtolower(str_replace(' ','-',$page->name));
            @$prefix = str_replace(',','',$prefix);
            @$prefix = str_replace('.','',$prefix);
            
            return $prefix;
     }  
        
     
     //Directs the checkbox actions on "Pages" view
     public function action_direct_page(){ 
         if($this->input->post('add')){
             redirect('admin/page/add');
             
         } elseif($this->input->post('edit')){
             $page_array = $this->input->post('page_id');
             $page_id = $page_array[0];
              redirect("admin/page/edit/$page_id");
             
         } elseif($this->input->post('delete')){
             //Get page ids from checkboxes
             $page_array = $this->input->post('page_id');
             //Pass to delete function
             $this->delete($page_array);
             
         } elseif($this->input->post('publish')){
             //Get page ids from checkboxes
             $page_array = $this->input->post('page_id');
             //Pass to delete function
             $this->publish($page_array);
             
         } elseif($this->input->post('unpublish')){
             //Get page ids from checkboxes
             $page_array = $this->input->post('page_id');
             //Pass to delete function
             $this->unpublish($page_array);
             
         } elseif($this->input->post('feature')){
             //Get page ids from checkboxes
             $page_array = $this->input->post('page_id');
             //Pass to delete function
             $this->feature($page_array);
             
         } elseif($this->input->post('unfeature')){
             //Get page ids from checkboxes
             $page_array = $this->input->post('page_id');
             //Pass to delete function
             $this->unfeature($page_array);

         } else {
             redirect('admin/pages');
         }
     }
    
    public function add(){  
        //Validation Rules
        $this->form_validation->set_rules('page_name','Page Name','trim|required|min_length[4]|xss_clean');
        $this->form_validation->set_rules('page_body','Page Body','trim|required|xss_clean');
        $this->form_validation->set_rules('page_title','Page Title','trim|xss_clean');       
        $this->form_validation->set_rules('page_keywords','Meta Keywords','trim|xss_clean');
        $this->form_validation->set_rules('page_description','Meta Description','trim|xss_clean');
        $this->form_validation->set_rules('page_modules','Page Modules','xss_clean');
        $this->form_validation->set_rules('published','Published','required');
        $this->form_validation->set_rules('featured','Featured','required');
        $this->form_validation->set_rules('page_menu','Page Menu','required');
        $this->form_validation->set_rules('anchor','Menu Item Title','trim|xss_clean');
        $this->form_validation->set_rules('order','Order','required|integer');
        
          if($this->form_validation->run() == FALSE){ 
              //Get module options  
              $data['mod_select'] = $this->Module_model->get_modules();
              //Get menu options  
              $data['menu_select'] = $this->Page_model->get_menus();
              //Get users roles
              $data['roles'] = $this->User_model->get_roles();
              //Get all pages
              $data['all_pages'] = $this->Page_model->get_all();
              //Get menu items
              $data['menu_items'] = $this->Menu_model->get_all_items();
              //Get parent menu items
              $data['top_items'] = $this->Menu_model->get_parent_items();
              //Get child menu items
              $data['child_items'] = $this->Menu_model->get_child_items();
              
              //Views
              $data['main_content'] = 'admin/page/add_new_page';
              $this->load->view('admin/template', $data);
                
          } else {
                if(!is_writable('application/cache/page_routes.php')){ 
                  //Create Message
                  $this->session->set_flashdata('page_routes_writable', 'Your pages menu item was not created correctly. You need to chmod 777 the following file <strong>"application/cache/page_routes.php"</strong>');
              }          
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
                    'name'              => $this->input->post('page_name'),
                    'body'              => $this->input->post('page_body'),
                    'page_title'        => $this->input->post('page_title'),
                    'meta_keywords'     => $this->input->post('page_keywords'),
                    'meta_description'  => $this->input->post('page_description'),
                    'page_modules'      => $mod_string,
                    'registered_only'   => $this->input->post('page_access'),
                    'is_published'      => $this->input->post('published'),
                    'is_featured'       => $this->input->post('featured')
             );
       
            $this->Page_model->add_page($data);  
            
            //Get the last insert id
            $last_page_id = $this->Page_model->get_insert_id();
            $next_page_id = $last_page_id;
       
            //Create route
            $this->save_routes();
            
               //Get Page Menu if Any
              if($this->input->post('page_menu') != "" && $this->input->post('page_menu') != 0 && $this->input->post('page_menu') != 'none'){
                   
                  //Make menu item private if page is private
                   if($this->input->post('page_access') == 1){
                       $menu_reg_only = 1;
                   } else {
                       $menu_reg_only = 0;
                   }
                   
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
                        'page_id'           => $next_page_id,
                        'order'             => $this->input->post('order'),
                        'registered_only'   => $menu_reg_only,
                        'parent_id'         => $this->input->post('parent_item'),
                        'is_child'          => $is_child,
                        'alias'             => strtolower(str_replace(' ','-',$this->input->post('page_name'))),
                        'is_published'      => 1
                    );
                    
                    //Add data to menu_items table
                    $this->Page_model->add_page_to_menu($data);
               
                }
            
            //Create Message
            $this->session->set_flashdata('page_added', 'Your page has been added');
            
            //Redirect to pages
            redirect('admin/pages');
          }
    }
    
    
    public function edit($page_id){
        //Validation Rules
        $this->form_validation->set_rules('page_name','Page Name','trim|required|min_length[4]|xss_clean');
        $this->form_validation->set_rules('page_body','Page Body','trim|required|xss_clean');
        $this->form_validation->set_rules('page_title','Page Title','trim|xss_clean');
        $this->form_validation->set_rules('page_keywords','Meta Keywords','trim|xss_clean');
        $this->form_validation->set_rules('page_description','Meta Description','trim|xss_clean');       
        $this->form_validation->set_rules('anchor','Menu Item Title','trim|xss_clean');
        
          if($this->form_validation->run() == FALSE){
              
              //Get the page to edit 
              $data['this_page'] = $this->Page_model->get_page_admin($page_id);
              //Get the page to edit 
              $data['this_item'] = $this->Menu_model->get_item_by_page($page_id);
              //Get module options  
              $data['mod_select'] = $this->Module_model->get_modules();
              //Get which modules are selected
              $data['selected_modules'] = $this->Module_model->get_selected_modules($page_id,'pages');
              //Get ALL menu options  
              $data['menu_select'] = $this->Page_model->get_menus();
              //Check for the menu that this current page is attached to 
              $data['selected_menu'] = $this->Page_model->get_selected_menu($page_id);
              //Check for the parent menu item/page
              $data['selected_parent'] = $this->Page_model->get_selected_parent($page_id);
              //Check if page is published 
              $data['is_published'] = $this->Page_model->check_if_published($page_id);
              //Check if page is featured
              $data['is_featured'] = $this->Page_model->check_if_featured($page_id);
              //Get users roles
              $data['roles'] = $this->User_model->get_roles();
               //Get all pages
              $data['all_pages'] = $this->Page_model->get_all();
               //Get menu items
              $data['menu_items'] = $this->Menu_model->get_all_items();
             //Get parent menu items
              $data['top_items'] = $this->Menu_model->get_parent_items();
              //Get child menu items
              $data['child_items'] = $this->Menu_model->get_child_items();
              
              //Views
              $data['main_content'] = 'admin/page/edit_page';
              $this->load->view('admin/template', $data);
                
          } else {
              if(!is_writable('application/cache/page_routes.php')){ 
                  //Create Message
                  $this->session->set_flashdata('page_routes_writable', 'Your pages menu item was not created correctly. You need to chmod 777 the following file <strong>"application/cache/page_routes.php"</strong>');
              } 
              //Get Page Menu if Any
              if($this->input->post('page_menu') != "0"){
                  
                  //Make menu item private if page is private
                   if($this->input->post('page_access') == 1){
                       $menu_reg_only = 1;
                   } else {
                       $menu_reg_only = 0;
                   }
                   
                   //Decide if child item
                   if($this->input->post('parent_item') != 0){
                       $is_child = 1;
                   } else {
                       $is_child = 0;
                   }
                  
                    $data = array(
                        'menu_id'           => $this->input->post('page_menu'),
                        'anchor'            => $this->input->post('anchor'),
                        'page_id'           => $page_id,
                        'order'             => $this->input->post('order'),
                        'registered_only'   => $menu_reg_only,
                        'parent_id'         => $this->input->post('parent_item'),
                        'is_child'          => $is_child,
                        'alias'             => strtolower(str_replace(' ','-',$this->input->post('page_name'))),
                        'is_published'      => 1
                    );
                    
                    /* DEBUG
                    foreach($data as $key => $value){
                        echo $key . " -> " . $value . "<br />";
                    }
                    die();         
                     */
                    
                    //Add data to menu_items table
                    $this->Page_model->edit_page_to_menu($data);
                    
               
                } else if($this->input->post('page_menu') == "0"){
                   $this->Page_model->delete_single_menu_item($page_id);
                }
         
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
                    'name'              => $this->input->post('page_name'),
                    'body'              => $this->input->post('page_body'),
                    'page_title'        => $this->input->post('page_title'),
                    'meta_keywords'     => $this->input->post('page_keywords'),
                    'meta_description'  => $this->input->post('page_description'),
                    'page_modules'      => $mod_string,
                    'registered_only'   => $this->input->post('page_access'),
                    'is_published'      => $this->input->post('published'),
                    'is_featured'       => $this->input->post('featured')
             );
        
            $this->Page_model->edit_page($page_id,$data);  
       
            //Create route
            $this->save_routes();
            
            //Create Message
            $this->session->set_flashdata('page_edited', 'Your page has been saved ');
            
            //Redirect to pages
            redirect('admin/page/edit/' .$page_id . '');
          }
    }
    
    
    
     public function delete($page_array){      
            if(!isset($page_array) || $page_array == ''){
                redirect('admin/pages');
            }
            //Delete pages in array
            $this->Page_model->delete_pages($page_array);
            //Delete menu items in array
            $this->Page_model->delete_menu_items($page_array);
         
            //Create Message
            $this->session->set_flashdata('page_deleted', 'Your page(s) have been deleted');
            
            //Redirect to pages
            redirect('admin/pages');
     }
     
     
     
     public function publish($page_array){
          if(!isset($page_array) || $page_array == ''){
                redirect('admin/pages');
            }
            //Publish pages in array
            $this->Page_model->publish_pages($page_array);
            //Publish Menu Items in array
            $this->Page_model->publish_menu_items($page_array);
         
            //Create Message
            $this->session->set_flashdata('page_published', 'Your page(s) have been published');
            
            //Redirect to pages
            redirect('admin/pages');
     }
     
     
     
      public function unpublish($page_array){
           if(!isset($page_array) || $page_array == ''){
                redirect('admin/pages');
            }
         //Unpublish pages in array
          $this->Page_model->unpublish_pages($page_array);
          //Unpublish menu items in array
          $this->Page_model->unpublish_menu_items($page_array);
         
            //Create Message
            $this->session->set_flashdata('page_unpublished', 'Your page(s) have been unpublished');
            
            //Redirect to pages
            redirect('admin/pages');
     }
     
     
     
      public function feature($page_array){
           if(!isset($page_array) || $page_array == ''){
                redirect('admin/pages');
            }
         
         $this->Page_model->feature_pages($page_array);
         
            //Create Message
            $this->session->set_flashdata('page_featured', 'Your page(s) have been featured');
            
            //Redirect to pages
            redirect('admin/pages');
     }
     
     
     
      public function unfeature($page_array){
           if(!isset($page_array) || $page_array == ''){
                redirect('admin/pages');
            }
         
          $this->Page_model->unfeature_pages($page_array);
         
            //Create Message
            $this->session->set_flashdata('page_unfeatured', 'Your page(s) have been unfeatured');
            
            //Redirect to pages
            redirect('admin/pages');
     }
     
     
}
