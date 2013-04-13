<!--Display Errors-->
<?php echo validation_errors('<p class="error">'); ?>
<!--Start Page-->
<h1>Change Password</h1>
<p>Change the users password below</p>
<!--Start Form-->
<?php echo form_open('admin/user/change_password/' .$this_user->id); ?>
<!--Field: Password-->
<p>
<?php echo form_label('Password:'); ?><br />
<?php
$data = array(
              'name'        => 'password',
              'value'       => set_value('password')
            );
?>
<?php echo form_password($data); ?>
</p>

<!--Field: Confirm Password-->
<p>
<?php echo form_label('Confirm Password:'); ?><br />
<?php
$data = array(
              'name'        => 'password2',
              'value'       => set_value('password2')
            );
?>
<?php echo form_password($data); ?>
</p>
<p>
    <?php echo form_submit('change_password_submit', 'Change Password'); ?> or 
    <a href="<?php echo base_url(); ?>admin/user/edit/<?php echo $this_user->id; ?>">Cancel</a>
<?php echo form_close(); ?>

