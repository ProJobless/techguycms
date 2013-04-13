<?php
class User_model extends CI_Model{
    
     public function create_member($activation_code){
        $new_member_insert = array(
            'first_name'       => $this->input->post('first_name'),
            'last_name'        => $this->input->post('last_name'),
            'email'            => $this->input->post('email'),
            'username'         => $this->input->post('username'),
            'activation_code'  => $activation_code,
            'role'             => 1,
            'password'         => md5($this->input->post('password'))
        );
        
        $insert = $this->db->insert('users', $new_member_insert);
        return $insert;
    }
    
    
    
    public function check_username_exists($username){
        $this->db->select('username');
        $this->db->where('username',$username);
        $result = $this->db->get('users');
        if($result->num_rows > 0){
                //It exists
                return true;
	} else {
                //It doesnt exist
                return false;
        }
    }
    
    
    
     public function check_email_exists($email){
        $this->db->select('email');
        $this->db->where('email',$email);
        $result = $this->db->get('users');
        if($result->num_rows > 0){
                //It exists
                return true;
	} else {
                //It doesnt exist
                return false;
        }
    }
    
    
    
    public function confirm_registration($activation_code){
        $data = array();
        $this->db->select('id');
        $this->db->where('activation_code',$activation_code);
        $result = $this->db->get('users');
        if($result->num_rows() > 0){
            $data = array('is_activated' => 1);
            $this->db->where('activation_code',$activation_code);
            $this->db->update('users',$data);
            return true;
        } else {
            return false;
        }
    }
    
    
    
    public function login_user($username,$passowrd){
        
        //Secure password
        $enc_password = md5($passowrd);
        
        //Validate
        $this->db->where('username',$username);
        $this->db->where('password',$enc_password);
        $this->db->where('is_activated',1);
        
        $result = $this->db->get('users');
        if($result->num_rows() == 1){
            return $result->row(0)->id;
        } else {
            return false;
        }
    }
    
    
    public function get_user($user_id){
        $this->db->where('id',$user_id);
        $query = $this->db->get('users');
        return $query->row();
    }
    
    
    //Array with all states
    public function get_states(){
        $state_array = array(
                '0'=>"Select State",  
                'AL'=>"Alabama",
                'AK'=>"Alaska",  
                'AZ'=>"Arizona",  
                'AR'=>"Arkansas",  
                'CA'=>"California",  
                'CO'=>"Colorado",  
                'CT'=>"Connecticut",  
                'DE'=>"Delaware",  
                'DC'=>"District Of Columbia",  
                'FL'=>"Florida",  
                'GA'=>"Georgia",  
                'HI'=>"Hawaii",  
                'ID'=>"Idaho",  
                'IL'=>"Illinois",  
                'IN'=>"Indiana",  
                'IA'=>"Iowa",  
                'KS'=>"Kansas",  
                'KY'=>"Kentucky",  
                'LA'=>"Louisiana",  
                'ME'=>"Maine",  
                'MD'=>"Maryland",  
                'MA'=>"Massachusetts",  
                'MI'=>"Michigan",  
                'MN'=>"Minnesota",  
                'MS'=>"Mississippi",  
                'MO'=>"Missouri",  
                'MT'=>"Montana",
                'NE'=>"Nebraska",
                'NV'=>"Nevada",
                'NH'=>"New Hampshire",
                'NJ'=>"New Jersey",
                'NM'=>"New Mexico",
                'NY'=>"New York",
                'NC'=>"North Carolina",
                'ND'=>"North Dakota",
                'OH'=>"Ohio",  
                'OK'=>"Oklahoma",  
                'OR'=>"Oregon",  
                'PA'=>"Pennsylvania",  
                'RI'=>"Rhode Island",  
                'SC'=>"South Carolina",  
                'SD'=>"South Dakota",
                'TN'=>"Tennessee",  
                'TX'=>"Texas",  
                'UT'=>"Utah",  
                'VT'=>"Vermont",  
                'VA'=>"Virginia",  
                'WA'=>"Washington",  
                'WV'=>"West Virginia",  
                'WI'=>"Wisconsin",  
                'WY'=>"Wyoming");
        
      return $state_array;
    }
 
    //Get a list of roles from this array
    public function get_roles(){
        $query = $this->db->get('user_roles');
        return $query->result();
       
    }
    
    //Get a users role
    public function get_role($user_id){
        $this->db->where('id',$user_id);
        $query = $this->db->get('users');
        $role_id = $query->row()->role;
        
        $this->db->where('id',$role_id);
        $query = $this->db->get('user_roles');
        return $query->row()->id;
       
    }
    
    
    /*
     * ADMIN USER FUNCTIONS
     * Below functions are for admins only
     */
    public function login_admin_user($username_a,$password_a){
        
         //Secure password
        $enc_password_a = md5($password_a);
      
        //Validate
        $this->db->where('role',3); //admin
        $this->db->where('username',$username_a);
        $this->db->where('password',$enc_password_a);
        $this->db->where('is_activated',1);
        
        $result = $this->db->get('users');
        if($result->num_rows() == 1){
            return $result->row(0)->id;
        } else {
            return false;
        }
    }
    
    
    public function get_user_full_name($user_id_a){
        $this->db->where('id',$user_id_a);
        $query = $this->db->get('users');
        if($query->num_rows() == 1){
            $first_name = $query->row()->first_name;
            $last_name = $query->row()->last_name;
            
            $full_name = $first_name . ' ' . $last_name;
            return $full_name;
        }
    }
    
    
     //Get avatar image name
    public function get_avatar($user_id){
        $this->db->where('id',$user_id);
        $query = $this->db->get('users');
        return $query->row()->avatar;
    }
    
    //Delete avatar image
    public function delete_avatar_image($user_id){     
       $data = array(
               'avatar' => ''
            );
            $this->db->where('id',$user_id);
            $this->db->update('users',$data);
       return;
    }
    
    public function get_all_users(){
        $query = $this->db->get('users');
        return $query->result();
    }
    
    
    //Add a user
    public function add_user($data){
        $this->db->insert('users', $data);
	return;
    }
    
    
    
    public function edit_user($user_id,$data){
        $this->db->where('id', $user_id);
        $this->db->update('users', $data); 
        return;
    }
    
    
    
   //Delete user(s)
    public function delete_users($user_array){
         foreach($user_array as $user_id){
            $this->db->where('id',$user_id);
            $this->db->delete('users');
        }
        return;
    }
    
    
    
    //Activate user(s)
      public function activate_users($user_array){
        foreach($user_array as $user_id){
           $data = array(
               'is_activated' => 1
            );
            $this->db->where('id',$user_id);
            $this->db->update('users',$data);
        }
        return;
    }
    
    
    
    //Deactivate user(s)
      public function deactivate_users($user_array){
        foreach($user_array as $user_id){
           $data = array(
               'is_activated' => 0
            );
            $this->db->where('id',$user_id);
            $this->db->update('users',$data);
        }
        return;
    }
    
    
    public function change_password($user_id,$enc_password,$reset_code = null){
        if($reset_code == null){
            $this->db->set('password',$enc_password);
            $this->db->where('id', $user_id);
            $this->db->update('users');
        } else {
            $this->db->set('password',$enc_password);
            $this->db->where('activation_code', $reset_code);
            $this->db->update('users');
        }
        return;
    }
    
    
     public function get_reset_code($email){
        $this->db->where('email',$email);
        $query = $this->db->get('users');
        if($query->num_rows > 0){
            return $query->row()->activation_code;
        } else {
            return FALSE;
        }
    }
    
    
     public function confirm_reset($reset_code){
        $data = array();
        $this->db->where('activation_code',$reset_code);
        $query = $this->db->get('users');
        if($query->num_rows > 0){
            return $query->row();
        } else {
            return false;
        }
    }
    
    
    public function ban_user(){
        
    }
    
    public function user_search(){
        
    }
}
