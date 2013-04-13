<?php
class Settings extends Admin_Controller{
    
     public function __construct() {
            parent::__construct();
           //Validate user
            if($this->session->userdata('logged_in_a') != true){
                redirect('admin/login');
            }
           
     }
     
     
     public function index(){
        $this->form_validation->set_rules('site_name','Website Name','trim|required|max_length[200]|xss_clean');
        $this->form_validation->set_rules('headline_text','headline_text','trim|xss_clean|max_length[300]');
        $this->form_validation->set_rules('copyright','Copyright','trim|xss_clean|max_length[300]');
        $this->form_validation->set_rules('meta_keywords','Meta Keywords','trim|xss_clean');
        $this->form_validation->set_rules('meta_description','Meta Description','trim|xss_clean');
        $this->form_validation->set_rules('page_title','Page Title','trim|xss_clean');
        $this->form_validation->set_rules('logo_width','Logo Width','trim|integer');
        $this->form_validation->set_rules('blog_menu_position','Blog Menu Position','trim|integer');
        $this->form_validation->set_rules('post_num','Post Count','trim|integer');
        $this->form_validation->set_rules('intro_text_count','Character Count','trim|integer');
        $this->form_validation->set_rules('main_image_width','Main Image Width','trim|integer');
       
        if($this->form_validation->run() == FALSE){
              $data['statistics'] = $this->Dashboard_model->get_statistics();
              $data['menu_select'] = $this->Page_model->get_menus();
              //Get module options  
              $data['mod_select'] = $this->Module_model->get_modules();
              $data['selected_modules'] = $this->Module_model->get_blog_modules();
              //Get menu options  
              $data['menu_select'] = $this->Menu_model->get_menus();   
              //Get menu items
              $data['menu_items'] = $this->Menu_model->get_all_items();
              //Get blog menu item - If itemID is not 2 then change the param below to the correct itemID
              $data['blog_item'] = $this->Menu_model->get_blog_item(2);
        
              //Views
              $data['main_content'] = 'admin/settings/index';
              $this->load->view('admin/template', $data);
        
        } else {
             if(!is_writable('assets/images')){ 
                  //Create Message
                  $this->session->set_flashdata('images_folder', 'Logo was not uploaded. you need to chmod 777 the folder <strong>"assets/images"</strong>');
              }
              if(!is_writable('assets/images/logo')){ 
                  //Create Message
                  $this->session->set_flashdata('images_logo_folder', 'Logo was not uploaded. you need to chmod 777 the folder <strong>"assets/images/logo"</strong>');
              }
                //Upload Logo
                $config['upload_path'] = './assets/images/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '2048';
                $config['max_height']	= '0';
                $config['max_width']	= '0';
                $config['overwrite']    = true;
                //Load upload lib
		$this->load->library('upload', $config);
                
                //If they uploaded a logo
		if ($this->upload->do_upload('userfile')){
			$upload_data = $this->upload->data();
                        $logo_image = $upload_data['file_name'];
                        
                //If no logo was uploaded        
		} else {
                    //Check if there is already an image for this post
                        $logo_image = $this->Settings_model->get_logo();
                       
                        if(!$logo_image){
                            //If no main imgage, set it to null
                            $logo_image = NULL;
                        }
                         //Debug 
                         //$error = array('error' => $this->upload->display_errors()); foreach($error as $er){ echo $er;}die();
		}
                
                
              //Get Blog Page Modules if Any
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
                
               //Create an array from the post values to update settings              
                $post_data = array(
                    'website_name' => $this->input->post('site_name'),
                    'headline_text' => $this->input->post('headline_text'),
                    'logo_type' => $this->input->post('logo_type'),
                    'logo_image' => $logo_image,
                    'logo_width' => $this->input->post('logo_width'),
                    'logo_height' => $this->input->post('logo_height'),
                    'meta_keywords' => $this->input->post('meta_keywords'),
                    'page_title' => $this->input->post('page_title'),
                    'meta_description' => $this->input->post('meta_description'),
                    'activate_blog' => $this->input->post('activate_blog'),
                    'post_num' => $this->input->post('post_num'),
                    'intro_text_count' => $this->input->post('intro_text_count'),
                    'main_image_width' => $this->input->post('main_image_width'),
                    'copyright' => $this->input->post('copyright'),
                    'activate_frontend_login' => $this->input->post('frontend_login'),
                    'google_analytics' => $this->input->post('analytics'),
                    'blog_menu_anchor' => $this->input->post('blog_menu_anchor'),
                    'blog_menu_id' => $this->input->post('menu_id'),
                    'blog_modules' => $mod_string,
                    'blog_menu_position' => $this->input->post('blog_menu_position')
                 );
                //Insert settings through model
                $this->Settings_model->update_settings($post_data);
                
                //Unpublish/publish blog
                if($this->input->post('activate_blog')==0){
                    $this->Menu_model->unpublish_item(2);
                } elseif($this->input->post('activate_blog')==1){
                    $this->Menu_model->publish_item(2);
                }
                
                  //Create an array from the menu item        
                $item_data = array(
                    'anchor' => $this->input->post('blog_menu_anchor'),
                    'menu_id' => $this->input->post('menu_id'),
                    'order' => $this->input->post('order')
                 );
                
                //Update blog item through model
                $this->Settings_model->update_blog_item($item_data);
   
                //Create Message
                $this->session->set_flashdata('settings_saved', 'Your settings have been saved ');
            
                //Redirect to posts
                redirect('admin/settings');
         
        }
       
    }
    
    public function blog(){
        $this->form_validation->set_rules('blog_menu_position','Blog Menu Position','trim|integer');
        $this->form_validation->set_rules('post_num','Post Count','trim|integer');
        $this->form_validation->set_rules('intro_text_count','Character Count','trim|integer');
        $this->form_validation->set_rules('main_image_width','Main Image Width','trim|integer');
       
        if($this->form_validation->run() == FALSE){
            //Get all menus
            $data['menu_select'] = $this->Page_model->get_menus();
            //Get module options  
            $data['mod_select'] = $this->Module_model->get_modules();
            $data['selected_modules'] = $this->Module_model->get_blog_modules();
            //Get menu items
              $data['menu_items'] = $this->Menu_model->get_all_items();
            //Get blog menu item - If itemID is not 2 then change the param below to the correct itemID
            $data['blog_item'] = $this->Menu_model->get_blog_item(2);
        
            //Views
            $data['main_content'] = 'admin/settings/blog_only';
            $this->load->view('admin/template', $data);
        } else {
            //Get Blog Page Modules if Any
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
              
               //Create an array from the post values to update settings              
                $post_data = array(
                    'activate_blog' => $this->input->post('activate_blog'),
                    'post_num' => $this->input->post('post_num'),
                    'intro_text_count' => $this->input->post('intro_text_count'),
                    'main_image_width' => $this->input->post('main_image_width'),                  
                    'blog_menu_anchor' => $this->input->post('blog_menu_anchor'),
                    'blog_modules' => $mod_string,
                    'blog_menu_position' => $this->input->post('blog_menu_position')
                 );
                //Insert settings through model
                $this->Settings_model->update_settings($post_data);
                
                //Unpublish/publish blog
                if($this->input->post('activate_blog')==0){
                    $this->Menu_model->unpublish_item(2);
                } elseif($this->input->post('activate_blog')==1){
                    $this->Menu_model->publish_item(2);
                }
                
                  //Create an array from the menu item        
                $item_data = array(
                    'anchor' => $this->input->post('blog_menu_anchor'),
                    'menu_id' => $this->input->post('menu_id'),
                    'order' => $this->input->post('order')
                 );
                
                //Update blog item through model
                $this->Settings_model->update_blog_item($item_data);
   
                //Create Message
                $this->session->set_flashdata('settings_saved', 'Your settings have been saved ');
            
                //Redirect to posts
                redirect('admin/settings/blog');
         
        }
        
    }
      
}
