<?php
class Settings_model extends CI_Model{
    public function check_install(){
        $this->db->where('key','activate_site');
        $query = $this->db->get('globals');
        return $query->row()->value;
    }
    
    public function get_global_settings(){
        $query = $this->db->get('globals');
        $result = $query->result();
         
         return $result;
    
    }
    
    public function get_global_setting($key){
        $this->db->where('key', $key);
        $query = $this->db->get('globals');
         if ($query->num_rows() == 1) {
             return $query->row();
        } else {
            return FALSE;
        }
    }
 
     //Get main site name
    public function get_site_name(){
        $this->db->where('key','website_name');
        $query = $this->db->get('globals');
        return $query->row()->value;
    }
    
    
    public function get_logo(){
        $this->db->where('key','logo_image');
        $query = $this->db->get('globals');
        return $query->row()->value;
    }
    
    //Insert or update setting values
    public function update_settings($post_data){
        foreach($post_data as $key => $value){
            $this->db->where('key',$key);
            $this->db->set('value',$value);
            $this->db->update('globals');          
        }
    }
    
    //Get main site email
    public function get_site_email(){
        $this->db->where('key','site_email');
        $query = $this->db->get('globals');
        return $query->row()->value;
    }
   
    
    //Check if site is activated
    public function activate_site(){
        $this->db->where('key','activate_site');
        $query = $this->db->get('globals');
        $result = $query->row()->value;
        if($result == 1){
            return true;
        } else {
            return false;
        }
    }
    
    
     public function is_blog_activated(){
        $this->db->where('key','activate_blog');
        $query = $this->db->get('globals');
        return $query->row()->value;
    }
    
    public function activate_blog(){
        $this->db->where('key','activate_blog');
        $this->db->set('value',1);
        $this->db->update('globals');    
        return;
    }
    
    public function deactivate_blog(){
        $this->db->where('key','activate_blog');
        $this->db->set('value',0);
        $this->db->update('globals');  
        return;
    }
    
    public function update_blog_item($item_data){
        $this->db->where('item_id',2);
        $this->db->update('menu_items', $item_data); 
        return;
    }
    
    
    //Get form type
    public function get_form_type($form_id){
        $this->db->where('id',$form_id);
        $query = $this->db->get('forms');
        return $query->row()->type;
    }
}
