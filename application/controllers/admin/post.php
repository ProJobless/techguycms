<?php
class Post extends Admin_Controller{
    public function __construct() {
            parent::__construct();
           
            //Validate user
            if($this->session->userdata('logged_in_a') != true){
                redirect('admin/login');
            }
            
            //Is blog activated?
            if($this->Settings_model->is_blog_activated() != true){
                redirect('admin');
            }
            
            //Load custom "blog" helper
            $this->load->helper('blog');
        
             //Load editor
            $this->load->helper('ckeditor');
    }
    
    //Posts view page
     public function index(){  
          
            //Show stats
            $data['statistics'] = $this->Dashboard_model->get_statistics();
            
            //Get all blog posts
            $data['posts'] = $this->Post_model->get_all_posts();
     
            //Views
            $data['main_content'] = 'admin/post/posts';
            $this->load->view('admin/template', $data);
    }
    
    
    
     //Saves url routes
     public function save_routes(){   
            //this simply returns all the posts from my database
            $routes = $this->Post_model->get_all_post_routes();
            
            // write out the PHP array to the file with help from the file helper
            if ( !empty( $routes ) ){
                // for every post in the database, get the route using the recursive function - _get_route()
                foreach( $routes as $route ){
                    $data[] = '$route["' . $this->_get_route($route->id) . '"] = "' . "blog/display/{$route->id}" . '";';
                }
                $output = "<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');\n";
                $output .= implode("\n", $data);
                $this->load->helper('file');
                //Write to the custom routes file
                write_file(APPPATH . "cache/post_routes.php", $output);
            }
        }
 
     //Gets url routes
     private function _get_route($id){   
            // get the post from the db using it's id
            $post = $this->Post_model->get_post($id);
  
            //Creates the url prefix/alias
            @$prefix = strtolower(str_replace(' ','-',$post->title));
            @$prefix = str_replace(',','',$prefix);
            @$prefix = str_replace('.','',$prefix);
            
            return $prefix;
     }  
        
     
     //Directs the checkbox actions on "Posts" view
     public function action_direct_post(){ 
         if($this->input->post('add')){
             redirect('admin/post/add');
             
         } elseif($this->input->post('edit')){
             $post_array = $this->input->post('post_id');
             $post_id = $post_array[0];
              redirect("admin/post/edit/$post_id");
             
         } elseif($this->input->post('delete')){
             //Get post ids from checkboxes
             $post_array = $this->input->post('post_id');
             //Pass to delete function
             $this->delete($post_array);
             
         } elseif($this->input->post('publish')){
             //Get post ids from checkboxes
             $post_array = $this->input->post('post_id');
             //Pass to delete function
             $this->publish($post_array);
             
         } elseif($this->input->post('unpublish')){
             //Get post ids from checkboxes
             $post_array = $this->input->post('post_id');
             //Pass to delete function
             $this->unpublish($post_array);

         } else {
             redirect('admin/posts');
         }
     }
            
    //Add a new blog post
    public function add(){  
        $this->form_validation->set_rules('post_title','Post Title','trim|required|min_length[4]|xss_clean');
        $this->form_validation->set_rules('post_body','Post Body','trim|required|xss_clean');
        $this->form_validation->set_rules('page_title','Page Title','trim|xss_clean');
        
        $this->form_validation->set_rules('page_keywords','Meta Keywords','trim|xss_clean');
        $this->form_validation->set_rules('page_description','Meta Description','trim|xss_clean');
        $this->form_validation->set_rules('page_modules','Page Modules','xss_clean');
        $this->form_validation->set_rules('published','Published','required');
        $this->form_validation->set_rules('category','Category','required');
        
         $this->form_validation->set_rules('anchor','Menu Item Title','trim|xss_clean');
         $this->form_validation->set_rules('order','Order','trim|integer');
        
          if($this->form_validation->run() == FALSE){
              //Get module options  
              $data['mod_select'] = $this->Module_model->get_modules();
              //Get menu options  
              $data['menu_select'] = $this->Page_model->get_menus();
              
              //Get Categories
              $data['categories'] = $this->Post_model->get_all_categories();
              //Get Authors
              $data['authors'] = $this->Post_model->get_all_authors();
              
              //Get the user that is logged in as the default author
              $data['author_name'] = $this->session->userdata('user_full_name_a');
              $data['author_id'] = $this->session->userdata('user_id_a');
              
              //Views
              $data['main_content'] = 'admin/post/add_new_post';
              $this->load->view('admin/template', $data);
                
          } else {
               if(!is_writable('application/cache/post_routes.php')){ 
                  //Create Message
                  $this->session->set_flashdata('post_routes_writable', 'Your blog item was not created correctly. You need to chmod 777 the following file <strong>"application/cache/post_routes.php"</strong>');
              }    
              
              if(!is_writable('assets/images')){ 
                  //Create Message
                  $this->session->set_flashdata('images_folder', 'Main Image was not uploaded. you need to chmod 777 the folder <strong>"assets/images"</strong>');
              }
              if(!is_writable('assets/images/blog')){ 
                  //Create Message
                  $this->session->set_flashdata('images_blog_folder', 'Main Image was not uploaded. you need to chmod 777 the folder <strong>"assets/images/blog"</strong>');
              }
                //Upload Image
                $config['upload_path'] = './assets/images/blog/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '2048';

		$this->load->library('upload', $config);

		if ($this->upload->do_upload('userfile')){
			$upload_data = $this->upload->data();
                        $main_image = $upload_data['file_name'];

		} else {
                        $main_image = "";
		}
                
              //Get Page Modules if Any
              if($this->input->post('page_modules') != ""){
                $modules[] = $this->input->post('page_modules');
                foreach ($modules as $mods) {
                    foreach($mods as $mod){
                    $mod_string[] = $mod;
                    }
                }
                //Make Array CSV string
                $mod_string = implode(",",$mod_string);
              } else {
                  $mod_string = 0;
              }           
           
            $data = array(
                    'title' => $this->input->post('post_title'),
                    'body' => $this->input->post('post_body'),
                    'main_image' => $main_image,
                    'page_title' => $this->input->post('page_title'),
                    'meta_keywords' => $this->input->post('tags'),
                    'meta_description' => $this->input->post('page_description'),
                    'page_modules' => $mod_string,
                    'category_id' => $this->input->post('category'),
                    'author_id' => $this->input->post('author'),
                    'tags' => $this->input->post('tags'),
                    'is_published' => $this->input->post('published')
             );
       
            $this->Post_model->add_post($data);  
            
            //Get the last insert id
            $last_post_id = $this->Post_model->get_insert_id();
            $next_post_id = $last_post_id;
       
            //Create route
            $this->save_routes();
            
            //Create Message
            $this->session->set_flashdata('post_added', 'Your post has been added');
            
            //Redirect to posts
            redirect('admin/posts');
          }
    }
    
    
    //Edit an existing blog post
    public function edit($post_id){
        $this->form_validation->set_rules('post_title','Post Title','trim|required|min_length[4]|xss_clean');
        $this->form_validation->set_rules('post_body','Post Body','trim|required|xss_clean');
        $this->form_validation->set_rules('page_title','Page Title','trim|xss_clean');
        
        $this->form_validation->set_rules('page_keywords','Meta Keywords','trim|xss_clean');
        $this->form_validation->set_rules('page_description','Meta Description','trim|xss_clean');
        //$this->form_validation->set_rules('page_modules','Post Modules','trim|xss_clean');
        $this->form_validation->set_rules('published','Published','required');
        
         $this->form_validation->set_rules('anchor','Menu Item Title','trim|xss_clean');
         $this->form_validation->set_rules('order','Order','trim|integer');
        
          if($this->form_validation->run() == FALSE){
              
              //Get the post to edit 
              $data['this_post'] = $this->Post_model->get_post_admin($post_id);
              //Get all module options  
              $data['mod_select'] = $this->Module_model->get_modules();
              //Get which modules are selected
              $data['selected_modules'] = $this->Module_model->get_selected_modules($post_id,'blog_posts');
              //Get all Categories
              $data['categories'] = $this->Post_model->get_all_categories();
              //Get the current post category
              $data['post_category'] = $this->Post_model->get_category($post_id);
               //Get all Authors
              $data['authors'] = $this->Post_model->get_all_authors();
              //Get the current post author
              $data['post_author'] = $this->Post_model->get_author($post_id);
              //Get the current post main image
              $data['post_image'] = $this->Post_model->get_image($post_id);
             
              //Views
              $data['main_content'] = 'admin/post/edit_post';
              $this->load->view('admin/template', $data);
                
          } else {
               if(!is_writable('application/cache/post_routes.php')){ 
                  //Create Message
                  $this->session->set_flashdata('post_routes_writable', 'Your blog item was not created correctly. You need to chmod 777 the following file <strong>"application/cache/post_routes.php"</strong>');
              }    
             if(!is_writable('assets/images')){ 
                  //Create Message
                  $this->session->set_flashdata('images_folder', 'Main Image was not uploaded. you need to chmod 777 the folder <strong>"assets/images"</strong>');
              }
              if(!is_writable('assets/images/blog')){ 
                  //Create Message
                  $this->session->set_flashdata('images_blog_folder', 'Main Image was not uploaded. you need to chmod 777 the folder <strong>"assets/images/blog"</strong>');
              }
                //Upload Image
                $config['upload_path'] = './assets/images/blog/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '2048';
                $config['max_height']	= '0';
                $config['max_width']	= '0';
                $config['overwrite']    = true;
                //Load upload lib
		$this->load->library('upload', $config);
                
                //If they uploaded a file
		if ($this->upload->do_upload('userfile')){
			$upload_data = $this->upload->data();
                        $main_image = $upload_data['file_name'];
                //If no file was uploaded        
		} else {
                    if($this->input->post('delete_image') == 1){
                        $this->Post_model->delete_post_image($post_id);
                    }
                    //Check if there is already an image for this post
                        $main_image = $this->Post_model->get_image($post_id);
                        if(!$main_image){
                            $main_image = "";
                        }
                         //Debug 
                         //$error = array('error' => $this->upload->display_errors()); foreach($error as $er){ echo $er;}die();
		}
         
              //Get Page Modules if Any
              if($this->input->post('page_modules') != ""){
                $modules[] = $this->input->post('page_modules');
                foreach ($modules as $mods) {
                    foreach($mods as $mod){
                    $mod_string[] = $mod;
                    }
                }
                //Make Array CSV string
                $mod_string = implode(",",$mod_string);
              } else {
                  $mod_string = 0;
              }           
           
            $data = array(
                    'title' => $this->input->post('post_title'),
                    'body' => $this->input->post('post_body'),
                    'main_image' => $main_image,
                    'page_title' => $this->input->post('page_title'),
                    'meta_keywords' => $this->input->post('tags'),
                    'tags' => $this->input->post('tags'),
                    'meta_description' => $this->input->post('page_description'),
                    'page_modules' => $mod_string,
                    'category_id' => $this->input->post('category'),
                    'author_id' => $this->input->post('author'),
                    'is_published' => $this->input->post('published')
             );
        
            $this->Post_model->edit_post($post_id,$data);  
       
            //Create route
            $this->save_routes();
            
            //Create Message
            $this->session->set_flashdata('post_edited', 'Your post has been saved ');
            
            //Redirect to posts
            redirect('admin/post/edit/' .$post_id . '');
          }
    }
    
    
    //Delete a blog post
     public function delete($post_array){      
            if(!isset($post_array) || $post_array == ''){
                redirect('admin/posts');
            }
            //Delete the record(s)
            $this->Post_model->delete_posts($post_array);
            
            //Delete the comment(s)
            $this->Post_model->delete_post_comments($post_array);
         
            //Create Message
            $this->session->set_flashdata('post_deleted', 'Your post(s) have been deleted');
            
            //Redirect to posts
            redirect('admin/posts');
     }
     
     
     //Publish a blog post
     public function publish($post_array){
          if(!isset($post_array) || $post_array == ''){
                redirect('admin/posts');
            }
         
            $this->Post_model->publish_posts($post_array);
         
            //Create Message
            $this->session->set_flashdata('post_published', 'Your post(s) have been published');
            
            //Redirect to posts
            redirect('admin/posts');
     }
     
     
     //Unpublish a blog post
      public function unpublish($post_array){
           if(!isset($post_array) || $post_array == ''){
                redirect('admin/posts');
            }
         
          $this->Post_model->unpublish_posts($post_array);
         
            //Create Message
            $this->session->set_flashdata('post_unpublished', 'Your post(s) have been unpublished');
            
            //Redirect to posts
            redirect('admin/posts');
     }
     
     //////////////////////////* Start CATEGORY functions *////////////////////////////////
     
     //List all categories
     public function categories(){
            //Show stats
            $data['statistics'] = $this->Dashboard_model->get_statistics();
            
            //Get all blog posts
            $data['categories'] = $this->Post_model->get_all_categories();
     
            //Views
            $data['main_content'] = 'admin/post/categories';
            $this->load->view('admin/template', $data);
     }
     
     
     
     //Directs the checkbox actions on Categories view
     public function action_direct_category(){ 
         if($this->input->post('add')){
             redirect('admin/post/add_category');
             
         } elseif($this->input->post('edit')){
             $category_array = $this->input->post('category_id');
             $category_id = $category_array[0];
              redirect("admin/post/edit_category/$category_id");
             
         } elseif($this->input->post('delete')){
             //Get post ids from checkboxes
             $category_array = $this->input->post('category_id');
             //Pass to delete function
             $this->delete_categories($category_array);
             
         } elseif($this->input->post('publish')){
             //Get post ids from checkboxes
             $category_array = $this->input->post('category_id');
             //Pass to publish function
             $this->publish_category($category_array);
             
         } elseif($this->input->post('unpublish')){
             //Get post ids from checkboxes
             $category_array = $this->input->post('category_id');
             //Pass to unpublish function
             $this->unpublish_category($category_array);

         } else {
             redirect('admin/post/categories');
         }
     }
     
     
     //Add a category
     public function add_category(){
        $this->form_validation->set_rules('category_name','Category Name','trim|xss_clean|required|min_length[3]');
     
          if($this->form_validation->run() == FALSE){       
              //Views
              $data['main_content'] = 'admin/post/add_new_category';
              $this->load->view('admin/template', $data); 
          } else {        
            $data = array(
                    'name' => $this->input->post('category_name'),
                    'description' => $this->input->post('category_description'),
                    'is_published' => $this->input->post('published')
             );
       
            $this->Post_model->add_category($data);  
            
            //Get the last insert id
            //$last_post_id = $this->Post_model->get_insert_id();
            //$next_post_id = $last_post_id;
       
            //Create route
            //$this->save_routes();
            
            //Create Message
            $this->session->set_flashdata('category_added', 'Your category has been added');
            
            //Redirect to posts
            redirect('admin/post/categories');
              
          }
     }
     
     
     //Edit an existing category
     public function edit_category($category_id){
       $this->form_validation->set_rules('category_name','Category Name','trim|xss_clean|required|min_length[3]');
          if($this->form_validation->run() == FALSE){
              
              //Get the category to edit 
              $data['this_category'] = $this->Post_model->get_category_admin($category_id);
            
              //Views
              $data['main_content'] = 'admin/post/edit_category';
              $this->load->view('admin/template', $data);
                
          } else {
              
                $data = array(
                    'name' => $this->input->post('category_name'),
                    'description' => $this->input->post('category_description'),
                    'is_published' => $this->input->post('published')
                );
        
            $this->Post_model->edit_category($category_id,$data);  
       
            //Create route
            //$this->save_routes();
            
            //Create Message
            $this->session->set_flashdata('category_edited', 'Your category has been saved ');
            
            //Redirect to posts
            redirect('admin/post/edit_category/' .$category_id . '');
        }
     }
     
     
     //Publish a catregory
      public function publish_category($category_array){
          if(!isset($category_array) || $category_array == ''){
                redirect('admin/post/categories');
            }
         
            $this->Post_model->publish_categories($category_array);
         
            //Create Message
            $this->session->set_flashdata('category_published', 'Your category has been published');
            
            //Redirect to posts
            redirect('admin/post/categories');
     }
     
     
     //Unpublish a category
       public function unpublish_category($category_array){
          if(!isset($category_array) || $category_array == ''){
                redirect('admin/post/categories');
            }
         
            $this->Post_model->unpublish_categories($category_array);
         
            //Create Message
            $this->session->set_flashdata('category_unpublished', 'Your category has been unpublished');
            
            //Redirect to posts
            redirect('admin/post/categories');
     }
     
     
     //Delete categories
      public function delete_categories($category_array){      
            if(!isset($category_array) || $category_array == ''){
                redirect('admin/post/categories');
            }
            //Delete categories selected
            $this->Post_model->delete_categories($category_array);
            //Change the posts in the deleted categories to "Uncategorized(0)"
            $this->Post_model->change_post_categories($category_array);
         
            //Create Message
            $this->session->set_flashdata('category_deleted', 'Your category has been deleted');
            
            //Redirect to posts
            redirect('admin/post/categories');
     }
     
     
     
     //////////////////////////* Start COMMENT functions *////////////////////////////////
     
     
     public function comments(){
            //Show stats
            $data['statistics'] = $this->Dashboard_model->get_statistics();
            
            //Get all blog posts
            $data['comments'] = $this->Post_model->get_all_comments();
     
            //Views
            $data['main_content'] = 'admin/post/comments';
            $this->load->view('admin/template', $data);
     }
     
     
     //Directs the checkbox actions on Comments view
     public function action_direct_comment(){    
          if($this->input->post('delete')){
             //Get comment ids from checkboxes
             $comment_array = $this->input->post('comment_id');
             //Pass to delete function
             $this->delete_comments($comment_array);
             
         } elseif($this->input->post('approve')){
             //Get comment ids from checkboxes
             $comment_array = $this->input->post('comment_id');
             //Pass to approve function
             $this->approve_comment($comment_array);
             
         } elseif($this->input->post('unapprove')){
             //Get comment ids from checkboxes
             $comment_array = $this->input->post('comment_id');
             //Pass to unapprove function
             $this->unapprove_comment($comment_array);

         } else {
             redirect('admin/post/comments');
         }
     }
     
     
     //Delete comments
      public function delete_comments($comment_array){      
            if(!isset($comment_array) || $comment_array == ''){
                redirect('admin/post/comments');
            }
            //Delete comments selected
            $this->Post_model->delete_comments($comment_array);
         
            //Create Message
            $this->session->set_flashdata('comment_deleted', 'Your comment has been deleted');
            
            //Redirect to posts
            redirect('admin/post/comments');
     }
     
     
      //Approve a comment
      public function approve_comment($comment_array){
          if(!isset($comment_array) || $comment_array == ''){
                redirect('admin/post/comments');
            }
         
            $this->Post_model->approve_comments($comment_array);
         
            //Create Message
            $this->session->set_flashdata('comment_approved', 'Your comment has been approved');
            
            //Redirect to posts
            redirect('admin/post/comments');
     }
     
     
     //Unapprove a comment
       public function unapprove_comment($comment_array){
          if(!isset($comment_array) || $comment_array == ''){
                redirect('admin/post/comments');
            }
         
            $this->Post_model->unapprove_comments($comment_array);
         
            //Create Message
            $this->session->set_flashdata('comment_unapproved', 'Your comment has been unapproved');
            
            //Redirect to posts
            redirect('admin/post/comments');
     }
     
     
     //Check if blog is activated
     public function is_blog_activated(){
         if($this->Post_model->check_blog_activated()==1){
             return true;
         } elseif($this->Post_model->check_blog_activated()==0){
             return false;
         }
     }
     
}

