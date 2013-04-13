<?php
//Global Controller
class MY_Controller extends CI_Controller{
    public function __construct() {
            parent::__construct();
           
            //If the db_params file exists and is not empty, redirect to install
            if(is_dir('install') && file_exists('install/config/db_params.php') && filesize('install/config/db_params.php') == 0){
                redirect('install');
            }
            //Set timezone
            date_default_timezone_set('America/New_York');
            //Load the page model
            $this->load->model('Page_model');
            //Load the menu model
            $this->load->model('Menu_model');
            //Load the blog post model
            $this->load->model('Post_model');
            //Load the modules model
            $this->load->model('Module_model');
             //Load the settings model
            $this->load->model('Settings_model');
             //Load the user model
            $this->load->model('User_model');
            //Load the form model
            $this->load->model('Form_model');
            
            //Loop to get all settings in the "globals" table
            foreach ($this->Settings_model->get_global_settings() as $result){
                 $global_data[$result->key] = $this->Settings_model->get_global_setting($result->key);
            }

            //Get modules
            $global_data['modules'] = $this->Module_model->get_modules();
            
            //Load into all views loaded by this controller
            $this->load->vars($global_data);
    }
    
    
}


//Admin Controller
class Admin_Controller extends MY_Controller{
    public function __construct() {
        parent::__construct();
        
        //Check if install folder is gone
        if(is_dir('install')){
            redirect(base_url().'install/delete_install_folder.php');
            die();
        }
        
        //Check if site is activated
        if($this->Settings_model->activate_site() == false){
            redirect('install');
        }
        
         //Load the dashboard model
         $this->load->model('Dashboard_model');
        
         //Get menu data
         //$admin_data['admin_menu'] = $this->Page_model->get_menu(3);
         
         //Load into all admin views
         //$this->load->vars($admin_data);
         
         
    }
}

//Public Controller
class Public_Controller extends MY_Controller{
    public function __construct() {
        parent::__construct();
        
        //Check if install folder is gone
        if(is_dir('install')){
            redirect(base_url().'install/delete_install_folder.php');
            die();
        }
        
         //Check if site is activated
        if($this->Settings_model->activate_site() == false){
            redirect('install');
        }
        
         //Get menus
         $public_data['menus'] = $this->Module_model->get_menus();
            
         //Get main menu data - NEED TO MAKE THIS DYNAMIC
         $public_data['main_menu'] = $this->Menu_model->get_parent_items(1);
         $public_data['main_menu_child'] = $this->Menu_model->get_child_items(1);
         
         $site_email = 'info@techguy.com';
      
         //Load into all public views
         $this->load->vars($public_data);
    }
}
