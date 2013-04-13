<h1>Reset Password</h1>
 <?php if($this->session->flashdata('email_not_found')) : ?>
<?php echo '<p class="error">' .$this->session->flashdata('email_not_found') . '</p>'; ?>
<?php endif; ?>
 <?php if($this->session->flashdata('email_no_send')) : ?>
<?php echo '<p class="error">' .$this->session->flashdata('email_no_send') . '</p>'; ?>
<?php endif; ?>
 <?php if($this->session->flashdata('email_yes_send')) : ?>
<?php echo '<p class="error">' .$this->session->flashdata('email_yes_send') . '</p>'; ?>
<?php endif; ?>
<?php echo validation_errors('<p class="error">'); ?>
<p>Please fill in the information below to reset your password</p>
<?php echo form_open('user/reset_password'); ?>
<p>
<label for 'email'>Email Address:</label><br />
<?php echo form_input('email',set_value('email')); ?>
</p>
 <?php echo form_submit('reset_password_submit', 'Reset Password'); ?> or
    <a href="<?php echo base_url(); ?>">Cancel</a>
<?php echo form_close(); ?>

