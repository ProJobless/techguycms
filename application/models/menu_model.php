<?php
class Menu_model extends CI_Model{
    //Get PUBLISHED menus
    public function get_menus(){
        $this->db->order_by('id');
        $this->db->where('is_published',1);
        $query = $this->db->get('menus');
        return $query->result();
    }
    
     //Get ALL menus
    public function get_all_menus(){
        $this->db->order_by('id');
        $query = $this->db->get('menus');
        return $query->result();
    }
    
     //Get all menu items
    public function get_all_items(){
        $this->db->order_by('order');
        $query = $this->db->get('menu_items');
        return $query->result();
    }
    
    
    //Get menu items
    public function get_parent_items($id = 1){
        $this->db->where('menu_id',$id);
        $this->db->where('is_child',0);
        $this->db->where('is_published',1);
        $this->db->order_by('order','ASC');
        $query = $this->db->get('menu_items');
        return $query->result();
    }
    
    
    //Get second level
    public function get_child_items($id = 1){
        $this->db->where('menu_id',$id);
        $this->db->where('is_child',1);
        $this->db->where('is_published',1);
        $this->db->order_by('order','ASC');
        $query = $this->db->get('menu_items');
        return $query->result();
    }
    
    
    //Get single menu
    public function get_single_menu($id){
        $this->db->where('id', $id);
        $query = $this->db->get('menus');
        return $query->row();
    }
    
    
     //Edit + Update Menu
    public function edit_menu($menu_id,$data){
        $this->db->where('id', $menu_id);
        $this->db->update('menus', $data); 
        return;
    }
    
    //Add a menu
     public function add_menu($data){
        $this->db->insert('menus', $data);
	return;
    }
    
   
    //Get the position of a menu
    public function get_selected_position($menu_id){
        $this->db->select('module_position');
        $this->db->where('id',$menu_id);
        $query = $this->db->get('menus');
        return $query->row()->module_position;
    }
    
    
    //Publish menu(s)
      public function publish_menus($menu_array){
        foreach($menu_array as $menu_id){
           $data = array(
               'is_published' => 1
            );
            $this->db->where('id',$menu_id);
            $this->db->update('menus',$data);
        }
        return;
    }
    
    
    
    //Unpublish menu(s)
     public function unpublish_menus($menu_array){
        foreach($menu_array as $menu_id){
            $data = array(
               'is_published' => 0
            );
            $this->db->where('id',$menu_id);
            $this->db->update('menus',$data);
        }
        return;
    }
    
    
    //Make menu(s) global
      public function make_menus_global($menu_array){
        foreach($menu_array as $menu_id){
           $data = array(
               'is_global' => 1
            );
            $this->db->where('id',$menu_id);
            $this->db->update('menus',$data);
        }
        return;
    }
    
    
    
    //Remove global
     public function remove_menus_global($menu_array){
        foreach($menuarray as $menu_id){
            $data = array(
               'is_global' => 0
            );
            $this->db->where('id',$menu_id);
            $this->db->update('menus',$data);
        }
        return;
    }
    
     //Delete menu(s)
     public function delete_menus($menu_array){
         foreach($menu_array as $menu_id){
            $this->db->where('id',$menu_id);
            $this->db->delete('menus');
        }
        return;
    }
    
    /*
     public function get_top_items(){
        $this->db->where('parent_id',0);
        $this->db->order_by('order');
        $query = $this->db->get('menu_items');
        return $query->result();
    }
     
     */
    
    /*
    public function get_child_items(){
         $this->db->where('is_child',1);
        $this->db->order_by('order');
        $query = $this->db->get('menu_items');
        return $query->result();
    }
    */
    
    //Get a pages menu
    public function get_selected_menu($page_id){
        $this->db->where('page_id',$page_id);
        $query = $this->db->get('menu_items');
        return $query->row();
    }
    
    
    //Get selected menu items
    public function get_selected_items($menu_id){
        $this->db->where('menu_id',$menu_id);
        $query = $this->db->get('menu_items');
        return $query->result();
    }
    
    //Get item by page
    public function get_item_by_page($page_id){
        $this->db->order_by('order');
        $this->db->where('page_id',$page_id);
        $query = $this->db->get('menu_items');
        return $query->row();
    }
    
    //Get item by form
    public function get_item_by_form($form_id){
        $this->db->order_by('order');
        $this->db->where('form_id',$form_id);
        $query = $this->db->get('menu_items');
        return $query->row();
    }
    
    
    //Add menu items
    public function add_menu_items($data,$item_array){    
       foreach($item_array as $item){
            $this->db->where('item_id',$item);
            $this->db->insert('menu_items', $data);
       }
    die();
	return;
    }
    
    
    //Delete menu items
     public function delete_menu_items($menu_array){
        foreach($menu_array as $menu_id){
            $this->db->where('menu_id',$menu_id);
            $this->db->delete('menu_items');
        }
        return;
    }
    
    
    //Delete a single menu item
    public function delete_single_menu_item($page_id){
         $this->db->where('page_id',$page_id);
         $this->db->delete('menu_items');
    }
    
    
    //Publish a menu item
    public function publish_item($id){
        $this->db->set('is_published',1);
        $this->db->where('item_id',$id);
        $this->db->update('menu_items'); 
        return;
    }
    
    
     //Unpublish a menu item
    public function unpublish_item($id){
        $this->db->set('is_published',0);
        $this->db->where('item_id',$id);
        $this->db->update('menu_items'); 
        return;
    }
    
    
    //Get blog menu item
    public function get_blog_item($item_id){
        $this->db->where('item_id',$item_id);
        $query = $this->db->get('menu_items');
        return $query->row();
    }
    
    //Is the blog menu item published?
    public function is_blog_item_published(){
        $this->db->where('item_id',2);
        $query = $this->db->get('menu_items');
        if($query->row()->is_published == 1){
            return true;
        } else {
            return false;
        }
    }
    
    
    //Update blog menu item
    public function update_blog_item($item_data){
        //Create alias var
        $alias = $item_data['alias'];
        $this->db->where('alias', $alias);
        $this->db->update('menu_items', $item_data); 
        return;
    }
    
    
    public function get_all_from_menu($id){
        $this->db->where('menu_id',$id);
        $this->db->order_by('order');
        $query = $this->db->get('menu_items');
        return $query->result();
    }
    
    
}