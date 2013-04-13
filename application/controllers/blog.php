<?php
class Blog extends Public_Controller{
    
    //Number of posts on blog index page
    private $post_num;
    //Length of intro text
    private $intro_chars;
    //Main image size
    private $main_image_width;
    
    
    
    public function __construct() {    
        parent::__construct();
        
        //Is blog activated?
        if($this->Settings_model->is_blog_activated() != true){
            redirect('home');
        }
            
        //Load custom "blog" helper
        $this->load->helper('blog');
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
            //Check if any modules are enabled
            if(!empty($module_array)){
                $data['page_modules'] = $this->Module_model->get_blog_modules();
            } else {
                $data['page_modules'] = null;
            }
            
            //Check if sidebar is enabled
            $data['sidebar_enabled'] = $this->Module_model->is_sidebar_enabled(null,'post','latest',$module_array);
            
            //Meta stuff
            $meta['page_meta'] = $this->Post_model->get_post_meta(null,'latest');
            $this->load->vars($meta);
            
            //Views
            $data['main_content'] = 'public/blog/index';
            $this->load->view('public/template', $data);
    }
    
    
    
    public function display($id){
          //Get single post
           $data['post'] = $this->Post_model->get_post($id);
           
           //Get blog info
           $data['author'] = $this->Post_model->get_author($id);
           $data['blog_comments'] = $this->Post_model->get_comments($id);
           $data['category'] = $this->Post_model->get_category($id);
           
           //Get the pages modules
           $data['page_modules'] = $this->Module_model->get_page_modules($id,'post','regular');
           
           //Check if sidebar is enabled
           $data['sidebar_enabled'] = $this->Module_model->is_sidebar_enabled($id,'post','regular');
           
           //Meta stuff
           $meta['page_meta'] = $this->Post_model->get_post_meta($id);
           $this->load->vars($meta);
           
           //Views
           $data['main_content'] = 'public/blog/display';
           $this->load->view('public/template', $data);
        }
        
        
        //Process the comment form info
        public function comment_form_process($post_id){           
            $this->form_validation->set_rules('title','Title','trim|required|xss_clean');
            $this->form_validation->set_rules('name','Name','trim|required|xss_clean');
            $this->form_validation->set_rules('website','Website','trim|xss_clean|prep_url');
            $this->form_validation->set_rules('comment','Comment','trim|required|xss_clean');
            
             if($this->form_validation->run() == FALSE){
                $this->session->set_flashdata('comment_form', 'Please fill out the comment form correctly.');
                redirect("blog/display/$post_id#bottom");
             } else {
                 
             }
             //Comment info array
            $data = array(
                'title' => $this->input->post('title'),
                'author_name' => $this->input->post('name'),
                'website' => $this->input->post('website'),
                'body' => $this->input->post('comment'),
                'is_approved' => 0,
                'post_id' => $post_id
            );
            
            //Add the comment to db but not approved yet
            $this->Post_model->add_comment($data);
            
             //Create Message
            $this->session->set_flashdata('comment_added', 'Your comment has been added and is waiting approval');
            
            redirect("blog/display/$post_id");
        }
}
