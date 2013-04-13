<?php
class User extends Admin_Controller{
    
    public function __construct() {
        parent::__construct();
  
    }
    
     public function index(){
            
          //Validate User
         if($this->session->userdata('logged_in_a') != true){
             redirect('admin/login');
         } 
         
         //Show stats
         $data['statistics'] = $this->Dashboard_model->get_statistics();
                       
         //Get all users
         $data['users'] = $this->User_model->get_all_users();
         
         //Get users roles
         $data['roles'] = $this->User_model->get_roles();
     
         //Views
         $data['main_content'] = 'admin/user/users';
         $this->load->view('admin/template', $data);
    }
        
    
    
    //Login admin user
     public function login(){
         //Validate form
         $this->form_validation->set_rules('username_a','Username','trim|required|min_length[4]|xss_clean');
         $this->form_validation->set_rules('password_a','Password','trim|required|min_length[4]|xss_clean');
         
          if($this->form_validation->run() == FALSE){
              //Just load view
               $this->load->view('admin/login');
          } else {
              //Get from post
               $username_a = $this->input->post('username_a');
               $password_a = $this->input->post('password_a');
               
               //Get user id
               $user_id_a = $this->User_model->login_admin_user($username_a,$password_a);
               
               //Validate ADMIN user
               if($user_id_a){
                   //Get user full name
                    $user_full_name_a = $this->User_model->get_user_full_name($user_id_a);
                    //Get user role
                    $user_role_a = $this->User_model->get_role($user_id_a);
                   
                   //Create array of user data
                   $user_data_a = array(
                       'user_id_a'        => $user_id_a,
                       'username_a'       => $username_a,
                       'user_full_name_a' => $user_full_name_a,
                       'user_role_a'      => $user_role_a,
                       'logged_in_a'      => true
                   );
                    //Set session userdata
                   $this->session->set_userdata($user_data_a);
                   
                   //Set message
                   $this->session->set_flashdata('pass_login', 'You are now logged in');
                   redirect('admin/dashboard');
               } else {
                    //Set error
                   $this->session->set_flashdata('fail_login', 'Sorry, the login info that you entered is invalid');
                   redirect('admin/login');
               }
                   
               redirect('admin');
               
          }
    }
    
    
    //Logout admin and destroy session
     public function logout(){

        @$this->session->unset_userdata($user_data_a);
        $this->session->sess_destroy();

        redirect('admin/login');
    }
    
    
    
    //Directs the checkbox actions on "Users" view
     public function action_direct_user(){ 
         if($this->input->post('add')){
             redirect('admin/user/add');
             
         } elseif($this->input->post('edit')){
             $user_array = $this->input->post('user_id');
             $user_id = $user_array[0];
              redirect("admin/user/edit/$user_id");
             
         } elseif($this->input->post('delete')){
             //Get user ids from checkboxes
             $user_array = $this->input->post('user_id');
             //Pass to delete function
             $this->delete($user_array);
             
         } elseif($this->input->post('activate')){
             //Get user ids from checkboxes
             $user_array = $this->input->post('user_id');
             //Pass to delete function
             $this->activate($user_array);
             
         } elseif($this->input->post('deactivate')){
             //Get user ids from checkboxes
             $user_array = $this->input->post('user_id');
             //Pass to delete function
             $this->deactivate($user_array);
         } else {
             redirect('admin/users');
         }
     }
     
     
     private function _random_string($length) {
        $len = $length;
        $base = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz123456789";
        $max = strlen($base) - 1;
        $activatecode = '';
        mt_srand((double) microtime() * 1000000);

        while (strlen($activatecode) < $len + 1) {
            $activatecode.=$base[mt_rand(0, $max)];
        }

            return $activatecode;
    }
     
     
     
     public function add(){  
         //Form validation
        $this->form_validation->set_rules('first_name','First Name','trim|required|min_length[3]|xss_clean');
        $this->form_validation->set_rules('last_name','Last Name','trim|xss_clean');
        $this->form_validation->set_rules('username','Username','trim|required|min_length[3]|xss_clean|callback_check_username_exists');
        $this->form_validation->set_rules('first_name','First Name','trim|required|min_length[3]|xss_clean');
        $this->form_validation->set_rules('email','Email','trim|required|valid_email|xss_clean|callback_check_email_exists');
        $this->form_validation->set_rules('password','Password','trim|required|min_length[4]|max_length[50]|xss_clean');
        $this->form_validation->set_rules('password2','Confirm Password','trim|required|matches[password]|xss_clean');
        $this->form_validation->set_rules('activated','Activated','required');
        $this->form_validation->set_rules('address1','Address','trim|xss_clean');
        $this->form_validation->set_rules('address2','Address 2','trim|xss_clean');
        $this->form_validation->set_rules('city','City','trim|xss_clean');
        $this->form_validation->set_rules('state','State','trim|xss_clean');
          //If validation has not run yet
          if($this->form_validation->run() == FALSE){
              //Get state options
              $data['states'] = $this->User_model->get_states();
              //Get role options
              $data['roles'] = $this->User_model->get_roles();
             
              //Views
              $data['main_content'] = 'admin/user/add_new_user';
              $this->load->view('admin/template', $data);
              
          //If validation has ran and passed 
          } else {
              if(!is_writable('assets/images')){ 
                  //Create Message
                  $this->session->set_flashdata('images_folder', 'Avatar was not uploaded. you need to chmod 777 the folder <strong>"assets/images"</strong>');
              }
              if(!is_writable('assets/images/user')){ 
                  //Create Message
                  $this->session->set_flashdata('images_user_folder', 'Avatar was not uploaded. you need to chmod 777 the folder <strong>"assets/images/user"</strong>');
              }
                //Upload Image
                $config['upload_path'] = './assets/images/user/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '2048';

		$this->load->library('upload', $config);

		if ($this->upload->do_upload('userfile')){
			$upload_data = $this->upload->data();
                        $avatar_image = $upload_data['file_name'];
                        ////////// MAKE IMAGE NAME UNIQUE, GET USER ID ////////////

		} else {
                        $avatar_image = '';
		}
           
                //Encrypt password
                $enc_password = md5($this->input->post('password'));
                
                //Get random code
                $activation_code = $this->_random_string(10);
              
            $data = array(
                    'first_name' => $this->input->post('first_name'),
                    'last_name' => $this->input->post('last_name'),
                    'avatar' => $avatar_image,
                    'email' => $this->input->post('email'),
                    'username' => $this->input->post('username'),
                    'password' => $enc_password,
                    'role' => $this->input->post('role'),
                    'phone' => $this->input->post('phone'),
                    'address1' => $this->input->post('address'),
                    'address2' => $this->input->post('address2'),
                    'city' => $this->input->post('city'),
                    'state' => $this->input->post('state'),
                    'postcode' => $this->input->post('postcode'),
                    'is_activated' => $this->input->post('activated'),
                    'activation_code' => $activation_code
                
             );
       
            $this->User_model->add_user($data);  
            
            //Create Message
            $this->session->set_flashdata('user_added', 'User has been added');
            
            //Redirect to users
            redirect('admin/users');
          }
    }
    
    
    //Edit-update user fields
     public function edit($user_id){  
         //Form validation
        $this->form_validation->set_rules('first_name','First Name','trim|required|min_length[3]|xss_clean');
        $this->form_validation->set_rules('last_name','Last Name','trim|xss_clean');
        $this->form_validation->set_rules('username','Username','trim|required|min_length[3]|xss_clean');
        $this->form_validation->set_rules('first_name','First Name','trim|required|min_length[3]|xss_clean');
        $this->form_validation->set_rules('email','Email','trim|required|valid_email|xss_clean');
        $this->form_validation->set_rules('address1','Address','trim|xss_clean');
        $this->form_validation->set_rules('address2','Address 2','trim|xss_clean');
        $this->form_validation->set_rules('city','City','trim|xss_clean');
        $this->form_validation->set_rules('state','State','trim|xss_clean');
          //If validation has not run yet
          if($this->form_validation->run() == FALSE){
              //Get state options
              $data['states'] = $this->User_model->get_states();
              
              //Get role options
              $data['roles'] = $this->User_model->get_roles();
              
              //Get the user to edit 
              $data['this_user'] = $this->User_model->get_user($user_id);
             
              //Views
              $data['main_content'] = 'admin/user/edit_user';
              $this->load->view('admin/template', $data);
              
          //If validation has ran and passed 
          } else {
              if(!is_writable('assets/images')){ 
                  //Create Message
                  $this->session->set_flashdata('images_folder', 'Avatar was not uploaded. you need to chmod 777 the folder <strong>"assets/images"</strong>');
              }
              if(!is_writable('assets/images/user')){ 
                  //Create Message
                  $this->session->set_flashdata('images_user_folder', 'Avatar was not uploaded. you need to chmod 777 the folder <strong>"assets/images/user"</strong>');
              }
              //Upload Image
              $config['upload_path'] = './assets/images/user/';
	      $config['allowed_types'] = 'gif|jpg|png';
	      $config['max_size']	= '2048';
              $config['max_height']	= '0';
              $config['max_width']	= '0';
              $config['overwrite']    = true;

	      $this->load->library('upload', $config);
                
	      //If they uploaded a file
	      if ($this->upload->do_upload('userfile')){
	        $upload_data = $this->upload->data();
                $avatar_image = $upload_data['file_name'];
                        ////////// MAKE IMAGE NAME UNIQUE, GET USER ID ////////////
              //If no file was uploaded        
              } else {
                  if($this->input->post('delete_avatar') == 1){
                  $this->User_model->delete_avatar_image($user_id);
              }
              //Check if there is already an image for this post
              $avatar_image = $this->User_model->get_avatar($user_id);
               if(!$avatar_image){
                   //If no main imgage, set it to noimage.jpg
                   $avatar_image = '';
               }
	    }
           
                
                //Create data array
            $data = array(
                    'first_name' => $this->input->post('first_name'),
                    'last_name' => $this->input->post('last_name'),
                    'avatar' => $avatar_image,
                    'email' => $this->input->post('email'),
                    'username' => $this->input->post('username'),
                    'role' => $this->input->post('role'),
                    'phone' => $this->input->post('phone'),
                    'address1' => $this->input->post('address'),
                    'address2' => $this->input->post('address2'),
                    'city' => $this->input->post('city'),
                    'state' => $this->input->post('state'),
                    'postcode' => $this->input->post('postcode'),
                    'is_activated' => $this->input->post('activated')
             );
            
            //update the users fields from above
            $this->User_model->edit_user($user_id,$data);  
            
            //Create Message
            $this->session->set_flashdata('user_saved', 'User has been saved');
            
            //Redirect to user
            redirect('admin/user/edit/' . $user_id . '');
          }
    }
    
    
    
    
    //Check for existing username
    public function check_username_exists($username){
        $this->form_validation->set_message('check_username_exists','That username already exists. Please choose a different one');
       if($this->User_model->check_username_exists($username)){
           return false;
       } else {
           return true;
       }
    }
    
    
    
    //Check for existing email address
     public function check_email_exists($email){
        $this->form_validation->set_message('check_email_exists','That email already exists. Please choose a different one');
       if($this->User_model->check_email_exists($email)){
           return false;
       } else {
           return true;
       }
    }
    
    //Delete user
    public function delete($user_array){      
            if(!isset($user_array) || $user_array == ''){
                redirect('admin/posts');
            }
            $this->User_model->delete_users($user_array);
         
            //Create Message
            $this->session->set_flashdata('user_deleted', 'Your user(s) have been deleted');
            
            //Redirect to posts
            redirect('admin/users');
     }
     
     
     //Activate user
      public function activate($user_array){
          if(!isset($user_array) || $user_array == ''){
                redirect('admin/users');
            }
         
            $this->User_model->activate_users($user_array);
         
            //Create Message
            $this->session->set_flashdata('user_activated', 'User(s) have been activated');
            
            //Redirect to posts
            redirect('admin/users');
     }
     
     
     //Deactivate user
      public function deactivate($user_array){
          if(!isset($user_array) || $user_array == ''){
                redirect('admin/users');
            }
         
            $this->User_model->deactivate_users($user_array);
         
            //Create Message
            $this->session->set_flashdata('user_deactivated', 'User(s) have been deactivated');
            
            //Redirect to posts
            redirect('admin/users');
     }
    
     
     
     public function resend_activation(){
         
     }
     
     
     public function change_password($user_id){
         
         $this->form_validation->set_rules('password','Password','trim|required|min_length[4]|max_length[50]|xss_clean');
         $this->form_validation->set_rules('password2','Confirm Password','trim|required|matches[password]|xss_clean');
       
          //If validation has not run yet
          if($this->form_validation->run() == FALSE){
              //Get the user
              $data['this_user'] = $this->User_model->get_user($user_id);
         
              //Views
              $data['main_content'] = 'admin/user/change_password';
              $this->load->view('admin/template', $data);
              
          //If validation has ran and passed 
          } else {
             $enc_password = md5($this->input->post('password'));
             
             //Update the users password
            $this->User_model->change_password($user_id,$enc_password);  
            
            //Create Message
            $this->session->set_flashdata('password_changed', 'Users password has been changed');
            
            //Redirect to user
            redirect('admin/user/edit/' . $user_id . '');
                  
          }
         
     }
    
    
}

