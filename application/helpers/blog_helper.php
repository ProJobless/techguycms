<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//Shorten the blog post body on the main blog page
function trunc_latest_blog($string,$limit){
 
   // return with no change if string is shorter than $limit
  if(strlen($string) > $limit){
     $pos = strpos($string, ' ',$limit);
      if ($pos !== false) {
        return substr($string, 0, $pos);
     }
  } else{
      return $string;
  }
}  

//Convert author id to the authors first and last name
function get_author_name($author_id){
     $CI =& get_instance();
     $CI->load->database();
     
     $CI->db->where('id',$author_id);
     $query = $CI->db->get('users');
     
     $first_name = $query->row()->first_name;
     $last_name = $query->row()->last_name;
     
     return $first_name . " ". $last_name;
}  


//Get the post name from the post id for comment
function get_post_name($post_id){
     $CI =& get_instance();
     $CI->load->database();
     
     $CI->db->where('id',$post_id);
     $query = $CI->db->get('blog_posts');
     
     return $query->row()->title;
}


