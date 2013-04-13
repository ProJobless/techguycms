<?php
class Page_model extends CI_Model{
    
    //Get all pages
    public function get_all(){
        $query = $this->db->get('pages');
        return $query->result();
    }
    
    //Set the page title
    public function set_page_title(){
        $url = $this->uri->segment(1);
        $page_title = ucwords(str_replace('-',' ',$url));
        return $page_title;
    }
 
    
    //Get all featured/home pages
    public function get_featured_pages(){
        $this->db->where('is_featured',1);
        $query = $this->db->get('pages');
        return $query->result();
    }
    
    //Get a single page
    public function get_page($id){
        $this->db->where('is_published',1);
        $this->db->where('id',$id);
        $query = $this->db->get('pages');
        return $query->row();
    }
    
    
    //Get all order numbers
    public function get_orders(){
        $this->db->select('order');
        $query = $this->db->get('menu_items');
        return $query->result();
    }
    
    //Get order of children
     public function get_children_orders($parent_id){
        $this->db->where('is_child',1);
        $query = $this->db->get('menu_items');
        return $query->result();
    }
    
    
    //Get a pages order
    public function get_order_from_page($page_id){
        $this->db->where('page_id',$page_id);
        $query = $this->db->get('menu_items');
        return $query->row()->order+1;
        
    }
    
    
    
    public function get_page_meta($id = null,$area = null){
            if($area == 'contact'){
               //get contact page meta
            }
            $this->db->where('id', $id);
            $query = $this->db->get('pages');
            $meta_info = $query->row(); 
            return $meta_info;
    }
    
    
    
    public function get_homepage_meta(){
            $this->db->where('is_featured',1);
            $query = $this->db->get('pages');
            $meta_info = $query->row(); 
            return $meta_info;
    }
    
    
    
    public function get_search_results($search_query){ 
       $sql = "SELECT * FROM pages WHERE name LIKE '%".$this->db->escape_like_str($search_query)."%' OR body LIKE '%".$this->db->escape_like_str($search_query)."%'";
       $query = $this->db->query($sql);
        if($query->num_rows() > 0){
            return $query->result();
        } else {
            return '<p>Sorry, no results</p>';
        }
    }
    
    
    
    public function get_search_rows($search_query){
         $sql = "SELECT * FROM pages WHERE name LIKE '%".$this->db->escape_like_str($search_query)."%' OR body LIKE '%".$this->db->escape_like_str($search_query)."%'";
       $query = $this->db->query($sql);
        if($query->num_rows() > 0){
           $rowcount = $query->num_rows();
            return $rowcount;
        } else {
            return false;
        }
    }
      
    
    public function check_if_published($page_id){
        $this->db->select('is_published');
        $this->db->where('id',$page_id);
        $query = $this->db->get('pages');
        return $query->row();
    }
    
    
    
     public function check_if_featured($page_id){
        $this->db->select('is_featured');
        $this->db->where('id',$page_id);
        $query = $this->db->get('pages');
        return $query->row();
    }
    
   
    //This gets ALL pages whether published or not
    public function get_page_admin($id){
        $this->db->where('id',$id);
        $query = $this->db->get('pages');
        return $query->row();
    }
    
    
    public function add_page($data){
        $this->db->insert('pages', $data);
	return;
    }
    
    
    
    public function get_insert_id(){
        return $this->db->insert_id();
    }
     
    
    
    public function edit_page($page_id,$data){
        $this->db->where('id', $page_id);
        $this->db->update('pages', $data); 
        return;
    }
    
    
    
    public function delete_pages($page_array){
        foreach($page_array as $page_id){
            $this->db->where('id',$page_id);
            $this->db->delete('pages');
        }
        return;
    }
    
    
    public function publish_pages($page_array){
        foreach($page_array as $page_id){
           $data = array(
               'is_published' => 1
            );
            $this->db->where('id',$page_id);
            $this->db->update('pages',$data);
        }
        return;
    }
    
    
     public function publish_menu_items($page_array){
        foreach($page_array as $page_id){
           $data = array(
               'is_published' => 1
            );
            $this->db->where('page_id',$page_id);
            $this->db->update('menu_items',$data);
        }
    }
    
    
    
     public function unpublish_pages($page_array){
        foreach($page_array as $page_id){
            $data = array(
               'is_published' => 0
            );
            $this->db->where('id',$page_id);
            $this->db->update('pages',$data);
        }
        return;
    }
    
    
     public function unpublish_menu_items($page_array){
        foreach($page_array as $page_id){
            $data = array(
               'is_published' => 0
            );
            $this->db->where('page_id',$page_id);
            $this->db->update('menu_items',$data);
        }
        return;
    }
    
    
    
     public function feature_pages($page_array){
        foreach($page_array as $page_id){
           $data = array(
               'is_featured' => 1
            );
            $this->db->where('id',$page_id);
            $this->db->update('pages',$data);
        }
        return;
    }
    
    
    
     public function unfeature_pages($page_array){
        foreach($page_array as $page_id){
            $data = array(
               'is_featured' => 0
            );
            $this->db->where('id',$page_id);
            $this->db->update('pages',$data);
        }
        return;
    }
    
    
    public function add_page_to_menu($data){
        $this->db->insert('menu_items',$data);
        return;
    }
    
    
    public function edit_page_to_menu($data){
        $this->db->where('page_id',$data['page_id']);
        $query = $this->db->get('menu_items');
         
        if($query->num_rows() > 0){
            $this->db->where('page_id', $data['page_id']);
            $this->db->update('menu_items', $data);
        } else {
            $this->add_page_to_menu($data);
        }
    
    }
    
    
    //Get all menus
    public function get_menus(){
        $this->db->order_by('id');
        $this->db->where('is_published',1);
        $query = $this->db->get('menus');
        return $query->result();
    }
    
    //Get top levels
    public function get_menu($id){
        $this->db->where('menu_id',$id);
        $this->db->where('is_child',0);
        $this->db->where('is_published',1);
        $this->db->order_by('order','ASC');
        $query = $this->db->get('menu_items');
        return $query->result();
    }
    
    
    //Get sub items
     public function get_menu_children($id){ 
        $this->db->where('menu_id',$id);
        $this->db->where('is_child',1);
        $this->db->where('is_published',1);
        $this->db->order_by('order','ASC');
        $query = $this->db->get('menu_items');
        return $query->result();
    }
    
    
    //Get a pages menu
    public function get_selected_menu($page_id){
        $this->db->where('page_id',$page_id);
        $query = $this->db->get('menu_items');
        return $query->row();
    }
    
    //Delete menu items
     public function delete_menu_items($page_array){
        foreach($page_array as $page_id){
            $this->db->where('page_id',$page_id);
            $this->db->delete('menu_items');
        }
    }
    
    //Delete a single menu item
    public function delete_single_menu_item($page_id){
         $this->db->where('page_id',$page_id);
         $this->db->delete('menu_items');
    }
    
    //Get parent
    public function get_selected_parent($page_id){
        $this->db->where('page_id',$page_id);
        $query = $this->db->get('menu_items');
        return $query->row();
    }
     
}
