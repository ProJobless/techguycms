<!--Display Errors-->
<?php echo validation_errors('<p class="error">'); ?>
<!--Display Messages-->
<?php if($this->session->flashdata('no_activation')) : ?>
<?php echo '<p class="error">' .$this->session->flashdata('no_activation') . '</p>'; //Activation is incorect ?>
<?php endif; ?>
<?php if($this->session->flashdata('fail_login')) : ?>
<?php echo '<p class="error">' .$this->session->flashdata('fail_login') . '</p>'; //Login failed ?>
<?php endif; ?>
<?php if($this->session->flashdata('logged_out')) : ?>
<?php echo '<p class="error">' .$this->session->flashdata('logged_out') . '</p>'; //Login failed ?>
<?php endif; ?>
<!--Start Page-->
<h1>Please Login</h1>
<p>Use the form below to login. If you do not have an account, please <a href="<?php echo base_url(); ?>user/register">register</a></p>
<!--Start Form-->
<?php $attributes = array('id' => 'login_form'); ?>
<?php echo form_open('user/login',$attributes); ?>

<!--Field: Username-->
<p>
<?php echo form_label('Username:'); ?>
<?php
$data = array(
              'name'        => 'username',
              'value'       => set_value('username')
            );
?>
<?php echo form_input($data); ?>
</p>

<!--Field: Password-->
<p>
<?php echo form_label('Password:'); ?>
<?php
$data = array(
              'name'        => 'password',
              'value'       => set_value('password')
            );
?>
<?php echo form_password($data); ?>
</p>
<p>
    <?php echo form_submit('submit','Login'); ?>
</p>
