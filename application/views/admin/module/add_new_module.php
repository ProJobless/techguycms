<!--Display form validation errors-->
<?php echo validation_errors('<p class="error">'); ?>
<!--Start Page-->
<div id="content">
<h1>Add A New Module</h1>
<!--Start Form-->
<?php $attributes = array('id' => 'add_module_form'); ?>
<?php echo form_open_multipart('admin/module/add',$attributes); ?>

<!--Field: Module Name-->
<p>
<?php echo form_label('Module Name:');?><br />
<?php
$data = array(
              'name'        => 'module_name',
              'value'       => set_value('module_name')
            );
?>
<?php echo form_input($data); ?>
</p>

<!--Field: Show Name-->
<p>
<?php echo form_label('Show Name/Heading:');?><br />
Yes <?php echo form_radio('show_name', '1', TRUE); ?>
No  <?php echo form_radio('show_name', '0', FALSE); ?>
</p>

<!--Field: Module Content-->
<?php
$data = array(
              'name'        => 'module_content',
              'id'          => 'module_content',
              'value'       =>  set_value('module_content'),
              'maxlength'   => '500',
              'style'       => 'width:100%;height:70px',
        );
?>

<p>
<script type="text/javascript">
	window.onload = function()
	{
		CKEDITOR.replace( 'module_content' );
	};
</script>
<?php echo form_label('Module Content:');?><br />
<?php echo form_textarea($data); ?>
</p>

<!--Field: Module Position-->
<p>
<?php echo form_label('Module Position:');?><br />
<select name="module_position"> 
    <option value="0">Select Position</option>
    <?php foreach($module_positions as $position) : ?>
        <option value="<?php echo $position; ?>" <?php echo set_select('module_position',$position); ?>><?php echo $position; ?></option>
    <?php endforeach; ?>
</select>
<a href="" class="someClass"  title="Your template might not support all of the positions. Check with your developer"><img class="tipimage" style="margin:0 0 -4px 4px;" src="<?php echo base_url(); ?>assets/images/admin/info.png" /></a>
</p>

<!--Field: Global-->
<p>
<?php echo form_label('Global:');?><br />
Yes <?php echo form_radio(array("name"=>"global","id"=>"global_yes","value"=>"1", 'checked'=>set_radio('global', '1', TRUE))); ?>
No  <?php echo form_radio(array("name"=>"global","id"=>"global_no","value"=>"0", 'checked'=>set_radio('global', '0', FALSE))); ?>
<a href="" class="someClass"  title="If global, the module will be displayed on every page of the site"><img class="tipimage" style="margin:0 0 -4px 4px;" src="<?php echo base_url(); ?>assets/images/admin/info.png" /></a>
</p>

<!--Field: Published-->
<p>
<?php echo form_label('Published:');?><br />
Yes <?php echo form_radio(array("name"=>"published","id"=>"published_yes","value"=>"1", 'checked'=>set_radio('published', '1', TRUE))); ?>
No  <?php echo form_radio(array("name"=>"published","id"=>"published_no","value"=>"0", 'checked'=>set_radio('published', '0', FALSE))); ?>
</p>

</div>

<!--Sidebar-->
<div id="sidebar">
<h1>Optional</h1>

<!--Field: Suffix-->
<p>
<?php echo form_label('Class Suffix:');?><br />
    <?php echo form_input('suffix',set_value('suffix')); ?>
</p>

<!--Field: Order-->
<p>
<?php echo form_label('Order:');?><br />
<?php
$data = array(
              'name'        => 'order',
              'value'       =>  set_value('order'),
              'style'       => 'text-align:center;width:30px;'
            );
?>
<?php echo form_input($data); ?>
<a href="" class="someClass"  title="Choose the order for this module. Current order is listed below"><img class="tipimage" style="margin:0 0 -4px 4px;" src="<?php echo base_url(); ?>assets/images/admin/info.png" /></a>
</p>

<!--Current Order-->
<p>
<?php echo form_label('Current Module Order:');?><br />
<table style="margin-top:0;" width="200">
<?php foreach($modules as $module) : ?>
<tr>
    <td><?php echo $module->name; ?></td>
     <td><?php echo $module->order; ?></td>
</tr>
    <?php endforeach; ?>
</table>
</p>
</div><!--sidebar-->


<div class="clr"></div>

<!--Submit Buttons-->
<?php
$data = array(
              'name'        => 'submit',
              'id'          => 'module_submit',
              'value'       =>  'Save'
        );
?>
<br />
<p>
    <?php echo form_submit($data); ?> or <a href="<?php echo base_url(); ?>admin/modules">Cancel</a>
</p>


