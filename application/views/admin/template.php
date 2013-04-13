<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
 <!--Load "head"-->
 <?php $this->load->view('admin/head'); ?>
<body>
  <div id="main">
    <div id="header">
      <div id="logo">
          <div id="admin_links">
              <ul>
                  <li><a href="<?php echo base_url(); ?>" target="_blank">View Website</a> | <a href="<?php echo base_url(); ?>admin/logout">Logout</a></li>
              </ul>
          </div>
        <div id="logo_text">
          <h1><a href="<?php echo base_url(); ?>admin">Techguy CMS</a></h1>
          <h2>Full Website Control</h2>
        </div>
 
      </div>    
    <div id="menubar">
          <div class="mainmenu">
    <ul id="menu" class="dropdown">
           <li><a href="<?php echo base_url(); ?>admin">Dashboard</a></li>
           <li><a href="<?php echo base_url(); ?>admin/pages">Pages</a>
           <ul class="sub_menu">
               <li><a href="<?php echo base_url(); ?>admin/pages">View Pages</a></li>
              <li><a href="<?php echo base_url(); ?>admin/page/add">Add Page</a></li>
              <li><a href="<?php echo base_url(); ?>admin/menus">Manage Menus</a></li>
            </ul>
           </li>
            <?php if($activate_blog->value == 1) : ?>
             <li><a href="<?php echo base_url(); ?>admin/posts">Blog</a>
             <ul class="sub_menu">
               <li><a href="<?php echo base_url(); ?>admin/posts">View Posts</a></li>
              <li><a href="<?php echo base_url(); ?>admin/post/add">Add Post</a></li>
              <li><a href="<?php echo base_url(); ?>admin/post/categories">View Categories</a></li>
              <li><a href="<?php echo base_url(); ?>admin/post/add_category">Add Category</a></li>
              <li><a href="<?php echo base_url(); ?>admin/post/comments">Comments</a></li>
              <li><a href="<?php echo base_url(); ?>admin/settings/blog">Blog Settings</a></li>
            </ul>
             </li>
             <?php endif; ?>
           <li><a href="<?php echo base_url(); ?>admin/forms">Forms</a>
            <ul class="sub_menu">
               <li><a href="<?php echo base_url(); ?>admin/forms">View Forms</a></li>
              <li><a href="<?php echo base_url(); ?>admin/form/add">Add Form</a></li>
            </ul>
           </li>
            <li><a href="<?php echo base_url(); ?>admin/modules">Modules</a>
            <ul class="sub_menu">
               <li><a href="<?php echo base_url(); ?>admin/modules">View Modules</a></li>
              <li><a href="<?php echo base_url(); ?>admin/module/add">Add Module</a></li>
            </ul>
            </li>
            <li><a href="<?php echo base_url(); ?>admin/users">Users</a>
            <ul class="sub_menu">
               <li><a href="<?php echo base_url(); ?>admin/users">Manage Users</a></li>
              <li><a href="<?php echo base_url(); ?>admin/user/add">Create New User</a></li>
            </ul>
            </li>
            <li><a href="<?php echo base_url(); ?>admin/settings">Settings</a>
            <ul class="sub_menu">
               <li><a href="<?php echo base_url(); ?>admin/settings">Edit Settings</a></li>
              <li><a href="<?php echo base_url(); ?>admin/help">Help & Info</a></li>
            </ul>
            </li>
   </ul>	
    </div> 
    </div>
    </div>
    <div id="site_content"> 
    <!--Main page content-->
    <?php $this->load->view($main_content); ?>
  
    </div>
      <div style="clear:both;"></div>
    <div id="footer">Techguy CMS</div>
    </div>
</body>
</html>

