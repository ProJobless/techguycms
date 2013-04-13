<?php if($this->session->userdata('logged_in') != true) : ?>
<?php $attributes = array('class' => 'site_form', 'id' => 'login_form'); ?>
<?php echo form_open('user/login',$attributes); ?>
<?php echo form_input('username','Username'); ?>
<?php echo form_password('password','Password'); ?><br />
<?php echo form_submit('login', 'Login'); ?>
<?php echo form_close(); ?>

<a href="<?php echo base_url(); ?>user/register">Register</a> | <a href="<?php echo base_url(); ?>user/reset_password">Forgot Password</a>

<?php else : ?>

Hello <?php echo $this->session->userdata('username'); ?><br />
<a href="user/logout">Logout</a>

<?php endif; ?>
