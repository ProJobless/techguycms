<!--Display form validation errors-->
<?php echo validation_errors('<p class="error">'); ?>

<!--Start Page-->
<div id="content">   
<h1>Edit Module</h1>

<!--Start Form-->
<?php $attributes = array('id' => 'edit_module_form'); ?>
<?php echo form_open_multipart('admin/module/edit/' . $this_module->id .'',$attributes); ?>

<!--Field: Module Name-->
<p>
<?php echo form_label('Module Name:');?><br />
<?php
$data = array(
              'name'        => 'module_name',
              'value'       => $this_module->name
            );
?>
<?php echo form_input($data); ?>
</p>

<!--Field: Show Name-->
<p>
<?php echo form_label('Show Module Name/Heading:');?><br />
    <?php if($this_module->show_name == 1) : ?>
    Yes <?php echo form_radio('show_name', '1', TRUE); ?>
    No  <?php echo form_radio('show_name', '0', FALSE); ?>
    <?php else : ?>
     Yes <?php echo form_radio('show_name', '1', FALSE); ?>
     No  <?php echo form_radio('show_name', '0', TRUE); ?>
    <?php endif; ?>
</p>

<!--If the content/body is editable, create the hidden field-->
<?php if ($this_module->is_editable == 1) : ?>
<input type="hidden" name="is_editable" value="1" />

<!--Field: Module Content-->
<?php
$data = array(
              'name'        => 'module_content',
              'id'          => 'module_content',
              'value'       =>  $this_module->content,
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
<?php else : ?>
<input type="hidden" name="is_editable" value="0" />
<p><strong>This module's content is not editable</strong></p>
<?php endif; ?>

<!--Field: Module Position-->
<p>
<?php echo form_label('Choose Position:');?><br />
<select name="module_position"> 
    <option value="0">Select Position</option>
    <?php foreach($module_positions as $position) : ?>
        <option 
            <?php if($selected_module_position == $position) : ?>
            selected="selected"
            <?php endif; ?>
            value="<?php echo $position; ?>"><?php echo $position; ?></option>
    <?php endforeach; ?>
</select> <a href="" class="someClass"  title="Your template might not support all of the positions. Check with your developer"><img class="tipimage" style="margin:0 0 -4px 4px;" src="<?php echo base_url(); ?>assets/images/admin/info.png" /></a>
</p>



<!--Field: Global-->
<p>
<?php echo form_label('Global:');?><br />
     <?php if($this_module->is_global == 1) : ?>
    Yes <?php echo form_radio('global', '1', TRUE); ?>
    No  <?php echo form_radio('global', '0', FALSE); ?><a href="" class="someClass"  title="If global, the module will be displayed on every page of the site"><img class="tipimage" style="margin:0 0 -4px 4px;" src="<?php echo base_url(); ?>assets/images/admin/info.png" /></a>
    <?php else : ?>
     Yes <?php echo form_radio('global', '1', FALSE); ?>
     No  <?php echo form_radio('global', '0', TRUE); ?><span class="info-padding"><a href="" class="someClass"  title="If global, the module will be displayed on every page of the site"><img class="tipimage" style="margin:0 0 -4px 4px;" src="<?php echo base_url(); ?>assets/images/admin/info.png" /></a>
    <?php endif; ?>
</p>

<!--Field: Published-->
<p>
<?php echo form_label('Published:');?><br />
     <?php if($this_module->is_published == 1) : ?>
    Yes <?php echo form_radio('published', '1', TRUE); ?>
    No  <?php echo form_radio('published', '0', FALSE); ?>
    <?php else : ?>
     Yes <?php echo form_radio('published', '1', FALSE); ?>
     No  <?php echo form_radio('published', '0', TRUE); ?>
    <?php endif; ?>
</p>

</div>

<!--Sidebar-->
<div id="sidebar">
    
<h1>Optional</h1>

<!--Suffix-->
<p>
<?php echo form_label('Class Suffix:');?><br />
<?php
$data = array(
              'name'        => 'suffix',
              'value'       => $this_module->class_suffix
            );
?>
<?php echo form_input($data); ?>
</p>

<!--Field: Order-->
<p>
<?php echo form_label('Order:');?><br />
<?php
$data = array(
              'name'        => 'order',
              'value'       => $this_module->order,
              'style'       => 'text-align:center;width:30px;'
            );
?>
<?php echo form_input($data); ?>
<a href="" class="someClass"  title="Choose the order for this module. Current order is listed below"><img class="tipimage" style="margin:0 0 -4px 4px;" src="<?php echo base_url(); ?>assets/images/admin/info.png" /></a>
</p>
<p>
    
<!--Current Order-->
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

</div><!--sidebar end div-->
<div class="clr"></div>

<!--Submit Button-->
<?php
$data = array(
              'name'        => 'submit',
              'id'          => 'module_submit',
              'value'       => 'Save Module'
        );
?>
<br />
<p>
    <?php echo form_submit($data); ?> or <a href="<?php echo base_url(); ?>admin/modules">Cancel</a>
</p>



