<?php
class Form_model extends CI_Model{
    public function get_all_forms(){
        $query = $this->db->get('forms');
        return $query->result();
    }
    
    
     public function get_all_published_forms(){
         $this->db->where('is_published',1);
        $query = $this->db->get('forms');
        return $query->result();
    }
    
    
    public function get_form($id){
        $this->db->where('id',$id);
        $query = $this->db->get('forms');
        return $query->row();
    }
    
    
    public function get_array_from_string($string){
        $new_array = explode(',',$string);
        return $new_array;
    }
    
    
    public function get_to_email($id){
        $this->db->where('id',$id);
        $query = $this->db->get('forms');
        if($query->num_rows() > 0){
            return $query->row()->to_email;
        } else {
            return false;
        }
    }
    
    
    public function add_form($data){
        $this->db->insert('forms', $data);
	return;
    }
    
    
    public function add_form_to_menu($data){
        $this->db->insert('menu_items',$data);
        return;
    }
    
     public function get_insert_id(){
        return $this->db->insert_id();
    }
    
    //Get a forms order
    public function get_order_from_form($form_id){
        $this->db->where('form_id',$form_id);
        $query = $this->db->get('menu_items');
        return $query->row()->order+1;
        
    }
    
    
    //Edit + update form
    public function edit_form($form_id,$data){
        $this->db->where('id', $form_id);
        $this->db->update('forms', $data); 
        return;
    }
    
    public function edit_form_to_menu($data){
        $this->db->where('form_id',$data['form_id']);
        $query = $this->db->get('menu_items');
         
        if($query->num_rows() > 0){
            $this->db->where('form_id', $data['form_id']);
            $this->db->update('menu_items', $data);
        } else {
            $this->add_form_to_menu($data);
        }
    
    }
    
    //Delete selected forms
    public function delete_forms($form_array){
        foreach($form_array as $form_id){
            $this->db->where('id',$form_id);
            $this->db->delete('forms');
        }
        return;
    }
    
    
    //Delete menu items
     public function delete_menu_items($form_array){
        foreach($form_array as $form_id){
            $this->db->where('form_id',$form_id);
            $this->db->delete('menu_items');
        }
    }
    
    
    //Delete a single menu item
    public function delete_single_menu_item($form_id){
         $this->db->where('form_id',$form_id);
         $this->db->delete('menu_items');
    }
    
    
    public function publish_forms($form_array){
        foreach($form_array as $form_id){
           $data = array(
               'is_published' => 1
            );
            $this->db->where('id',$form_id);
            $this->db->update('forms',$data);
        }
        return;
    }
    
    
     public function publish_menu_items($form_array){
        foreach($form_array as $form_id){
           $data = array(
               'is_published' => 1
            );
            $this->db->where('form_id',$form_id);
            $this->db->update('menu_items',$data);
        }
    }
    
    
    
     public function unpublish_forms($form_array){
        foreach($form_array as $form_id){
            $data = array(
               'is_published' => 0
            );
            $this->db->where('id',$form_id);
            $this->db->update('forms',$data);
        }
        return;
    }
    
    
     public function unpublish_menu_items($form_array){
        foreach($form_array as $form_id){
            $data = array(
               'is_published' => 0
            );
            $this->db->where('form_id',$form_id);
            $this->db->update('menu_items',$data);
        }
        return;
    }
    
    
    //Get a form pages menu
    public function get_selected_menu($form_id){
        $this->db->where('form_id',$form_id);
        $query = $this->db->get('menu_items');
        return $query->row();
    }
    
    
    /* FORM FIELD LOGIC */
    
     public function get_form_fields($form_id){
        $this->db->order_by('order','ASC');
        $this->db->where('form_id',$form_id);
        $query = $this->db->get('form_fields');
        return $query->result();
    }
    
    public function get_form_field($form_id,$field_id){
        $this->db->where('form_id',$form_id);
        $this->db->where('id',$field_id);
        $query = $this->db->get('form_fields');
        return $query->row();
    }
    
     public function get_published_form_fields($form_id){
        $this->db->order_by('order','ASC');
        $this->db->where('form_id',$form_id);
        $this->db->where('is_published',1);
        $query = $this->db->get('form_fields');
        return $query->result();
    }
    
    public function get_selected_validations($form_id,$field_id){
        $this->db->where('form_id',$form_id);
        $this->db->where('id',$field_id);
        $query = $this->db->get('form_fields');
        return $query->row()->validation;
    }
  
    
    //Add form field
    public function add_field($form_id,$data){
        $this->db->where('form_id',$form_id);
        $this->db->insert('form_fields',$data);
        return;
    }
    
    //Edit form field
    public function edit_field($form_id,$field_id,$data){
        $this->db->where('form_id',$form_id);
        $this->db->where('id', $field_id);
        $this->db->update('form_fields', $data); 
        return;
    }
    
    
    //Delete fields
    public function delete_fields($form_id,$field_array){
        foreach($field_array as $field_id){
            $this->db->where('form_id',$form_id);
            $this->db->where('id',$field_id);
            $this->db->delete('form_fields');
        }
       return;
    }
    
    
    //Publish fields
    public function publish_fields($form_id,$field_array){
        foreach($field_array as $field_id){
            $this->db->where('form_id',$form_id);
            $this->db->where('id',$field_id);
            $data = array(
               'is_published' => 1
            );
            $this->db->update('form_fields',$data);
        }
       return;
    }
    
    
    //Unpublish fields
    public function unpublish_fields($form_id,$field_array){
        foreach($field_array as $field_id){
            $this->db->where('form_id',$form_id);
            $this->db->where('id',$field_id);
            $data = array(
               'is_published' => 0
            );
            $this->db->update('form_fields',$data);
        }
       return;
    }
    
    //Get parent
    public function get_selected_parent($form_id){
        $this->db->where('form_id',$form_id);
        $query = $this->db->get('menu_items');
        return $query->row();
    }
    
    
}