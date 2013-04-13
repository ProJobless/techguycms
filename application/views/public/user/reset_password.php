<h1>Reset Password</h1>
<?php echo validation_errors('<p class="error">'); ?>
<p>You can now reset your password</p>
<?php echo form_open('user/reset_confirm/' . $reset_code); ?>
<?php form_hidden('reset_code', $reset_code); ?>
<p>
<label for 'password'>New Password:</label><br />
<?php echo form_password('password',set_value('password')); ?>
</p>
<p>
<label for 'password2'>Confirm Password:</label><br />
<?php echo form_password('password2',set_value('password2')); ?>
</p>
 <?php echo form_submit('reset_password_submit', 'Reset Password'); ?> or
    <a href="<?php echo base_url(); ?>">Cancel</a>
<?php echo form_close(); ?>
