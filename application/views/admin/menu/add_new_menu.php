<!--Display Errors-->
<?php echo validation_errors('<p class="error">'); ?>
<!--Start Page-->
<div id="content">
<h1>Add A New Menu</h1>
<!--Start Form-->
<?php $attributes = array('id' => 'add_menu_form'); ?>
<?php echo form_open('admin/menu/add_menu',$attributes); ?>

<!--Field: Menu Name-->
<p>
<?php echo form_label('Menu Name:');?><br />
<?php
$data = array(
              'name'        => 'menu_name',
              'value'       => set_value('menu_name')
            );
?>
<?php echo form_input($data); ?>
</p>


<!--Field: Show Name-->
<p>
<?php echo form_label('Show Name:');?><br />
   Yes <?php echo form_radio(array("name"=>"show_name","id"=>"show_name_yes","value"=>"1", 'checked'=>set_radio('show_name', '1', TRUE))); ?>
   No  <?php echo form_radio(array("name"=>"show_name","id"=>"show_name_no","value"=>"0", 'checked'=>set_radio('show_name', '0', FALSE))); ?>
</p>

<!--Field: Module Position-->
<p>
<?php echo form_label('Choose Position:');?><br />
<select name="module_position"> 
    <option value="0">Select Position</option>
    <?php foreach($module_positions as $position) : ?>
        <option value="<?php echo $position; ?>" <?php echo set_select('module_position',$position); ?>><?php echo $position; ?></option>
    <?php endforeach; ?>
</select> 
<a href="" class="someClass"  title="Your template might not support all of the positions, check with your developer"><img class="tipimage" style="margin:0 0 -4px 4px;" src="<?php echo base_url(); ?>assets/images/admin/info.png" /></a>
</p>


<!--Field: Order-->
<p>
<?php echo form_label('Order:');?><br />
    <?php echo form_input('order',set_value('order')); ?>
</p>


<!--Field: Global-->
<p>
<?php echo form_label('Global:');?><br />
   Yes <?php echo form_radio(array("name"=>"global","id"=>"global_yes","value"=>"1", 'checked'=>set_radio('global', '1', TRUE))); ?>
   No  <?php echo form_radio(array("name"=>"global","id"=>"global_no","value"=>"0", 'checked'=>set_radio('global', '0', FALSE))); ?>
   <a href="" class="someClass"  title="If global, the module will be displayed on every page of the site"><img class="tipimage" style="margin:0 0 -4px 4px;" src="<?php echo base_url(); ?>assets/images/admin/info.png" /></a>
</p>

<!--Field: Registered Only-->
<p>
<?php echo form_label('Registered Only:');?><br />
   Yes <?php echo form_radio('registered_only', '1', FALSE); ?>
   No  <?php echo form_radio('registered_only', '0', TRUE); ?>
</p>

<!--Field: Published-->
<p>
<?php echo form_label('Published');?><br />
   Yes <?php echo form_radio(array("name"=>"published","id"=>"published_yes","value"=>"1", 'checked'=>set_radio('published', '1', TRUE))); ?>
   No  <?php echo form_radio(array("name"=>"published","id"=>"published_no","value"=>"0", 'checked'=>set_radio('published', '0', FALSE))); ?>
</p>

</div>

<!--Sidebar-->
<div id="sidebar">
<h1>Optional</h1>

<!--Field: Suffix-->
<p>
<?php echo form_label('Class Suffix');?><br />
    <?php echo form_input('suffix',set_value('suffix')); ?>
</p>
</div><!--sidebar-->
<div class="clr"></div>

<!--Submit Button-->
<?php
$data = array(
              'name'        => 'submit',
              'id'          => 'menu_submit',
              'value'       =>  'Add Menu'
        );
?>

<p>
    <?php echo form_submit($data); ?> or <a href="<?php echo base_url(); ?>admin/menus">Cancel</a>
</p>


