<!--Display Errors-->
<?php echo validation_errors('<p class="error">'); ?>
<!--Display Message-->
<?php if($this->session->flashdata('field_edited')) : ?>
<?php echo '<p class="message">' .$this->session->flashdata('field_edited') . '</p>'; ?>
<a style="padding-bottom:10px" href="<?php echo base_url(); ?>admin/form/fields/<?php echo $this_form->id; ?>">Back to Fields</a>
<?php endif; ?>
<!--Options Box Toggle-->
<?php if($this_field->type != "select") : ?>
    <script>window.onload = typeList; </script>
<?php endif; ?>
<!--Start Page-->
<div id="close">
<div id="content">
<h1>Edit Field</h1>
<?php echo form_open('admin/form/edit_field/'.$this_form->id.'/'.$this_field->id); ?>


<!--Field: Label-->
<p>
<?php echo form_label('Field Label:'); ?><br />
<?php
$data = array(
              'name'        => 'label',
              'value'       => $this_field->label
            );
?>
<?php echo form_input($data); ?>
<a href="" class="someClass" title="Label is the text you want next to the input inside of <strong>label</strong> tags"><img class="tipimage" style="margin:0 0 -4px 4px" src="<?php echo base_url(); ?>assets/images/admin/info.png" /></a>

</p>


<!--Field: Name-->
<p>
<?php echo form_label('Field Name:'); ?><br />
<?php
$data = array(
              'name'        => 'name',
              'value'       => $this_field->name
            );
?>
<?php echo form_input($data); ?>
<a href="" class="someClass" title="This is the name attribute value for the form field"><img class="tipimage" style="margin:0 0 -4px 4px" src="<?php echo base_url(); ?>assets/images/admin/info.png" /></a>
</p>


<!--Field: Type-->
<p>
<?php echo form_label('Field Type:'); ?><br />
<select id="type" name="type" onchange="OnChange(this.form.type);">
    <option value="text" <?php if($this_field->type == "text"){ echo 'selected'; } ?>>Text</option>
    <option value="select" <?php if($this_field->type == "select"){ echo 'selected'; } ?>>Select List</option>
    <option value="email" <?php if($this_field->type == "email"){ echo 'selected'; } ?>>Email</option>
    <option value="textarea" <?php if($this_field->type == "textarea"){ echo 'selected'; } ?>>Textarea</option>
    <option value="checkbox" <?php if($this_field->type == "checkbox"){ echo 'selected'; } ?>>Checkbox</option>
    <option value="radio" <?php if($this_field->type == "radio"){ echo 'selected'; } ?>>Radio</option>
</select>
</p>



<!--Field: Options-->
<p id="options">
    <?php echo form_label('Options: (Separate options with a comma)'); ?><br />
<?php
$data = array(
              'name'        => 'options',
              'value'       => $this_field->options,
              'id'          => 'options',
              'rows'        => '6',
              'style'       => 'width: 95%;'
            );
?>
<?php echo form_textarea($data); ?>
</p>


<!--Field: Width-->
<p>
<?php echo form_label('Field Width:'); ?><br />
<?php
$data = array(
              'name'        => 'width',
              'value'       => $this_field->width,
              'maxlength'   => '4',
              'size'        => '4'
            );
?>
<?php echo form_input($data); ?>
<a href="" class="someClass" title="The width in pixels of the input field"><img class="tipimage" style="margin:0 0 -4px 4px" src="<?php echo base_url(); ?>assets/images/admin/info.png" /></a>
</p>


<!--Field: Height-->
<p>
<?php echo form_label('Field Height:'); ?><br />
<?php
$data = array(
              'name'        => 'height',
              'value'       => $this_field->height,
              'maxlength'   => '4',
              'size'        => '4'
            );
?>
<?php echo form_input($data); ?>
<a href="" class="someClass" title="The height in pixels of the input field"><img class="tipimage" style="margin:0 0 -4px 4px" src="<?php echo base_url(); ?>assets/images/admin/info.png" /></a>
</p>


<!--Field: Published-->
<p>
   <?php echo form_label('Published:'); ?><br />
    <?php if($this_field->is_published == 1) : ?>
    Yes <?php echo form_radio('published', '1', TRUE); ?>
    No  <?php echo form_radio('published', '0', FALSE); ?>
    <?php else : ?>
     Yes <?php echo form_radio('published', '1', FALSE); ?>
     No  <?php echo form_radio('published', '0', TRUE); ?>
    <?php endif; ?>
</p>

</div>
  
<div class="content-right" style="padding-top:40px;"> 
    
    
<!--Field: Validation-->
<p>
<?php echo form_label('Validation:'); ?><br />
<select name="validation[]" multiple="multiple">
<option value="required" <?php if(in_array('required',$selected_validations)){echo 'selected';}?>>Required</option>
<option value="valid_email" <?php if(in_array('valid_email',$selected_validations)){echo 'selected';}?>>Valid Email</option>
<option value="alpha" <?php if(in_array('alpha',$selected_validations)){echo 'selected';}?>>Alpha</option>
<option value="alpha_numeric" <?php if(in_array('alpha_numeric',$selected_validations)){echo 'selected';}?>>Alpha Numeric</option>
<option value="numeric" <?php if(in_array('numeric',$selected_validations)){echo 'selected';}?>>Numeric</option>
</select>
</p>


<!--Field: Order-->
<p>
<?php echo form_label('Order:'); ?><br />
<?php
$data = array(
              'name'        => 'order',
              'value'       => $this_field->order,
              'maxlength'   => '4',
              'size'        => '4',
              'style'       => 'text-align:center;width:30px;'
            );
?>
<?php echo form_input($data); ?>
    <a href="" class="someClass"  title="Choose the order position for this field in the form. Current order is listed below"><img class="tipimage" style="margin:0 0 -4px 4px;" src="<?php echo base_url(); ?>assets/images/admin/info.png" /></a>
</p>

<!--Current Field Order-->
<p>
<?php echo form_label('Current Field Order:'); ?><br />
<table style="margin-top:0;" width="200">
<?php foreach($this_form_fields as $field) : ?>
<tr>
    <td><?php if($this_field->label == $field->label){ echo '<strong>'; } ?><?php echo $field->label; ?><?php if($this_field->label == $field->label){ echo '</strong>'; } ?></td>
     <td><?php if($this_field->label == $field->label){ echo '<strong>'; } ?><?php echo $field->order; ?><?php if($this_field->label == $field->label){ echo '</strong>'; } ?></td>
</tr>
    <?php endforeach; ?>
</table>
</p>
    
</div><!--content right-->

<div style="clear:both;"></div>
<?php
$data = array(
              'name'        => 'submit',
              'id'          => 'form_submit',
              'value'       =>  'Save Field'
        );
?>
<br />
<p>
    <?php echo form_submit($data); ?> or <a href="<?php echo base_url(); ?>admin/form/fields/<?php echo $this_form->id; ?>">Cancel</a>
</p>

</div>
<?php echo form_close(); ?>