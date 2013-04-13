<?php
class Module_model extends CI_Model{
    
    //Get Published modules
    public function get_modules(){
        $this->db->order_by('order');
        $this->db->where('is_published', 1); 
        $query = $this->db->get('modules');
        return $query->result();
    }
    
    //Get module
    public function get_module($mod_id){
        $this->db->where('id', $mod_id);
        $query = $this->db->get('modules');
        return $query->row();
    }

    //Get ALL modules
    public function get_all_modules(){
        $this->db->order_by('order');
        $query = $this->db->get('modules');
        return $query->result();
    }
    
    //Get all order numbers
    public function get_orders(){
        $this->db->select('order');
        $query = $this->db->get('modules');
        return $query->result();
    }
    
    //Get modules by page
    public function get_page_modules($id,$type = 'page',$area='regular'){
        if($id == null && $type == 'page' && $area == 'featured'){
             //If "featured" page
            $this->db->select('page_modules');
            $this->db->where('is_featured', 1);
            $this->db->where('is_published', 1); 
            $query = $this->db->get('pages');
            
            $modules_string = $query->row()->page_modules;
            $modules_array = explode(',',$modules_string); 
            return $modules_array; 
        } elseif($id != null && $type == 'page' && $area =='regular') {
            //If regular page
            $this->db->select('page_modules');
            $this->db->where('id', $id);
            $this->db->where('is_published', 1); 
            $query = $this->db->get('pages');
            
            $modules_string = @$query->row()->page_modules;
            $modules_array = explode(',',$modules_string); 
            return $modules_array;
            
         } elseif($id != null && $type == 'form' && $area =='regular') {
            //If regular page
            $this->db->select('page_modules');
            $this->db->where('id', $id);
            $this->db->where('is_published', 1); 
            $query = $this->db->get('forms');
            
            $modules_string = @$query->row()->page_modules;
            $modules_array = explode(',',$modules_string); 
            return $modules_array;
        
         } elseif($id != null && $type == 'post' && $area =='regular') {
             //If regular blog post
            $this->db->select('page_modules');
            $this->db->where('id', $id);
            $this->db->where('is_published', 1); 
            $query = $this->db->get('blog_posts');
            
            $modules_string = @$query->row()->page_modules;
            $modules_array = explode(',',$modules_string); 
            return $modules_array;
        //If none then return false
        }else {
            return false;
        }
    }
    
    public function get_blog_modules(){
        $this->db->where('key','blog_modules');
        $modules_string = @$this->db->get('globals')->row()->value;
        $modules_array = explode(',',$modules_string); 
        return $modules_array;
    }
    
   
    
    
     //Manually get modules by id
    public function get_modules_by_id($modules_array){
       $ids = join(',',$modules_array); 
       $query = $this->db->query("SELECT * FROM modules WHERE id IN ($ids)");
       foreach ($query->result() as $row){
           $data[] = $row->id;
       }
       return $data;
    }
  
     //Check if "right" positioned modules are enabled on a page
    public function is_sidebar_enabled($id,$type = 'page',$area='regular',$module_array = null){
        //Find modules in "right" position
         $this->db->where('module_position', 'right'); 
         $query = $this->db->get('modules');
         $right_modules = $query->result();
         
         if($id == null && $type =='page' && $area == 'featured'){  
            //If "featured" page 
            $modules = $this->get_page_modules(null,'page','featured'); //Array of all modules on the page
            foreach($right_modules as $right_module){
                if($right_module->is_global == 0){
                    return true;
                }
                 if(in_array($right_module->id, $modules) ){
                    return true;
                } 
             }
              return false;
        } elseif($id != null && $type =='page' && $area == 'regular') {
            //If "regular" page
            $modules = $this->get_page_modules($id,'page','regular'); //Array of all modules on the page
             foreach($right_modules as $right_module){
                if($right_module->is_global == 0){
                    return true;
                }
                 if(in_array($right_module->id, $modules) ){
                    return true;
                } 
             }
              return false;
              } elseif($id != null && $type =='form' && $area == 'regular') {
            //If "regular" page
            $modules = $this->get_page_modules($id,'form','regular'); //Array of all modules on the form page
             foreach($right_modules as $right_module){
                if($right_module->is_global == 0){
                    return true;
                }
                 if(in_array($right_module->id, $modules) ){
                    return true;
                } 
             }
              return false;
             } elseif($id != null && $type =='post' && $area == 'regular') {
            //If "regular" page
            $modules = $this->get_page_modules($id,'page','regular'); //Array of all modules on the page
             foreach($right_modules as $right_module){
                if($right_module->is_global == 0){
                    return true;
                }
                 if(in_array($right_module->id, $modules) ){
                    return true;
                } 
             }
              return false;
        } elseif($id == null && $type =='post' && $area == 'latest' && $module_array != null){
            //If "Latest" post(s)
            $modules = $this->get_modules_by_id($module_array); //Array of manually published modules
            foreach($right_modules as $right_module){
                if($right_module->is_global == 0){
                    return true;
                }
                 if(in_array($right_module->id, $modules) ){
                    return true;
                } 
             }
              } elseif($id == null && $type =='other' && $area == 'null' && $module_array != null){
            //If "Latest" post(s)
            $modules = $this->get_modules_by_id($module_array); //Array of manually published modules
            foreach($right_modules as $right_module){
                if($right_module->is_global == 0){
                    return true;
                }
                 if(in_array($right_module->id, $modules) ){
                    return true;
                } 
             }
              return false;
        } else {
            //If none then return false
            return false;
        }
       
    }
    
    
    
    
    //Get the position of a module
    public function get_selected_position($mod_id){
        $this->db->select('module_position');
        $this->db->where('id',$mod_id);
        $query = $this->db->get('modules');
        return $query->row()->module_position;
    }
    
    
     /*
     * ADMIN MODULE FUNCTIONS
     * Below functions are for admins only
     */
    
     //Get the modules selected for a certain page
    public function get_selected_modules($id, $table){
            $this->db->select('page_modules');
            $this->db->where('id',$id);
            $query = $this->db->get($table);

        $modules_string = @$query->row()->page_modules;
        $modules_array = explode(',',$modules_string); 
        return $modules_array;
    }
    
    //Add new module
    public function add_module($data){
        $this->db->insert('modules', $data);
	return;
    }
    
    
    //Edit + Update module
    public function edit_module($mod_id,$data){
        $this->db->where('id', $mod_id);
        $this->db->update('modules', $data); 
        return;
    }
    
    //Publish module(s)
      public function publish_modules($mod_array){
        foreach($mod_array as $mod_id){
           $data = array(
               'is_published' => 1
            );
            $this->db->where('id',$mod_id);
            $this->db->update('modules',$data);
        }
        return;
    }
    
    
    
    //Unpublish module(s)
     public function unpublish_modules($mod_array){
        foreach($mod_array as $mod_id){
            $data = array(
               'is_published' => 0
            );
            $this->db->where('id',$mod_id);
            $this->db->update('modules',$data);
        }
        return;
    }
    
    
    //Make module(s) global
      public function make_modules_global($mod_array){
        foreach($mod_array as $mod_id){
           $data = array(
               'is_global' => 1
            );
            $this->db->where('id',$mod_id);
            $this->db->update('modules',$data);
        }
        return;
    }
    
    
    
    //Remove global
     public function remove_modules_global($mod_array){
        foreach($mod_array as $mod_id){
            $data = array(
               'is_global' => 0
            );
            $this->db->where('id',$mod_id);
            $this->db->update('modules',$data);
        }
        return;
    }
    
    
    
    //Get module possions from static array
    public function get_module_positions(){
        $mod_positions = array('menu','right','left','social','content_top','content_bottom','showcase','box1','box2','box3','footer1','footer2','footer3','copyright');
        return $mod_positions;
    }
    
    
    //Delete module(s)
     public function delete_modules($mod_array){
         foreach($mod_array as $mod_id){
            $this->db->where('id',$mod_id);
            $this->db->delete('modules');
        }
        return;
    }
    
    //Is front login activated?
    private function frontend_login_activated(){
        $this->db->where('key','activate_frontend_login');
        $activated = $this->db->get('globals')->row()->value;
        if($activated == 1){
            return true;
        } else {
            return false;
        }
    }
    
    
    //Get menu modules
    public function get_menus(){
         $query = $this->db->get('menus');
         return $query->result();
    }
   
}
