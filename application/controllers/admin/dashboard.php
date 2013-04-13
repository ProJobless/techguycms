<?php
class Dashboard extends Admin_Controller{
    
    public function __construct() {
            parent::__construct();
 
           //Validate user
            if($this->session->userdata('logged_in_a') != true){
                redirect('admin/login');
            }
            
            $blog_activated = $this->Post_model->check_blog_activated();
    }
        
    
    public function index(){
        //Files that need to be checked for writeability
         $files = array(
             'application/cache/page_routes.php',
             'application/cache/post_routes.php',
             'application/config/database.php',
             'assets/images',
             'assets/images/user',
             'assets/images/blog',
             'assets/images/logo',
             'assets/images/admin'
         );
         //Get the unwriteble files
         $data['unwriteable'] = $this->check_writeable($files);  
         //Get dashboard stats
         $data['statistics'] = $this->Dashboard_model->get_statistics();
         //Is the blog activated?
         $data['blog_activated'] = $this->Dashboard_model->is_blog_activated();
        
         //Views
         $data['main_content'] = 'admin/dashboard';
         $this->load->view('admin/template', $data);
    }
    
    
    public function activate_blog(){
        $this->Dashboard_model->activate_blog();
        $this->Menu_model->publish_item(2);
        //Redirect to dashboard
        redirect('admin');
    }
    
    
    public function deactivate_blog(){
        $this->Dashboard_model->deactivate_blog();
        $this->Menu_model->unpublish_item(2);
        //Redirect to dashboard
        redirect('admin');
    }
    
    
    public function check_writeable($files){
        return $this->Dashboard_model->check_writeable($files);
    }
  
        
}

