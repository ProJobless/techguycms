<!--Display form validation errors-->
<?php echo validation_errors('<p class="error">'); ?>
<!--Display Message-->
<?php if($this->session->flashdata('user_saved')) : ?>
<?php echo '<p class="message">' .$this->session->flashdata('user_saved') . '</p>'; ?>
<a style="padding-bottom:10px" href="<?php echo base_url(); ?>admin/users">Back to users</a>
<?php endif; ?>
<!--Display Message-->
<?php if($this->session->flashdata('password_changed')) : ?>
<?php echo '<p class="message">' .$this->session->flashdata('password_changed') . '</p>'; ?>
<a href="<?php echo base_url(); ?>admin/pages">Back to Pages</a>
<?php endif; ?>
<!--Display Message-->
<?php if($this->session->flashdata('images_folder')) : ?> 
<?php echo '<p class="error">' .$this->session->flashdata('images_folder') . '</p>'; ?>
<?php endif; ?>
<!--Display Message-->
<?php if($this->session->flashdata('images_user_folder')) : ?>
<?php echo '<p class="error">' .$this->session->flashdata('images_user_folder') . '</p>'; ?>
<?php endif; ?>

<!--Start Page-->
<div id="content-full">
<div id="content-left">
<h1>Edit User</h1>
<!--Start Form-->
<?php $attributes = array('id' => 'edit_user_form'); ?>
<?php echo form_open_multipart('admin/user/edit/' .$this_user->id . '',$attributes); ?>

<!--Field: First Name-->
<p>
<?php echo form_label('First Name:'); ?><br />
<?php
$data = array(
              'name'        => 'first_name',
              'value'       => $this_user->first_name
            );
?>
<?php echo form_input($data); ?>
</p>

<!--Field: Last Name-->
<p>
<?php echo form_label('Last Name:'); ?><br />
<?php
$data = array(
              'name'        => 'last_name',
              'value'       => $this_user->last_name
            );
?>
<?php echo form_input($data); ?>
</p>

<!--Field: Email-->
<p>
<?php echo form_label('Email Address:'); ?><br />
<?php
$data = array(
              'name'        => 'email',
              'value'       => $this_user->email
            );
?>
<?php echo form_input($data); ?>
</p>

<!--Field: Username-->
<p>
<?php echo form_label('Username:'); ?><br />
<?php
$data = array(
              'name'        => 'username',
              'value'       => $this_user->username
            );
?>
<?php echo form_input($data); ?>
</p>

<!--Field: Role-->
<p>
<?php echo form_label('Choose Role:'); ?><br />
<select name="role">
   <?php foreach($roles as $role) : ?>
        <option value="<?php echo $role->id; ?>"
                <?php if($this_user->role == $role->id) : ?>
                selected
                <?Php endif; ?>
                ><?php echo $role->name; ?></option>
    <?php endforeach; ?>
</select>
</p>

<br />

<!--Field: Activated-->
<p>
    <?php echo form_label('Activated:'); ?><br />
    <?php if($this_user->is_activated == 1) : ?>
    Yes <?php echo form_radio('activated', '1', TRUE); ?>
    No  <?php echo form_radio('activated', '0', FALSE); ?>
    <?php else : ?>
    Yes <?php echo form_radio('activated', '1', FALSE); ?>
    No  <?php echo form_radio('activated', '0', TRUE); ?>
    <?php endif; ?>
</p>
<p>
    <a href="<?php echo base_url(); ?>admin/user/change_password/<?php echo $this_user->id; ?>">Change <?php echo $this_user->first_name; ?>'s Password </a>
</p>
</div><!--content left-->

<!--content right-->
<div id="content-right">
   
<!--Field: Avatar Image-->
<h1>Optional Info</h1>
<?php echo form_label('Upload Avatar:'); ?><br />
<input type="file" name="userfile" size="20" />
<p>
Current Avatar: <strong><?php echo $this_user->avatar; ?></strong>
</p>
<?php if($this_user->avatar != "" || !isset($this_user->avatar)) : ?>
<img width="80" src="<?php echo base_url(); ?>assets/images/user/<?php echo $this_user->avatar; ?>" />
<br />
<p>Delete Current Avatar <?php echo form_checkbox('delete_avatar', '1', false); ?></p>

<?php else : ?>
<p>This user has no avatar</p>
<?php endif; ?>


<!--Field: Phone-->
<p>
<?php echo form_label('Phone Number:'); ?><br />
<?php
$data = array(
              'name'        => 'phone',
              'value'       => $this_user->phone
            );
?>
<?php echo form_input($data); ?>
</p>

<!--Field: Address-->
<p>
<?php echo form_label('Address'); ?><br />
<?php
$data = array(
              'name'        => 'address',
              'value'       => $this_user->address1
            );
?>
<?php echo form_input($data); ?>
</p>

<!--Field: Address2-->
<p>
<?php echo form_label('Address 2:'); ?><br />
<?php
$data = array(
              'name'        => 'address2',
              'value'       => $this_user->address2
            );
?>
<?php echo form_input($data); ?>
</p>

<!--Field: City-->
<p>
<?php echo form_label('City:'); ?><br />
<?php
$data = array(
              'name'        => 'city',
              'value'       => $this_user->city
            );
?>
<?php echo form_input($data); ?>
</p>

<!--Field: State-->
<p>
<?php echo form_label('State:'); ?><br />
<select name="state">
    <?php foreach($states as $key => $value) : ?>
        <option 
            <?php if($this_user->state == $key) : ?>
            selected="selected"
            <?php endif; ?>
            value="<?php echo $key; ?>"><?php echo $value ?></option>
    <?php endforeach; ?>
</select>
</p>


<!--Field: Postcode-->
<p>
<?php echo form_label('Postcode:'); ?><br />
<?php
$data = array(
              'name'        => 'postcode',
              'value'       => $this_user->postcode
            );
?>
<?php echo form_input($data); ?>
</p>

</div><!--content-left-->
</div><!--content-full-->
<div class="clr"></div>

<!--Submit Buttons-->
<?php
$data = array(
              'name'        => 'submit',
              'id'          => 'user_submit',
              'value'       => 'Save User'
        );
?>
<br />
<p>
    <?php echo form_submit($data); ?> or <a href="<?php echo base_url(); ?>admin/users">Cancel</a>
</p>

<?php echo form_close(); ?>