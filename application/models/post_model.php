<?php
class Post_model extends CI_Model{
    
    //Get all posts with category and author
    public function get_all_posts(){
         $sql = "SELECT blog_posts.id, 
                               blog_posts.title, 
                               blog_posts.body, 
                               blog_posts.create_date,
                               blog_posts.is_published,
                               blog_categories.name,
                               blog_categories.id as cat_id,
                               users.first_name,
                               users.last_name
                               FROM blog_posts 
                               LEFT JOIN users ON blog_posts.author_id = users.id
                               LEFT JOIN blog_categories ON blog_posts.category_id = blog_categories.id
                               ";
         
         $query = $this->db->query($sql);
         return $query->result();
    }
    
    
    
    //Get all posts for routing
    public function get_all_post_routes(){
        $query = $this->db->get('blog_posts');
        return $query->result();
    }
    
    
    
    //Get the most recent posts
    public function get_latest_posts($post_limit){
        $this->db->where('is_published',1);
        $this->db->limit($post_limit);
        $query = $this->db->get('blog_posts');
        return $query->result();
    }
    
    
    
    //Get single published post
     public function get_post($id){
        $this->db->where('is_published',1);
        $this->db->where('id',$id);
        $query = $this->db->get('blog_posts');
        return $query->row();
    }
    
   
    
    //Get all categories
    public function get_all_categories(){
        $query = $this->db->get('blog_categories');
        return $query->result();
    }
    
    
    
    //Get category of post
     public function get_category($post_id){
        $this->db->where('is_published',1);
        $this->db->where('id',$post_id);
        $query = $this->db->get('blog_posts');
        
        $category_id = $query->row()->category_id;
        if($category_id == 0){
            return 'Uncategorized';
        } else {
            $this->db->where('id',$category_id);
            $query = $this->db->get('blog_categories');
            return $query->row();
        }
    }
    
    
    
    //Get all users that have author priv
    public function get_all_authors(){
        $this->db->where('role',2);
        $this->db->or_where('role',3);
        $query = $this->db->get('users');
        return $query->result();
    }
    
    
    
    //Get author for post
    public function get_author($id){
        $this->db->where('is_published',1);
        $this->db->where('id',$id);
        $query = $this->db->get('blog_posts');
        
        $author_id = $query->row()->author_id;
        
        $this->db->where('id',$author_id);
        $query = $this->db->get('users');
        return $query->row();
    }
    
    
    
    //Get meta info for post
    public function get_post_meta($id = null,$area = null){
        if($area == 'latest'){
            
        }
         $this->db->where('id', $id);
         $query = $this->db->get('blog_posts');
         $meta_info = $query->row(); 
         return $meta_info;
    }
    
    
    
    //Get all comments
    public function get_all_comments(){
        $query = $this->db->get('blog_comments');
        return $query->result();
    }
    
    
    
    
    //Get the comments for a post
    public function get_comments($post_id){
         $post = $this->get_post($post_id);
         
         $this->db->where('post_id',$post_id);
         $this->db->where('is_approved',1);
         $this->db->order_by('submit_date');
         $query = $this->db->get('blog_comments');
         
         return $query->result();
    }
    
    
    
    //Add a comment
    public function add_comment($data){
       $this->db->insert('blog_comments', $data);
       return;
    }
    
    
    
    //Check if a post is published
    public function check_if_published($post_id){
        $this->db->select('is_published');
        $this->db->where('id',$post_id);
        $query = $this->db->get('blog_posts');
        return $query->row();
    }
    
    
    
    //Check if a post is featured
     public function check_if_featured($post_id){
        $this->db->select('is_featured');
        $this->db->where('id',$post_id);
        $query = $this->db->get('blog_posts');
        return $query->row();
    }
    
    
    
    //This gets post whether published or not
    public function get_post_admin($id){
        $this->db->where('id',$id);
        $query = $this->db->get('blog_posts');
        return $query->row();
    }
    
    
    
    //Add a post
    public function add_post($data){
       $this->db->insert('blog_posts', $data);
	return;
    }
    
    
    
    //Get the id of the last insert
    public function get_insert_id(){
        return $this->db->insert_id();
    }
    
    
    
    //Edit + Update post
    public function edit_post($post_id,$data){
        $this->db->where('id', $post_id);
        $this->db->update('blog_posts', $data); 
        return;
    }
    
    
    
    //Get post main image
    public function get_image($post_id){
        $this->db->where('id',$post_id);
        $query = $this->db->get('blog_posts');
        return $query->row()->main_image;
    }
    
    
    
    //Delete post(s)
    public function delete_posts($post_array){
         foreach($post_array as $post_id){
            $this->db->where('id',$post_id);
            $this->db->delete('blog_posts');
        }
        return;
    }
    
    
    
    //Delete post comment(s)
    public function delete_post_comments($post_array){
         foreach($post_array as $post_id){
            $this->db->where('post_id',$post_id);
            $this->db->delete('blog_comments');
        }
        return;
    }
    
    
    
    //Delete post image
    public function delete_post_image($post_id){     
       $data = array(
               'main_image' => ''
            );
            $this->db->where('id',$post_id);
            $this->db->update('blog_posts',$data);
       return;
    }
    
    
    
    
    //Publish post(s)
      public function publish_posts($post_array){
        foreach($post_array as $post_id){
           $data = array(
               'is_published' => 1
            );
            $this->db->where('id',$post_id);
            $this->db->update('blog_posts',$data);
        }
        return;
    }
    
    
    
    //Unpublish post(s)
     public function unpublish_posts($post_array){
        foreach($post_array as $post_id){
            $data = array(
               'is_published' => 0
            );
            $this->db->where('id',$post_id);
            $this->db->update('blog_posts',$data);
        }
        return;
    }
    
    
    
    /* Start Category Model Functions */
    
     //This gets category whether published or not
    public function get_category_admin($id){
        $this->db->where('id',$id);
        $query = $this->db->get('blog_categories');
        return $query->row();
    }
    
    
    
    //Add new category
    public function add_category($data){
        $this->db->insert('blog_categories', $data);
	return;
    }
    
    
    
    //Edit category
     public function edit_category($category_id,$data){
        $this->db->where('id', $category_id);
        $this->db->update('blog_categories', $data); 
        return;
    }
    
    
    
    //Publish category(s)
    public function publish_categories($category_array){
        foreach($category_array as $category_id){
           $data = array(
               'is_published' => 1
            );
            $this->db->where('id',$category_id);
            $this->db->update('blog_categories',$data);
        }
        return;
    }
    
    
    
    //Unpublish category(s)
     public function unpublish_categories($category_array){
        foreach($category_array as $category_id){
            $data = array(
               'is_published' => 0
            );
            $this->db->where('id',$category_id);
            $this->db->update('blog_categories',$data);
        }
        return;
    }
    
    
    
    //Delete category(s)
     public function delete_categories($category_array){
         foreach($category_array as $category_id){
            $this->db->where('id',$category_id);
            $this->db->delete('blog_categories');
        }
        return;
    }
    
    
    //Change posts to 0 if category was deleted
     public function change_post_categories($category_array){
         foreach($category_array as $category_id){
            $this->db->where('category_id',$category_id);
            $data = array(
               'category_id' => 0
            );
            $this->db->update('blog_posts',$data);
        }
        return;
    }
    
    
    //Get category image
    public function get_category_image($category_id){
        $this->db->where('id',$category_id);
        $query = $this->db->get('blog_categories');
        return $query->row()->category_image;
    }
    
    
    //Delete comments(s)
     public function delete_comments($comment_array){
        foreach($comment_array as $comment_id){
            $this->db->where('id',$comment_id);
            $this->db->delete('blog_comments');
        }
        return;
    }
    
    
    
    //Approve comment(s)
    public function approve_comments($comment_array){
        foreach($comment_array as $comment_id){
           $data = array(
               'is_approved' => 1
            );
            $this->db->where('id',$comment_id);
            $this->db->update('blog_comments',$data);
        }
        return;
    }
    
    
    
    //Unpublish comment(s)
     public function unapprove_comments($comment_array){
        foreach($comment_array as $comment_id){
            $data = array(
               'is_approved' => 0
            );
            $this->db->where('id',$comment_id);
            $this->db->update('blog_comments',$data);
        }
        return;
    }
    

    //Get number of posts for blog page
    public function get_post_num(){
        $this->db->where('key','post_num');
        $query = $this->db->get('globals');
        return $query->row()->value;
    }
    
    //Get number of chars for posts on blog page
    public function get_intro_chars(){
        $this->db->where('key','intro_text_count');
        $query = $this->db->get('globals');
        return $query->row()->value;
    }
    
    //Get width of main images on blog page
    public function get_main_image_width(){
        $this->db->where('key','main_image_width');
        $query = $this->db->get('globals');
        return $query->row()->value;
    }
    
    
    //Check if blog activated
    public function check_blog_activated(){
        $this->db->where('key','activate_blog');
        $query = $this->db->get('globals');
        return $query->row()->value;
    }
    
    //Create a blog menu item
    public function add_blog_menu_item($data){
        $this->db->insert('menu_items', $data);
	return;
    }
    
}
