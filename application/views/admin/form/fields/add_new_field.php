<script>window.onload = typeList; </script>
<!--Display Errors-->
<?php echo validation_errors('<p class="error">'); ?>
<!--Start Page-->
<div id="close">
<div id="content">
<h1>Add A New Field</h1>
<!--Start Form-->
<?php echo form_open('admin/form/add_fields/'.$this_form->id); ?>

<!--Field: Label-->
<p>
<?php echo form_label('Field Label:'); ?><br />
<?php
$data = array(
              'name'        => 'label',
              'value'       => set_value('label')
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
              'value'       => set_value('name')
            );
?>
<?php echo form_input($data); ?>
<a href="" class="someClass" title="This is the name attribute value for the form field"><img class="tipimage" style="margin:0 0 -4px 4px" src="<?php echo base_url(); ?>assets/images/admin/info.png" /></a>
</p>


<!--Field: Type-->
<p>
<?php echo form_label('Field Type:'); ?><br />
<select id="type" name="type" onchange="OnChange(this.form.type);">
    <option value="text" <?php echo set_select('type','text'); ?>>Text</option>
    <option value="select" <?php echo set_select('type','select'); ?>>Select List</option>
    <option value="email" <?php echo set_select('type','email'); ?>>Email</option>
    <option value="textarea" <?php echo set_select('type','textarea'); ?>>Textarea</option>
    <option value="checkbox" <?php echo set_select('type','checkbox'); ?>>Checkbox</option>
    <option value="radio" <?php echo set_select('type','radio'); ?>>Radio</option>
</select>
</p>



<!-- Field: Options-->
<p id="options">
    <?php echo form_label('Options: (Separate options with a comma)'); ?><br />
<?php
$data = array(
              'name'        => 'options',
              'value'       => set_value('options'),
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
              'value'       => set_value('width'),
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
              'value'       => set_value('height'),
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
Yes <?php echo form_radio(array("name"=>"published","id"=>"published_yes","value"=>"1", 'checked'=>set_radio('published', '1', TRUE))); ?>
No  <?php echo form_radio(array("name"=>"published","id"=>"published_no","value"=>"0", 'checked'=>set_radio('published', '0', FALSE))); ?>
</p>

</div>
  
<div class="content-right" style="padding-top:40px;"> 
    
    
<!--Field: Validation-->
<p>
<?php echo form_label('Validation:'); ?><br />
<select name="validation[]" multiple="multiple">
<option value="required">Required</option>
<option value="valid_email">Valid Email</option>
<option value="alpha">Alpha</option>
<option value="alpha_numeric">Alpha Numeric</option>
<option value="numeric">Numeric</option>
</select>
</p>


<!--Field: Order-->
<p>
<?php echo form_label('Order:'); ?><br />
<?php
$data = array(
              'name'        => 'order',
              'value'       => set_value('order'),
              'maxlength'   => '4',
              'size'        => '4',
              'style'       => 'text-align:center;width:30px;'
            );
?>
<?php echo form_input($data); ?>
    <a href="" class="someClass"  title="Choose the order position for this field in the form. Current order is listed below"><img class="tipimage" style="margin:0 0 -4px 4px;" src="<?php echo base_url(); ?>assets/images/admin/info.png" /></a>
</p>


<!--Current Order-->
<?php echo form_label('Current Field Order:'); ?><br />
<table style="margin-top:0;" width="200">
<?php foreach($this_form_fields as $field) : ?>
<tr>
    <td><?php echo $field->label; ?></td>
     <td><?php echo $field->order; ?></td>
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
              'value'       =>  'Save'
        );
?>
<br />
<p>
    <?php echo form_submit($data); ?> or <a href="<?php echo base_url(); ?>admin/form/fields/<?php echo $this_form->id; ?>">Cancel</a>
</p>

</div>
<?php echo form_close(); ?>