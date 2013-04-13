<!--Display form validation errors-->
<?php echo validation_errors('<p class="error">'); ?>
<!--Display Message-->  
<?php if($this->session->flashdata('menu_edited')) : ?>
<?php echo '<p class="message">' .$this->session->flashdata('menu_edited') . '</p>'; ?>
     <a href="<?php echo base_url(); ?>admin/menus">Back to Menus</a>
<?php endif; ?>
<!--Start Page-->
<div id="content">
<h1>Edit Menu</h1>
<!--Start Form-->
<?php $attributes = array('id' => 'edit_menu_form'); ?>
<?php echo form_open('admin/menu/edit_menu/'.$this_menu->id.'',$attributes); ?>

<!--Field: Menu Name-->
<p>
<?php echo form_label('Menu Name:');?><br />
<?php
$data = array(
              'name'        => 'menu_name',
              'value'       => $this_menu->name
            );
?>
<?php echo form_input($data); ?>
</p>

<!--Field: Show Name-->
<p>
<?php echo form_label('Show Name/Heading:');?><br />
    <?php if($this_menu->show_name == 1) : ?>
    Yes <?php echo form_radio('show_name', '1', TRUE); ?>
    No  <?php echo form_radio('show_name', '0', FALSE); ?>
    <?php else : ?>
     Yes <?php echo form_radio('show_name', '1', FALSE); ?>
     No  <?php echo form_radio('show_name', '0', TRUE); ?>
    <?php endif; ?>
</p>

<!--Field: Module Position-->
<p>
<?php echo form_label('Module Position:');?><br />
<select name="module_position"> 
    <option value="0">Select Position</option>
   <?php foreach($module_positions as $position) : ?>
        <option 
            <?php if($selected_module_position == $position) : ?>
            selected="selected"
            <?php endif; ?>
            value="<?php echo $position; ?>"><?php echo $position; ?></option>
    <?php endforeach; ?>
</select> <span class="info"><strong>Note:</strong> Your template might not support all of the positions</span>
</p>

<!--Field: Order-->
<p>
<?php echo form_label('Order:');?><br />
    <?php echo form_input('order',$this_menu->order); ?>
</p>

<!--Field: Global-->
<p>
<?php echo form_label('Global:');?><br />
     <?php if($this_menu->is_global == 1) : ?>
    Yes <?php echo form_radio('global', '1', TRUE); ?>
    No  <?php echo form_radio('global', '0', FALSE); ?>
    <?php else : ?>
     Yes <?php echo form_radio('global', '1', FALSE); ?>
     No  <?php echo form_radio('global', '0', TRUE); ?>
    <?php endif; ?>
</p>

<!--Field: Registered Only-->
<p>
<?php echo form_label('Registered Only:');?><br />
     <?php if($this_menu->registered_only == 1) : ?>
    Yes <?php echo form_radio('registered_only', '1', TRUE); ?>
    No  <?php echo form_radio('registered_only', '0', FALSE); ?>
    <?php else : ?>
     Yes <?php echo form_radio('registered_only', '1', FALSE); ?>
     No  <?php echo form_radio('registered_only', '0', TRUE); ?>
    <?php endif; ?>
</p>

<!--Field: Published-->
<p>
<?php echo form_label('Published:');?><br />
  <?php if($this_menu->is_published == 1) : ?>
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
     
<!--Field: Suffix-->
<p>
<?php echo form_label('Class Suffix:');?><br />
    <?php echo form_input('suffix',$this_menu->class_suffix); ?>
</p>

<!--Current Pages Linked-->
<p>
<p><strong>Pages linked to this menu:</strong></p>
<ul>
<?php foreach($selected_menu_items as $item) : ?>
    <li><?php echo $item->anchor; ?></li>
<?php endforeach; ?>
</ul><span style="margin:0;padding:0;" class="info"><strong>Note:</strong> You can add pages via the "Page Manager"</span>
</p>
</div><!--sidebar-->
<div class="clr"></div>
<?php
$data = array(
              'name'        => 'submit',
              'id'          => 'menu_submit',
              'value'       =>  'Edit Menu'
        );
?>
<br />
<p>
    <?php echo form_submit($data); ?> or <a href="<?php echo base_url(); ?>admin/menus">Cancel</a>
</p>


