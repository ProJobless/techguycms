<!--Display form validation errors-->
<?php echo validation_errors('<p class="error">'); ?>
<div id="content">
<!--Display Message-->
<?php if($this->session->flashdata('images_folder')) : ?> 
<?php echo '<p class="error">' .$this->session->flashdata('images_folder') . '</p>'; ?>
<?php endif; ?>
<!--Display Message-->
<?php if($this->session->flashdata('images_user_folder')) : ?>
<?php echo '<p class="error">' .$this->session->flashdata('images_user_folder') . '</p>'; ?>
<?php endif; ?>

<!--Start Page-->
<div id="content-left">
<h1>Add A New User</h1>
<!--Start Form-->
<?php $attributes = array('id' => 'add_user_form'); ?>
<?php echo form_open_multipart('admin/user/add',$attributes); ?>

<!--Field: First Name-->
<p>
<?php echo form_label('First Name:'); ?><br />
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
<?php echo form_label('Last Name:'); ?><br />
<?php
$data = array(
              'name'        => 'last_name',
              'value'       => set_value('last_name')
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
              'value'       => set_value('email')
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
              'value'       => set_value('username')
            );
?>
<?php echo form_input($data); ?>
</p>

<!--Field: Password-->
<p>
<?php echo form_label('Password:'); ?><br />
<?php
$data = array(
              'name'        => 'password',
              'value'       => set_value('password')
            );
?>
<?php echo form_input($data); ?>
</p>

<!--Field: Confirm Password-->
<p>
<?php echo form_label('Password Confirm:'); ?><br />
<?php
$data = array(
              'name'        => 'password2',
              'value'       => set_value('password2')
            );
?>
<?php echo form_input($data); ?>
</p>

<!--Field: Category-->
<p>
<?php echo form_label('Choose Role:'); ?><br />
<select name="role">
    <?php foreach($roles as $role) : ?>
        <option 
            <?php if(set_value('role')) : ?>
            selected="selected"
            <?php endif; ?>
            value="<?php echo $role->id; ?>"><?php echo ucwords($role->name); ?></option>
    <?php endforeach; ?>
</select>
</p>

<br />

<!--Field: Activated-->
<p>
<?php echo form_label('Activated:'); ?><br />
Yes <?php echo form_radio(array("name"=>"activated","id"=>"activated_yes","value"=>"1", 'checked'=>set_radio('activated', '1', TRUE))); ?>
No  <?php echo form_radio(array("name"=>"activated","id"=>"activated_no","value"=>"0", 'checked'=>set_radio('activated', '0', FALSE))); ?>
</p>

</div><!--content left-->

<!--content right-->
<div id="content-right">
   
<!--Field: Avatar Image-->
<h1>Optional Info</h1>
<?php echo form_label('Avatar:'); ?><br />
<input type="file" name="userfile" size="20" />
<br /><br />

<!--Field: Phone-->
<p>
<?php echo form_label('Phone Number:'); ?><br />
<?php
$data = array(
              'name'        => 'phone',
              'value'       => set_value('phone')
            );
?>
<?php echo form_input($data); ?>
</p>

<!--Field: Address-->
<p>
<?php echo form_label('Address:'); ?><br />
<?php
$data = array(
              'name'        => 'address',
              'value'       => set_value('address')
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
              'value'       => set_value('address2')
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
              'value'       => set_value('city')
            );
?>
<?php echo form_input($data); ?>
</p>

<!--Field: State-->
<p>
<?php echo form_label('Choose State:'); ?><br />
<select name="state">
    <?php foreach($states as $key => $value) : ?>
        <option value="<?php echo $key; ?>" <?php echo set_select('state',$key); ?>><?php echo $value ?></option>
    <?php endforeach; ?>
</select>
</p>


<!--Field: Postcode-->
<p>
<?php echo form_label('Postcode:'); ?><br />
<?php
$data = array(
              'name'        => 'postcode',
              'value'       => set_value('postcode')
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
              'value'       => 'Add User'
        );
?>
<br />
<p>
    <?php echo form_submit($data); ?> or <a href="<?php echo base_url(); ?>admin/users">Cancel</a>
</p>

<?php echo form_close(); ?>