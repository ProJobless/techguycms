<?php
class Dashboard_model extends CI_Model{
    
    public function get_statistics(){
        $stat_array = array();
 
        /* User Stats */
        //Current user username
        $user_id_a = $this->session->userdata('user_id_a');
        $this->db->where('id',$user_id_a);
        $query = $this->db->get('users');
        $stat_array['current_user'] = $query->row()->username;
        
        //Current user role
        $user_role_a = $this->session->userdata('user_role_a');
     
        $this->db->where('id',$user_role_a);
        $query = $this->db->get('user_roles');
        $stat_array['current_role'] = $query->row()->name;
        
        $count_user_query = $this->db->get('users');
        $stat_array['num_users'] = $count_user_query->num_rows();
        
        $this->db->where('is_activated',1);
        $activated_users_query = $this->db->get('users');
        $stat_array['num_activated_users'] = $activated_users_query->num_rows();
        
        $this->db->where('is_activated',0);
        $unactivated_users_query = $this->db->get('users');
        $stat_array['num_unactivated_users'] = $unactivated_users_query->num_rows();
        
        /* Page Stats */
        $count_page_query = $this->db->get('pages');
        $stat_array['num_pages'] = $count_page_query->num_rows();
        
        $this->db->where('is_published',1);
        $count_pages_published_query = $this->db->get('pages');
        $stat_array['num_published_pages'] = $count_pages_published_query->num_rows();
        
        $this->db->where('is_published',0);
        $count_pages_unpublished_query = $this->db->get('pages');
        $stat_array['num_unpublished_pages'] = $count_pages_unpublished_query->num_rows();
        
        /* Blog Post Stats */
        $count_post_query = $this->db->get('blog_posts');
        $stat_array['num_posts'] = $count_post_query->num_rows();
        
        $this->db->where('is_published',1);
        $count_posts_published_query = $this->db->get('blog_posts');
        $stat_array['num_published_posts'] = $count_posts_published_query->num_rows();
        
        $this->db->where('is_published',0);
        $count_posts_unpublished_query = $this->db->get('blog_posts');
        $stat_array['num_unpublished_posts'] = $count_posts_unpublished_query->num_rows();
        
        return $stat_array;
        
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
    
    public function check_writeable($files){
        $unwriteable = array();
        foreach($files as $file){
            if(!is_writable($file)){
                $unwriteable[] = $file;
            } 
        }
        return $unwriteable;
    }
}
    
