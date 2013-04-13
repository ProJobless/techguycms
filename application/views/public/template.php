<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
 <!--Load "head"-->
 <?php $this->load->view('public/head'); ?>
<body>
  <div id="main">
    <div id="header">
      <div id="logo">
          <?php if($logo_type->value == 'text') : ?>
            <div id="logo_text">
              <h1><a href="<?php echo base_url(); ?>"><?php echo $website_name->value; ?></a></h1>
              <h2><?php echo $headline_text->value; ?></h2>
            </div>
          <?php elseif($logo_type->value == 'image') : ?>
            <img height="<?php echo $logo_height->value; ?>" width="<?php echo $logo_width->value; ?>" src="<?php echo base_url().'assets/images/logo/'.$logo_image->value; ?>" alt="logo" />
          <?php endif; ?>
        <div id="search">
           <!-- Module-->
           <?php $this->load->view('public/modules/positions/header_right'); ?>
        </div>
      </div>    
    <div id="menubar">
        <!--Menu Module-->
       <?php $this->load->view('public/modules/positions/menu'); ?>
    </div>
    </div>
    <div id="site_content"> 
        <div class="sidebar">
            <!--Right Modules-->
            <?php $this->load->view('public/modules/positions/right'); ?>
        </div>  
    <!--Content div depends on if there are any sidebar items-->
    <?php if(@$sidebar_enabled) : ?>
        <div id="content">
    <?php else : ?>
        <div id="content-full">
    <?php endif; ?>
    <!--Main page content-->
    <?php $this->load->view($main_content); ?>
    </div>
    </div>
    <div id="footer">
        <?php if($copyright->value == "" || !isset($copyright->value)) : ?>
            <?php echo $website_name->value; ?>
        <?php else : ?>
            <?php echo $copyright->value; ?>
        <?php endif; ?>
         | <a href="<?php echo base_url(); ?>admin">Admin Login</a>
    </div>
    </div>
</body>
</html>

