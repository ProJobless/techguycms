<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page extends Public_Controller {
    
        public function __construct() {
            parent::__construct();           
        }

       
	public function index(){
            
            //Get the number of posts from db
            $this->post_num = $this->Post_model->get_post_num();
            //Get the number of chars in post intro
            $this->intro_chars = $this->Post_model->get_intro_chars();
            //Get the main image width
            $this->main_image_width = $this->Post_model->get_main_image_width();
            //Get blog info
            $data['latest_posts'] = $this->Post_model->get_latest_posts($this->post_num);
            $data['intro'] = $this->intro_chars;
            $data['main_image_width'] = $this->main_image_width;
            
            //Get the modules for main blog page
             $module_array = $this->Module_model->get_blog_modules();
             if(empty($module_array[0]) || $module_array[0] == ""){
                $module_array = null;
             }
            
            //Get the page modules
            $data['page_modules'] = $this->Module_model->get_page_modules(null,'page','featured');
            
            //Get featured pages for homepage
            $data['pages'] = $this->Page_model->get_featured_pages();
            
            //Check if sidebar is enabled
            $data['sidebar_enabled'] = $this->Module_model->is_sidebar_enabled(null,'page','featured',null);
            
            
            //Meta stuff
            $meta['page_meta'] = $this->Page_model->get_homepage_meta();
            $this->load->vars($meta);
            
            //Views
            $data['main_content'] = 'public/page/index';
            $this->load->view('public/template', $data);
	}
        
        
        public function display($id){   
          //Get single page
           $data['page'] = $this->Page_model->get_page($id);
           
           //Get the pages modules
           $data['page_modules'] = $this->Module_model->get_page_modules($id,'page','regular');
           
           //Check if sidebar is enabled
           $data['sidebar_enabled'] = $this->Module_model->is_sidebar_enabled($id,'page','regular');
           
           //Meta stuff
           $meta['page_meta'] = $this->Page_model->get_page_meta($id);
           $this->load->vars($meta);
           
           //Views
           $data['main_content'] = 'public/page/display';
           $this->load->view('public/template', $data);
        }
        
        
        public function search(){   
            //Get the keyword(s) field input from the $_POST array
            $search_query = $this->input->post('search_query');
            
            $data['search_results'] = $this->Page_model->get_search_results($search_query);
            //Count the number of result rows
            $data['search_num_rows'] = $this->Page_model->get_search_rows($search_query);
            
            //Views
            $data['main_content'] = 'public/page/search_results';
            $this->load->view('public/template', $data);
        }              
}
