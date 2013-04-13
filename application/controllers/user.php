<?php
class User extends Public_Controller{
    
    public function __construct() {
        parent::__construct();
    }
    
    
    public function register(){
        $this->form_validation->set_rules('first_name','First Name','trim|required|xss_clean');
        $this->form_validation->set_rules('last_name','Last Name','trim|required|xss_clean');
        $this->form_validation->set_rules('email','Email','trim|required|valid_email|xss_clean|callback_check_email_exists');
        
        $this->form_validation->set_rules('username','Username','trim|required|min_length[4]|xss_clean');
        $this->form_validation->set_rules('username','Username','trim|required|min_length[4]|max_length[16]|xss_clean|callback_check_username_exists');
        $this->form_validation->set_rules('password','Password','trim|required|min_length[4]|max_length[50]|xss_clean');
        $this->form_validation->set_rules('password2','Confirm Password','trim|required|matches[password]|xss_clean');
        
        if($this->form_validation->run() == FALSE){
            //Show View
            $data['main_content'] = 'public/user/register';
            $this->load->view('public/template', $data);
        //Validation has ran and passed    
        } else {
            //Get email address from post
            $email = $this->input->post('email');
            
            //Get a random activation code
            $activation_code = $this->_random_string(9);
            
            //Get global site email
            $from_email = $this->Settings_model->get_site_email();
            $from_name =  $this->Settings_model->get_site_name();
            
            if($query = $this->User_model->create_member($activation_code)){
                //Email confirmation
                $this->load->library('email');
                $this->email->from($from_email,$from_name);
                $this->email->to($email);
                $this->email->subject('Activate Your Account');
                $this->email->message('Please click the following link to activate your account '
                      . base_url().'user/register_confirm/' . $activation_code . '');
                
                //Send email
                if (!$this->email->send()) { //If email did not send
                      //Create error
                      $this->session->set_flashdata('email_no_send', 'There was an issue with sending the activation email. Contact your administrator');
                      //Redirect to index page with error above
                      redirect('index');
                } else { //If email was sent
                      //Create message
                      $this->session->set_flashdata('email_yes_send', 'Please check your email inbox and click on the activation link');
                      
                      //Send to activation info page
                      $data['main_content'] = 'public/user/activate';
                      $this->load->view('public/template', $data);
                }
                
                
               
            }
        }
        
    }
    
    
    public function check_username_exists($username){
        $this->form_validation->set_message('check_username_exists','That username already exists. Please choose a different one');
       if($this->User_model->check_username_exists($username)){
           return false;
       } else {
           return true;
       }
    }
    
    
     public function check_email_exists($email){
        $this->form_validation->set_message('check_email_exists','That email already exists. Please choose a different one');
       if($this->User_model->check_email_exists($email)){
           return false;
       } else {
           return true;
       }
    }
    
    
    public function register_confirm(){
        $activation_code = $this->uri->segment(3);
      
        if($activation_code == ''){
           $this->session->set_flashdata('no_activation', 'Sorry, your activation code is incorrect.');
           redirect('index.php');
        } else {
            if($this->User_model->confirm_registration($activation_code)){
                $this->session->set_flashdata('yes_activation', 'Your account is now activated, please log in');
                redirect('index.php');
            } else {
                 $this->session->set_flashdata('no_activation', 'Sorry, your activation code is incorrect.');
                 redirect('index.php');
            }
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

    
    public function login(){
         $this->form_validation->set_rules('username','Username','trim|required|min_length[4]|xss_clean');
         $this->form_validation->set_rules('password','Password','trim|required|min_length[4]|xss_clean');
         
          if($this->form_validation->run() == FALSE){
              //Just load view
              $data['main_content'] = 'public/user/login';
              $this->load->view('public/template', $data);
          } else {
              //Get from post
               $username = $this->input->post('username');
               $password = $this->input->post('password');
               
               //Get user id from model
               $user_id = $this->User_model->login_user($username,$password);
               
               //Validate user
               if($user_id){
                   //Create array of user data
                   $user_data = array(
                       'user_id'   => $user_id,
                       'username'  => $username,
                       'logged_in' => true
                   );
                    //Set session userdata
                   $this->session->set_userdata($user_data);
                   
                   //Set message
                   $this->session->set_flashdata('pass_login', 'You are now logged in');
                   redirect('index.php');
               } else {
                    //Set error
                   $this->session->set_flashdata('fail_login', 'Sorry, the login info that you entered is invalid');
                   redirect('user/login');
               }
                   
               //Set message
               $this->session->set_flashdata('logged_in', 'You are now logged in');
               redirect('index.php');
               
          }
    }
    
    
    public function logout(){
        //Unset user data
        $this->session->unset_userdata('logged_in');
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('username');
        $this->session->sess_destroy();
        
         //Set message
        $this->session->set_flashdata('logged_out', 'You have been logged out');
        redirect('index.php');
    }
    
    
     public function reset_password($email=null){
         //Validation rules
         $this->form_validation->set_rules('email','Email','trim|required|valid_email|xss_clean');
         
          //If validation has not run yet
          if($this->form_validation->run() == FALSE){
              //Views
             $data['main_content'] = 'public/user/reset_password_email';
             $this->load->view('public/template', $data);
              
          //If validation has ran and passed 
          } else {
 
                //Get email address from post
                $email = $this->input->post('email');
             
                //Get reset/activation code
                $reset_code = $this->User_model->get_reset_code($email);
              
              if($reset_code){
                 
                  //Get global site email
                  $from_email = $this->Settings_model->get_site_email();
                  $from_name =  $this->Settings_model->get_site_name();

                 //Send user email
                  $this->load->library('email');
                  $this->email->from($from_email,$from_name);
                  $this->email->to($email);
                  $this->email->subject('Password Reset');
                  $this->email->message('Please click the following link to reset your password '
                      . base_url().'user/reset_confirm/' . $reset_code . '');
                  if (!$this->email->send()) { //If email did not send
                      //Create error
                      $this->session->set_flashdata('email_no_send', 'There was an issue with sending the email. Contact your administrator');
                  } else { //If email was sent
                      //Create message
                      $this->session->set_flashdata('email_yes_send', 'Please check your inbox and click the reset link');
                  }
                  
                   //Redirect to user
                   redirect('user/reset_password');
              } else {
                  //Create Message
                  $this->session->set_flashdata('email_not_found', 'The email you provided does not exist');
            
                  //Redirect to user
                  redirect('user/reset_password');
              }
               
             
          }
          
     }
     
     //Confirm the reset code
     public function reset_confirm(){
          //Validation rules
          $this->form_validation->set_rules('password','Password','trim|required|min_length[4]|max_length[50]|xss_clean');
          $this->form_validation->set_rules('password2','Confirm Password','trim|required|matches[password]|xss_clean');
         
          //If validation has not run yet
          if($this->form_validation->run() == FALSE){
             $reset_code = $this->uri->segment(3);
        
            if($reset_code == ''){
                $this->session->set_flashdata('no_reset', 'Sorry, your reset code is incorrect.');
                redirect('index.php');
            } else {
                if($this->User_model->confirm_reset($reset_code)){  
                    $data['reset_code'] = $reset_code;
                    //Views
                    $data['main_content'] = 'public/user/reset_password';
                    $this->load->view('public/template', $data);
                } else {
                    $this->session->set_flashdata('no_reset', 'Sorry, your reset code is incorrect.');
                    redirect('index.php');
                }
            }
          } else {
              //If password form is submitted and passed
              $reset_code = $this->uri->segment(3);
              $new_password = $this->input->post('password');
              $enc_password = md5($new_password);
              $this->User_model->change_password(null,$enc_password,$reset_code);
              
              $this->session->set_flashdata('reset_complete', 'Your password has been changed');
              
              redirect('index.php');
          }
     }
     
}
