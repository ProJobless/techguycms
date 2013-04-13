<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
 <!--Load "head"-->
 <?php $this->load->view('admin/head'); ?>
<body id="login">
    <div id="login_box">
        <div id="login_head">
            <h1>Techguy<span>CMS</span></h1>
        </div><!--login head-->
        
        <div id="login_body">
        <h5>Administrator Login</h5>
 <?php echo validation_errors('<p class="error">'); ?>
         <?php if($this->session->flashdata('fail_login')) : ?>
        <?php echo '<p class="error">' .$this->session->flashdata('fail_login') . '</p>'; //Login failed ?>
        <?php endif; ?>

        <?php if($this->session->flashdata('logged_out')) : ?>
        <?php echo '<p class="error">' .$this->session->flashdata('logged_out') . '</p>'; //Logged out ?>
        <?php endif; ?>
        <?php $attributes = array('id' => 'login_form'); ?>
        <?php echo form_open('admin/login',$attributes); ?>
       
        <p>
            <label for="username">Username:</label>
                <?php echo form_input('username_a',set_value('username_a')); ?>
        </p>
        <p>
            <label for="password">Password:</label>
            <?php echo form_password('password_a',set_value('password_a')); ?>
        </p>
        <img id="admins" src="<?php echo base_url(); ?>assets/images/admin/admins.png" alt="admins" />
        <p>
            <?php echo form_submit('submit','Login'); ?>
        </p>
        </div><!--login body-->
</div><!--login box-->
   
<div id="copy">TechguyCMS &copy; 2013</div>
</body>
</html>

