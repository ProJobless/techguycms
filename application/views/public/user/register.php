<!--Display Errors-->
<?php echo validation_errors('<p class="error">'); ?>
<!--Start Page-->
<h1>Register</h1>
<p>Please fill out the form below to register as a member of our site</p>
<!--Start Form-->
<?php $attributes = array('id' => 'reg_form'); ?>
<?php echo form_open('user/register',$attributes); ?>

<!--Field: First Name-->
<p>
<?php echo form_label('First Name:'); ?>
<?php
$data = array(
              'name'        => 'first_name',
              'value'       => set_value('first_name')
            );
?>
<?php echo form_input($data); ?>
</p>

<!--Field: Last Name-->
<p>
<?php echo form_label('Last Name:'); ?>
<?php
$data = array(
              'name'        => 'last_name',
              'value'       => set_value('last_name')
            );
?>
<?php echo form_input($data); ?>
</p>

<!--Field: Email Address-->
<p>
<?php echo form_label('Email Address:'); ?>
<?php
$data = array(
              'name'        => 'email',
              'value'       => set_value('email')
            );
?>
<?php echo form_input($data); ?>
</p>

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
<?php echo form_input($data); ?>
</p>

<!--Field: Password2-->
<p>
<?php echo form_label('Confirm Password:'); ?>
<?php
$data = array(
              'name'        => 'password2',
              'value'       => set_value('password2')
            );
?>
<?php echo form_input($data); ?>
</p>

<!--Submit Buttons-->
<p>
    <?php echo form_submit('submit','Register'); ?>
</p>